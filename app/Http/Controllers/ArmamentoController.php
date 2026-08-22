<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ArmamentoController extends Controller
{
    public function index(Request $request, bool $puedeRegistrar = false)
    {
        $usuarioId = $this->usuarioId($request);

        $busqueda = trim((string) $request->input('q'));
        $agenteSesion = DB::table('agentes')->where('id', $usuarioId)->first(['placa']);

        $armas = DB::table('armamento')
            ->leftJoin('agentes', 'agentes.placa', '=', 'armamento.placa')
            ->when($puedeRegistrar, function ($query) use ($agenteSesion) {
                $query->where('armamento.placa', $agenteSesion->placa ?? '');
            })
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($filtro) use ($busqueda) {
                    $filtro->where('agentes.nombre', 'like', '%' . $busqueda . '%')
                        ->orWhere('armamento.placa', 'like', '%' . $busqueda . '%')
                        ->orWhere('armamento.numero_serie', 'like', '%' . $busqueda . '%');
                });
            })
            ->select(
                'armamento.id',
                'armamento.tipo_arma',
                'armamento.numero_serie',
                'armamento.placa',
                'armamento.fecha_registro',
                'agentes.nombre as agente_nombre'
            )
            ->orderByDesc('armamento.id')
            ->get();

        return view('armamento', compact('armas', 'busqueda', 'puedeRegistrar'));
    }

    public function store(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        $datos = $request->validate([
            'tipo_arma' => ['required', 'in:Pistola reglamentaria,Taser'],
            'numero_serie' => ['required', 'string', 'max:45'],
        ]);

        $agente = DB::table('agentes')->where('id', $usuarioId)->first(['placa']);
        abort_unless($agente && filled($agente->placa), 422, 'El agente de la sesión no tiene una placa asignada.');

        DB::table('armamento')->insert([
            'tipo_arma' => $datos['tipo_arma'],
            'numero_serie' => $datos['numero_serie'],
            'placa' => $agente->placa,
            'fecha_registro' => now()->toDateTimeString(),
        ]);

        return redirect()->route('registrar-armamento.index')->with('mensaje', 'Armamento registrado correctamente.');
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
