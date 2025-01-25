<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\API\AsistenController;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\ModulController;
use App\Http\Controllers\API\NilaiController;
use App\Http\Controllers\API\SoalTAController;
use App\Http\Controllers\API\SoalTKController;
use App\Http\Controllers\API\SoalTMController;
use App\Http\Controllers\API\SoalTPController;
use App\Http\Controllers\API\DeadlineController;
use App\Http\Controllers\API\PollingsController;
use App\Http\Controllers\API\SoalFITBController;
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

Route::get('/', function () {
    return Inertia::render('LandingPage');
})->name('landing')->middleware('check.auth');

Route::get('/login', function () {
    return Inertia::render('LoginPage');
})->name('login')->middleware('check.auth');

Route::get('/register', function () {
    return Inertia::render('RegistPage');
})->name('register')->middleware('check.auth');

Route::get('/contact', function () {
    return Inertia::render('PagesPraktikan/ContactPage');
})->name('contact')->middleware('check.auth');

Route::get('/about', function () {
    return Inertia::render('PagesPraktikan/AboutPage');
})->name('about')->middleware('check.auth');

//Authenticated pages

Route::get('/assistant',
    function () {
        return Inertia::render('PagesAssistants/ProfileAssistant');
    }
)->name('assistant')->middleware(['auth:asisten', 'can:manage-profile,lms-configuration']);

Route::get('/ranking', function () {
    return Inertia::render('PagesAssistants/RankingPraktikan');
})->name('ranking')->middleware(['auth:asisten', 'can:ranking-praktikan']);

Route::get('/polling', function () {
    return Inertia::render('PagesAssistants/PollingAssistant');
})->name('polling')->middleware(['auth:asisten', 'can:see-polling']);

Route::get('/lihat-tp', function () {
    return Inertia::render('PagesAssistants/LihatTP');
})->name('lihat-tp')->middleware(['auth:asisten', 'can:check-tugas-pendahuluan']);

Route::get('/jawaban-tp', function () {
    return Inertia::render('PagesAssistants/ResultLihatTP');
})->name('jawaban-tp')->middleware(['auth:asisten', 'can:check-tugas-pendahuluan']);

Route::get('/list-laporan', function () {
    return Inertia::render('PagesAssistants/ResultLaporan');
})->name('list-laporan')->middleware(['auth:asisten', 'can:laporan-praktikum']);

Route::get('/set-praktikan', function () {
    return Inertia::render('PagesAssistants/SetPraktikan');
})->name('set-praktikan')->middleware(['auth:asisten', 'can:set-praktikan']);

Route::get('/pelanggaran', function () {
    return Inertia::render('PagesAssistants/PelanggaranAssistant');
})->name('pelanggaran')->middleware(['auth:asisten', 'can:manage-pelanggran,see-pelanggaran']);

Route::get('/history', function () {
    return Inertia::render('PagesAssistants/HistoryPraktikum');
})->name('history')->middleware(['auth:asisten', 'can:see-history']);

Route::get('/plottingan', function () {
    return Inertia::render('PagesAssistants/PlottingAssistant');
})->name('plottingan')->middleware(['auth:asisten', 'can:see-plot, manage-plot']);;

Route::get('/manage-role', function () {
    return Inertia::render('PagesAssistants/ManageRole');
})->name('manage-role')->middleware(['auth:asisten', 'can:manage-role']);

Route::get('/nilai-praktikan', function () {
    return Inertia::render('PagesAssistants/NilaiPraktikan');
})->name('nilai-praktikan');

Route::get('/start-praktikum', function () {
    return Inertia::render('PagesAssistants/StartPraktikum');
})->name('manage-role')->middleware(['auth:asisten', 'can:manage-praktikum, see-praktikum']);

Route::get('/modul', function () {
    return Inertia::render('PagesAssistants/ModulePraktikum');
})->name('modul')->middleware(['auth:asisten', 'can:manage-modul']);//sesuaikan kalo emng asisten biasa bisa lihat

Route::get('/soal', function () {
    return Inertia::render('PagesAssistants/SoalPraktikum');
})->name('soal')->middleware(['auth:asisten', 'can:see-soal,manage-soal']);



// route for praktikan
Route::get('/praktikan', function () {
    return Inertia::render('PagesPraktikan/ProfilePraktikan');
})->name('praktikan')->middleware(['auth:praktikan', 'can:lihat-profile']);

Route::get('/praktikum', function () {
    return Inertia::render('PagesPraktikan/ModulePage');
})->name('praktikum')->middleware(['auth:praktikan', 'can:lihat-modul']);

Route::get('/score-praktikan', function () {
    return Inertia::render('PagesPraktikan/ScorePraktikan');
})->name('score-praktikan')->middleware(['auth:praktikan', 'can:lihat-nilai']);

Route::get('/leaderboard-praktikan', function () {
    return Inertia::render('PagesPraktikan/LeaderboardPraktikan');
})->name('leaderboard-praktikan')->middleware(['auth:praktikan', 'can:ranking-praktikan']);

Route::get('/contact-assistant', function () {
    return Inertia::render('PagesPraktikan/ContactAssistant');
})->name('contact-assistant')->middleware(['auth:praktikan', 'can:lihat-asisten']);

Route::get('/polling-assistant', function () { 
    return Inertia::render('PagesPraktikan/PollingPage'); 
})->name('polling-assistant');

/////////////////////////////////////// Data Routes ///////////////////////////////////////
Route::prefix('api-v1')->group(function () {
    Route::put('/asisten', [AsistenController::class, 'update'])->name('update.asisten')->middleware(['auth:asisten', 'can:manage-profile']);

    // i guess
    Route::post('/register/asisten', [RegisteredAsistenController::class, 'store'])->name('store.asisten')->middleware('guest');
    Route::post('/register/praktikan', [RegisteredPraktikanController::class, 'store'])->name('store.praktikan')->middleware('guest');

    // Asisten
    // Route::get('/asisten', [AsistenController::class, 'index'])->name('get.asisten')->middleware(['auth:asisten', 'can:see-plot,lihat-asisten']);
    // Route::put('/asisten', [AsistenController::class, 'update'])->name('update.asisten')->middleware(['auth:asisten', 'can:manage-profile']);
    Route::delete('/asisten/{idAsisten}', [AsistenController::class, 'destroy'])->name('destroy.asisten')->middleware(['auth:asisten', 'can:manage-role']);

    // Roles
    Route::get('/roles', [RoleController::class, 'index'])->name('get.roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('store.roles')->middleware(['auth:asisten', 'can:manage-role']);
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('update.roles')->middleware(['auth:asisten', 'can:manage-role']);

    // Modul
    Route::get('/modul', [ModulController::class, 'index'])->name('get.modul')->middleware(['auth:asisten', 'can:lihat-modul,see-soal,see-praktikum']);
    Route::post('/modul', [ModulController::class, 'store'])->name('store.modul')->middleware(['auth:asisten', 'can:manage-modul']);
    Route::put('/modul/{id}', [ModulController::class, 'update'])->name('update.modul')->middleware(['auth:asisten', 'can:manage-modul']);
    Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('delete.modul')->middleware(['auth:asisten', 'can:manage-modul']);
    Route::post('/modul/reset', [ModulController::class, 'reset'])->name('reset.modul')->middleware(['auth:asisten', 'can:lms-configuration']);
    Route::patch('/modul/update-status', [ModulController::class, 'updateStatus'])->name('update.status')->middleware(['auth:asisten', 'can:manage-modul']);

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('get.kelas')->middleware(['auth:asisten', 'can:manage-plot,see-plot']);
    Route::post('/kelas', [KelasController::class, 'store'])->name('store.kelas')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('update.kelas')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('delete.kelas')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::post('/kelas/reset', [KelasController::class, 'reset'])->name('reset.kelas')->middleware(['auth:asisten', 'can:lms-configuration']);

    // Jadwal Jaga
    Route::get('/jadwal', [JadwalJagaController::class, 'index'])->name('get.jadwal')->middleware(['auth:asisten', 'can:see-plot,manage-plot']);
    Route::post('/jadwal', [JadwalJagaController::class, 'store'])->name('store.jadwal')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::delete('/jadwal/{id}', [JadwalJagaController::class, 'destroy'])->name('delete.jadwal')->middleware(['auth:asisten', 'can:manage-plot']);

    // History Jaga
    Route::get('/history-jaga', [HistoryJagaController::class, 'index'])->name('get.history')->middleware(['auth:asisten', 'can:see-history']);
    Route::post('/history-jaga', [HistoryJagaController::class, 'store'])->name('store.history')->middleware(['auth:asisten', 'can:manage-praktikum']);

    // Laporan PJ
    Route::get('/laporan-pj', [LaporanPjController::class, 'index'])->name('get.laporanPJ')->middleware(['auth:asisten', 'can:laporan-praktikum']);
    Route::post('/laporan-pj/{idKelas}', [LaporanPjController::class, 'store'])->name('store.laporanPJ')->middleware(['auth:asisten', 'can:laporan-praktikum']);
    Route::get('/laporan-pj/{id}', [LaporanPjController::class, 'show'])->name('show.laporanPJ')->middleware(['auth:asisten', 'can:laporan-praktikum']);
    // Route::delete('/laporan-pj/{id}', [LaporanPjController::class, 'destroy'])->name('delete.laporanPJ'); //in audit for rollback feature maybe

    // Configuration
    Route::get('/config', [ConfigurationController::class, 'index'])->name('get.config')->middleware(['auth:asisten', 'can:lms-configuration,tp-configuration,praktikan-regist']);
    Route::put('/config', [ConfigurationController::class, 'update'])->name('update.config')->middleware(['auth:asisten', 'can:lms-configuration,tp-configuration,praktikan-regist']);

    // Pelanggaran
    Route::get('/pelanggaran', [PelanggaranController::class, 'index'])->name('get.pelanggaran')->middleware(['auth:asisten', 'can:see-pelanggaran']);
    Route::post('/pelanggaran', [PelanggaranController::class, 'store'])->name('store.pelanggaran')->middleware(['auth:asisten', 'can:manage-praktikum']);
    Route::delete('/pelanggaran/{id}', [PelanggaranController::class, 'destroy'])->name('delete.pelanggaran')->middleware(['auth:asisten', 'can:manage-pelanggaran']);
    Route::post('/pelanggaran/reset', [PelanggaranController::class, 'reset'])->name('reset.pelanggaran')->middleware(['auth:asisten', 'can:lms-configuration']);

    // Jenis Polling
    Route::get('/jenis-polling', [JenisPollingController::class, 'index'])->name('get.jenis.poling')->middleware(['auth:asisten', 'can:see-polling,isi-polling']);

    // Polling View Count
    Route::get('/polling/{id}', [PollingsController::class, 'show'])->name('show.polling')->middleware(['auth:asisten', 'can:see-polling']);

    // Soal TP
    Route::get('/soal-tp/{idModul}', [SoalTPController::class, 'show'])->name('show.soaltp')->middleware(['auth:asisten', 'can:lihat-modul,see-soal']);
    Route::post('/soal-tp/{idModul}', [SoalTPController::class, 'store'])->name('store.soaltp')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-tp/{idSoal}', [SoalTPController::class, 'update'])->name('update.soaltp')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-tp/{id}', [SoalTPController::class, 'destroy'])->name('delete.soaltp')->middleware(['auth:asisten', 'can:manage-soal']);

    // Soal TM
    Route::get('/soal-tm/{idModul}', [SoalTMController::class, 'show'])->name('show.soaltm')->middleware(['auth:asisten', 'can:lihat-modul,see-soal']);
    Route::post('/soal-tm/{idModul}', [SoalTMController::class, 'store'])->name('store.soaltm')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-tm/{idSoal}', [SoalTMController::class, 'update'])->name('update.soaltm')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-tm/{id}', [SoalTMController::class, 'destroy'])->name('delete.soaltm')->middleware(['auth:asisten', 'can:manage-soal']);

    // Soal FITB
    Route::get('/soal-fitb/{idModul}', [SoalFITBController::class, 'show'])->name('show.soalfitb')->middleware(['auth:asisten', 'can:lihat-modul,see-soal']);
    Route::post('/soal-fitb/{idModul}', [SoalFITBController::class, 'store'])->name('store.soalfitb')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-fitb/{idSoal}', [SoalFITBController::class, 'update'])->name('update.soalfitb')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-fitb/{id}', [SoalFITBController::class, 'destroy'])->name('delete.soalfitb')->middleware(['auth:asisten', 'can:manage-soal']);

    // soal jurnal
    Route::get('/soal-jurnal/{idModul}', [SoalJurnalController::class, 'show'])->name('show.soaljurnal')->middleware(['auth:asisten', 'can:lihat-modul,see-soal']);
    Route::post('/soal-jurnal/{idModul}', [SoalJurnalController::class, 'store'])->name('store.soaljurnal')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-jurnal/{idSoal}', [SoalJurnalController::class, 'update'])->name('update.soaljurnal')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-jurnal/{id}', [SoalJurnalController::class, 'destroy'])->name('delete.soaljurnal')->middleware(['auth:asisten', 'can:manage-soal']);

    // soal ta
    Route::get('/soal-ta/{idModul}/kelas/{idKelas}', [SoalTAController::class, 'show'])->name('show.soalta')->middleware(['auth:asisten', 'can:lihat-modul,see-soal']);
    Route::post('/soal-ta/{idModul}', [SoalTAController::class, 'store'])->name('store.soalta')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-ta/{idSoal}', [SoalTAController::class, 'update'])->name('update.soalta')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-ta/{id}', [SoalTAController::class, 'destroy'])->name('delete.soalta')->middleware(['auth:asisten', 'can:manage-soal']);

    // soal tk
    Route::get('/soal-tk/{idModul}/kelas/{idKelas}', [SoalTKController::class, 'show'])->name('show.soaltk')->middleware(['auth:asisten', 'can:lihat-modul,see-soal']);
    Route::post('/soal-tk/{idModul}', [SoalTKController::class, 'store'])->name('store.soaltk')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-tk/{idSoal}', [SoalTKController::class, 'update'])->name('update.soaltk')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-tk/{id}', [SoalTKController::class, 'destroy'])->name('delete.soaltk')->middleware(['auth:asisten', 'can:manage-soal']);

    // praktikums
    Route::get('/praktikum/{idKelas}', [PraktikumController::class, 'show'])->name('show.praktikums')->middleware(['auth:asisten', 'can:manage-praktikum,see-praktikum']);
    Route::put('/praktikum/{id}', [PraktikumController::class, 'update'])->name('update.praktikums')->middleware(['auth:asisten', 'can:manage-praktikum']);

    // reset praktikum
    Route::put('/deadline/reset/{idPraktikum}', [DeadlineController::class, 'reset'])->name('reset.deadline')->middleware(['auth:asisten', 'can:manage-praktikum']);

    // deadlines
    Route::get('/deadline/{idPraktikum}', [DeadlineController::class, 'show'])->name('show.deadlines')->middleware(['auth:asisten', 'can:manage-praktikum,see-praktikum']);
    Route::put('/deadline/{id}', [DeadlineController::class, 'update'])->name('update.deadlines')->middleware(['auth:asisten', 'can:manage-praktikum']);

    // tugas pendahuluan
    Route::get('/tugas-pendahuluan', [TugasPendahuluanController::class, 'index'])->name('index.tugaspendahuluans')->middleware(['auth:asisten', 'can:tugas-pendahuluan']);
    Route::put('/tugas-pendahuluan', [TugasPendahuluanController::class, 'update'])->name('update.tugaspendahuluans')->middleware(['auth:asisten', 'can:tugas-pendahuluan']);

    // leaderboard
    Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('get.leaderboard')->middleware(['auth:asisten', 'can:ranking-praktikan']);
    Route::get('/leaderboard/{idKelas}', [LeaderBoardController::class, 'show'])->name('show.leaderboard')->middleware(['auth:asisten', 'can:ranking-praktikan']);

    // nilais
    Route::post('/nilai', [NilaiController::class, 'store'])->name('store.nilais')->middleware(['auth:asisten', 'can:nilai-praktikan, praktikum-lms']);
    Route::get('/nilai/{id}', [NilaiController::class, 'showAsisten'])->name('showAsisten.nilais')->middleware(['auth:asisten', 'can:nilai-praktikan']);
    Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('update.nilais')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // // Jawaban TM asisten
    // Route::get('/jawaban-mandiri/praktikan/{idPraktikan}/modul/{idModul}', [JawabanTMController::class, 'showAsisten'])->name('showAsisten.jawaban.tm')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // // Jawaban Fitb asisten
    // Route::get('/jawaban-fitb/praktikan/{idPraktikan}/modul/{idModul}', [JawabanFITBController::class, 'showAsisten'])->name('showAsisten.jawaban.fitb')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // // Jawaban Jurnal asisten
    // Route::get('/jawaban-jurnal/praktikan/{idPraktikan}/modul/{idModul}', [JawabanJurnalController::class, 'showAsisten'])->name('showAsisten.jawaban.jurnal')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban TP asisten
    Route::get('/jawaban-tp/praktikan/{idPraktikan}/modul/{idModul}', [JawabanTMController::class, 'showAsisten'])->name('showAsisten.jawaban.tp')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // lapran praktikan ini buat asisten
    Route::get('/laporan-praktikan/{id}', [LaporanPraktikanController::class, 'show'])->name('show.laporan-praktikan')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    //set praktikan
    Route::post('/set-praktikan', [PraktikanController::class, 'setPraktikan'])->name('set.praktikan')->middleware(['auth:asisten', 'can:set-praktikan']);

    //set praktikan
    Route::post('/set-password', [PraktikanController::class, 'setPassword'])->name('set.password')->middleware(['auth:asisten', 'can:set-praktikan']);


    ////////////////praktikan///////////////////////////////    
    // polling
    Route::post('/polling', [PollingsController::class, 'store'])->name('store.polling')->middleware(['auth:praktikan', 'can:isi-polling']);

    Route::get('/nilai', [NilaiController::class, 'show'])->name('show.nilais')->middleware(['auth:praktikan', 'can:lihat-nilai']);

    // Jawaban TA
    Route::post('/jawaban-ta', [JawabanTAController::class, 'store'])->name('store.jawaban.ta')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-ta/{idModul}', [JawabanTAController::class, 'show'])->name('show.jawaban.ta')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban TK
    Route::post('/jawaban-tk', [JawabanTKController::class, 'store'])->name('store.jawaban.tk')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-tk/{idModul}', [JawabanTKController::class, 'show'])->name('show.jawaban.tk')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban TM
    Route::post('/jawaban-tm', [JawabanTMController::class, 'store'])->name('store.jawaban.tm')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-tm/{idModul}', [JawabanTMController::class, 'show'])->name('show.jawaban.tm')->middleware(['auth:praktikan', 'can:lihat-modul']);

    //Jawaban Fitb
    Route::post('/jawaban-fitb', [JawabanFITBController::class, 'store'])->name('store.jawaban.fitb')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-fitb/{idModul}', [JawabanFITBController::class, 'show'])->name('show.jawaban.fitb')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban Jurnal
    Route::post('/jawaban-jurnal', [JawabanJurnalController::class, 'store'])->name('store.jawaban.jurnal')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-jurnal/{idModul}', [JawabanJurnalController::class, 'show'])->name('show.jawaban.jurnal')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban Tugas Pendahuluan
    Route::post('/jawaban-tp', [JawabanTPController::class, 'store'])->name('store.jawaban.tugas-pendahuluan')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-tp/{idModul}', [JawabanTPController::class, 'show'])->name('show.jawaban.tp')->middleware(['auth:praktikan', 'can:lihat-modul']);

    //laporan Praktikan
    Route::post('/laporan-praktikan', [LaporanPraktikanController::class, 'store'])->name('store.laporan-praktikan')->middleware(['auth:praktikan', 'can:praktikum-lms']);

});

Route::fallback(function () {
    return redirect('/');
})->middleware('check.auth');


require __DIR__ . '/auth.php';

