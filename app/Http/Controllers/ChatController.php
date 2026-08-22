<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        $this->usuarioId($request);

        return redirect()->route('fichaje.index');
    }

    public function store(Request $request, int $ficha)
    {
        $usuarioId = $this->usuarioId($request);

        $registro = DB::table('fichas_agentes')->where('id', $ficha)->first();
        abort_unless($registro, 404);
        $esDirectiva = $this->esDirectiva($usuarioId);
        abort_unless($esDirectiva || $registro->agente_id === $usuarioId, 403);

        $receptorId = $esDirectiva ? $registro->agente_id : $registro->creada_por;

        $datos = $request->validate([
            'mensaje' => ['required', 'string', 'max:2000'],
        ]);

        DB::table('mensajes')->insert([
            'emisor_id' => $usuarioId,
            'receptor_id' => $receptorId,
            'mensaje' => $datos['mensaje'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('fichas-agentes.show', $ficha);
    }

    private function usuarioId(Request $request): int
    {
        abort_unless($request->session()->has('usuario_id'), 401);

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

}
