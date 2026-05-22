<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Летние шины', 'slug' => 'letnie'],
            ['name' => 'Зимние шины', 'slug' => 'zimnie'],
            ['name' => 'Всесезонные шины', 'slug' => 'vsesezonnye'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['slug' => $cat['slug']], $cat);
        }

        $products = [
            ['category' => 'letnie', 'slug' => 'michelin-primacy-4-205-55-r16', 'name' => 'Michelin Primacy 4 205/55 R16', 'price' => 8490, 'image' => 'michelin-primacy-4.png', 'description' => 'Летняя шина с отличным сцеплением на мокрой дороге. Низкий уровень шума, экономия топлива.'],
            ['category' => 'letnie', 'slug' => 'bridgestone-turanza-t005-225-45-r17', 'name' => 'Bridgestone Turanza T005 225/45 R17', 'price' => 11200, 'image' => 'bridgestone-turanza-t005.png', 'description' => 'Премиальная летняя шина для комфортной езды. Усиленная боковина, стабильность на скорости.'],
            ['category' => 'letnie', 'slug' => 'continental-premiumcontact-6-195-65-r15', 'name' => 'Continental PremiumContact 6 195/65 R15', 'price' => 6790, 'image' => 'continental-premiumcontact-6.png', 'description' => 'Универсальная летняя модель для городских автомобилей. Короткий тормозной путь.'],
            ['category' => 'zimnie', 'slug' => 'nokian-hakkapeliitta-10-205-55-r16', 'name' => 'Nokian Hakkapeliitta 10 205/55 R16', 'price' => 9890, 'image' => 'nokian-hakkapeliitta-10.png', 'description' => 'Шипованная зимняя шина для суровых условий. Надёжное сцепление на льду и снегу.'],
            ['category' => 'zimnie', 'slug' => 'gislaved-nord-frost-200-215-60-r16', 'name' => 'Gislaved Nord*Frost 200 215/60 R16', 'price' => 5490, 'image' => 'gislaved-nord-frost-200.jpg', 'description' => 'Доступная зимняя шина с шипами. Хорошая управляемость в городе.'],
            ['category' => 'zimnie', 'slug' => 'pirelli-ice-zero-fr-225-50-r17', 'name' => 'Pirelli Ice Zero FR 225/50 R17', 'price' => 10500, 'image' => 'pirelli-ice-zero-fr.jpeg', 'description' => 'Фрикционная зимняя шина без шипов. Для регионов с мягкой зимой.'],
            ['category' => 'vsesezonnye', 'slug' => 'goodyear-vector-4seasons-gen-3-205-55-r16', 'name' => 'Goodyear Vector 4Seasons Gen-3 205/55 R16', 'price' => 7990, 'image' => 'goodyear-vector-4seasons-gen-3.png', 'description' => 'Всесезонная шина для круглогодичной эксплуатации. Сбалансированные характеристики.'],
            ['category' => 'vsesezonnye', 'slug' => 'michelin-crossclimate-2-225-45-r17', 'name' => 'Michelin CrossClimate 2 225/45 R17', 'price' => 12490, 'image' => 'michelin-crossclimate-2.png', 'description' => 'Премиальная всесезонка с маркировкой 3PMSF. Подходит для лёгкого снега.'],
            ['category' => 'vsesezonnye', 'slug' => 'hankook-kinergy-4s2-195-65-r15', 'name' => 'Hankook Kinergy 4S2 195/65 R15', 'price' => 5890, 'image' => 'hankook-kinergy-4s2.png', 'description' => 'Экономичная всесезонная модель. Долгий срок службы протектора.'],
        ];

        foreach ($products as $item) {
            $category = Category::where('slug', $item['category'])->firstOrFail();

            Product::updateOrCreate(
                ['slug' => $item['slug']],
                [
                    'category_id' => $category->id,
                    'name' => $item['name'],
                    'price' => $item['price'],
                    'image' => $item['image'],
                    'description' => $item['description'],
                    'available' => true,
                ]
            );
        }

        User::updateOrCreate(
            ['email' => 'admin@autoclub.ru'],
            [
                'name' => 'Администратор',
                'password' => 'password',
                'is_admin' => true,
            ]
        );

        $client = User::updateOrCreate(
            ['email' => 'client@autoclub.ru'],
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
                'address' => 'ул. Автомобильная, 10',
                'postal_code' => '428000',
            ]
        );
    }
}
