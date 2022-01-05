<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\DataWebController;
use App\Http\Controllers\CekJaroController;
use App\Http\Controllers\JaroWinklerController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StopwordController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TaghtmlController;
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

// Route Halaman Cek Similarity
Route::get('/', [CekJaroController::class, 'input']);
// Route::get('/about', [AboutController::class, 'about']);

//Route
Route::post('/hasil-similarity', [CekJaroController::class, 'getHtml']);

//Route Proses Input Form (Url/text/file)
// Route::get('/cek-plagiarism', [CekJaroController::class, 'input']);

//Route::post('/jaroWinkler', [JaroWinklerController::class, 'jaro']);
// Route::post('/result-plagiarism', [JaroWinklerController::class, 'prosesJaro']);

// Route::get('/admin', [LoginController::class, 'index'])->name('login')->middleware('guest');
// Route::post('/admin', [LoginController::class, 'authenticate']);
// Route::post('/logout', [LoginController::class, 'logout']);

// Route::get('/web', [DatawebController::class, 'index']);
// Route::post('/web', [DatawebController::class, 'store']);

// Route::get('/dashboard/stopword', [StopwordController::class, 'index'])->middleware('auth');
// Route::post('/dashboard/stopword', [StopwordController::class, 'store'])->middleware('auth');
// Route::get('/dashboard/stopword/{id}', [StopwordController::class, 'delete_single_data'])->middleware('auth');
// Route::put('/dashboard/stopword/{id}', [StopwordController::class, 'update'])->middleware('auth');

// Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
// Route::get('/dashboard/addweb', [TaghtmlController::class, 'index'])->middleware('auth');
// Route::post('/dashboard/addweb', [TaghtmlController::class, 'store'])->middleware('auth');
// Route::get('/dashboard/addweb/{id}', [TaghtmlController::class, 'delete_single_data'])->middleware('auth');
// Route::put('/dashboard/addweb/{id}', [TaghtmlController::class, 'update'])->middleware('auth');
