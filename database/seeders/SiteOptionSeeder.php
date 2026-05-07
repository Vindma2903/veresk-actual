<?php

namespace Database\Seeders;

use App\Models\SiteOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SiteOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 'form_email',
                'title' => 'E-mail для отправки сообщений с сайта',
                'description' => '',
                '__temp' => 'info@veresk-landshaft.ru',
                'type' => SiteOption::BODY_TYPE_EMAIL,
            ],
        ];


        $footerContacts = <<<HTML
<div class="uppercase text-sm mb-4 opacity-50">Социальные сети</div>
<div class="flex gap-x-12">
    <a href="#" class="hover:underline hover:underline-offset-4">Twitter</a>
    <a href="#" class="hover:underline hover:underline-offset-4">Vkontakte</a>
    <a href="#" class="hover:underline hover:underline-offset-4">Odnoklassniki</a>
</div>

<div class="uppercase text-sm mb-4 mt-9 opacity-50">Почта</div>
<div class="flex gap-x-12">
    <a href="mailto:info@veresk-vandshaft.ru" class="hover:underline hover:underline-offset-4">info@veresk-vandshaft.ru</a>
</div>
HTML;

        $data[] =  [
            'id' => 'footer_contacts',
            'title' => 'Контактные данные внизу сайта',
            'description' => null,
            '__temp' => $footerContacts,
            'type' => SiteOption::BODY_TYPE_HTML,
        ];

        $topMenu = <<<JSON
[
    {
        "title": "О нас",
        "url": "/about"
    },
    {
        "title": "Услуги",
        "url": "/services",
        "children": [
            {
                "title": "Ландшафтное проектирование в СПб",
                "url": "/services/landshaftnoe-proektirovanie"
            },
            {
                "title": "Благоустройство дачного участка в СПб",
                "url": "/services/blagoustrojstvo-dachnogo-uchastka"
            },
            {
                "title": "Озеленение участка",
                "url": "/services/ozelenenie-uchastka"
            },
            {
                "title": "Уход за садом",
                "url": "/services/ukhod-za-sadom"
            },
            {
                "title": "Ландшафтный дизайн участка под ключ",
                "url": "/services/landshaftnyj-dizajn-uchastka"
            }
        ]
    },
    {
        "title": "Цены",
        "url": "/prices"
    },
    {
        "title": "Портфолио",
        "url": "/portfolio"
    },
    {
        "title": "Связаться",
        "url": "/contacts"
    }
]
JSON;
        $data[] =  [
            'id' => 'top_menu',
            'title' => 'Верхняя навигация',
            'description' => null,
            '__temp' => $topMenu,
            'type' => SiteOption::BODY_TYPE_JSON,
        ];

        $footerCopyright = <<<HTML
<div class="flex justify-between align-center text-sm mt-[100px]">
    <div class="opacity-70">©2017-<span id="js-current-year"></span> VERESK. All rights reserved.</div>
    <a href="/privacy-policy" class="underline underline-offset-4 opacity-70 hover:opacity-100">Privacy Policy</a>
</div>
HTML;
        $data[] =  [
            'id' => 'footer_copyright',
            'title' => 'Копирайт внизу сайта',
            'description' => null,
            '__temp' => $footerCopyright,
            'type' => SiteOption::BODY_TYPE_HTML,
        ];

        $portfolioHeader = <<<HTML
<div class="xl:flex xl:justify-between xl:items-center mt-24 lg:mt-32">
    <div class="text-4xl lg:text-6xl mb-5 xl:mb-0 uppercase">Наши проекты</div>
    <div>
        <div class="uppercase opacity-60 mb-4 xl:mb-2">Больше проектов в наших социальных сетях @veresklandscape</div>
        <a href="https://vk.com/veresk_landshaft" target="_blank" rel="nofollow" class="border border-white px-5 py-0.5 inline-block text-sm hover:opacity-80">Увидеть больше</a>
    </div>
</div>
HTML;

        $data[] = [
            'id' => 'portfolio_works_header',
            'title' => 'Заголовок наши проекты',
            'description' => 'Выводится на всех страницах портфолио внизу страницы',
            '__temp' => $portfolioHeader,
            'type' => SiteOption::BODY_TYPE_HTML,
        ];

        $topMenuContacts = <<<JSON
[
  {
    "title": "Telegram",
    "url": "https://t.me/veresklandshaft",
    "i": "lab la-telegram"
  },
  {
    "title": "Whatsapp",
    "url": "https://wa.me/79219051863",
    "i": "lab la-whatsapp"
  }
]
JSON;
        $data[] =  [
            'id' => 'top_menu_contacts',
            'title' => 'Контакты в меню десктоп',
            'description' => 'Меню для размера десктопа, свёрстано для двух контактов',
            '__temp' => $topMenuContacts,
            'type' => SiteOption::BODY_TYPE_JSON,
        ];

        $topMenuContactsMobile = <<<JSON
[
  {
    "title": "info@veresk-landshaft.ru",
    "url": "mailto:info@veresk-landshaft.ru",
    "i": "las la-envelope"
  },
  {
    "title": "+7 (812) 905-18-63",
    "url": "tel:+78129051863",
    "i": "las la-phone"
  },
  {
    "title": "+7 (921) 905-18-63",
    "url": "tel:+79219051863",
    "i": "las la-phone"
  },
  {
    "title": "Telegram",
    "url": "https://t.me/veresklandshaft",
    "i": "lab la-telegram"
  },
  {
    "title": "Whatsapp",
    "url": "https://wa.me/79219051863",
    "i": "lab la-whatsapp"
  }
]
JSON;

        $data[] =  [
            'id' => 'top_menu_contacts_mobile',
            'title' => 'Контакты в меню для мобильных',
            'description' => null,
            '__temp' => $topMenuContactsMobile,
            'type' => SiteOption::BODY_TYPE_JSON,
        ];


        foreach ($data as $key => $item) {
            $val = $item['__temp'];
            unset($item['__temp']);
            if ($item['type'] === SiteOption::BODY_TYPE_JSON) {
                $item['body_json'] = $val;
                $item['body'] = null;
            } else {
                $item['body'] = $val;
                $item['body_json'] = null;
            }
            $data[$key] = $item;
        }
        DB::table('site_options')->truncate();
        DB::table('site_options')->insert(\array_values($data));
    }
}
