<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\SujetoProcesadoController;


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

Route::get('/login', [LoginController::class, 'index'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [LoginController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| Página principal
|--------------------------------------------------------------------------
*/

Route::get('/', [FichajeController::class, 'index'])
    ->name('fichaje.index');

Route::post('/fichar', [FichajeController::class, 'fichar'])
    ->name('fichaje.fichar');

/*
|--------------------------------------------------------------------------
| Sujetos Procesados
|--------------------------------------------------------------------------
*/

Route::resource(
    'sujetos-procesados',
    SujetoProcesadoController::class
);