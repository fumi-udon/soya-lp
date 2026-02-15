<?php

use Illuminate\Support\Facades\Route;

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
