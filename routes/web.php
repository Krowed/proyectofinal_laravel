<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrdenesController;
use App\Http\Controllers\ProductoController;

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



Route::get('/'                                  , [LoginController::class   , 'index'])->name('login');
Route::post('/iniciarsesion'                    , [LoginController::class   , 'iniciarsesion'])->name('iniciarsesion');
Route::get('/cerrarsesion'                      , [LoginController::class    , 'cerrarsesion'])->name('cerrarsesion');
Route::get('/home'                              , [HomeController::class    , 'index'])->name('home');


Route::get('/ordenes'                           , [OrdenesController::class , 'index'])->name('ordenes');
Route::get('/nuevaorden'                        , [OrdenesController::class , 'nuevaorden'])->name('nuevaorden');


Route::get('/productos'                         , [ProductoController::class , 'index'])->name('productos');
Route::get('/getProductos'                      , [ProductoController::class , 'getProductos'])->name('getProductos');
Route::get('/nuevoproducto'                     , [ProductoController::class , 'nuevoproducto'])->name('nuevoproducto');
Route::get('/editarproducto/{idproducto}'       , [ProductoController::class , 'editarproducto'])->name('editarproducto');
Route::post('/agregarproducto'                  , [ProductoController::class , 'agregarproducto'])->name('agregarproducto');
Route::post('/storeproducto'                    , [ProductoController::class , 'storeproducto'])->name('storeproducto');
Route::post('/eliminarproducto'                 , [ProductoController::class , 'eliminarproducto'])->name('eliminarproducto');

Route::post('/buscarproducto'                   , [ProductoController::class , 'buscarproducto'])->name('buscarproducto');

Route::post('/agregardetalle'                   , [ProductoController::class , 'agregardetalle'])->name('agregardetalle');