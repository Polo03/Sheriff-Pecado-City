<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FichajeController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FichaAgenteController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\ComunicacionController;
use App\Http\Controllers\ArmamentoController;
use App\Http\Controllers\MosqueteLocalController;
use App\Http\Controllers\MatriculaSospechosaController;
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

Route::get('/anuncios', [AnuncioController::class, 'index'])
    ->name('anuncios.index');

Route::post('/anuncios', [AnuncioController::class, 'store'])
    ->name('anuncios.store');

Route::delete(
    '/anuncios/{anuncio}',
    [AnuncioController::class, 'destroy']
)->name('anuncios.destroy');

Route::get('/briefing', [AnuncioController::class, 'index'])
    ->defaults('tipo', 'briefing')
    ->name('briefing.index');

Route::post('/briefing', [AnuncioController::class, 'store'])
    ->defaults('tipo', 'briefing')
    ->name('briefing.store');

Route::delete('/briefing/{anuncio}', [AnuncioController::class, 'destroy'])
    ->name('briefing.destroy');

Route::get('/mensajes-divisiones', [AnuncioController::class, 'index'])
    ->defaults('tipo', 'mensajes-divisiones')
    ->name('mensajes-divisiones.index');

Route::post('/mensajes-divisiones', [AnuncioController::class, 'store'])
    ->defaults('tipo', 'mensajes-divisiones')
    ->name('mensajes-divisiones.store');

Route::get('/busqueda-captura-activas', [AnuncioController::class, 'index'])
    ->defaults('tipo', 'busqueda-captura')
    ->name('busqueda-captura.index');

Route::post('/busqueda-captura-activas', [AnuncioController::class, 'store'])
    ->defaults('tipo', 'busqueda-captura')
    ->name('busqueda-captura.store');

Route::get('/mosquetes-locales', [MosqueteLocalController::class, 'index'])
    ->name('mosquetes-locales.index');

Route::post('/mosquetes-locales', [MosqueteLocalController::class, 'store'])
    ->name('mosquetes-locales.store');

Route::get('/mosquetes-locales/{mosquete}', [MosqueteLocalController::class, 'show'])
    ->name('mosquetes-locales.show');

Route::get('/mosquetes-locales/{mosquete}/editar', [MosqueteLocalController::class, 'edit'])
    ->name('mosquetes-locales.edit');

Route::get('/mosquetes-locales/{mosquete}/editar', [MosqueteLocalController::class, 'edit'])
    ->name('mosquetes-locales.edit');

Route::put('/mosquetes-locales/{mosquete}', [MosqueteLocalController::class, 'update'])
    ->name('mosquetes-locales.update');

Route::delete('/mosquetes-locales/{mosquete}', [MosqueteLocalController::class, 'destroy'])
    ->name('mosquetes-locales.destroy');

Route::get('/matriculas-sospechosas', [MatriculaSospechosaController::class, 'index'])
    ->name('matriculas-sospechosas.index');

Route::post('/matriculas-sospechosas', [MatriculaSospechosaController::class, 'store'])
    ->name('matriculas-sospechosas.store');

Route::get('/matriculas-sospechosas/{matricula}/editar', [MatriculaSospechosaController::class, 'edit'])
    ->name('matriculas-sospechosas.edit');

Route::put('/matriculas-sospechosas/{matricula}', [MatriculaSospechosaController::class, 'update'])
    ->name('matriculas-sospechosas.update');

Route::delete('/matriculas-sospechosas/{matricula}', [MatriculaSospechosaController::class, 'destroy'])
    ->name('matriculas-sospechosas.destroy');

Route::get(
    '/matriculas-sospechosas/{matricula}',
    [MatriculaSospechosaController::class, 'show']
    )->name('matriculas-sospechosas.show');

Route::get('/comunicaciones/{canal}', [ComunicacionController::class, 'show'])
    ->name('comunicaciones.show');

Route::post('/comunicaciones/{canal}', [ComunicacionController::class, 'store'])
    ->name('comunicaciones.store');

Route::get('/armamento', [ArmamentoController::class, 'index'])
    ->name('armamento.index');

Route::get('/registrar-armamento', [ArmamentoController::class, 'index'])
    ->defaults('puedeRegistrar', true)
    ->name('registrar-armamento.index');

Route::post('/registrar-armamento', [ArmamentoController::class, 'store'])
    ->name('registrar-armamento.store');

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

/*
|--------------------------------------------------------------------------
| Plantilla mensajes
|--------------------------------------------------------------------------
*/

Route::get(
    '/plantilla-mensajes',
    [AnuncioController::class, 'index']
)
    ->defaults('tipo', 'plantilla-mensajes')
    ->name('plantilla-mensajes.index');


Route::post(
    '/plantilla-mensajes',
    [AnuncioController::class, 'store']
)
    ->defaults('tipo', 'plantilla-mensajes')
    ->name('plantilla-mensajes.store');

Route::delete(
    '/plantilla-mensajes/{anuncio}',
    [AnuncioController::class, 'destroy']
)
    ->name('plantilla-mensajes.destroy');