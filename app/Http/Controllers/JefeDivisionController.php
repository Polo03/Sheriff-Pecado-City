<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JefeDivisionController extends Controller
{
    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        $divisiones = DB::table('divisiones')
            ->leftJoin(
                'agentes as jefe',
                'jefe.id',
                '=',
                'divisiones.jefe_id'
            )
            ->leftJoin(
                'agentes as subjefe',
                'subjefe.id',
                '=',
                'divisiones.subjefe_id'
            )
            ->whereIn('divisiones.nombre', [
                'Marshall',
                'Trooper',
                'Aeronautica',
                'Entrevistador',
                'Instruccion',
                'Bani',
            ])
            ->select(
                'divisiones.id',
                'divisiones.nombre',
                'divisiones.jefe_id',
                'divisiones.subjefe_id',

                'jefe.nombre as jefe_nombre',
                'jefe.placa as jefe_placa',

                'subjefe.nombre as subjefe_nombre',
                'subjefe.placa as subjefe_placa'
            )
            ->orderBy('divisiones.id')
            ->get();

        return view('jefes_divisiones', [
            'divisiones' => $divisiones,
            'esDirectiva' => $this->esDirectiva($usuarioId),
        ]);
    }


    public function edit(Request $request, int $division)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $divisionData = DB::table('divisiones')
            ->where('id', $division)
            ->first();

        abort_unless($divisionData, 404);

        $agentes = DB::table('agentes')
            ->select(
                'id',
                'nombre',
                'placa',
                'rango'
            )
            ->orderBy('nombre')
            ->get();

        return view('editar_jefe_division', [
            'division' => $divisionData,
            'agentes' => $agentes,
        ]);
    }


    public function update(Request $request, int $division)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'jefe_id' => [
                'nullable',
                'integer',
                'exists:agentes,id',
            ],

            'subjefe_id' => [
                'nullable',
                'integer',
                'exists:agentes,id',
            ],
        ]);

        $divisionExiste = DB::table('divisiones')
            ->where('id', $division)
            ->exists();

        abort_unless($divisionExiste, 404);

        DB::table('divisiones')
            ->where('id', $division)
            ->update([
                'jefe_id' => $datos['jefe_id'] ?? null,
                'subjefe_id' => $datos['subjefe_id'] ?? null,
            ]);

        return redirect()
            ->route('jefes-divisiones.index')
            ->with(
                'mensaje',
                'Los responsables de la división se han actualizado correctamente.'
            );
    }


    private function esDirectiva(int $usuarioId): bool
    {
        return DB::table('agentes')
            ->join(
                'rangos',
                'rangos.rango',
                '=',
                'agentes.rango'
            )
            ->where('agentes.id', $usuarioId)
            ->where('rangos.escala', 'Directiva')
            ->exists();
    }


    private function usuarioId(Request $request): int
    {
        if (!$request->session()->has('usuario_id')) {
            return (int) abort(401);
        }

        return (int) $request->session()->get('usuario_id');
    }
}