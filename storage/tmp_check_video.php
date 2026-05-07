<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$page = App\Models\Page::where('slug', 'landshaftnoe-proektirovanie')->first();
if (!$page) { echo "NO_PAGE\n"; exit(1); }
$blocks = $page->blocks_json;
foreach ((array)$blocks as $i => $b) {
  if (($b['name'] ?? '') === 'Блок 8') {
    $video = $b['video'] ?? null;
    echo "BLOCK8_VIDEO=" . (is_string($video)?$video:'NULL') . "\n";
    if (is_string($video) && $video !== '') {
      $abs = __DIR__ . '/../storage/app/public/' . ltrim($video, '/');
      echo "FILE_EXISTS=" . (file_exists($abs) ? '1' : '0') . "\n";
      echo "ABS_PATH={$abs}\n";
    }
  }
}
?>
