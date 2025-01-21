<?php

use App\Models\Role;
use App\Models\Asisten;
use App\Models\Polling;
use App\Models\JenisPolling;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Container\Attributes\Auth;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\ModulController;
use App\Http\Controllers\API\NilaiController;
use App\Http\Controllers\API\SoalTAController;
use App\Http\Controllers\API\SoalTKController;
use App\Http\Controllers\API\SoalTMController;
use App\Http\Controllers\API\SoalTPController;
use App\Http\Controllers\API\AsistenController;
use App\Http\Controllers\API\DeadlineController;
use App\Http\Controllers\API\PollingsController;
use App\Http\Controllers\API\SoalFITBController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\API\JawabanTAController;
use App\Http\Controllers\API\JawabanTKController;
use App\Http\Controllers\API\JawabanTMController;
use App\Http\Controllers\API\JawabanTPController;
use App\Http\Controllers\API\LaporanPjController;
use App\Http\Controllers\API\PraktikanController;
use App\Http\Controllers\API\PraktikumController;
use App\Http\Controllers\API\JadwalJagaController;
use App\Http\Controllers\API\SoalJurnalController;
use App\Http\Controllers\API\HistoryJagaController;
use App\Http\Controllers\API\JawabanFITBController;
use App\Http\Controllers\API\LeaderBoardController;
use App\Http\Controllers\API\PelanggaranController;
use App\Http\Controllers\API\JenisPollingController;
use App\Http\Controllers\API\ConfigurationController;
use App\Http\Controllers\API\JawabanJurnalController;
use App\Http\Controllers\API\LaporanPraktikanController;
use App\Http\Controllers\API\TugasPendahuluanController;
use App\Http\Controllers\Auth\RegisteredAsistenController;
use App\Http\Controllers\Auth\RegisteredPraktikanController;
use App\Models\Deadline;

// i guess
// Route::post('/registrasi/asisten', [RegisteredAsistenController::class, 'store'])->name('store.asisten')->middleware('guest');
// Route::post('/registrasi/praktikan', [RegisteredPraktikanController::class, 'store'])->name('store.praktikan')->middleware('guest');

// Asisten
Route::get('/asisten', [AsistenController::class, 'index'])->name('get.asisten')->middleware(['auth:sanctum', 'ability:see-plot,lihat-asisten']);
Route::put('/asisten', [AsistenController::class, 'update'])->name('update.asisten')->middleware(['auth:sanctum', 'ability:manage-profile']);
Route::delete('/asisten/{idAsisten}', [AsistenController::class, 'destroy'])->name('destroy.asisten')->middleware(['auth:sanctum', 'ability:manage-role']);

// Roles
Route::post('/roles', [RoleController::class, 'store'])->name('get.roles')->middleware(['auth:sanctum', 'ability:manage-role']);
Route::put('/roles/{id}', [RoleController::class, 'update'])->name('update.roles')->middleware(['auth:sanctum', 'ability:manage-role']);

// Modul
Route::get('/modul', [ModulController::class, 'index'])->name('get.modul')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal,see-praktikum']);
Route::post('/modul', [ModulController::class, 'store'])->name('store.modul')->middleware(['auth:sanctum', 'ability:manage-modul']);
Route::put('/modul/{id}', [ModulController::class, 'update'])->name('update.modul')->middleware(['auth:sanctum', 'ability:manage-modul']);
Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('delete.modul')->middleware(['auth:sanctum', 'ability:manage-modul']);
Route::post('/modul/reset', [ModulController::class, 'reset'])->name('reset.modul')->middleware(['auth:sanctum', 'ability:lms-configuration']);
Route::patch('/modul/update-status', [ModulController::class, 'updateStatus'])->name('update.status')->middleware(['auth:sanctum', 'ability:manage-modul']);

// Kelas
Route::get('/kelas', [KelasController::class, 'index'])->name('get.kelas')->middleware(['auth:sanctum', 'ability:manage-plot,see-plot']);
Route::post('/kelas', [KelasController::class, 'store'])->name('store.kelas')->middleware(['auth:sanctum', 'ability:manage-plot']);
Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('update.kelas')->middleware(['auth:sanctum', 'ability:manage-plot']);
Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('delete.kelas')->middleware(['auth:sanctum', 'ability:manage-plot']);
Route::post('/kelas/reset', [KelasController::class, 'reset'])->name('reset.kelas')->middleware(['auth:sanctum', 'ability:lms-configuration']);

// Jadwal Jaga
Route::get('/jadwal', [JadwalJagaController::class, 'index'])->name('get.jadwal')->middleware(['auth:sanctum', 'ability:see-plot,manage-plot']);
Route::post('/jadwal', [JadwalJagaController::class, 'store'])->name('store.jadwal')->middleware(['auth:sanctum', 'ability:manage-plot']);
Route::delete('/jadwal/{id}', [JadwalJagaController::class, 'destroy'])->name('delete.jadwal')->middleware(['auth:sanctum', 'ability:manage-plot']);

// History Jaga
Route::get('/history-jaga', [HistoryJagaController::class, 'index'])->name('get.history')->middleware(['auth:sanctum', 'ability:see-history']);
Route::post('/history-jaga', [HistoryJagaController::class, 'store'])->name('store.history')->middleware(['auth:sanctum', 'ability:manage-praktikum']);

// Laporan PJ
Route::get('/laporan-pj', [LaporanPjController::class, 'index'])->name('get.laporanPJ')->middleware(['auth:sanctum', 'ability:laporan-praktikum']);
Route::post('/laporan-pj/{idKelas}', [LaporanPjController::class, 'store'])->name('store.laporanPJ')->middleware(['auth:sanctum', 'ability:laporan-praktikum']);
Route::get('/laporan-pj/{id}', [LaporanPjController::class, 'show'])->name('show.laporanPJ')->middleware(['auth:sanctum', 'ability:laporan-praktikum']);
// Route::delete('/laporan-pj/{id}', [LaporanPjController::class, 'destroy'])->name('delete.laporanPJ'); //in audit for rollback feature maybe

// Configuration
Route::get('/config', [ConfigurationController::class, 'index'])->name('get.config')->middleware(['auth:sanctum', 'ability:lms-configuration']);
Route::put('/config', [ConfigurationController::class, 'update'])->name('update.config')->middleware(['auth:sanctum', 'ability:lms-configuration, tp-configuration, praktikan-regist']);

// Pelanggaran
Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('get.pelanggaran')->middleware(['auth:sanctum', 'ability:see-pelanggaran']);
Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('store.pelanggaran')->middleware(['auth:sanctum', 'ability:manage-praktikum']);
Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('delete.pelanggaran')->middleware(['auth:sanctum', 'ability:manage-pelanggaran']);
Route::post('/pelanggaran/reset', [PelanggaranController::class, 'reset'])->name('reset.pelanggaran')->middleware(['auth:sanctum', 'ability:lms-configuration']);

// Jenis Polling
Route::get('/jenis-polling', [JenisPollingController::class, 'index'])->name('get.jenis.poling')->middleware(['auth:sanctum', 'ability:see-polling, isi-polling']);

// Polling View Count
Route::get('/polling/{id}', [PollingsController::class, 'show'])->name('show.polling')->middleware(['auth:sanctum', 'ability:see-polling']);

// Soal TP
Route::get('/soal-tp/{idModul}', [SoalTPController::class, 'show'])->name('show.soaltp')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal']);
Route::post('/soal-tp/{idModul}', [SoalTPController::class, 'store'])->name('store.soaltp')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::put('/soal-tp/{idSoal}', [SoalTPController::class, 'update'])->name('update.soaltp')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::delete('/soal-tp/{id}', [SoalTPController::class, 'destroy'])->name('delete.soaltp')->middleware(['auth:sanctum', 'ability:manage-soal']);

// Soal TM
Route::get('/soal-tm/{idModul}', [SoalTMController::class, 'show'])->name('show.soaltm')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal']);
Route::post('/soal-tm/{idModul}', [SoalTMController::class, 'store'])->name('store.soaltm')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::put('/soal-tm/{idSoal}', [SoalTMController::class, 'update'])->name('update.soaltm')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::delete('/soal-tm/{id}', [SoalTMController::class, 'destroy'])->name('delete.soaltm')->middleware(['auth:sanctum', 'ability:manage-soal']);

// Soal FITB
Route::get('/soal-fitb/{idModul}', [SoalFITBController::class, 'show'])->name('show.soalfitb')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal']);
Route::post('/soal-fitb/{idModul}', [SoalFITBController::class, 'store'])->name('store.soalfitb')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::put('/soal-fitb/{idSoal}', [SoalFITBController::class, 'update'])->name('update.soalfitb')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::delete('/soal-fitb/{id}', [SoalFITBController::class, 'destroy'])->name('delete.soalfitb')->middleware(['auth:sanctum', 'ability:manage-soal']);

// soal jurnal
Route::get('/soal-jurnal/{idModul}', [SoalJurnalController::class, 'show'])->name('show.soaljurnal')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal']);
Route::post('/soal-jurnal/{idModul}', [SoalJurnalController::class, 'store'])->name('store.soaljurnal')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::put('/soal-jurnal/{idSoal}', [SoalJurnalController::class, 'update'])->name('update.soaljurnal')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::delete('/soal-jurnal/{id}', [SoalJurnalController::class, 'destroy'])->name('delete.soaljurnal')->middleware(['auth:sanctum', 'ability:manage-soal']);

// soal ta
Route::get('/soal-ta/{idModul}/kelas/{idKelas}', [SoalTAController::class, 'show'])->name('show.soalta')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal']);
Route::post('/soal-ta/{idModul}', [SoalTAController::class, 'store'])->name('store.soalta')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::put('/soal-ta/{idSoal}', [SoalTAController::class, 'update'])->name('update.soalta')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::delete('/soal-ta/{id}', [SoalTAController::class, 'destroy'])->name('delete.soalta')->middleware(['auth:sanctum', 'ability:manage-soal']);

// soal tk
Route::get('/soal-tk/{idModul}/kelas/{idKelas}', [SoalTKController::class, 'show'])->name('show.soaltk')->middleware(['auth:sanctum', 'ability:lihat-modul, see-soal']);
Route::post('/soal-tk/{idModul}', [SoalTKController::class, 'store'])->name('store.soaltk')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::put('/soal-tk/{idSoal}', [SoalTKController::class, 'update'])->name('update.soaltk')->middleware(['auth:sanctum', 'ability:manage-soal']);
Route::delete('/soal-tk/{id}', [SoalTKController::class, 'destroy'])->name('delete.soaltk')->middleware(['auth:sanctum', 'ability:manage-soal']);

// praktikums
Route::get('/praktikum/{idKelas}', [PraktikumController::class, 'show'])->name('show.praktikums')->middleware(['auth:sanctum', 'ability:manage-praktikum,see-praktikum']);
Route::put('/praktikum/{id}', [PraktikumController::class, 'update'])->name('update.praktikums')->middleware(['auth:sanctum', 'ability:manage-praktikum']);

// reset praktikum
Route::put('/deadline/reset/{idPraktikum}', [DeadlineController::class, 'reset'])->name('reset.deadline')->middleware(['auth:sanctum', 'ability:manage-praktikum']);

// deadlines
Route::get('/deadline/{idPraktikum}', [DeadlineController::class, 'show'])->name('show.deadlines')->middleware(['auth:sanctum', 'ability:manage-praktikum,see-praktikum']);
Route::put('/deadline/{id}', [DeadlineController::class, 'update'])->name('update.deadlines')->middleware(['auth:sanctum', 'ability:manage-praktikum']);

// tugas pendahuluan
Route::get('/tugas-pendahuluan', [TugasPendahuluanController::class, 'index'])->name('index.tugaspendahuluans')->middleware(['auth:sanctum', 'ability:tugas-pendahuluan']);
Route::put('/tugas-pendahuluan', [TugasPendahuluanController::class, 'update'])->name('update.tugaspendahuluans')->middleware(['auth:sanctum', 'ability:tugas-pendahuluan']);

// leaderboard
Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('get.leaderboard')->middleware(['auth:sanctum', 'ability:ranking-praktikan']);
Route::get('/leaderboard/{idKelas}', [LeaderBoardController::class, 'show'])->name('get.leaderboard')->middleware(['auth:sanctum', 'ability:ranking-praktikan']);

// nilais
Route::post('/nilai', [NilaiController::class, 'store'])->name('store.nilais')->middleware(['auth:sanctum', 'ability:nilai-praktikan, praktikum-lms']);
Route::get('/nilai/{id}', [NilaiController::class, 'showAsisten'])->name('showAsisten.nilais')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);
Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('update.nilais')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);

// // Jawaban TM asisten
// Route::get('/jawaban-mandiri/praktikan/{idPraktikan}/modul/{idModul}', [JawabanTMController::class, 'showAsisten'])->name('showAsisten.jawaban.tm')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);

// // Jawaban Fitb asisten
// Route::get('/jawaban-fitb/praktikan/{idPraktikan}/modul/{idModul}', [JawabanFITBController::class, 'showAsisten'])->name('showAsisten.jawaban.fitb')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);

// // Jawaban Jurnal asisten
// Route::get('/jawaban-jurnal/praktikan/{idPraktikan}/modul/{idModul}', [JawabanJurnalController::class, 'showAsisten'])->name('showAsisten.jawaban.jurnal')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);

// Jawaban TP asisten
Route::get('/jawaban-tp/praktikan/{idPraktikan}/modul/{idModul}', [JawabanTMController::class, 'showAsisten'])->name('showAsisten.jawaban.tp')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);

// lapran praktikan ini buat asisten
Route::get('/laporan-praktikan/{id}', [LaporanPraktikanController::class, 'show'])->name('show.laporan-praktikan')->middleware(['auth:sanctum', 'ability:nilai-praktikan']);

//set praktikan
Route::post('/set-praktikan', [PraktikanController::class, 'setPraktikan'])->name('set.praktikan')->middleware(['auth:sanctum', 'ability:set-praktikan']);

//set praktikan
Route::post('/set-password', [PraktikanController::class, 'setPassword'])->name('set.password')->middleware(['auth:sanctum', 'ability:set-praktikan']);


////////////////praktikan///////////////////////////////    
// polling
Route::post('/polling', [PollingsController::class, 'store'])->name('store.polling')->middleware(['auth:sanctum', 'ability:isi-polling']);

Route::get('/nilai', [NilaiController::class, 'show'])->name('show.nilais')->middleware(['auth:sanctum', 'ability:lihat-nilai']);

// Jawaban TA
Route::post('/jawaban-ta', [JawabanTAController::class, 'store'])->name('store.jawaban.ta')->middleware(['auth:sanctum', 'ability:praktikum-lms']);
Route::get('/jawaban-ta/{idModul}', [JawabanTAController::class, 'show'])->name('show.jawaban.ta')->middleware(['auth:sanctum', 'ability:lihat-modul']);

// Jawaban TK
Route::post('/jawaban-tk', [JawabanTKController::class, 'store'])->name('store.jawaban.tk')->middleware(['auth:sanctum', 'ability:praktikum-lms']);
Route::get('/jawaban-tk/{idModul}', [JawabanTKController::class, 'show'])->name('show.jawaban.tk')->middleware(['auth:sanctum', 'ability:lihat-modul']);

// Jawaban TM
Route::post('/jawaban-tm', [JawabanTMController::class, 'store'])->name('store.jawaban.tm')->middleware(['auth:sanctum', 'ability:praktikum-lms']);
Route::get('/jawaban-tm/{idModul}', [JawabanTMController::class, 'show'])->name('show.jawaban.tm')->middleware(['auth:sanctum', 'ability:lihat-modul']);

//Jawaban Fitb
Route::post('/jawaban-fitb', [JawabanFITBController::class, 'store'])->name('store.jawaban.fitb')->middleware(['auth:sanctum', 'ability:praktikum-lms']);
Route::get('/jawaban-fitb/{idModul}', [JawabanFITBController::class, 'show'])->name('show.jawaban.fitb')->middleware(['auth:sanctum', 'ability:lihat-modul']);

// Jawaban Jurnal
Route::post('/jawaban-jurnal', [JawabanJurnalController::class, 'store'])->name('store.jawaban.jurnal')->middleware(['auth:sanctum', 'ability:praktikum-lms']);
Route::get('/jawaban-jurnal/{idModul}', [JawabanJurnalController::class, 'show'])->name('show.jawaban.jurnal')->middleware(['auth:sanctum', 'ability:lihat-modul']);

// Jawaban Tugas Pendahuluan
Route::post('/jawaban-tp', [JawabanTPController::class, 'store'])->name('store.jawaban.tugas-pendahuluan')->middleware(['auth:sanctum', 'ability:praktikum-lms']);
Route::get('/jawaban-tp/{idModul}', [JawabanTPController::class, 'show'])->name('show.jawaban.tp')->middleware(['auth:sanctum', 'ability:lihat-modul']);

//laporan Praktikan
Route::post('/laporan-praktikan', [LaporanPraktikanController::class, 'store'])->name('store.laporan-praktikan')->middleware(['auth:sanctum', 'ability:praktikum-lms']);


Route::fallback(function () {
    return redirect('/');
})->middleware(RedirectIfAuthenticated::class);