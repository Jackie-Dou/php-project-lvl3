<?php

use App\Http\Controllers\UrlCheckController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UrlController;

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

Route::get('/', function (): Illuminate\Contracts\View\View {
    return view('welcome');
})->name('home');

Route::post('urls', [UrlController::class, 'store'])
    ->name('urls.store');

Route::get('urls', [UrlController::class, 'index'])
    -> name('urls.index');

Route::get('urls/{id}', [UrlController::class, 'show'])
    ->name('urls.show');

Route::post('urls/{id}/checks', [UrlCheckController::class, 'store'])
    ->name('url_checks.store');
