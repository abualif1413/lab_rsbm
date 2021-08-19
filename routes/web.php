<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\MasterData;
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

Route::middleware('guest')->group(function () {
    
    // Bagian login
    Route::get('/login', [Controllers\LoginController::class, 'index'])->name('login');
    Route::post('/login/attempt', [Controllers\LoginController::class, 'loginAttempt']);

});

Route::middleware('auth')->group(function () {

    Route::get('/', function () {
        return view('home');
    });

    Route::get('/pelayanan_lab', [Controllers\PelayananLabController::class, 'home']);
    Route::post('/pelayanan_lab/insert', [Controllers\PelayananLabController::class, 'insert']);
    Route::get('/pelayanan_lab/delete', [Controllers\PelayananLabController::class, 'delete']);
    
    Route::get('/kegiatan', [Controllers\KegiatanController::class, 'home']);
    Route::post('/kegiatan/mapping', [Controllers\KegiatanController::class, 'mapping']);
    
    Route::get('/antrian_lab', [Controllers\AntrianLabController::class, 'home']);
    Route::get('/antrian_lab/find/{id_pasien_lab}', [Controllers\AntrianLabController::class, 'find']);
    Route::post('/antrian_lab/add', [Controllers\AntrianLabController::class, 'add']);
    Route::get('/antrian_lab/pasien_masuk', [Controllers\AntrianLabController::class, 'pasienMasuk']);
    Route::get('/antrian_lab/pasien_batal_masuk', [Controllers\AntrianLabController::class, 'pasienBatalMasuk']);
    Route::get('/antrian_lab/pasien_selesai_periksa_lab', [Controllers\AntrianLabController::class, 'pasienSelesaiPeriksaLab']);
    Route::get('/antrian_lab/pasien_batal_selesai_periksa_lab', [Controllers\AntrianLabController::class, 'pasienBatalSelesaiPeriksa']);
    Route::get('/antrian_lab/antrian_batal', [Controllers\AntrianLabController::class, 'antrianBatal']);
    Route::get('/antrian_lab/antrian_masuk', [Controllers\AntrianLabController::class, 'antrianMasuk']);
    Route::get('/antrian_lab/antrian_selesai_periksa', [Controllers\AntrianLabController::class, 'antrianSelesaiPeriksa']);
    Route::get('/antrian_lab/antrian_selesai_hasil', [Controllers\AntrianLabController::class, 'antrianSelesaiHasil']);
    Route::get('/antrian_lab/input_hasil/{id_pasien_lab}', [Controllers\AntrianLabController::class, 'inputHasil']);
    Route::get('/antrian_lab/sms_hasil/{id_pasien_lab}', [Controllers\AntrianLabController::class, 'smsHasil']);
    Route::post('/antrian_lab/input_hasil/tentukan_pelayanan', [Controllers\AntrianLabController::class, 'inputHasilTentukanPelayanan']);
    Route::post('/antrian_lab/input_hasil/isi_hasil_pemeriksaan', [Controllers\AntrianLabController::class, 'inputHasilIsiHasilPemeriksaanLab']);
    
    Route::get('/cetak', [Controllers\CetakController::class, 'cetak']);
    Route::get('/cetak/swab', [Controllers\CetakController::class, 'cetakSwab']);
    Route::get('/cetak/antigen', [Controllers\CetakController::class, 'cetakAntigen']);
    Route::get('/cetak/lab', [Controllers\CetakController::class, 'cetakLab']);
    Route::get('/cetak/narkoba', [Controllers\CetakController::class, 'cetakNarkoba']);
    Route::get('/cetak/pasien_selesai', [Controllers\CetakController::class, 'cetakPasienSelesai']);
    
    Route::get('/penanda_tangan_hasil', [Controllers\PenandaTanganHasilController::class, 'home']);
    Route::post('/penanda_tangan_hasil/submit', [Controllers\PenandaTanganHasilController::class, 'submit']);
    Route::get('/penanda_tangan_hasil/delete', [Controllers\PenandaTanganHasilController::class, 'delete']);

     // Bagian master data pengguna
     Route::get('/master_data/usersatker', [MasterData\UserSatkerController::class, 'index']);
     Route::get('/master_data/usersatker/getusersatkerdt', [MasterData\UserSatkerController::class, 'getUserSatkerDT']);
     Route::get('/master_data/usersatker/getusersatker/{id}', [MasterData\UserSatkerController::class, 'getUserSatker']);
     Route::post('/master_data/usersatker/add', [MasterData\UserSatkerController::class, 'add']);
     Route::post('/master_data/usersatker/resetpassword', [MasterData\UserSatkerController::class, 'resetPassword']);

    Route::get('/logout', [Controllers\LoginController::class, 'logout']);

});



