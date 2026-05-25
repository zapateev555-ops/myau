<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FetchProductImages extends Command
{
    protected $signature = 'images:fetch-products';

    protected $description = 'Загрузить реальные фото товаров из каталогов (izap24 и др.)';

    /** @var array<string, string> slug => page URL or direct image URL */
    private array $sources = [
        'mann-w-712-95' => 'https://izap24.ru/new/w71295-mann-2061651/',
        'bosch-spark-plug-fr7dc' => 'https://izap24.ru/katalog/?filter%5Btext%5D=FR7DC+Bosch',
        'gates-timing-belt-5529xs' => 'https://novosibirsk.izap24.ru/new/5408xs-gates-1478567/',
        'mahle-kolbtseno-kpl-026' => 'https://voronej.izap24.ru/new/01106n0-mahle-2299343/',
        'ina-tensioner-534-0181' => 'https://rostov-na-donu.izap24.ru/new/534001610-ina-1521062/',
        'elring-prokladka-gbc-4078' => 'https://izap24.ru/new/343370-elring-1424089/',
        'brembo-pad-p85077' => 'https://izap24.ru/new/p85077-brembo-1377531/',
        'ate-disc-24-0131' => 'https://ufa.izap24.ru/new/24012501581-ate-1343527/',
        'ferodo-ds2500-pad' => 'https://izap24.ru/katalog/?filter%5Btext%5D=DS2500+Ferodo',
        'trw-brake-hose-scj115' => 'https://izap24.ru/new/pha344-trw-8712860/',
        'ate-brake-fluid-dot4' => 'https://izap24.ru/katalog/?filter%5Btext%5D=тормозная+жидкость+ATE+SL6',
        'textar-pad-2395601' => 'https://volgograd.izap24.ru/new/2395001-textar-1841683/',
        'sachs-amort-313-267' => 'https://novosibirsk.izap24.ru/new/317575-sachs-1762058/',
        'lemforder-stabil-link-27318' => 'https://izap24.ru/new/3603901-lemforder-1570703/',
        'moog-ball-joint-k80632' => 'https://izap24.ru/new/fisb16934-moog-13802504/',
        'fag-hub-bearing-713-6107' => 'https://izap24.ru/new/713610610-fag-1443842/',
        'trw-tie-rod-jte190' => 'https://novosibirsk.izap24.ru/new/jte1090-trw-1829068/',
        'kyb-spring-sm5126' => 'https://izap24.ru/new/ra5249-kyb-52397937/',
        'bosch-battery-s5-008' => 'https://ekb.izap24.ru/new/0092s50080-bosch-1935648/',
        'philips-h7-x-treme' => 'https://izap24.ru/katalog/?filter%5Btext%5D=12972XV+Philips',
        'valeo-starter-438-226' => 'https://izap24.ru/katalog/?filter%5Btext%5D=438226+Valeo',
        'denso-alternator-dan-999' => 'https://novosibirsk.izap24.ru/new/3730027013-hyundai-kia-9080439/',
        'febi-sensor-abs-37452' => 'https://izap24.ru/new/181010-febi-18623680/',
        'hella-horn-twin-007' => 'https://kazan.izap24.ru/new/0986ah0501-bosch-2270802/',
        'hella-wiper-aerotwin' => 'https://volgograd.izap24.ru/new/3397118995-bosch-1373742/',
        'febi-mirror-glass-45712' => 'https://izap24.ru/new/566857507e-vag-5886237/',
        'valeo-clutch-kit-826-552' => 'https://izap24.ru/new/786027-valeo-1876951/',
        'mann-cabin-filter-cuk-2939' => 'https://izap24.ru/new/cuk2939-mann-2055752/',
        'febi-door-lock-171-175' => 'https://izap24.ru/new/172114-febi-11855743/',
        'hella-fog-lamp-ff-50' => 'https://ekb.izap24.ru/tovar/34539407_novyie-hella-fara-2w1-svet-plus-protivotumannyie.html',
        'castrol-edge-5w30-4l' => 'https://izap24.ru/new/15f6dc-castrol-32303018/',
        'motul-8100-5w40-5l' => 'https://izap24.ru/tovar/13557302_motul-8100-x-cess-5w40-5l-oficjalna-dystrybucja.html',
        'glysantin-g40-5l' => 'https://krasnoyarsk.izap24.ru/new/p999evo12005-hepu-47509850/',
        'liqui-moly-atf-1l' => 'https://habarovsk.izap24.ru/new/20460-liqui-moly-2190098/',
        'mann-air-filter-c-25-114' => 'https://izap24.ru/katalog/?filter%5Btext%5D=C25114+MANN',
        'febi-washer-fluid-5l' => 'https://izap24.ru/katalog/?filter%5Btext%5D=Febi+омыватель',
    ];

    public function handle(): int
    {
        $dir = public_path('images/products');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $ok = 0;
        foreach ($this->sources as $slug => $source) {
            $imageUrl = $this->resolveImageUrl($source);
            if (! $imageUrl) {
                $this->warn("Нет фото: {$slug}");
                continue;
            }

            if ($this->download($slug, $imageUrl, $dir)) {
                $this->info("OK {$slug}");
                $ok++;
            } else {
                $this->warn("Ошибка загрузки: {$slug}");
            }
            usleep(250000);
        }

        $this->info("Готово: {$ok}/".count($this->sources));

        return self::SUCCESS;
    }

    private function resolveImageUrl(string $source): ?string
    {
        if (preg_match('/\.(jpe?g|png|webp)(\?|$)/i', $source)) {
            return $source;
        }

        $page = $this->findProductPage($source);
        if (! $page) {
            return null;
        }

        $html = $this->fetch($page);
        if (! $html) {
            return null;
        }

        $candidates = [];

        if (preg_match('/property="og:image"\s+content="([^"]+)"/i', $html, $m)) {
            $candidates[] = $m[1];
        }

        if (preg_match_all('#https://cdn\.izap24\.ru/images/(?:newprod|prodacts/sourse)/[^"\'\s>]+\.(?:webp|jpe?g|png)#i', $html, $matches)) {
            foreach ($matches[0] as $url) {
                $candidates[] = $url;
            }
        }

        if (preg_match_all('#https://(?:[\w.-]+\.)?izap24\.ru/sticker/[^"\'\s>]+#i', $html, $stickers)) {
            foreach ($stickers[0] as $url) {
                $candidates[] = $url;
            }
        }

        return $this->pickBestPhotoUrl($candidates);
    }

    /** @param  list<string>  $urls */
    private function pickBestPhotoUrl(array $urls): ?string
    {
        $filtered = [];
        foreach (array_unique($urls) as $url) {
            if (str_contains($url, '/banners/') || str_contains($url, '/images/rb/')) {
                continue;
            }
            if (str_contains($url, '/images/newprod/') && preg_match('#/s\d+/#', $url)) {
                continue;
            }
            if (str_contains($url, '/images/prodacts/') && ! str_contains($url, '/images/prodacts/sourse/')) {
                continue;
            }
            $filtered[] = $url;
        }

        if ($filtered === []) {
            return null;
        }

        if (count($filtered) === 1) {
            return $filtered[0];
        }

        $bestUrl = $filtered[0];
        $bestScore = -1.0;

        foreach (array_slice($filtered, 0, 8) as $url) {
            $score = $this->scoreProductPhoto($url);
            if ($score > $bestScore) {
                $bestScore = $score;
                $bestUrl = $url;
            }
        }

        return $bestUrl;
    }

    private function scoreProductPhoto(string $url): float
    {
        $ctx = stream_context_create([
            'http' => [
                'header' => "User-Agent: MotorDetalShop/1.0\r\n",
                'timeout' => 20,
            ],
        ]);
        $data = @file_get_contents($url, false, $ctx);
        if ($data === false || strlen($data) < 2500) {
            return 0;
        }

        $img = @imagecreatefromstring($data);
        if (! $img) {
            return str_contains($url, '/images/prodacts/sourse/') ? 50 : 10;
        }

        $w = imagesx($img);
        $h = imagesy($img);
        $colors = [];
        $samples = min(800, max(100, (int) ($w * $h / 400)));
        for ($i = 0; $i < $samples; $i++) {
            $rgb = imagecolorat($img, random_int(0, max(0, $w - 1)), random_int(0, max(0, $h - 1)));
            $colors[$rgb & 0xFFFFFF] = true;
        }
        imagedestroy($img);

        $diversity = count($colors);
        $bonus = str_contains($url, '/images/prodacts/sourse/') ? 40 : 0;
        $bonus += str_contains($url, '/sticker/') ? 30 : 0;

        return $diversity + $bonus;
    }

    private function findProductPage(string $url): ?string
    {
        if (preg_match('#/(new|tovar)/#', $url)) {
            return $url;
        }

        $html = $this->fetch($url);
        if (! $html) {
            return null;
        }

        if (preg_match('#href="(https://[^"]*izap24\.ru/(?:new|tovar)/[^"]+)"#i', $html, $m)) {
            return $m[1];
        }
        if (preg_match('#href="(/(?:new|tovar)/[^"]+)"#i', $html, $m)) {
            return 'https://izap24.ru'.$m[1];
        }

        return null;
    }

    private function fetch(string $url): ?string
    {
        $ctx = stream_context_create([
            'http' => [
                'header' => "User-Agent: MotorDetalShop/1.0\r\n",
                'timeout' => 30,
            ],
        ]);
        $body = @file_get_contents($url, false, $ctx);

        return $body !== false ? $body : null;
    }

    private function download(string $slug, string $url, string $dir): bool
    {
        $ctx = stream_context_create([
            'http' => [
                'header' => "User-Agent: MotorDetalShop/1.0\r\n",
                'timeout' => 45,
            ],
        ]);
        $data = @file_get_contents($url, false, $ctx);
        if ($data === false || strlen($data) < 2500) {
            return false;
        }

        $jpg = $dir.DIRECTORY_SEPARATOR.$slug.'.jpg';
        $webp = $dir.DIRECTORY_SEPARATOR.$slug.'.webp';

        if (str_contains(strtolower($url), '.webp') && function_exists('imagecreatefromwebp')) {
            file_put_contents($webp, $data);
            $img = @imagecreatefromwebp($webp);
            if ($img) {
                imagejpeg($img, $jpg, 88);
                imagedestroy($img);
                @unlink($webp);

                return is_file($jpg) && filesize($jpg) > 2500;
            }
        }

        file_put_contents($jpg, $data);

        return is_file($jpg) && filesize($jpg) > 2500;
    }
}
