<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = App\Models\Page::where('slug', 'landshaftnoe-proektirovanie')->first();
if (!$page) {
    echo "NO_PAGE\n";
    exit(1);
}

$page->title = 'Ландшафтное проектирование';
if (empty($page->meta_title) || stripos((string)$page->meta_title, 'Landshaftnoe Proektirovanie') !== false) {
    $page->meta_title = 'Ландшафтное проектирование в СПб';
}

$blocks = $page->blocks_json;
if (is_array($blocks)) {
    foreach ($blocks as $i => $block) {
        if (!is_array($block)) {
            continue;
        }
        if (($block['name'] ?? null) === 'Блок 1') {
            $blocks[$i]['is_active'] = true;
            if (empty($blocks[$i]['body'])) {
                $blocks[$i]['body'] = '<section></section>';
            }
        }
    }
    $page->blocks_json = $blocks;
}

$page->save();

echo "UPDATED_PAGE_ID={$page->id}\n";
echo "TITLE={$page->title}\n";
echo "META_TITLE={$page->meta_title}\n";
?>
