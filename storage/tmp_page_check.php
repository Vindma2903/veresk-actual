<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = App\Models\Page::where('slug', 'landshaftnoe-proektirovanie')->first();
if (!$page) {
    echo "NO_PAGE\n";
    exit;
}

echo "ID={$page->id}\n";
echo "TITLE={$page->title}\n";
$blocks = $page->blocks_json;
echo 'BLOCKS_TYPE=' . gettype($blocks) . "\n";
if (is_array($blocks)) {
    echo 'COUNT=' . count($blocks) . "\n";
    foreach ($blocks as $i => $b) {
        $name = is_array($b) ? ($b['name'] ?? '') : '';
        $active = (is_array($b) && !empty($b['is_active'])) ? '1' : '0';
        echo ($i + 1) . ':' . $name . ':' . $active . "\n";
    }
}
