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

Route::get('/', [App\Http\Controllers\IndexController::class, 'index']);
Route::get('/truyen-tranh/{slug}', [App\Http\Controllers\IndexController::class, 'truyen_tranh']);
Route::get('/truyen-tranh/{slug}/{tap}', [App\Http\Controllers\IndexController::class, 'xemtruyentranh']);
Route::get('/theodoitruyen/{matruyen}/{id}', [App\Http\Controllers\IndexController::class, 'theodoitruyen']);
Route::get('/botheodoitruyen/{matruyen}/{id}', [App\Http\Controllers\IndexController::class, 'botheodoitruyen']);
Route::post('/thembinhluantruyen/{matruyen}/{id}', [App\Http\Controllers\IndexController::class, 'thembinhluantruyen']);
Route::post('/thembinhluanchap/{matruyen}/{machap}/{id}', [App\Http\Controllers\IndexController::class, 'thembinhluanchap']);
Route::post('/traloibinhluantruyen/{id}/{mabinhluan}/{uid}', [App\Http\Controllers\IndexController::class, 'traloibinhluantruyen']);
Route::post('/traloibinhluanchap/{id}/{mabinhluan}/{tap}/{uid}', [App\Http\Controllers\IndexController::class, 'traloibinhluanchap']);
Route::get('/theo-doi/{id}', [App\Http\Controllers\IndexController::class, 'theo_doi']);
Route::get('/lich-su/{id}', [App\Http\Controllers\IndexController::class, 'lich_su']);
Route::get('/xoalichsu/{id}', [App\Http\Controllers\IndexController::class, 'xoalichsu']);
Route::get('/theo-doi', [App\Http\Controllers\IndexController::class, 'goto_login']);
Route::get('/lich-su', [App\Http\Controllers\IndexController::class, 'goto_login']);
Route::get('/the-loai/{slug}', [App\Http\Controllers\IndexController::class, 'the_loai']);
Route::get('/truyen-hot', [App\Http\Controllers\IndexController::class, 'truyen_hot']);
Route::get('/tim-kiem', [App\Http\Controllers\IndexController::class, 'tim_kiem'])->name('tim-kiem');
Route::post('/checkallnotification', [App\Http\Controllers\IndexController::class, 'checkallnotification']);
Route::post('/anbinhluan', [App\Http\Controllers\IndexController::class, 'anbinhluan']);
Route::post('/antraloi', [App\Http\Controllers\IndexController::class, 'antraloi']);

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'home'])->name('home');
Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'home'])->name('dashboard');

Route::get('/theloai', [App\Http\Controllers\TheloaiController::class, 'index']);
Route::post('/themtheloai', [App\Http\Controllers\TheloaiController::class, 'them']);
Route::get('/suatheloai/{id}', [App\Http\Controllers\TheloaiController::class, 'sua']);
Route::post('/capnhattheloai/{id}', [App\Http\Controllers\TheloaiController::class, 'capnhat']);
Route::get('/xoatheloai/{id}', [App\Http\Controllers\TheloaiController::class, 'xoa']);

Route::get('/nguoidung', [App\Http\Controllers\UserController::class, 'index']);
Route::post('/phanquyennguoidung', [App\Http\Controllers\UserController::class, 'phanquyennguoidung']);
Route::post('/khoataikhoang', [App\Http\Controllers\UserController::class, 'khoataikhoang']);
Route::post('/motaikhoang', [App\Http\Controllers\UserController::class, 'motaikhoang']);

Route::get('/hoso/{id}', [App\Http\Controllers\HosoController::class, 'index']);
Route::post('/capnhathoso/{id}', [App\Http\Controllers\HosoController::class, 'capnhat']);

Route::get('/truyen', [App\Http\Controllers\TruyenController::class, 'index']);
Route::post('/themtruyen', [App\Http\Controllers\TruyenController::class, 'them']);
Route::get('/suatruyen/{id}', [App\Http\Controllers\TruyenController::class, 'sua']);
Route::post('/capnhattruyen/{id}', [App\Http\Controllers\TruyenController::class, 'capnhat']);
Route::get('/xoatruyen/{id}', [App\Http\Controllers\TruyenController::class, 'xoa']);
Route::get('/lietketruyen', [App\Http\Controllers\TruyenController::class, 'lietke']);
Route::get('/decutruyen', [App\Http\Controllers\TruyenController::class, 'decutruyen']);
Route::post('/themdecutruyen', [App\Http\Controllers\TruyenController::class, 'themdecutruyen']);
Route::post('/bodecutruyen', [App\Http\Controllers\TruyenController::class, 'bodecutruyen']);
Route::get('/capnhattinhtrang', [App\Http\Controllers\TruyenController::class, 'capnhattinhtrang']);
Route::post('/themtruyenhoanthanh', [App\Http\Controllers\TruyenController::class, 'themtruyenhoanthanh']);
Route::post('/botruyenhoanthanh', [App\Http\Controllers\TruyenController::class, 'botruyenhoanthanh']);

Route::get('/chap', [App\Http\Controllers\ChapController::class, 'index']);
Route::post('/themchap', [App\Http\Controllers\ChapController::class, 'them']);
Route::get('/suachap/{id}', [App\Http\Controllers\ChapController::class, 'sua']);
Route::post('/capnhatchap/{id}', [App\Http\Controllers\ChapController::class, 'capnhat']);
Route::get('/xoachap/{id}', [App\Http\Controllers\ChapController::class, 'xoa']);
Route::get('/lietkechap', [App\Http\Controllers\ChapController::class, 'lietke']);
Route::get('/xoaanhchap/{id}/{name}/{maanhchap}', [App\Http\Controllers\ChapController::class, 'xoaanh']);

Route::get('/binhluan', [App\Http\Controllers\BinhluanController::class, 'index']);
Route::post('/hienbinhluan', [App\Http\Controllers\BinhluanController::class, 'hienbinhluan']);
Route::post('/hientraloi', [App\Http\Controllers\BinhluanController::class, 'hientraloi']);