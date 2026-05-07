<?php

namespace App\Http\Controllers;

use Butschster\Head\Contracts\MetaTags\MetaInterface;
use Butschster\Head\Packages\Entities\OpenGraphPackage;

class EntryController extends Controller
{
    private MetaInterface $meta;

    public function __construct(MetaInterface $meta)
    {
        $this->meta = $meta;
    }

    public function createSeoMeta(
        string $title,
        string $description = null,
        string $keywords = null,
        string $image = null
    ): OpenGraphPackage
    {
        $title = self::cleanStr($title);
        $description = self::cleanStr($description);
        $keywords = self::cleanStr($keywords);

        $this->meta->prependTitle($title);
        $desc = !empty($description) ? $description : config('meta_tags.description.default');
        $this->meta->setDescription($desc);
        $this->meta->setKeywords(!empty($keywords) ? $keywords: config('meta_tags.keywords.default'));

        $og = new OpenGraphPackage('default');
        $og->setTitle($this->meta->getTitle()->toArray()['content']);
        $og->setDescription($this->meta->getDescription()->toArray()['content']);
        $og->setType('website');
        $og->setSiteName(config('app.name'));
        $og->setLocale('ru_RU');
        $og->setUrl(request()->url());
        if (!empty($image)) {
            $og->addImage(asset('/storage/' . $image));
        } else {
            $og->addImage(asset('/apple-touch-icon.png'));
        }

        $this->meta->registerPackage($og);

        return $og;
    }

    private static function cleanStr(string $str = null): ?string
    {
        if (!empty($str)) $str = strip_tags($str);
        if (!empty($str)) $str = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $str);
        if (!empty($str)) $str = trim($str);
        return $str;
    }
}
