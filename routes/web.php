<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('LandingPage');
})->name('landing');

Route::get('/contact', function () {
    return Inertia::render('PagesPraktikan/ContactPage');
})->name('contact');

Route::get('/about', function () {
    return Inertia::render('PagesPraktikan/AboutPage');
})->name('about');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::prefix('praktikan')->group(function () {
    Route::get('/', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});


// route for assiatant
Route::get('/assistant', function () {
    return Inertia::render('PagesAssistants/ProfileAssistant');
})->name('assistant');

Route::get('/ranking', function () {
    return Inertia::render('PagesAssistants/RankingPraktikan');
})->name('ranking');

Route::get('/polling', function () {
    return Inertia::render('PagesAssistants/PollingAssistant');
})->name('polling');

Route::get('/lihat-tp', function () {
    return Inertia::render('PagesAssistants/LihatTP');
})->name('lihat-tp');

Route::get('/jawaban-tp', function () {
    return Inertia::render('PagesAssistants/ResultLihatTP');
})->name('jawaban-tp');

Route::get('/list-laporan', function () {
    return Inertia::render('PagesAssistants/ResultLaporan');
})->name('list-laporan');

Route::get('/set-praktikan', function () {
    return Inertia::render('PagesAssistants/SetPraktikan');
})->name('set-praktikan');

Route::get('/pelanggaran', function () {
    return Inertia::render('PagesAssistants/PelanggaranAssistant');
})->name('pelanggaran');

Route::get('/history', function () {
    return Inertia::render('PagesAssistants/HistoryPraktikum');
})->name('history');

Route::get('/plottingan', function () {
    return Inertia::render('PagesAssistants/PlottingAssistant');
})->name('plottingan');

Route::get('/manage-role', function () {
    return Inertia::render('PagesAssistants/ManageRole');
})->name('manage-role');

Route::get('/nilai-praktikan', function () {
    return Inertia::render('PagesAssistants/NilaiPraktikan');
})->name('nilai-praktikan');

Route::get('/praktikum', function () {
    return Inertia::render('PagesAssistants/StartPraktikum');
})->name('praktikum');

Route::get('/module', function () {
    return Inertia::render('PagesAssistants/ModulePraktikum');
})->name('module');

Route::get('/soal', function () {
    return Inertia::render('PagesAssistants/SoalPraktikum');
})->name('soal');

require __DIR__.'/auth.php';