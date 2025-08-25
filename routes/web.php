<?php

use Illuminate\Support\Facades\Route;

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
