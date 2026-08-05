<?php

use App\Http\Controllers\API\AnomalyController;
use App\Http\Controllers\API\AsistenController;
use App\Http\Controllers\API\AutosaveSnapshotController;
use App\Http\Controllers\API\ConfigurationController;
use App\Http\Controllers\API\ImageKitAuthController;
use App\Http\Controllers\API\JadwalJagaController;
use App\Http\Controllers\API\JawabanFITBController;
use App\Http\Controllers\API\JawabanJurnalController;
use App\Http\Controllers\API\JawabanTAController;
use App\Http\Controllers\API\JawabanTKController;
use App\Http\Controllers\API\JawabanTMController;
use App\Http\Controllers\API\JawabanTPController;
use App\Http\Controllers\API\JenisPollingController;
use App\Http\Controllers\API\KelasController;
use App\Http\Controllers\API\LaporanPraktikanController;
use App\Http\Controllers\API\LeaderBoardController;
use App\Http\Controllers\API\ModulController;
use App\Http\Controllers\API\NilaiController;
use App\Http\Controllers\API\PollingsController;
use App\Http\Controllers\API\PraktikanController;
use App\Http\Controllers\API\PraktikumController;
use App\Http\Controllers\API\PraktikumProgressController;
use App\Http\Controllers\API\RoleController;
use App\Http\Controllers\API\SeeLabsProxyController;
use App\Http\Controllers\API\SoalCommentController;
use App\Http\Controllers\API\SoalFITBController;
use App\Http\Controllers\API\SoalJurnalController;
use App\Http\Controllers\API\SoalTAController;
use App\Http\Controllers\API\SoalTKController;
use App\Http\Controllers\API\SoalTMController;
use App\Http\Controllers\API\SoalTPController;
use App\Http\Controllers\API\TugasPendahuluanController;
use App\Http\Controllers\Api\V1\NilaiComplaintController;
use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\Auth\RegisteredAsistenController;
use App\Http\Controllers\Auth\RegisteredPraktikanController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::inertia('/', 'LandingPage')
    ->name('landing')
    ->middleware('check.auth');

Route::inertia('/login', 'LoginPage')
    ->name('login')
    ->middleware('check.auth');

Route::inertia('/register', 'RegistPage')
    ->name('register')
    ->middleware('check.auth');

Route::inertia('/contact', 'Praktikan/ContactPage')
    ->name('contact')
    ->middleware('check.auth');

Route::inertia('/about', 'Praktikan/AboutPage')
    ->name('about')
    ->middleware('check.auth');

// Authenticated pages

Route::get('/assistant', function () {
    return Inertia::render('Assistants/ProfileAssistant', [
        'foto' => auth('asisten')->user()?->foto_asistens?->foto ?? 'https://via.placeholder.com/150',
    ]);
})->name('assistant')->middleware(['auth:asisten', 'permission:manage-profile|lms-configuration']);

Route::inertia('/polling', 'Assistants/PollingAssistant')
    ->name('polling')
    ->middleware(['auth:asisten', 'can:see-polling']);

Route::inertia('/leaderboard-ranking', 'Assistants/LeaderboardRanking')
    ->name('leaderboard-ranking')
    ->middleware(['auth:asisten', 'can:ranking-praktikan']);

Route::inertia('/lihat-tp', 'Assistants/LihatTP')
    ->name('lihat-tp')
    ->middleware(['auth:asisten', 'can:check-tugas-pendahuluan']);

Route::inertia('/jawaban-tp', 'Assistants/ResultLihatTP')
    ->name('jawaban-tp')
    ->middleware(['auth:asisten', 'can:check-tugas-pendahuluan']);

Route::inertia('/list-laporan', 'Assistants/ResultLaporan')
    ->name('list-laporan')
    ->middleware(['auth:asisten', 'can:laporan-praktikum']);

Route::inertia('/pelanggaran', 'Assistants/PelanggaranAssistant')
    ->name('pelanggaran')
    ->middleware(['auth:asisten', 'can:see-pelanggaran']);

Route::inertia('/history', 'Assistants/HistoryPraktikum')
    ->name('history')
    ->middleware(['auth:asisten', 'can:see-history']);

Route::inertia('/plottingan', 'Assistants/PlottingAssistant')
    ->name('plottingan')
    ->middleware(['auth:asisten', 'permission:see-plot|manage-plot']);

Route::inertia('/manage-role', 'Assistants/ManageRole')
    ->name('manage-role')
    ->middleware(['auth:asisten', 'can:manage-role']);

Route::get('/audit-logs', AuditLogController::class)
    ->name('audit-logs')
    ->middleware(['auth:asisten', 'permission:manage-role']);

Route::inertia('/nilai-praktikan', 'Assistants/NilaiPraktikan')
    ->name('nilai-praktikan')
    ->middleware(['auth:asisten', 'can:nilai-praktikan']);

Route::inertia('/set-praktikan', 'Assistants/SetPraktikan')
    ->name('set-praktikan')
    ->middleware(['auth:asisten']);

Route::inertia('/manage-praktikan', 'Assistants/ManagePraktikan')
    ->name('manage-praktikan')
    ->middleware(['auth:asisten', 'can:set-praktikan']);

Route::inertia('/start-praktikum', 'Assistants/StartPraktikum')
    ->name('start-praktikum')
    ->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);

Route::inertia('/modul', 'Assistants/ModulePraktikum')
    ->name('modul')
    ->middleware(['auth:asisten', 'can:manage-modul']);

Route::inertia('/soal', 'Assistants/SoalPraktikum')
    ->name('soal')
    ->middleware(['auth:asisten', 'permission:see-soal|manage-soal']);

// route for praktikan
Route::inertia('/praktikan', 'Praktikan/ProfilePraktikan')
    ->name('praktikan')
    ->middleware(['auth:praktikan', 'can:lihat-profile']);

Route::inertia('/praktikum', 'Praktikan/PraktikumPage')
    ->name('praktikum')
    ->middleware(['auth:praktikan', 'can:lihat-modul']);

Route::inertia('/praktikan-modul', 'Praktikan/ModulesPage')
    ->name('praktikan-modul')
    ->middleware(['auth:praktikan', 'can:lihat-modul']);

Route::inertia('/tugas-pendahuluan', 'Praktikan/TugasPendahuluanPage')
    ->name('tugas-pendahuluan')
    ->middleware(['auth:praktikan', 'can:lihat-modul']);

Route::inertia('/score-praktikan', 'Praktikan/ScorePraktikan')
    ->name('score-praktikan')
    ->middleware(['auth:praktikan', 'can:lihat-nilai']);

Route::inertia('/contact-assistant', 'Praktikan/ContactAssistant')
    ->name('contact-assistant')
    ->middleware(['auth:praktikan', 'can:lihat-asisten']);

Route::inertia('/polling-assistant', 'Praktikan/PollingPage')
    ->name('polling-assistant');

// Route::inertia('/praktikum/timer', 'PraktikumTimer')
//         ->name('praktikum.timer');

Route::prefix('api-v1')->group(function () {
    Route::get('/get-kelas', [RegisteredPraktikanController::class, 'getKelas'])->name('public-getkelas');
    Route::post('/register/asisten', [RegisteredAsistenController::class, 'store'])->name('store.asisten');
    Route::post('/register/praktikan', [RegisteredPraktikanController::class, 'store'])->name('store.praktikan');
    Route::get('/config', [ConfigurationController::class, 'index'])->name('public.get.config');
    Route::get('/roles', [RoleController::class, 'index'])->name('public.get.roles');
    // Route::get('/praktikum/active', [PraktikumController::class, 'active'])->name('api.public.praktikum.active');
});

// ///////////////////////////////////// Data Routes ///////////////////////////////////////
Route::prefix('api-v1')->middleware(['audit.assistant', 'auth:asisten,praktikan'])->group(function () {
    // see.labs proxy (asisten shortcut window)
    Route::match(['get', 'post'], '/see-proxy', [SeeLabsProxyController::class, 'handle'])
        ->name('see.proxy')
        ->middleware('auth:asisten');

    // ImageKit authentication endpoint
    Route::get('/imagekit/auth', [ImageKitAuthController::class, 'generateAuth'])->name('imagekit.auth');

    // ImageKit server-side upload endpoint
    Route::post('/imagekit/upload', [ImageKitAuthController::class, 'upload'])->name('imagekit.upload');

    Route::put('/asisten', [AsistenController::class, 'update'])->name('update.asisten')->middleware(['auth:asisten', 'can:manage-profile']);
    Route::post('/profilePic', [AsistenController::class, 'updatePp'])
        ->name('updatePp.asisten')
        ->middleware('auth:asisten');
    Route::delete('/profilePic', [AsistenController::class, 'destroyPp'])
        ->name('destroyPp.asisten')
        ->middleware('auth:asisten');

    // i guess
    // Route::post('/register/asisten', [RegisteredAsistenController::class, 'store'])->name('store.asisten')->middleware('guest');
    // Route::post('/register/praktikan', [RegisteredPraktikanController::class, 'store'])->name('store.praktikan')->middleware('guest');
    // Route::get('/get-kelas', [RegisteredPraktikanController::class, 'getKelas'])->name('public-getkelas');

    // Praktikan
    Route::put('/praktikan', [PraktikanController::class, 'updateProfile'])->middleware('auth:praktikan');
    Route::patch('/praktikan/password', [PraktikanController::class, 'updatePassword'])->middleware('auth:praktikan');
    Route::post('/praktikan/profile-picture', [PraktikanController::class, 'updateProfilePicture'])->middleware('auth:praktikan');
    Route::delete('/praktikan/profile-picture', [PraktikanController::class, 'deleteProfilePicture'])->middleware('auth:praktikan');
    Route::get('/praktikan/autosave', [AutosaveSnapshotController::class, 'index'])
        ->name('praktikan.autosave.index')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::post('/praktikan/autosave', [AutosaveSnapshotController::class, 'store'])
        ->name('praktikan.autosave.store')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::post('/praktikan/autosave/bulk-upsert', [AutosaveSnapshotController::class, 'bulkUpsert'])
        ->name('praktikan.autosave.bulk')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::delete('/praktikan/autosave', [AutosaveSnapshotController::class, 'destroy'])
        ->name('praktikan.autosave.clear')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::post('/praktikan/autosave/questions', [AutosaveSnapshotController::class, 'storeQuestionIds'])
        ->name('praktikan.autosave.questions.store')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/praktikan/autosave/questions', [AutosaveSnapshotController::class, 'getQuestionIds'])
        ->name('praktikan.autosave.questions.index')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/praktikan', [PraktikanController::class, 'index'])
        ->name('praktikan.index')
        ->middleware(['auth:asisten', 'permission:praktikan-regist|manage-role|check-tugas-pendahuluan|nilai-praktikan']);
    Route::post('/praktikan', [PraktikanController::class, 'store'])
        ->name('praktikan.store')
        ->middleware(['auth:asisten', 'permission:praktikan-regist|manage-role']);
    Route::get('/praktikan/{praktikan}', [PraktikanController::class, 'show'])
        ->name('praktikan.show')
        ->middleware(['auth:asisten', 'permission:praktikan-regist|manage-role']);
    Route::put('/praktikan/{praktikan}', [PraktikanController::class, 'update'])
        ->name('praktikan.update')
        ->middleware(['auth:asisten', 'permission:praktikan-regist|manage-role']);
    Route::patch('/praktikan/{praktikan}', [PraktikanController::class, 'update'])
        ->name('praktikan.patch')
        ->middleware(['auth:asisten', 'permission:praktikan-regist|manage-role']);
    Route::delete('/praktikan/{praktikan}', [PraktikanController::class, 'destroy'])
        ->name('praktikan.destroy')
        ->middleware(['auth:asisten', 'permission:praktikan-regist|manage-role']);
    Route::get('/laporan/unmarked-summary', [LaporanPraktikanController::class, 'unmarkedSummary'])
        ->name('laporan.unmarked-summary')
        ->middleware(['auth:asisten', 'permission:see-pelanggaran|manage-role']);
    Route::post('/laporan-praktikan', [LaporanPraktikanController::class, 'store'])
        ->name('laporan-praktikan.store')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);

    Route::get('/asisten/soal-comment/{tipeSoal}/{modul}', [SoalCommentController::class, 'showByModul'])
        ->name('asisten.soal-comment.index')
        ->middleware(['auth:asisten', 'can:nilai-praktikan']);
    Route::post('/praktikan/soal-comment/{praktikan}/{tipeSoal}/{soal}', [SoalCommentController::class, 'store'])
        ->name('praktikan.soal-comment.store')
        ->middleware(['auth:praktikan', 'can:praktikum-lms']);

    // Asisten
    Route::patch('/asisten/password', [AsistenController::class, 'updatePassword'])->name('asisten.password.update')->middleware('auth:asisten');
    // Route::get('/asisten', [AsistenController::class, 'index'])->name('get.asisten')->middleware(['auth:asisten,praktikan', 'can:lihat-asisten']);
    Route::get('/asisten', [AsistenController::class, 'index'])->name('get.asisten')->middleware(['auth:asisten,praktikan', 'permission:lihat-asisten|manage-role|manage-praktikum']);
    // Route::put('/asisten', [AsistenController::class, 'update'])->name('update.asisten')->middleware(['auth:asisten', 'can:manage-profile']);
    Route::post('/asisten/delete', [AsistenController::class, 'destroy'])->name('destroy.asisten')->middleware(['auth:asisten', 'can:manage-role']);

    // Roles (GET is public via /api-v1/roles in public routes)
    Route::post('/roles', [RoleController::class, 'store'])->name('store.roles')->middleware(['auth:asisten', 'can:manage-role']);
    Route::put('/roles/{id}', [RoleController::class, 'update'])->name('update.roles')->middleware(['auth:asisten', 'can:manage-role']);

    // Modul
    // Route::get('/modul', [ModulController::class, 'index'])->name('get.modul');
    // Route::get('/modul', [ModulController::class, 'index'])->name('get.modul')->middleware(['auth:asisten,praktikan', 'permission:manage-modul|lihat-modul']);
    Route::get('/modul', [ModulController::class, 'index'])->name('get.modul')->middleware(['auth:asisten,praktikan', 'permission:manage-modul|lihat-modul|see-soal']);
    Route::post('/modul', [ModulController::class, 'store'])->name('store.modul')->middleware(['auth:asisten', 'can:manage-modul']);
    Route::patch('/modul/bulk-update', [ModulController::class, 'bulkUpdate'])
        ->name('modul.bulkUpdate')
        ->middleware(['auth:asisten', 'can:manage-modul']);
    // Route::put('/modul/{id}', [ModulController::class, 'update'])->name('update.modul')->middleware(['auth:asisten', 'can:manage-modul']);
    Route::patch('/modul/{id}', [ModulController::class, 'update'])->name('modul.update')->middleware(['auth:asisten', 'can:manage-modul']);
    Route::delete('/modul/{id}', [ModulController::class, 'destroy'])->name('delete.modul')->middleware(['auth:asisten', 'can:manage-modul']);

    Route::get('/anomalies/attendance', [AnomalyController::class, 'attendance'])
        ->name('anomalies.attendance')
        ->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);

    Route::get('/anomalies/grades', [AnomalyController::class, 'nilai'])
        ->name('anomalies.grades')
        ->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);

    // Kelas
    Route::get('/kelas', [KelasController::class, 'index'])->name('get.kelas');
    Route::post('/kelas', [KelasController::class, 'store'])->name('store.kelas')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::put('/kelas/{id}', [KelasController::class, 'update'])->name('update.kelas')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::delete('/kelas/{id}', [KelasController::class, 'destroy'])->name('delete.kelas')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::post('/kelas/reset', [KelasController::class, 'reset'])->name('reset.kelas')->middleware(['auth:asisten', 'can:lms-configuration']);

    // Jadwal Jaga
    Route::get('/jadwal', [JadwalJagaController::class, 'index'])->name('get.jadwal')->middleware(['auth:asisten', 'permission:see-plot|manage-plot|manage-praktikum']);
    Route::post('/jadwal', [JadwalJagaController::class, 'store'])->name('store.jadwal')->middleware(['auth:asisten', 'can:manage-plot']);
    Route::delete('/jadwal/{id}', [JadwalJagaController::class, 'destroy'])->name('delete.jadwal')->middleware(['auth:asisten', 'can:manage-plot']);

    // Praktikum Sessions
    Route::get('/praktikum', [PraktikumController::class, 'index'])->name('api.get.praktikums')->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);
    Route::post('/praktikum', [PraktikumController::class, 'store'])->name('api.store.praktikums')->middleware(['auth:asisten', 'can:manage-praktikum']);
    Route::get('/praktikum/check-praktikum', [PraktikumController::class, 'checkPraktikum'])->name('api.check.praktikum')->middleware(['auth:praktikan']);
    Route::post('/praktikum/set-dk', [PraktikumController::class, 'storeDk'])->name('api.praktikum.set-dk')->middleware(['auth:praktikan']);
    Route::get('/praktikum/history', [PraktikumController::class, 'history'])->name('api.history.praktikums')->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);
    Route::get('/praktikum/{idKelas}', [PraktikumController::class, 'show'])->name('api.show.praktikums')->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);
    Route::put('/praktikum/{id}', [PraktikumController::class, 'update'])->name('api.update.praktikums')->middleware(['auth:asisten', 'can:manage-praktikum']);

    // Configuration (UPDATE only - READ is public via /api-v1/config in public routes)
    Route::put('/config', [ConfigurationController::class, 'update'])->name('update.config')->middleware(['auth:asisten', 'permission:lms-configuration|tp-configuration|praktikan-regist']);

    // Jenis Polling
    Route::get('/jenis-polling', [JenisPollingController::class, 'index'])->name('get.jenis.poling')->middleware(['auth:asisten,praktikan']);
    Route::post('/jenis-polling', [JenisPollingController::class, 'store'])->name('store.jenis.poling')->middleware(['auth:asisten']);
    Route::delete('/jenis-polling/{jenisPolling}', [JenisPollingController::class, 'destroy'])
        ->name('destroy.jenis.poling')
        ->middleware(['auth:asisten']);

    // Polling View Count
    Route::get('/polling/{id}', [PollingsController::class, 'show'])->name('show.polling')->middleware(['auth:asisten,praktikan']);

    // Soal TP
    Route::get('/soal-tp/{idModul}', [SoalTPController::class, 'show'])->name('show.soaltp')->middleware(['auth:asisten,praktikan', 'permission:see-soal|lihat-modul']);
    Route::post('/soal-tp/{idModul}', [SoalTPController::class, 'store'])->name('store.soaltp')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-tp/{idSoal}', [SoalTPController::class, 'update'])->name('update.soaltp')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-tp/{idSoal}', [SoalTPController::class, 'destroy'])->name('delete.soaltp')->middleware(['auth:asisten', 'can:manage-soal']);

    // Soal TM
    Route::get('/soal-tm/{idModul}', [SoalTMController::class, 'show'])->name('show.soaltm')->middleware(['auth:asisten,praktikan', 'permission:see-soal|lihat-modul']);
    Route::post('/soal-tm/{idModul}', [SoalTMController::class, 'store'])->name('store.soaltm')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-tm/{idSoal}', [SoalTMController::class, 'update'])->name('update.soaltm')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-tm/{idSoal}', [SoalTMController::class, 'destroy'])->name('delete.soaltm')->middleware(['auth:asisten', 'can:manage-soal']);

    // Soal FITB
    Route::get('/soal-fitb/{idModul}', [SoalFITBController::class, 'show'])->name('show.soalfitb')->middleware(['auth:asisten,praktikan', 'permission:see-soal|lihat-modul']);
    Route::post('/soal-fitb/{idModul}', [SoalFITBController::class, 'store'])->name('store.soalfitb')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-fitb/{idSoal}', [SoalFITBController::class, 'update'])->name('update.soalfitb')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-fitb/{idSoal}', [SoalFITBController::class, 'destroy'])->name('delete.soalfitb')->middleware(['auth:asisten', 'can:manage-soal']);

    // soal jurnal
    Route::get('/soal-jurnal/{idModul}', [SoalJurnalController::class, 'show'])->name('show.soaljurnal')->middleware(['auth:asisten,praktikan', 'permission:see-soal|lihat-modul']);
    Route::post('/soal-jurnal/{idModul}', [SoalJurnalController::class, 'store'])->name('store.soaljurnal')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-jurnal/{idSoal}', [SoalJurnalController::class, 'update'])->name('update.soaljurnal')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-jurnal/{idSoal}', [SoalJurnalController::class, 'destroy'])->name('delete.soaljurnal')->middleware(['auth:asisten', 'can:manage-soal']);

    // soal ta
    Route::get('/soal-ta/{idModul}', [SoalTAController::class, 'show'])->name('show.soalta')->middleware(['auth:asisten,praktikan', 'permission:see-soal|lihat-modul']);
    Route::post('/soal-ta/{idModul}', [SoalTAController::class, 'store'])->name('store.soalta')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-ta/{idSoal}', [SoalTAController::class, 'update'])->name('update.soalta')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-ta/{idSoal}', [SoalTAController::class, 'destroy'])->name('delete.soalta')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::get('/soal-ta/{idModul}/analysis', [JawabanTAController::class, 'analysis'])
        ->name('analysis.soalta')
        ->middleware(['auth:asisten', 'permission:see-soal|manage-soal']);

    // soal tk
    Route::get('/soal-tk/{idModul}', [SoalTKController::class, 'show'])->name('show.soaltk')->middleware(['auth:asisten,praktikan', 'permission:see-soal|lihat-modul']);
    Route::post('/soal-tk/{idModul}', [SoalTKController::class, 'store'])->name('store.soaltk')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::put('/soal-tk/{idSoal}', [SoalTKController::class, 'update'])->name('update.soaltk')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::delete('/soal-tk/{idSoal}', [SoalTKController::class, 'destroy'])->name('delete.soaltk')->middleware(['auth:asisten', 'can:manage-soal']);
    Route::get('/soal-tk/{idModul}/analysis', [JawabanTKController::class, 'analysis'])
        ->name('analysis.soaltk')
        ->middleware(['auth:asisten', 'permission:see-soal|manage-soal']);

    // praktikums
    Route::get('/praktikum', [PraktikumController::class, 'index'])->name('get.praktikums')->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);
    Route::get('/praktikum/{idKelas}', [PraktikumController::class, 'show'])->name('show.praktikums')->middleware(['auth:asisten', 'permission:manage-praktikum|see-praktikum']);
    Route::put('/praktikum/{id}', [PraktikumController::class, 'update'])->name('update.praktikums')->middleware(['auth:asisten', 'can:manage-praktikum']);
    Route::get('/praktikum/{praktikum}/progress', [PraktikumProgressController::class, 'show'])->name('praktikum.progress.show');

    // tugas pendahuluan
    Route::get('/tugas-pendahuluan', [TugasPendahuluanController::class, 'index'])->name('index.tugaspendahuluans')->middleware(['auth:asisten,praktikan', 'permission:tugas-pendahuluan|lihat-modul|lms-configuration']);
    Route::put('/tugas-pendahuluan', [TugasPendahuluanController::class, 'update'])->name('update.tugaspendahuluans')->middleware(['auth:asisten', 'permission:tugas-pendahuluan|lms-configuration']);

    // leaderboard
    Route::get('/leaderboard', [LeaderBoardController::class, 'index'])->name('get.leaderboard')->middleware(['auth:asisten,praktikan', 'permission:lihat-leaderboard|ranking-praktikan']);
    Route::get('/leaderboard/praktikan/{praktikan}', [LeaderBoardController::class, 'detail'])
        ->name('detail.leaderboard')
        ->middleware(['auth:asisten', 'can:ranking-praktikan']);
    Route::get('/leaderboard/{idKelas}', [LeaderBoardController::class, 'show'])->name('show.leaderboard')->middleware(['auth:asisten', 'can:ranking-praktikan']);

    // nilais
    Route::post('/nilai', [NilaiController::class, 'store'])->name('store.nilais')->middleware(['auth:asisten', 'permission:nilai-praktikan|praktikum-lms']);
    Route::get('/nilai/praktikan/{praktikan}/modul/{modul}', [NilaiController::class, 'showAsisten'])->name('showAsisten.nilais')->middleware(['auth:asisten', 'can:nilai-praktikan']);
    Route::put('/nilai/{id}', [NilaiController::class, 'update'])->name('update.nilais')->middleware(['auth:asisten', 'can:nilai-praktikan']);
    Route::get('/nilai', [NilaiController::class, 'show'])->name('show.nilais')->middleware(['auth:praktikan', 'can:lihat-nilai']);

    // Nilai Complaints
    Route::post('/nilai-complaints', [NilaiComplaintController::class, 'store'])->name('store.nilai-complaints')->middleware(['auth:praktikan']);
    Route::get('/nilai-complaints', [NilaiComplaintController::class, 'index'])->name('index.nilai-complaints')->middleware(['auth:praktikan']);
    Route::get('/nilai-complaints/asisten', [NilaiComplaintController::class, 'getForAsisten'])->name('get-asisten.nilai-complaints')->middleware(['auth:asisten', 'can:nilai-praktikan']);
    Route::patch('/nilai-complaints/{complaint}', [NilaiComplaintController::class, 'updateStatus'])->name('update-status.nilai-complaints')->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban TM asisten
    Route::get('/jawaban-mandiri/praktikan/{praktikan}/modul/{modul}', [JawabanTMController::class, 'showAsisten'])
        ->name('showAsisten.jawaban.tm')
        ->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban Fitb asisten
    Route::get('/jawaban-fitb/praktikan/{praktikan}/modul/{modul}', [JawabanFITBController::class, 'showAsisten'])
        ->name('showAsisten.jawaban.fitb')
        ->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban Jurnal asisten
    Route::get('/jawaban-jurnal/praktikan/{praktikan}/modul/{modul}', [JawabanJurnalController::class, 'showAsisten'])
        ->name('showAsisten.jawaban.jurnal')
        ->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban TA asisten
    Route::get('/jawaban-ta/praktikan/{praktikan}/modul/{modul}', [JawabanTAController::class, 'showAsisten'])
        ->name('showAsisten.jawaban.ta')
        ->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban TK asisten
    Route::get('/jawaban-tk/praktikan/{praktikan}/modul/{modul}', [JawabanTKController::class, 'showAsisten'])
        ->name('showAsisten.jawaban.tk')
        ->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // Jawaban TP asisten
    // Route::get('/jawaban-tp/{nim}/{modulId}', [JawabanTPController::class, 'show'])->name('jawaban-tp.show')->middleware(['auth:asisten', 'can:nilai-praktikan']);
    Route::get('/jawaban-tp/{nim}/{modulId}', [JawabanTPController::class, 'getJawabanTP'])->name('jawaban-tp.show')->middleware(['auth:asisten', 'permission:nilai-praktikan|check-tugas-pendahuluan']);
    // For Inertia.js page rendering
    // set praktikan
    // Route::post('/set-praktikan', [PraktikanController::class, 'setPraktikan'])->name('set.praktikan')->middleware(['auth:asisten', 'can:set-praktikan']);

    // tarik praktikan
    Route::post('/tarik-praktikan', [PraktikanController::class, 'setPraktikan'])->name('set.praktikan')->middleware(['auth:asisten', 'can:set-praktikan']);
    Route::get('/praktikan-tertarik', [PraktikanController::class, 'getAssignedPraktikan'])->middleware(['auth:asisten', 'can:nilai-praktikan']);

    // set praktikan
    Route::patch('/set-password', [PraktikanController::class, 'setPassword'])->name('set-password')->middleware(['auth:asisten', 'can:set-praktikan']);
    // //////////////praktikan///////////////////////////////

    // polling
    Route::post('/pollings', [PollingsController::class, 'store'])->name('store.polling')->middleware(['auth:praktikan', 'can:isi-polling']);
    Route::get('/pollings/{id}', [PollingsController::class, 'show'])->name('show.polling')->middleware(['auth:praktikan', 'can:isi-polling']);
    Route::get('/pollings/{id}', [PollingsController::class, 'show'])->name('show.polling')->middleware(['auth:praktikan', 'can:isi-polling']);
    Route::get('/jenis-polling', [JenisPollingController::class, 'index'])->name('get.jenis.poling')->middleware(['auth:asisten,praktikan', 'permission:isi-polling|see-polling']);

    // Jawaban TA
    Route::post('/jawaban-ta', [JawabanTAController::class, 'store'])->name('store.jawaban.ta')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-ta/{idModul}', [JawabanTAController::class, 'show'])->name('show.jawaban.ta')->middleware(['auth:praktikan', 'can:lihat-modul']);
    Route::get('/nilai-ta/{praktikanId}/{modulId}', [JawabanTAController::class, 'score'])->name('praktikan.nilai.ta')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban TK
    Route::post('/jawaban-tk', [JawabanTKController::class, 'store'])->name('store.jawaban.tk')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-tk/{idModul}', [JawabanTKController::class, 'show'])->name('show.jawaban.tk')->middleware(['auth:praktikan', 'can:lihat-modul']);
    Route::get('/nilai-tk/{praktikanId}/{modulId}', [JawabanTKController::class, 'score'])->name('praktikan.nilai.tk')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban TM
    Route::post('/jawaban-tm', [JawabanTMController::class, 'store'])->name('store.jawaban.tm')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-tm/{idModul}', [JawabanTMController::class, 'show'])->name('show.jawaban.tm')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban Fitb
    Route::post('/jawaban-fitb', [JawabanFITBController::class, 'store'])->name('store.jawaban.fitb')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-fitb/{idModul}', [JawabanFITBController::class, 'show'])->name('show.jawaban.fitb')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban Jurnal
    Route::post('/jawaban-jurnal', [JawabanJurnalController::class, 'store'])->name('store.jawaban.jurnal')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-jurnal/{idModul}', [JawabanJurnalController::class, 'show'])->name('show.jawaban.jurnal')->middleware(['auth:praktikan', 'can:lihat-modul']);

    // Jawaban Tugas Pendahuluan
    Route::post('/jawaban-tp', [JawabanTPController::class, 'store'])->name('store.jawaban.tugas-pendahuluan')->middleware(['auth:praktikan', 'can:praktikum-lms']);
    Route::get('/jawaban-tp/{idModul}', [JawabanTPController::class, 'show'])->name('show.jawaban.tp')->middleware(['auth:praktikan', 'can:lihat-modul']);
});

Route::fallback(function () {
    return redirect('/');
})->middleware('check.auth');

require __DIR__.'/auth.php';
