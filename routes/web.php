<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\Admin\SurveyController as AdminSurveyController;

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
    return view('beranda');
});

Route::get('/beranda', function () {
    return view('beranda');
});

Route::get('/profil', function () {
    return view('profil');
});

Route::get('/profil-pejabat', function () {
    return view('profil-pejabat');
});

Route::get('/visi-misi', function () {
    return view('visi-misi');
});

Route::get('/tugas-fungsi', function () {
    return view('tugas-fungsi');
});

Route::get('/struktur-organisasi', function () {
    return view('struktur-organisasi');
});

Route::get('/pegawai', [App\Http\Controllers\PegawaiController::class, 'index'])->name('pegawai.index');

// Agenda Routes
Route::prefix('agenda')->name('agenda.')->group(function () {
    Route::get('/', [AgendaController::class, 'index'])->name('index');
    Route::get('/{agenda}', [AgendaController::class, 'show'])->name('show');
});

// Survey Routes
Route::prefix('survey')->name('survey.')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('index');
    Route::post('/', [SurveyController::class, 'store'])->name('store');
    Route::get('/success', [SurveyController::class, 'success'])->name('success');
    Route::get('/results', [SurveyController::class, 'results'])->name('results');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');


// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', function () {
        return redirect()->route('admin.dashboard');
    });
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');

    // Survey Management
    Route::prefix('surveys')->name('surveys.')->group(function () {
        Route::get('/', [AdminSurveyController::class, 'index'])->name('index');
        Route::get('/{survey}', [AdminSurveyController::class, 'show'])->name('show');
        Route::delete('/{survey}', [AdminSurveyController::class, 'destroy'])->name('destroy');
    });

    // Pegawai Management
    Route::prefix('pegawai')->name('pegawai.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\PegawaiController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\PegawaiController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\PegawaiController::class, 'store'])->name('store');
        Route::get('/{pegawai}', [App\Http\Controllers\Admin\PegawaiController::class, 'show'])->name('show');
        Route::get('/{pegawai}/edit', [App\Http\Controllers\Admin\PegawaiController::class, 'edit'])->name('edit');
        Route::put('/{pegawai}', [App\Http\Controllers\Admin\PegawaiController::class, 'update'])->name('update');
        Route::delete('/{pegawai}', [App\Http\Controllers\Admin\PegawaiController::class, 'destroy'])->name('destroy');
    });

    // Agenda Management
    Route::prefix('agenda')->name('agenda.')->group(function () {
        Route::get('/', [App\Http\Controllers\Admin\AgendaController::class, 'index'])->name('index');
        Route::get('/create', [App\Http\Controllers\Admin\AgendaController::class, 'create'])->name('create');
        Route::post('/', [App\Http\Controllers\Admin\AgendaController::class, 'store'])->name('store');
        Route::get('/{agenda}', [App\Http\Controllers\Admin\AgendaController::class, 'show'])->name('show');
        Route::get('/{agenda}/edit', [App\Http\Controllers\Admin\AgendaController::class, 'edit'])->name('edit');
        Route::put('/{agenda}', [App\Http\Controllers\Admin\AgendaController::class, 'update'])->name('update');
        Route::delete('/{agenda}', [App\Http\Controllers\Admin\AgendaController::class, 'destroy'])->name('destroy');
    });
});

// Public Pegawai Routes
Route::prefix('pegawai')->name('pegawai.')->group(function () {
    Route::get('/{pegawai}', [App\Http\Controllers\PegawaiController::class, 'show'])->name('show');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
