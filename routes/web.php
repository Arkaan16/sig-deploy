<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsController;


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
    return view('landing.index');
});

Route::get('/keluar', function () {
    return redirect('/'); // Mengarahkan ke halaman landing
})->name('keluar');


Route::resource('rumah-sakit', RsController::class);

Route::get('/rumah-sakit', [RsController::class, 'list'])->name('rumah-sakit.index');

Route::get('/peta', [RsController::class, 'index'])->name('peta.index');

Route::post('/peta', [RsController::class, 'store']);
