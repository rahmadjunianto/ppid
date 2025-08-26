<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\ArticleController;
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

// Survey Routes
Route::prefix('survey')->name('survey.')->group(function () {
    Route::get('/', [SurveyController::class, 'index'])->name('index');
    Route::post('/', [SurveyController::class, 'store'])->name('store');
    Route::get('/success', [SurveyController::class, 'success'])->name('success');
    Route::get('/results', [SurveyController::class, 'results'])->name('results');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Public Article Routes
Route::prefix('artikel')->name('articles.')->group(function () {
    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/kategori/{category:slug}', [ArticleController::class, 'category'])->name('category');
    Route::get('/jenis/{type}', [ArticleController::class, 'type'])->name('type');
    Route::get('/{article:slug}', [ArticleController::class, 'show'])->name('show');
});

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
        Route::get('/statistics', [AdminSurveyController::class, 'statistics'])->name('statistics');
        Route::get('/export', [AdminSurveyController::class, 'export'])->name('export');
        Route::get('/{survey}', [AdminSurveyController::class, 'show'])->name('show');
        Route::delete('/{survey}', [AdminSurveyController::class, 'destroy'])->name('destroy');
    });
});
