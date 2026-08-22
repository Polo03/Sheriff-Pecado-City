<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FichaAgenteController;
use App\Http\Controllers\SujetoProcesadoController;
use App\Http\Controllers\RangoController;


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

Route::get('/', [FichajeController::class, 'menuPrincipal'])
    ->name('menu.principal');

Route::get('/fichaje', [FichajeController::class, 'index'])
    ->name('fichaje.index');

Route::post('/fichar', [FichajeController::class, 'fichar'])
    ->name('fichaje.fichar');

Route::get('/fichaje/chat', [ChatController::class, 'index'])
    ->name('fichaje.chat');

Route::post('/fichaje/chat/{ficha}', [ChatController::class, 'store'])
    ->name('fichaje.chat.store');

Route::get('/gestion-agentes', [FichaAgenteController::class, 'index'])
    ->name('gestion-agentes.index');

Route::post('/gestion-agentes/alta', [FichaAgenteController::class, 'alta'])
    ->name('gestion-agentes.alta');

Route::get('/gestion-agentes/{agente}/editar', [FichaAgenteController::class, 'edit'])
    ->name('gestion-agentes.edit');

Route::put('/gestion-agentes/{agente}', [FichaAgenteController::class, 'update'])
    ->name('gestion-agentes.update');

Route::delete('/gestion-agentes/baja/{agente}', [FichaAgenteController::class, 'baja'])
    ->name('gestion-agentes.baja');

Route::get('/fichas-agentes/{ficha}', [FichaAgenteController::class, 'show'])
    ->name('fichas-agentes.show');

/*
|--------------------------------------------------------------------------
| Sujetos Procesados
|--------------------------------------------------------------------------
*/

Route::resource(
    'sujetos-procesados',
    SujetoProcesadoController::class
);

Route::get('/rangos', [RangoController::class, 'index'])
    ->name('rangos.index');

Route::post('/rangos/select', [RangoController::class, 'select'])
    ->name('rangos.select');

Route::post('/rangos/insert', [RangoController::class, 'insert'])
    ->name('rangos.insert');

Route::post('/rangos/update', [RangoController::class, 'update'])
    ->name('rangos.update');

Route::post('/rangos/delete', [RangoController::class, 'delete'])
    ->name('rangos.delete');

Route::fallback(function () {
    return redirect()->route('menu.principal');
});