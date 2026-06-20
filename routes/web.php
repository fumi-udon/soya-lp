<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MailTestController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\ReservationController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// 予約
Route::get('/reservation', [ReservationController::class, 'create'])->name('reservation');
Route::post('/reservation/confirm', [ReservationController::class, 'confirm'])->name('reservation.confirm.submit');
Route::get('/reservation/confirm', [ReservationController::class, 'showConfirm'])->name('reservation.confirm');
Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
Route::get('/reservation/complete', [ReservationController::class, 'complete'])->name('reservation.complete');

Route::get('/mailtest', [MailTestController::class, 'show'])->name('mailtest');
Route::post('/mailtest', [MailTestController::class, 'send'])->name('mailtest.send');

Route::get('/', function (Request $request) {
    $host = $request->getHost();

    // Bistro Nippon と Curry Kitano はトップ(/)で直接メニュー画面を表示
    if (in_array($host, ['menu.bistronippon.tn', 'menu.currykitano.tn'])) {
        return app(MenuController::class)->index($request);
    }

    // Söya（soya.bistronippon.tn 等）は従来のトップページを表示
    // ※ 'welcome' の部分は実際のSöyaトップページのblade名（indexなど）に合わせてください
    return view('welcome');
});
// SOYA. THE CRAFT A5マニフェストチラシ用のルート
Route::get('/soya/manifesto', function () {
    return view('soya.manifesto');
})->name('soya.manifesto');

// SOYA. THE CRAFT A5マニフェストチラシ用のルート
Route::get('/soya/manifestoa4', function () {
    return view('soya.manifestoa4');
})->name('soya.manifestoa4');

Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');

Route::get('/menu_test', function () {
    return view('menu_test');
})->name('menu_test');

Route::get('/shopcardv', function () {
    return view('shopcardv');
})->name('shopcardv');

Route::get('/shopcardv', function () {
    return view('shopcardv');
})->name('shopcardv');

