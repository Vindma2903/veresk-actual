<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\View;
use Symfony\Component\DomCrawler\Crawler;

class PortfolioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $pages = [
            'moon-lake' => ['title' => 'Лунное озеро'],
            'visualizations' => ['title' => 'Визуализации'],
            'belveder' => ['title' => 'Бельведер'],
            'sukhodole' => ['title' => 'Суходолье'],
            1 => ['title' => 'Водный мир'],
        ];

        $data = [];
        $exampleSections = View::make('pages.portfolio-example')->renderSections();
        foreach ($pages as $slug => $fields) {
            if (is_string($slug) && View::exists('pages.'.$slug)) {
                $sections = View::make('pages.'.$slug)->renderSections();
            } else {
                $sections = $exampleSections;
            }

            if (!is_string($slug)) {
                $slug = str($fields['title'])->slug();
            }

            $createdAt = $fields['created_at'] ?? new \DateTime();
            $updatedAt = new \DateTime();

            $body = null;
            if (!empty($sections['main'])) {
                $body = self::cleanHtml($sections['main']);
            }
            $bodyBefore = null;
            if (!empty($sections['main_before'])) {
                $bodyBefore = self::cleanHtml($sections['main_before']);
                $crawler = new Crawler($bodyBefore);
                $crawler->filter('h1')->each(function (Crawler $crawler) use ($fields) {
                    foreach ($crawler as $node) {
                        $h1 = $node;
                        $h1->textContent = $fields['title'];
                        $node->parentNode->replaceChild($node, $h1);
                    }
                });
                $bodyBefore = $crawler->html();
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
        }

        DB::table('portfolios')->truncate();
        DB::table('portfolios')->insert(\array_values($data));
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
