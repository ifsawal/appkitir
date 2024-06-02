<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Master\KitirController;
use App\Http\Controllers\Api\Master\PangkalanController;
use App\Http\Controllers\Api\Master\AkunTelegramController;
use App\Http\Controllers\Api\Master\Kitir\KitirReController;
use App\Http\Controllers\Api\Master\Cashback\CashbackReController;
use App\Http\Controllers\Api\Master\Kitir\LaporanPenjualanPecahController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/pangkalan', [PangkalanController::class, 'pangkalan']);




Route::get('/kitir', [KitirController::class, 'index']);
Route::get('/kitirpertanggalkitir/{tanggal}', [KitirController::class, 'kitir_pertanggal_kitir']);
Route::get('/kitirpertanggalmasuk/{tanggal}', [KitirController::class, 'kitir_pertanggal_masuk']);
Route::get('/kitirpecah/{tanggal}', [KitirReController::class, 'kitir_pecah']);
Route::get('/kitir-pecah-tgl-masuk/{tanggal}', [KitirReController::class, 'kitir_pecah_tgl_masuk']);

Route::get('/laporan-pecah/{bulan}/{tahun}', [LaporanPenjualanPecahController::class, 'laporan_pecah']);
Route::get('/download-laporan-pecah/{bulan}/{tahun}', [LaporanPenjualanPecahController::class, 'download']);

Route::get('/akuntelegram', [AkunTelegramController::class, 'index']);


Route::get('/data-cashback-semua-pangkalan-perbulan/{bulan}/{tahun}', [CashbackReController::class,'data_cashback_semua_pangkalan_perbulan']);
Route::get('/download/{bulan}/{tahun}', [CashbackReController::class,'download']);
Route::get('/kirim/{bulan}/{tahun}', [CashbackReController::class,'kirim']);
Route::post('/tandai-ok', [CashbackReController::class,'tandai_ok']);
Route::post('/tandai-batalkan', [CashbackReController::class,'tandai_batalkan']);

