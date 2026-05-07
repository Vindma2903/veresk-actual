<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Symfony\Component\DomCrawler\Crawler;

class ServiceSeeder extends Seeder
{
    private static string $siteUrl = 'https://veresk-landshaft.ru';
    private static array $serviceSlugs = [];
    private static array $serviceWorksData = [];
    private static bool $isOnlyOne = false;
    private static bool $isReplaceServiceWorkImages = false;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $parentSlugs = [
            'landshaftnoe-proektirovanie' => [
                'landshaftnye-predproektnye-raboty',
                'sostav-landshaftnogo-proekta',
                'topograficheskaya-semka',
                'analiz-pochvy',
            ],
            'blagoustrojstvo-dachnogo-uchastka' => [
                'moshhenie-dorozhek',
                'livnevaya-kanalizaciya',
                'drenazh-uchastka',
                'podpornye-stenki',
                'parkovka-na-dache-pod-klyuch',
                'ekoparkovka-pod-klyuch',
                'otmostka-vokrug-doma',
                'raschistka-uchastka',
                'pokos-travy',
            ],
            'ozelenenie-uchastka' => [
                'posadka-rastenij',
                'zhivye-izgorodi',
                'ustrojstvo-gazona',
                'rulonnyj-gazon-pod-klyuch',
                'posevnoj-gazon-pod-klyuch',
            ],
            'ukhod-za-sadom' => [
                'ukhod-za-sadom-vesnoj',
                'ukhod-za-sadom-osenyu',
                'uslugi-strizhki-gazona',
                'uslugi-ukhoda-za-gazonom',
                'strizhka-zhivoj-izgorodi',
                'obrezka-derevev',
                'obrezka-kustov',
                'ochistka-prudov',
                'prochistka-livnevoj-kanalizacii',
                'uborka-territorii-ot-listvy',
            ],
            'raschistka-uchastka' => [
                'korchevanie-pnej',
                'valka-derevev',
                'vyrubka-kustarnika',
            ],
            'posadka-rastenij' => [
                'posadka-kustarnikov',
                'posadka-derevev',
            ],
            'podpornye-stenki' => [
                'podpornye-stenki-iz-kamnya',
                'podpornye-stenki-iz-gabionov',
                'podpornye-stenki-iz-dereva',
                'podpornye-stenki-iz-betona',
                'oblicovka-podpornykh-stenok',
                'metallicheskie-podpornye-stenki',
            ],
            'moshhenie-dorozhek' => [
                'nabivnye-dorozhki',
                'moshhenie-trotuarnoj-plitkoj',
                'moshhenie-prirodnym-kamnem',
                'moshhenie-klinkerom',
                'moshhenie-bruschatkoj',
                'derevyannye-dorozhki-na-dache',
            ],
            'landshaftnyj-dizajn-uchastka' => []
        ];

        $childParent = [];

        foreach ($parentSlugs as $parent => $children) {
            if (!\in_array($parent, self::$serviceSlugs, true)) {
                self::$serviceSlugs[] = $parent;
            }
            foreach ($children as $child) {
                if (!\in_array($child, self::$serviceSlugs, true)) {
                    self::$serviceSlugs[] = $child;
                    $childParent[$child] = $parent;
                }
            }
        }

        $positions = [];

        foreach (self::$serviceSlugs as $key => $slug) {
            $url = self::$siteUrl . '/' . $slug;
            $html = file_get_contents($url);
            if (!$html) throw new \Error('file_get_contents html is empty');
            if (empty(self::$serviceWorksData)) {
                self::getWorks($html);
            }
            $item = self::scrape($html);
            $item['slug'] = $slug;
            $positionKey = \in_array($slug, \array_keys($childParent), true) ? $childParent[$slug] : 0;
            if (!isset($positions[$positionKey])) {
                $positions[$positionKey] = 1;
            }
            $item['position'] = $positions[$positionKey];
            $item['is_show_homepage'] = false;

            $positions[$positionKey] += 1;

            $data[] = $item;
            if (self::$isOnlyOne) {
                break;
            }
        }

        DB::table('service_works')->truncate();
        DB::table('service_works')->insert(\array_values(self::$serviceWorksData));
        DB::table('services')->truncate();
        DB::table('services')->insert(\array_values($data));

        // set parents
        $services = Service::all();
        $slugIdArr = Service::query()->pluck('id', 'slug')->toArray();

        foreach ($services as $service) {
            $slug = $service->slug;
            if (\in_array($slug, \array_keys($childParent), true)) {
                // have parent
                $service->parent_id = $slugIdArr[$childParent[$slug]];
                $service->is_show_homepage = rand(1, 2) === 2;
            } else {
                $service->is_show_homepage = true;
            }
            $service->save();
        }
    }

    private static function getWorks(string $html) : void
    {
        // remove all files in directory
        $files = glob(public_path('storage/files/service_works/*'));
        foreach ($files as $file) {
            if (is_file($file)) {
                unlink($file);
            }
        }

        $dc = new Crawler($html);
        $dc->filter('.works a.portfolio-fancy')->each(function (Crawler $a) {
            $path = $a->getNode(0)->getAttribute('href');
            $oldPath = public_path($path);
            if (file_exists($oldPath)) {
                $newPath = 'files/service_works/' . md5($path) . '.' . pathinfo($path)['extension'];
                copy($oldPath, public_path('storage/' . $newPath));
                self::$serviceWorksData[] = [
                    'thumbnail' => $newPath,
                    'position' => \count(self::$serviceWorksData) + 1,
                ];
            }
        });
    }

    private static function scrape(string $html): array
    {
        $dc = new Crawler($html);

        $title = $dc->filter('h1')->innerText();
        $content = $dc->filter('#content');
        $metaTitle = $dc->filterXPath('//html/head/meta[@name="Title"]')->attr('content');
        $metaDescription = $dc->filterXPath('//html/head/meta[@name="Description"]')->attr('content');
        $metaDescription = str_replace('Тел.8(812)905-18-63', '', $metaDescription);

        $metaKeywords = $dc->filterXPath('//html/head/meta[@name="Keywords"]')->attr('content');
        $lastModified = $dc->filterXPath('//html/head/meta[@name="Last-Modified"]')->attr('content');
        try {
            $updatedAt = new \DateTime($lastModified);
        } catch (\Exception $e) {
            $updatedAt = new \DateTime();
        }
        $createdAt = clone $updatedAt;
        $createdAt->sub(new \DateInterval('P1Y'));

        $titleImg = $dc->filter('.pageTitle img')->attr('src');
        if (!empty($titleImg)) {
            $newPath = 'files/services/' . pathinfo($titleImg)['basename'];
            $oldPath = public_path($titleImg);
            if (file_exists($oldPath)) {
                rename($oldPath, public_path('storage' . $newPath));
            }
            $titleImg = $newPath;
        }

        // remove path
        self::removeFromParentNode($content->filter('#path'));

        // remove h1 block
        self::removeFromParentNode($content->filter('.pageTitle.ins'));

        // remove colgroup
        self::removeFromParentNode($content->filter('colgroup'));

        $content->filter('ul')->each(function (Crawler $ulCrawler) {
            // удаляем списки в которых нет li элементов
            if ($ulCrawler->filter('li')->count() <= 0) {
                self::removeFromParentNode($ulCrawler);
            }

            // убираем p теги из li элементов
            $ulCrawler->filter('li')->each(function (Crawler $liCrawler) {
                foreach ($liCrawler as $node) {
                    $pEls = $liCrawler->filter('p');
                    if ($pEls->count() > 0) {
                        $text = [];
                        foreach ($pEls as $p) {
                            if (!empty($p->textContent)) {
                                $text[] = $p->textContent;
                                $p->parentNode->removeChild($p);
                            }
                        }
                        $node->textContent = join('<br>', $text);
                    }
                }
            });
        });

        // content update service links path to /services/...
        $content->filter('a')->each(function (Crawler $aCrawler) {
            $href = str_replace('/', '', $aCrawler->getNode(0)->getAttribute('href'));
            if (!empty($href) && \in_array($href, self::$serviceSlugs, true)) {
                $aCrawler->getNode(0)->setAttribute('href', '/services/' . $href);
            }
        });

        $body = self::removeTrash($content->html());

        return [
            'title' => $title,
            'title_img' => $titleImg,
            'body' => $body,
            'meta_title' => $metaTitle,
            'meta_description' => $metaDescription,
            'meta_keywords' => $metaKeywords,
            'updated_at' => $updatedAt,
            'created_at' => $createdAt,
            'is_active' => true,
        ];
    }

    private static function removeFromParentNode(Crawler $node): void
    {
        $node->each(function (Crawler $crawler) {
            foreach ($crawler as $node) {
                $node->parentNode->removeChild($node);
            }
        });
    }

    private static function removeTrash(string $html) :string
    {
        // remove style attributes
        $html = preg_replace('/(<[^>]+) style=".*?"/i', '$1', $html);

        // remove ids
        $html = preg_replace('#\s(id|class)="[^"]+"#', '', $html);
        $html = str_replace([
            ' dir="ltr"',
            'dir="ltr"',
            'align="left"',
            ' align="left"',
            ' valign="middle"',
            'valign="middle"',
            ' frame="hsides"',
            'frame="hsides"',
            ' rules="rows"',
            'rules="rows"',
            ' align="center"',
            'align="center"',
            ' cellspacing="1"',
            'cellspacing="1"',
            ' align="right"',
            'align="right"',
            ' cellpadding="0"',
            'cellpadding="0"',
            ' cellspacing="0"',
            'cellspacing="0"',
            '<p><span><br></span></p>',
            ' border="0"',
            'border="0"',
            '<span>',
            '</span>',
            '<address>',
            '</address>',
            '<div></div>',
            '<!--<p>--><!--</p>-->'
        ], '', $html);

        $html = preg_replace('/<span[^>]+>/i', '', $html);

        $html = str_replace('&nbsp;', ' ', $html);
        $html = str_replace('  ', ' ', $html);


        // remove empty tags
        $pattern = "/<p[^>]*><\\/p[^>]*>/";
        $html = preg_replace($pattern, '', $html);

        // remove empty lines
        $html = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $html);

        return $html;
    }
}
