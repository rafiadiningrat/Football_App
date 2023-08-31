<?php

use Illuminate\Support\Facades\Route;
use App\Models\Kategori;
use App\Models\COA;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\COAController;
use App\Http\Controllers\KlasemenController;
use App\Http\Controllers\KlubController;
use App\Http\Controllers\PertandinganController;
use App\Models\Transaksi;
use App\Http\Controllers\TransaksiController;

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
    return view('home');
});



Route::get('/klub', [KlubController::class, 'index']);
Route::post('/add-klub', [KlubController::class, 'store']);


Route::get('/pertandingan', function () {
    return view('pertandingan.view');
});



Route::get('/pertandingan', [PertandinganController::class, 'index']);
Route::post('/save-score', [PertandinganController::class, 'saveScore'])->name('save-score');
Route::post('/save-multiple-scores', [PertandinganController::class, 'saveMultipleScores'])->name('save-multiple-scores');



Route::get('/klasemen', [KlasemenController::class, 'showKlasemen'])->name('klasemen');
Route::get('/check-match/{klub1}/{klub2}', [PertandinganController::class, 'checkMatch']);



