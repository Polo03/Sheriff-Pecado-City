<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichaAgenteController extends Controller
{
    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $agentes = DB::table('agentes')
            ->leftJoin('rangos', 'rangos.rango', '=', 'agentes.rango')
            ->orderByDesc('rangos.id')
            ->orderBy('nombre')
            ->get(['agentes.id', 'agentes.nombre', 'agentes.usuario', 'agentes.rango', 'agentes.placa']);

        $rangos = DB::table('rangos')
            ->orderByDesc('id')
            ->get(['id', 'rango', 'escala']);

        $fichas = DB::table('fichas_agentes')
            ->join('agentes', 'agentes.id', '=', 'fichas_agentes.agente_id')
            ->leftJoin('rangos', 'rangos.rango', '=', 'agentes.rango')
            ->select('fichas_agentes.id', 'fichas_agentes.agente_id', 'agentes.placa', 'agentes.nombre', 'agentes.usuario', 'agentes.rango', 'rangos.escala')
            ->orderBy('agentes.nombre')
            ->get();

        return view('gestion_agentes', compact('agentes', 'fichas', 'rangos'));
    }

    public function alta(Request $request)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:45'],
            'placa' => ['required', 'string', 'max:45'],
            'rango_id' => ['required', 'integer', 'exists:rangos,id'],
        ]);

        $rango = DB::table('rangos')->where('id', $datos['rango_id'])->first(['id', 'rango']);
        $escalas = [
            'sheriff en practicas' => 'Academia',
            'sheriff en prácticas' => 'Academia',
            'patrulla jr' => 'Basica',
            'patrulla' => 'Basica',
            'patrulla sr' => 'Basica',
            'cabo i' => 'Basica',
            'cabo ii' => 'Basica',
            'cabo iii' => 'Basica',
            'sargento i' => 'Superior',
            'sargento ii' => 'Superior',
            'teniente' => 'Superior',
            'capitan' => 'Jefatura',
            'coronel' => 'Jefatura',
            'subcomisario' => 'Directiva',
            'comisario' => 'Directiva',
            'sheriff' => 'Directiva',
        ];
        $nombreRango = mb_strtolower(trim($rango->rango));
        abort_unless(isset($escalas[$nombreRango]), 422, 'El rango seleccionado no tiene una escala configurada.');

        DB::transaction(function () use ($datos, $usuarioId, $rango, $escalas, $nombreRango) {
            DB::table('rangos')->where('id', $rango->id)->update(['escala' => $escalas[$nombreRango]]);

            $agenteId = DB::table('agentes')->insertGetId([
                'nombre' => $datos['nombre'],
                'placa' => $datos['placa'],
                'rango' => $rango->rango,
            ]);

            DB::table('fichas_agentes')->insert([
                'agente_id' => $agenteId,
                'creada_por' => $usuarioId,
                'placa' => $datos['placa'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('gestion-agentes.index')->with('mensaje', 'Agente dado de alta correctamente.');
    }

    public function edit(Request $request, int $agente)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $agenteRegistro = DB::table('agentes')->where('id', $agente)->first();
        abort_unless($agenteRegistro, 404);

        $rangos = DB::table('rangos')->orderByDesc('id')->get(['id', 'rango', 'escala']);

        return view('editar_agente', compact('agenteRegistro', 'rangos'));
    }

    public function update(Request $request, int $agente)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:45'],
            'placa' => ['required', 'string', 'max:45'],
            'rango_id' => ['required', 'integer', 'exists:rangos,id'],
            'usuario' => ['required', 'string', 'max:45'],
            'contraseña' => ['required', 'string', 'max:45'],
        ]);

        $rango = DB::table('rangos')->where('id', $datos['rango_id'])->first(['id', 'rango']);
        $escala = $this->escalaPorRango($rango->rango);
        abort_unless($escala, 422, 'El rango seleccionado no tiene una escala configurada.');

        DB::transaction(function () use ($datos, $agente, $rango, $escala) {
            DB::table('rangos')->where('id', $rango->id)->update(['escala' => $escala]);
            DB::table('agentes')->where('id', $agente)->update([
                'nombre' => $datos['nombre'],
                'placa' => $datos['placa'],
                'rango' => $rango->rango,
                'usuario' => $datos['usuario'],
                'contraseña' => $datos['contraseña'],
            ]);
            DB::table('fichas_agentes')->where('agente_id', $agente)->update([
                'placa' => $datos['placa'],
                'updated_at' => now(),
            ]);
        });

        return redirect()->route('gestion-agentes.index')->with('mensaje', 'Agente actualizado correctamente.');
    }

    public function show(Request $request, int $ficha)
    {
        $usuarioId = $this->usuarioId($request);
        $registro = DB::table('fichas_agentes')
            ->join('agentes', 'agentes.id', '=', 'fichas_agentes.agente_id')
            ->leftJoin('rangos', 'rangos.rango', '=', 'agentes.rango')
            ->where('fichas_agentes.id', $ficha)
            ->select('fichas_agentes.*', 'agentes.nombre', 'agentes.usuario', 'agentes.rango', 'agentes.placa as placa_actual', 'rangos.escala')
            ->first();

        abort_unless($registro, 404);
        $esDirectiva = $this->esDirectiva($usuarioId);
        abort_unless($esDirectiva || $registro->agente_id === $usuarioId, 403);

        $fichasMenu = DB::table('fichas_agentes')
            ->join('agentes', 'agentes.id', '=', 'fichas_agentes.agente_id')
            ->where(function ($query) use ($usuarioId, $esDirectiva) {
                $query->where('fichas_agentes.agente_id', $usuarioId);

                if ($esDirectiva) {
                    $query->orWhereNotNull('fichas_agentes.id');
                }
            })
            ->select('fichas_agentes.id', 'fichas_agentes.placa', 'agentes.nombre')
            ->orderBy('agentes.nombre')
            ->get();

        $mensajes = DB::table('mensajes')
            ->join('agentes', 'agentes.id', '=', 'mensajes.emisor_id')
            ->where(function ($query) use ($registro) {
                $query->where(function ($pair) use ($registro) {
                    $pair->where('mensajes.emisor_id', $registro->agente_id)
                        ->where('mensajes.receptor_id', $registro->creada_por);
                })->orWhere(function ($pair) use ($registro) {
                    $pair->where('mensajes.emisor_id', $registro->creada_por)
                        ->where('mensajes.receptor_id', $registro->agente_id);
                });
            })
            ->select('mensajes.mensaje', 'mensajes.created_at', 'mensajes.emisor_id', 'agentes.nombre as emisor_nombre')
            ->orderBy('mensajes.created_at')
            ->get();

        return view('ficha_agente', [
            'ficha' => $registro,
            'mensajes' => $mensajes,
            'fichasMenu' => $fichasMenu,
        ]);
    }

    public function baja(Request $request, int $agente)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $existe = DB::table('agentes')->where('id', $agente)->exists();
        abort_unless($existe, 404);

        DB::transaction(function () use ($agente) {
            DB::table('fichas_agentes')->where('agente_id', $agente)->delete();
            DB::table('agentes')->where('id', $agente)->delete();
        });

        return redirect()->route('gestion-agentes.index')->with('mensaje', 'Agente dado de baja correctamente.');
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

    private function escalaPorRango(string $rango): ?string
    {
        return [
            'sheriff en practicas' => 'Academia',
            'sheriff en prácticas' => 'Academia',
            'patrulla jr' => 'Basica',
            'patrulla' => 'Basica',
            'patrulla sr' => 'Basica',
            'cabo i' => 'Basica',
            'cabo ii' => 'Basica',
            'cabo iii' => 'Basica',
            'sargento i' => 'Superior',
            'sargento ii' => 'Superior',
            'teniente' => 'Superior',
            'capitan' => 'Jefatura',
            'coronel' => 'Jefatura',
            'subcomisario' => 'Directiva',
            'comisario' => 'Directiva',
            'sheriff' => 'Directiva',
        ][mb_strtolower(trim($rango))] ?? null;
    }
}
