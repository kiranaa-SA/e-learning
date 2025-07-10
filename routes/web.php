<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MapelController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\TugasController;
use App\Http\Controllers\MateriController;
use App\Http\Controllers\KelasController;

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
    return view('welcome');
});
Route::resource('guru', GuruController::class);
Route::resource('siswa', SiswaController::class);
Route::resource('mapel', MapelController::class);
Route::resource('quiz', QuizController::class);
Route::resource('tugas', TugasController::class);
Route::resource('materi', MateriController::class);
Route::resource('kelas', KelasController::class);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
