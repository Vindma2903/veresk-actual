<?php

namespace App\Utils;

class SitemapGenerator
{
    protected string $host;
    protected array $urls;

    public function __construct(string $host, array $urls = [])
    {
        $this->host = $host;
        $this->urls = $urls;
    }

    public function addUrl(string $urlPart, \DateTimeInterface $lastMod = null, string $changeFreq = null, float $priority = null): void
    {
        $this->urls[] = $this->urlToXml(
            $this->host . $urlPart,
            $lastMod ? $lastMod->format(\DATE_ATOM) : null,
            $changeFreq,
            $priority ? number_format($priority, 1, '.', '') : null,
        );
    }

    private function urlToXml(string $loc, string $lastMod = null, string $changeFreq = null, string $priority = null): string
    {
        $url = "<url><loc>$loc</loc>";
        if ($lastMod) {
            $url .= "<lastmod>$lastMod</lastmod>";
        }
        if ($changeFreq) {
            $url .= "<changefreq>$changeFreq</changefreq>";
        }
        if ($priority) {
            $url .= "<priority>$priority</priority>";
        }
        $url .= '</url>';
        return $url;
    }

    public function generate(string $publicDirPath): void
    {
        $urlSet = '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
        $urlSet .= implode('', $this->urls);
        $urlSet .= '</urlset>';

        file_put_contents($publicDirPath . '/sitemap.xml', $urlSet);
    }
}
