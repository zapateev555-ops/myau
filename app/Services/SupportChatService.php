<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class SupportChatService
{
    public function isAiEnabled(): bool
    {
        return $this->resolveProvider() !== 'fallback';
    }

    public function providerLabel(): string
    {
        return match ($this->resolveProvider()) {
            'openai' => 'AI-ассистент',
            'gemini' => 'AI Gemini',
            'groq' => 'AI Groq',
            'pollinations' => 'AI-ассистент',
            default => 'Умный помощник',
        };
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $history
     */
    public function reply(string $message, array $history = []): string
    {
        $provider = $this->resolveProvider();

        if ($provider !== 'fallback') {
            $aiReply = match ($provider) {
                'openai' => $this->askOpenAiCompatible($message, $history, config('services.openai')),
                'gemini' => $this->askGemini($message, $history),
                'groq' => $this->askOpenAiCompatible($message, $history, config('services.groq')),
                'pollinations' => $this->askPollinations($message, $history),
                default => null,
            };

            if ($aiReply !== null) {
                return $aiReply;
            }
        }

        return $this->fallbackReply($message);
    }

    private function resolveProvider(): string
    {
        $forced = config('services.support_ai.provider');

        if ($forced && $forced !== 'auto' && $this->providerConfigured($forced)) {
            return $forced;
        }

        if (filled(config('services.openai.key'))) {
            return 'openai';
        }

        if (filled(config('services.gemini.key'))) {
            return 'gemini';
        }

        if (filled(config('services.groq.key'))) {
            return 'groq';
        }

        if (config('services.pollinations.enabled')) {
            return 'pollinations';
        }

        return 'fallback';
    }

    private function providerConfigured(string $provider): bool
    {
        return match ($provider) {
            'openai' => filled(config('services.openai.key')),
            'gemini' => filled(config('services.gemini.key')),
            'groq' => filled(config('services.groq.key')),
            'pollinations' => (bool) config('services.pollinations.enabled'),
            default => false,
        };
    }

    /**
     * @param  array{key?: string, base_url: string, model: string}  $config
     * @param  array<int, array{role: string, content: string}>  $history
     */
    private function askOpenAiCompatible(string $message, array $history, array $config): ?string
    {
        if (empty($config['key'])) {
            return null;
        }

        $messages = [
            ['role' => 'system', 'content' => $this->systemPrompt()],
            ...array_slice($history, -8),
            ['role' => 'user', 'content' => $message],
        ];

        try {
            $response = Http::withToken($config['key'])
                ->timeout(30)
                ->post(rtrim($config['base_url'], '/').'/chat/completions', [
                    'model' => $config['model'],
                    'messages' => $messages,
                    'max_tokens' => 500,
                    'temperature' => 0.7,
                ]);

            if ($response->successful()) {
                return $this->cleanAiText($response->json('choices.0.message.content'));
            }
        } catch (\Throwable) {
            //
        }

        return null;
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $history
     */
    private function askGemini(string $message, array $history): ?string
    {
        $key = config('services.gemini.key');
        if (! $key) {
            return null;
        }

        $model = config('services.gemini.model');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";

        $contents = [];
        foreach (array_slice($history, -6) as $item) {
            $role = $item['role'] === 'assistant' ? 'model' : 'user';
            $contents[] = ['role' => $role, 'parts' => [['text' => $item['content']]]];
        }
        $contents[] = ['role' => 'user', 'parts' => [['text' => $message]]];

        try {
            $response = Http::timeout(30)
                ->withHeaders(['x-goog-api-key' => $key])
                ->post($url, [
                    'systemInstruction' => ['parts' => [['text' => $this->systemPrompt()]]],
                    'contents' => $contents,
                    'generationConfig' => [
                        'temperature' => 0.7,
                        'maxOutputTokens' => 500,
                    ],
                ]);

            if ($response->successful()) {
                return $this->cleanAiText($response->json('candidates.0.content.parts.0.text'));
            }
        } catch (\Throwable) {
            //
        }

        return null;
    }

    /**
     * Бесплатный анонимный API: https://text.pollinations.ai
     *
     * @param  array<int, array{role: string, content: string}>  $history
     */
    private function askPollinations(string $message, array $history): ?string
    {
        $prompt = $this->buildPollinationsPrompt($message, $history);

        try {
            $client = Http::timeout(45);

            if (! config('services.pollinations.verify_ssl')) {
                $client = $client->withoutVerifying();
            }

            $response = $client->get(rtrim(config('services.pollinations.base_url'), '/').'/'.rawurlencode($prompt), [
                'model' => config('services.pollinations.model'),
            ]);

            if ($response->successful()) {
                $text = $this->cleanAiText($response->body());

                if ($text !== null && ! str_starts_with($text, '⚠️')) {
                    return $text;
                }
            }
        } catch (\Throwable) {
            //
        }

        return null;
    }

    /**
     * @param  array<int, array{role: string, content: string}>  $history
     */
    private function buildPollinationsPrompt(string $message, array $history): string
    {
        $lines = [
            $this->systemPrompt(),
            '',
            'Веди диалог на русском языке. Отвечай кратко (2–4 предложения).',
            'Не добавляй рекламу, подписи, ссылки на Pollinations, Ko-fi и другие сторонние сервисы.',
        ];

        foreach (array_slice($history, -6) as $item) {
            $prefix = $item['role'] === 'assistant' ? 'Ассистент' : 'Клиент';
            $lines[] = "{$prefix}: {$item['content']}";
        }

        $lines[] = "Клиент: {$message}";
        $lines[] = 'Ассистент:';

        return implode("\n", $lines);
    }

    private function cleanAiText(mixed $text): ?string
    {
        if (! is_string($text)) {
            return null;
        }

        $text = trim($this->stripProviderAds($text));

        return $text !== '' ? $text : null;
    }

    private function stripProviderAds(string $text): string
    {
        if (preg_match('/\n-{2,}\s*\n[\s\S]*$/u', $text, $match)) {
            $footer = Str::lower($match[0]);
            if (Str::contains($footer, ['pollinations', 'kofi', 'support our mission', '**ad**', '🌸'])) {
                $text = preg_replace('/\n-{2,}\s*\n[\s\S]*$/u', '', $text) ?? $text;
            }
        }

        $lines = preg_split("/\r\n|\n|\r/", $text) ?: [];
        $clean = [];

        foreach ($lines as $line) {
            $normalized = Str::lower(trim($line));

            if ($normalized === '') {
                $clean[] = $line;

                continue;
            }

            if (Str::contains($normalized, [
                'pollinations.ai',
                'pollinations',
                'support pollinations',
                'powered by pollinations',
                'support our mission',
                'kofi',
                '**ad**',
                '🌸',
            ])) {
                continue;
            }

            if (preg_match('/^\*{0,2}\s*ad\s*\*{0,2}$/iu', trim($line))) {
                continue;
            }

            $clean[] = $line;
        }

        $text = trim(implode("\n", $clean));
        $text = preg_replace("/\n{3,}/", "\n\n", $text) ?? $text;

        return trim($text);
    }

    private function systemPrompt(): string
    {
        return <<<'PROMPT'
Ты — виртуальный ассистент интернет-магазина автомобильных шин Autoclub (Россия).
Отвечай кратко, дружелюбно и по делу на русском языке.
Помогай с: подбором шин, каталогом, доставкой, оплатой, гарантией, шиномонтажом, заказами и контактами.
Факты о магазине:
- Доставка: бесплатно от 10 000 ₽ по Чебоксарам; в регионы — СДЭК, Boxberry, ПЭК.
- Телефон: +7 (999) 154-56-56, email: info@autoclub.ru.
- Адрес: г. Чебоксары, ул. Автомобильная, 10.
- Есть гарантия подлинности и шиномонтаж.
Если вопрос требует действий менеджера (жалоба, возврат конкретного заказа, индивидуальный расчёт) — предложи связаться по телефону или через страницу «Контакты».
Не выдумывай цены и наличие конкретных моделей — направляй в каталог.
Никогда не добавляй рекламу, подписи и ссылки на сторонние сервисы (Pollinations, Ko-fi и т.п.).
PROMPT;
    }

    private function fallbackReply(string $message): string
    {
        $text = Str::lower($message);

        if (Str::contains($text, ['привет', 'здравств', 'добрый', 'hi', 'hello'])) {
            return 'Здравствуйте! Я ассистент Autoclub. Помогу с выбором шин, доставкой, заказом или отвечу на вопросы о магазине. Чем могу помочь?';
        }

        if (Str::contains($text, ['доставк', 'привез', 'курьер', 'сдэк', 'отправ'])) {
            return 'Доставка по Чебоксарам бесплатна при заказе от 10 000 ₽ (иначе 490 ₽, 1–2 рабочих дня). По России отправляем СДЭК, Boxberry и ПЭК — срок и стоимость рассчитываются при оформлении. Подробнее на странице «Доставка».';
        }

        if (Str::contains($text, ['гарант', 'подлин', 'оригинал', 'поддел'])) {
            return 'Мы продаём только сертифицированные шины от официальных поставщиков. На все товары действует гарантия подлинности. Подробности — в разделе «Гарантия подлинности».';
        }

        if (Str::contains($text, ['шиномонтаж', 'монтаж', 'балансир', 'установ'])) {
            return 'В Autoclub есть собственный шиномонтаж: сезонная смена, балансировка и хранение шин. Запись и цены — на странице «Шиномонтаж» или по телефону +7 (999) 154-56-56.';
        }

        if (Str::contains($text, ['оплат', 'карт', 'налич', 'рассроч'])) {
            return 'Оплата доступна при оформлении заказа в личном кабинете — способы указаны на этапе оплаты. Если нужна консультация по оплате конкретного заказа, позвоните нам: +7 (999) 154-56-56.';
        }

        if (Str::contains($text, ['заказ', 'оформ', 'купить', 'корзин', 'каталог'])) {
            return 'Чтобы оформить заказ: выберите шины в каталоге, добавьте в корзину, войдите в аккаунт и перейдите к оформлению. Нужна регистрация — это займёт пару минут. Если что-то не получается — опишите проблему, помогу.';
        }

        if (Str::contains($text, ['размер', 'подбор', 'r16', 'r17', 'r18', 'летн', 'зимн', 'всесезон'])) {
            return 'Подбор шин зависит от размера (например 205/55 R16), сезона и стиля езды. Загляните в каталог — там можно фильтровать по параметрам. Напишите марку авто и размер с диска — подскажу, на что обратить внимание.';
        }

        if (Str::contains($text, ['контакт', 'телефон', 'почт', 'email', 'адрес', 'где вы', 'находит', 'связать'])) {
            return 'Контакты Autoclub: телефон +7 (999) 154-56-56, email info@autoclub.ru, адрес — г. Чебоксары, ул. Автомобильная, 10. Также можно написать через форму на странице «Контакты».';
        }

        if (Str::contains($text, ['возврат', 'обмен', 'вернут'])) {
            return 'Возврат и обмен регулируются законом о дистанционной торговле. Для индивидуальной ситуации лучше связаться с менеджером: +7 (999) 154-56-56 или info@autoclub.ru.';
        }

        if (Str::contains($text, ['спасибо', 'благодар'])) {
            return 'Рад помочь! Если появятся ещё вопросы — пишите. Хорошей дороги!';
        }

        return 'Спасибо за вопрос! Я могу подсказать по каталогу, доставке, оплате, гарантии и шиномонтажу. Уточните, пожалуйста, что именно вас интересует — или позвоните нам: +7 (999) 154-56-56.';
    }
}
