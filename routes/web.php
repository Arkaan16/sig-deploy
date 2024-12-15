<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RsController;
use App\Http\Controllers\RumahSakitController;


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


Route::resource('rs', RsController::class);

Route::get('/api/rumah-sakit', [RumahSakitController::class, 'getGeoJSON']);
Route::post('/api/rumah-sakit', [RumahSakitController::class, 'store']);
Route::put('/api/rumah-sakit/{id}', [RumahSakitController::class, 'update']);
Route::delete('/api/rumah-sakit/{id}', [RumahSakitController::class, 'destroy']);

Route::get('/peta', [RsController::class, 'index'])->name('peta.index');

Route::post('/peta', [RsController::class, 'store']);
