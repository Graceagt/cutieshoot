<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BoothController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\GalleryController;
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

Route::get('/', function () {
    return view('landingpage');
});

Route::get('/booth', [BoothController::class, 'index'])
    ->name('booth');

Route::post('/save-photo', [BoothController::class, 'store']);
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/gallery', [GalleryController::class, 'gallery'])
    ->name('gallery');