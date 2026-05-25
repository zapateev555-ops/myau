<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    private const VALID_SLUGS = ['dvigatel', 'tormoza', 'podveska', 'elektrika', 'kuzov', 'rashodniki'];

    public function run(): void
    {
        Product::whereHas('category', fn ($q) => $q->whereNotIn('slug', self::VALID_SLUGS))->delete();
        Category::whereNotIn('slug', self::VALID_SLUGS)->delete();

        $categories = [
            ['name' => 'Двигатель и фильтры', 'slug' => 'dvigatel', 'image' => 'dvigatel.jpg'],
            ['name' => 'Тормозная система', 'slug' => 'tormoza', 'image' => 'tormoza.jpg'],
            ['name' => 'Подвеска и рулевое', 'slug' => 'podveska', 'image' => 'podveska.jpg'],
            ['name' => 'Электрика и свет', 'slug' => 'elektrika', 'image' => 'elektrika.jpg'],
            ['name' => 'Кузов и салон', 'slug' => 'kuzov', 'image' => 'kuzov.jpg'],
            ['name' => 'Расходники и жидкости', 'slug' => 'rashodniki', 'image' => 'rashodniki.jpg'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $products = [
            ['category' => 'dvigatel', 'slug' => 'mann-w-712-95', 'name' => 'Фильтр масляный MANN W 712/95', 'price' => 890, 'description' => 'Оригинальный аналог для VAG 1.4–1.6 TSI. Высокая степень фильтрации.'],
            ['category' => 'dvigatel', 'slug' => 'bosch-spark-plug-fr7dc', 'name' => 'Свеча зажигания Bosch FR7DC+', 'price' => 420, 'description' => 'Комплект для 4-цилиндровых двигателей. Стабильное искрообразование.'],
            ['category' => 'dvigatel', 'slug' => 'gates-timing-belt-5529xs', 'name' => 'Ремень ГРМ Gates 5529XS', 'price' => 2890, 'description' => 'Зубчатый ремень для Hyundai/Kia 1.6 GDI. Армированный корд.'],
            ['category' => 'dvigatel', 'slug' => 'mahle-kolbtseno-kpl-026', 'name' => 'Поршневые кольца Mahle 026 98 N0', 'price' => 4590, 'description' => 'Комплект для капитального ремонта двигателя ВАЗ 21126.'],
            ['category' => 'dvigatel', 'slug' => 'ina-tensioner-534-0181', 'name' => 'Натяжитель ремня INA 534 0181 10', 'price' => 3290, 'description' => 'Ролик натяжителя приводного ремня для Toyota 2.0.'],
            ['category' => 'dvigatel', 'slug' => 'elring-prokladka-gbc-4078', 'name' => 'Прокладка ГБЦ Elring 407.820', 'price' => 1890, 'description' => 'Многослойная стальная прокладка для BMW N47.'],

            ['category' => 'tormoza', 'slug' => 'brembo-pad-p85077', 'name' => 'Колодки тормозные Brembo P 85 077', 'price' => 5490, 'description' => 'Передние колодки для VW Golf VII 1.4 TSI. Низкий уровень пыли.'],
            ['category' => 'tormoza', 'slug' => 'ate-disc-24-0131', 'name' => 'Диск тормозной ATE 24.0131-0159.1', 'price' => 4290, 'description' => 'Вентилируемый передний диск 312 мм для Ford Focus III.'],
            ['category' => 'tormoza', 'slug' => 'ferodo-ds2500-pad', 'name' => 'Колодки Ferodo DS2500 HP', 'price' => 7890, 'description' => 'Спортивные колодки для трека и агрессивной езды.'],
            ['category' => 'tormoza', 'slug' => 'trw-brake-hose-scj115', 'name' => 'Шланг тормозной TRW SCJ115', 'price' => 1290, 'description' => 'Передний левый шланг для Lada Vesta.'],
            ['category' => 'tormoza', 'slug' => 'ate-brake-fluid-dot4', 'name' => 'Жидкость тормозная ATE SL.6 DOT4', 'price' => 690, 'description' => '1 л, высокая температура кипения, совместима с ESP.'],
            ['category' => 'tormoza', 'slug' => 'textar-pad-2395601', 'name' => 'Колодки Textar 2395601', 'price' => 3890, 'description' => 'Задние колодки для Mercedes W205 220d.'],

            ['category' => 'podveska', 'slug' => 'sachs-amort-313-267', 'name' => 'Амортизатор Sachs 313 267', 'price' => 6490, 'description' => 'Передний газомасляный амортизатор для Skoda Octavia A5.'],
            ['category' => 'podveska', 'slug' => 'lemforder-stabil-link-27318', 'name' => 'Стойка стабилизатора Lemförder 27318 01', 'price' => 1490, 'description' => 'Соединительная тяга переднего стабилизатора BMW E90.'],
            ['category' => 'podveska', 'slug' => 'moog-ball-joint-k80632', 'name' => 'Шаровая опора Moog K80632', 'price' => 2190, 'description' => 'Нижняя опора для Chevrolet Cruze, усиленный корпус.'],
            ['category' => 'podveska', 'slug' => 'fag-hub-bearing-713-6107', 'name' => 'Подшипник ступицы FAG 713 6107 10', 'price' => 5290, 'description' => 'Комплект с ABS-кольцом для Renault Duster 4x4.'],
            ['category' => 'podveska', 'slug' => 'trw-tie-rod-jte190', 'name' => 'Наконечник рулевой TRW JTE190', 'price' => 1890, 'description' => 'Левый наконечник для Toyota Camry XV70.'],
            ['category' => 'podveska', 'slug' => 'kyb-spring-sm5126', 'name' => 'Пружина подвески KYB SM5126', 'price' => 3590, 'description' => 'Передняя пружина для Honda Civic X.'],

            ['category' => 'elektrika', 'slug' => 'bosch-battery-s5-008', 'name' => 'АКБ Bosch S5 008 77Ah', 'price' => 12490, 'description' => 'AGM для систем Start-Stop. Ток холодного пуска 780 А.'],
            ['category' => 'elektrika', 'slug' => 'philips-h7-x-treme', 'name' => 'Лампа H7 Philips X-tremeVision', 'price' => 1290, 'description' => 'Комплект 2 шт., +130% света, 12V 55W.'],
            ['category' => 'elektrika', 'slug' => 'valeo-starter-438-226', 'name' => 'Стартер Valeo 438226', 'price' => 9890, 'description' => 'Восстановленный аналог для Peugeot 308 1.6 THP.'],
            ['category' => 'elektrika', 'slug' => 'denso-alternator-dan-999', 'name' => 'Генератор Denso DAN999', 'price' => 14500, 'description' => '140A для Kia Ceed JD 1.6 GDI.'],
            ['category' => 'elektrika', 'slug' => 'febi-sensor-abs-37452', 'name' => 'Датчик ABS Febi 37452', 'price' => 2490, 'description' => 'Передний левый датчик скорости для Audi A4 B8.'],
            ['category' => 'elektrika', 'slug' => 'hella-horn-twin-007', 'name' => 'Сигнал Hella Twin Tone', 'price' => 2190, 'description' => 'Двухтональный электрический сигнал 12V 118dB.'],

            ['category' => 'kuzov', 'slug' => 'hella-wiper-aerotwin', 'name' => 'Щётки стеклоочистителя Hella Aerotwin', 'price' => 1890, 'description' => 'Бескаркасный комплект 600/400 мм для универсала.'],
            ['category' => 'kuzov', 'slug' => 'febi-mirror-glass-45712', 'name' => 'Зеркальный элемент Febi 45712', 'price' => 990, 'description' => 'Правый с обогревом для VW Polo Sedan.'],
            ['category' => 'kuzov', 'slug' => 'valeo-clutch-kit-826-552', 'name' => 'Комплект сцепления Valeo 826552', 'price' => 18900, 'description' => 'Диск + корзина + выжимной для Renault Logan II.'],
            ['category' => 'kuzov', 'slug' => 'mann-cabin-filter-cuk-2939', 'name' => 'Фильтр салона MANN CUK 2939', 'price' => 790, 'description' => 'Угольный фильтр для BMW 3 F30.'],
            ['category' => 'kuzov', 'slug' => 'febi-door-lock-171-175', 'name' => 'Замок двери Febi 171175', 'price' => 4590, 'description' => 'Привод замка передней правой двери Mercedes W212.'],
            ['category' => 'kuzov', 'slug' => 'hella-fog-lamp-ff-50', 'name' => 'Противотуманная фара Hella FF 50', 'price' => 3290, 'description' => 'Левая H11, стекло из закалённого стекла.'],

            ['category' => 'rashodniki', 'slug' => 'castrol-edge-5w30-4l', 'name' => 'Масло Castrol Edge 5W-30 A3/B4 4л', 'price' => 3890, 'description' => 'Синтетика для бензиновых и дизельных двигателей.'],
            ['category' => 'rashodniki', 'slug' => 'motul-8100-5w40-5l', 'name' => 'Масло Motul 8100 X-cess 5W-40 5л', 'price' => 5490, 'description' => 'Высокотемпературная синтетика для турбомоторов.'],
            ['category' => 'rashodniki', 'slug' => 'glysantin-g40-5l', 'name' => 'Антифриз Glysantin G40 5л', 'price' => 2190, 'description' => 'Концентрат lilac, совместим с VAG G12++.'],
            ['category' => 'rashodniki', 'slug' => 'liqui-moly-atf-1l', 'name' => 'ATF Liqui Moly Top Tec 1200 1л', 'price' => 1290, 'description' => 'Трансмиссионная жидкость для 6-ступенчатых АКПП.'],
            ['category' => 'rashodniki', 'slug' => 'mann-air-filter-c-25-114', 'name' => 'Фильтр воздушный MANN C 25 114', 'price' => 690, 'description' => 'Для Toyota Corolla E150 1.6.'],
            ['category' => 'rashodniki', 'slug' => 'febi-washer-fluid-5l', 'name' => 'Омыватель стекла Febi -20°C 5л', 'price' => 490, 'description' => 'Летне-зимний концентрат, без запаха спирта.'],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category'])->firstOrFail();

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['slug'].'.jpg',
                    'description' => $item['description'],
                    'available' => true,
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@motordetal.ru'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@motordetal.ru'],
            [
                'name' => 'Алексей Смирнов',
                'password' => 'password',
                'is_admin' => false,
            ]
        );

        $client->profile()->updateOrCreate(
            ['user_id' => $client->id],
            [
                'phone' => '+7 (999) 154-56-56',
                'city' => 'Чебоксары',
                'address' => 'ул. Гаражная, 14',
                'postal_code' => '428000',
            ]
        );
    }
}
