<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MatriculaSospechosaController extends Controller
{
    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);
        $esDirectiva = $this->esDirectiva($usuarioId);
        $busqueda = trim((string) $request->input('q'));

        $matriculas = DB::table('matriculas_sospechosas')
            ->leftJoin('agentes', 'agentes.id', '=', 'matriculas_sospechosas.agente')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($filtro) use ($busqueda) {
                    $filtro->where('agentes.nombre', 'like', '%' . $busqueda . '%')
                        ->orWhere('matriculas_sospechosas.placa', 'like', '%' . $busqueda . '%')
                        ->orWhere('matriculas_sospechosas.causa', 'like', '%' . $busqueda . '%');
                });
            })
            ->select(
                'matriculas_sospechosas.id',
                'matriculas_sospechosas.placa',
                'matriculas_sospechosas.foto_matricula',
                'matriculas_sospechosas.causa',
                'matriculas_sospechosas.fecha_registro',
                'agentes.nombre as agente_nombre'
            )
            ->orderByDesc('matriculas_sospechosas.id')
            ->get();

        return view('matriculas_sospechosas', compact('matriculas', 'busqueda', 'esDirectiva'));
    }

    public function store(Request $request)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'causa' => ['required', 'string', 'max:255'],
            'foto_matricula' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $agente = DB::table('agentes')->where('id', $usuarioId)->first(['id', 'placa']);
        abort_unless($agente, 403);

        $fotoMatricula = $request->file('foto_matricula')->store('matriculas_sospechosas', 'public');

        DB::table('matriculas_sospechosas')->insert([
            'agente' => (string) $agente->id,
            'placa' => $agente->placa,
            'foto_matricula' => $fotoMatricula,
            'causa' => $datos['causa'],
            'fecha_registro' => now(),
        ]);

        return redirect()->route('matriculas-sospechosas.index');
    }

    public function edit(Request $request, int $matricula)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);
        $registro = DB::table('matriculas_sospechosas')->where('id', $matricula)->first();
        abort_unless($registro, 404);
        return view('editar_matricula_sospechosa', ['matricula' => $registro]);
    }

    public function update(Request $request, int $matricula)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);
        $registro = DB::table('matriculas_sospechosas')->where('id', $matricula)->first();
        abort_unless($registro, 404);
        $datos = $request->validate([
            'causa' => ['required', 'string', 'max:255'],
            'foto_matricula' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);
        $actualizaciones = ['causa' => $datos['causa']];
        if ($request->hasFile('foto_matricula')) {
            Storage::disk('public')->delete($registro->foto_matricula);
            $actualizaciones['foto_matricula'] = $request->file('foto_matricula')->store('matriculas_sospechosas', 'public');
        }
        DB::table('matriculas_sospechosas')->where('id', $matricula)->update($actualizaciones);
        return redirect()->route('matriculas-sospechosas.index');
    }

    public function destroy(Request $request, int $matricula)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);
        $registro = DB::table('matriculas_sospechosas')->where('id', $matricula)->first();
        abort_unless($registro, 404);
        Storage::disk('public')->delete($registro->foto_matricula);
        DB::table('matriculas_sospechosas')->where('id', $matricula)->delete();
        return redirect()->back();
    }

    private function esDirectiva(int $usuarioId): bool
    {
        return DB::table('agentes')->join('rangos', 'rangos.rango', '=', 'agentes.rango')
            ->where('agentes.id', $usuarioId)->where('rangos.escala', 'Directiva')->exists();
    }

    private function usuarioId(Request $request): int
    {
        abort_unless($request->session()->has('usuario_id'), 401);

        return (int) $request->session()->get('usuario_id');
    }

}
