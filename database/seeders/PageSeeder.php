<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\DomCrawler\Crawler;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            'homepage' => [
                'title' => 'Ничего лишнего только гармония',
                'created_at' => new \DateTime('Mon, 6 Mar 2017 14:48:13 GMT'),
                'meta_title' => 'Ландшафтный дизайн в Санкт-Петербурге от компании Вереск',
                'meta_keywords' => 'ландшафтный дизайн спб компания санкт петербург фирма питер',
                'meta_description' => 'Ландшафтный дизайн в Санкт-Петербурге под ключ! Бесплатное проектирование, благоустройство, озеленение, посадка газона, дренаж. Тел.8(812)905-18-63'
            ],
            'about' => [
                'title' => 'Ландшафтный дизайн от мастерской вереск',
                'created_at' => new \DateTime('Mon, 6 Mar 2017 14:48:13 GMT'),
                'meta_title' => 'О компании - мастерская ландшафтов Вереск Санкт Петербург и ЛО',
                'meta_keywords' => 'о компании вереск',
                'meta_description' => 'Ландшафтные работы на загородном участке под ключ. Бесплатное проектирование, благоустройство, посадка растений. Гарантия на работы. Тел.8(812)905-18-63'

            ],
            'contacts' => [
                'title' => 'Контакты',
                'created_at' => new \DateTime('Mon, 6 Mar 2017 14:48:13 GMT'),
                'meta_keywords' => 'ландшафтная компания вереск контакты',
                'meta_description' => 'Предоставляем полный комплекс услуг ландшафтного строительства под ключ в Санкт-Петербурге и ЛО! Проектирование, благоустройство, озеленение и уход за садом.'
            ],
            'earthwork' => [
                'title' => 'Земляные работы',
                'created_at' => new \DateTime('Mon, 6 Mar 2017 14:48:13 GMT'),
            ],
            'planting' => [
                'title' => 'Посадка растений и крупномеров',
                'created_at' => new \DateTime('Mon, 6 Mar 2017 14:48:13 GMT'),
            ],
            'portfolio' => [
                'title' => 'Портфолио',
                'created_at' => new \DateTime('Mon, 6 Feb 2017 13:15:58 GMT'),
                'meta_keywords' => 'портфолио ландшафтный дизайн',
                'meta_description' => 'Ландшафтный дизайн в Санкт-Петербурге и области. Бесплатное проектирование, благоустройство и озеленение участка. Гарантии на работы. Тел.8(812)905-18-63'
            ],
            'prices' => [
                'title' => 'Цены',
                'created_at' => new \DateTime('Mon, 6 Mar 2017 14:48:13 GMT'),
                'meta_title' => 'Цены на ландшафтные работы на участке',
                'meta_keywords' => 'ландшафтные работы цена на участке услуги спб прайс лист расценки',
                'meta_description' => 'Ландшафтный дизайн в Санкт-Петербурге под ключ! Бесплатное проектирование, благоустройство, озеленение, посадка газона, дренаж. Тел.8(812)905-18-63'
            ],
            'services' => [
                'title' => 'Ландшафтный дизайн участка под ключ',
                'created_at' => new \DateTime(),
                'meta_keywords' => 'ландшафтный дизайн дачного участка под ключ стоимость спб',
                'meta_description' => 'Дизайн загородного участка в Санкт-Петербурге. Проектирование бесплатно, акции, портфолио. Высокий уровень качества в мастерской Вереск Тел.8(812)905-18-63'
            ],
            'privacy-policy' => [
                'title' => 'Соглашение на обработку персональных данных',
                'created_at' => new \DateTime(),
            ]
        ];

        $data = [];
        foreach ($pages as $slug => $fields) {
            $sections = View::make('pages.'.$slug)->renderSections();
            $createdAt = $fields['created_at'];
            $updatedAt = new \DateTime();

            $body = null;
            if (!empty($sections['main'])) {
                $body = self::cleanHtml($sections['main']);
            }
            $bodyBefore = null;
            if (!empty($sections['main_before'])) {
                $bodyBefore = self::cleanHtml($sections['main_before']);
            }

            $item = [
                'title' => $fields['title'],
                'slug' => $slug,
                'body_before' => $bodyBefore,
                'body' => $body,
                'is_active' => true,
                'created_at' => $createdAt,
                'updated_at' => $updatedAt,
                'meta_title' => $fields['meta_title'] ?? null,
                'meta_keywords' => $fields['meta_keywords'] ?? null,
                'meta_description' => $fields['meta_description'] ?? null,
            ];

            $data[] = $item;
//            break;
        }

        DB::table('pages')->truncate();
        DB::table('pages')->insert(\array_values($data));
    }

    private static function cleanHtml(string $html):string
    {
        // пустые строки
        $html = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $html);

        $html = str_replace([
            'http://127.0.0.1:8000',
        ], '', $html);

        return trim($html);
    }
}
