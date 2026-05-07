<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\NotifyController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ServiceController;
use App\Models\Page;
use App\Models\Service;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

if (!app()->isProduction()) {
    Route::get('/test', fn() => view('pages.test'));
}
Route::get('/imager/{path}', [ImageController::class, 'show'])->where('path', '.*')->name('imager');
Route::get('/services/{slug}', [ServiceController::class, 'show'])->name('services.show');
Route::get('/portfolio/{slug}', [PortfolioController::class, 'show'])->name('portfolios.show');
Route::post('/notify-send', [NotifyController::class, 'send'])->name('notify.send')->withoutMiddleware(\App\Http\Middleware\VerifyCsrfToken::class);
Route::get('/{slug?}', [PageController::class, 'show'])->name('pages.show');
//Route::get('/{slug?}', function (string $slug = null) {
//    if (!$slug) $slug = 'homepage';
//    $entry = Page::query()->where('slug', '=', $slug)->firstOrFail();
//
//    $serviceSliderData = [];
//    if ($slug === 'homepage') {
//        $serviceSliderData = Service::query()->where('is_show_homepage', '=', true)
//            ->inRandomOrder()
//            ->select(['title', 'slug'])
//            ->take(15)
//            ->get()
//            ->toArray()
//        ;
//    }
//
//    return view("pages.$slug", [
//        'entry' => $entry, 'service_slider_data' => $serviceSliderData
//    ]);
//})->name('pages.show');
//

