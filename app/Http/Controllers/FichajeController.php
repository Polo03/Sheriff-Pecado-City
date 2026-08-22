<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichajeController extends Controller
{
    public function menuPrincipal(Request $request)
    {
        return view('inicio', [
            'nombre' => $request->session()->get('nombre', 'visitante'),
        ]);
    }

    public function index(Request $request)
{
    if (!$request->session()->has('usuario_id')) {
        return redirect()->route('login');
    }

    $agente = $request->session()->get('usuario_id');
    $usuario = $request->session()->get('usuario');
    $nombre = $request->session()->get('nombre');

    $fichajeActivo = DB::table('fichaje')
        ->where('agente', $agente)
        ->where('salida', 'Sigue fichando')
        ->first();

    $esDirectiva = DB::table('agentes')
        ->join('rangos', 'rangos.rango', '=', 'agentes.rango')
        ->where('agentes.id', $agente)
        ->where('rangos.escala', 'Directiva')
        ->exists();

    $fichasMenu = DB::table('fichas_agentes')
        ->join('agentes', 'agentes.id', '=', 'fichas_agentes.agente_id')
        ->where(function ($query) use ($agente, $esDirectiva) {
            $query->where('fichas_agentes.agente_id', $agente);

            if ($esDirectiva) {
                $query->orWhereNotNull('fichas_agentes.id');
            }
        })
        ->select('fichas_agentes.id', 'fichas_agentes.placa', 'agentes.nombre')
        ->orderBy('agentes.nombre')
        ->get();

    return view('menu_principal', compact(
        'fichajeActivo',
        'agente',
        'usuario',
        'nombre',
        'fichasMenu'
    ));
}


    public function fichar(Request $request)
    {
        // Comprobar que hay un usuario conectado
        if (!$request->session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        // Obtener automáticamente el ID del agente conectado
        $agente = $request->session()->get('usuario_id');

        // Buscar si ya tiene un fichaje abierto
        $fichajeActivo = DB::table('fichaje')
            ->where('agente', $agente)
            ->where('salida', 'Sigue fichando')
            ->first();

        if ($fichajeActivo) {

            // Ya estaba fichando.
            // Cerramos el mismo registro.
            DB::table('fichaje')
                ->where('id', $fichajeActivo->id)
                ->update([
                    'salida' => now(),
                ]);

        } else {

            // No estaba fichando.
            // Creamos un nuevo registro.
            DB::table('fichaje')->insert([
                'agente' => $agente,
                'entrada' => now(),
                'salida' => 'Sigue fichando',
            ]);

        }

        return redirect()
            ->route('fichaje.index');

    }
}