<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\MenuController;
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

Route::get('/', function () {
    return view('welcome');
});

//予約
Route::get('/reservation', function () {
    // 既存のステータス管理変数（status）はControllerから渡す想定ですが、
    // ここでは簡易的に 1 (通常営業) としています。
    return view('reservation', ['status' => 1, 'message' => '']);
})->name('reservation');


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
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
