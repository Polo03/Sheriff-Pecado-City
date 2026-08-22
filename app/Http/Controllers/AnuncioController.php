<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnuncioController extends Controller
{
    public function index(Request $request, string $tipo = 'anuncios')
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless(in_array($tipo, ['anuncios', 'briefing', 'mensajes-divisiones', 'busqueda-captura'], true), 404);

        $anuncios = DB::table('anuncios')
            ->join('agentes', 'agentes.id', '=', 'anuncios.agente_id')
            ->where('anuncios.tipo', $tipo)
            ->select('anuncios.contenido', 'anuncios.created_at', 'agentes.nombre as autor')
            ->orderByDesc('anuncios.created_at')
            ->get();

        return view('anuncios', [
            'anuncios' => $anuncios,
            'puedePublicar' => $this->puedePublicar($usuarioId, $tipo),
            'titulo' => match ($tipo) {
                'briefing' => 'Briefing',
                'mensajes-divisiones' => 'Mensajes-divisiones',
                'busqueda-captura' => 'Busqueda y captura activas',
                default => 'Anuncios',
            },
            'rutaPublicar' => $tipo,
        ]);
    }

    public function store(Request $request, string $tipo = 'anuncios')
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless(in_array($tipo, ['anuncios', 'briefing', 'mensajes-divisiones', 'busqueda-captura'], true), 404);
        abort_unless($this->puedePublicar($usuarioId, $tipo), 403);

        $datos = $request->validate([
            'contenido' => ['required', 'string', 'max:2000'],
        ]);

        DB::table('anuncios')->insert([
            'agente_id' => $usuarioId,
            'tipo' => $tipo,
            'contenido' => $datos['contenido'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route(match ($tipo) {
            'briefing' => 'briefing.index',
            'mensajes-divisiones' => 'mensajes-divisiones.index',
            'busqueda-captura' => 'busqueda-captura.index',
            default => 'anuncios.index',
        });
    }

    private function usuarioId(Request $request): int
    {
        if (!$request->session()->has('usuario_id')) {
            return redirect()->route('login');
        }

        return (int) $request->session()->get('usuario_id');
    }

    private function esDirectiva(int $usuarioId): bool
    {
        return DB::table('agentes')
            ->join('rangos', 'rangos.rango', '=', 'agentes.rango')
            ->where('agentes.id', $usuarioId)
            ->where('rangos.escala', 'Directiva')
            ->exists();
    }

    private function puedePublicar(int $usuarioId, string $tipo): bool
    {
        if ($tipo === 'mensajes-divisiones') {
            return DB::table('agentes')->where('id', $usuarioId)->exists();
        }

        if ($tipo === 'busqueda-captura') {
            return DB::table('agentes')
                ->leftJoin('rangos', 'rangos.rango', '=', 'agentes.rango')
                ->where('agentes.id', $usuarioId)
                ->where(function ($query) {
                    $query->where('agentes.rango', 'Fiscal')
                        ->orWhere('rangos.escala', 'Directiva');
                })
                ->exists();
        }

        return $this->esDirectiva($usuarioId);
    }
}
