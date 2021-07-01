<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdenesController;

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

Route::get('/'              , [LoginController::class , 'index'])->name('login');
Route::get('/home'          , [HomeController::class , 'index'])->name('home');


Route::get('/ordenes'       , [OrdenesController::class , 'index'])->name('ordenes');
Route::get('/nuevaorden'    , [OrdenesController::class , 'nuevaorden'])->name('nuevaorden');