<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ComunicacionController extends Controller
{
    public function show(Request $request, string $canal)
    {
        $usuarioId = $this->agenteId($request);
        abort_unless(in_array($canal, ['general-ic', 'general-ooc'], true), 404);

        $mensajes = DB::table('mensajes')
            ->join('agentes', 'agentes.id', '=', 'mensajes.emisor_id')
            ->where('mensajes.canal', $canal)
            ->whereNull('mensajes.receptor_id')
            ->select('mensajes.mensaje', 'mensajes.created_at', 'mensajes.emisor_id', 'agentes.nombre as emisor_nombre')
            ->orderBy('mensajes.created_at')
            ->get();

        return view('comunicacion', [
            'canal' => $canal,
            'titulo' => $canal === 'general-ic' ? 'General-IC' : 'General-OOC',
            'mensajes' => $mensajes,
            'usuarioId' => $usuarioId,
        ]);
    }

    public function store(Request $request, string $canal)
    {
        $usuarioId = $this->agenteId($request);
        abort_unless(in_array($canal, ['general-ic', 'general-ooc'], true), 404);

        $datos = $request->validate([
            'mensaje' => ['required', 'string', 'max:2000'],
        ]);

        DB::table('mensajes')->insert([
            'emisor_id' => $usuarioId,
            'receptor_id' => null,
            'canal' => $canal,
            'mensaje' => $datos['mensaje'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return redirect()->route('comunicaciones.show', $canal);
    }

    private function agenteId(Request $request): int
    {
        abort_unless($request->session()->has('usuario_id'), 401);

        $usuarioId = (int) $request->session()->get('usuario_id');
        abort_unless(DB::table('agentes')->where('id', $usuarioId)->exists(), 403);

        return $usuarioId;
    }
}
