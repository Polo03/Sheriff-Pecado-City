<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MosqueteLocalController extends Controller
{
    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);
        $esDirectiva = $this->esDirectiva($usuarioId);
        $busqueda = trim((string) $request->input('q'));

        $mosquetes = DB::table('mosquetes_locales')
            ->leftJoin('agentes', 'agentes.id', '=', 'mosquetes_locales.agente')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where(function ($filtro) use ($busqueda) {
                    $filtro->where('mosquetes_locales.empresa', 'like', '%' . $busqueda . '%')
                        ->orWhere('mosquetes_locales.placa', 'like', '%' . $busqueda . '%')
                        ->orWhere('agentes.nombre', 'like', '%' . $busqueda . '%')
                        ->orWhere('mosquetes_locales.num_serie_mosquete', 'like', '%' . $busqueda . '%');
                });
            })
            ->select(
                'mosquetes_locales.id',
                'mosquetes_locales.empresa',
                'mosquetes_locales.placa',
                'mosquetes_locales.num_serie_mosquete',
                'mosquetes_locales.foto_dni',
                'mosquetes_locales.foto_licencia_armas',
                'mosquetes_locales.fecha_registro',
                'agentes.nombre as agente_nombre'
            )
            ->orderByDesc('mosquetes_locales.id')
            ->get();

        return view('mosquetes_locales', compact('mosquetes', 'busqueda', 'esDirectiva'));
    }

    public function store(Request $request)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'empresa' => ['required', 'string', 'max:45'],
            'num_serie_mosquete' => ['required', 'string', 'max:45'],
            'foto_dni' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'foto_licencia_armas' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);

        $agente = DB::table('agentes')->where('id', $usuarioId)->first(['id', 'placa']);
        abort_unless($agente, 403);

        $fotoDni = $request->file('foto_dni')->store('mosquetes_locales', 'public');
        $fotoLicencia = $request->file('foto_licencia_armas')->store('mosquetes_locales', 'public');

        DB::table('mosquetes_locales')->insert([
            'agente' => (string) $agente->id,
            'placa' => $agente->placa,
            'empresa' => $datos['empresa'],
            'num_serie_mosquete' => $datos['num_serie_mosquete'],
            'foto_dni' => $fotoDni,
            'foto_licencia_armas' => $fotoLicencia,
            'fecha_registro' => now(),
        ]);

        return redirect()->route('mosquetes-locales.index');
    }

    public function show(Request $request, int $mosquete)
    {
        $usuarioId = $this->usuarioId($request);

        $esDirectiva = $this->esDirectiva($usuarioId);

        $registro = DB::table('mosquetes_locales')
            ->leftJoin(
                'agentes',
                'agentes.id',
                '=',
                'mosquetes_locales.agente'
            )
            ->where('mosquetes_locales.id', $mosquete)
            ->select(
                'mosquetes_locales.*',
                'agentes.nombre as agente_nombre'
            )
            ->first();

        abort_unless($registro, 404);

        return view('ver_mosquete', [
            'mosquete' => $registro,
            'esDirectiva' => $esDirectiva,
        ]);
    }

    public function edit(Request $request, int $mosquete)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);
        $registro = DB::table('mosquetes_locales')->where('id', $mosquete)->first();
        abort_unless($registro, 404);

        return view('editar_mosquete', ['mosquete' => $registro]);
    }

    public function update(Request $request, int $mosquete)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);
        $registro = DB::table('mosquetes_locales')->where('id', $mosquete)->first();
        abort_unless($registro, 404);
        $datos = $request->validate([
            'empresa' => ['required', 'string', 'max:45'],
            'num_serie_mosquete' => ['required', 'string', 'max:45'],
            'foto_dni' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
            'foto_licencia_armas' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ]);
        $actualizaciones = ['empresa' => $datos['empresa'], 'num_serie_mosquete' => $datos['num_serie_mosquete']];
        foreach (['foto_dni', 'foto_licencia_armas'] as $campo) {
            if ($request->hasFile($campo)) {
                Storage::disk('public')->delete($registro->$campo);
                $actualizaciones[$campo] = $request->file($campo)->store('mosquetes_locales', 'public');
            }
        }
        DB::table('mosquetes_locales')->where('id', $mosquete)->update($actualizaciones);
        return redirect()->route('armamento.index');
    }

    public function destroy(Request $request, int $mosquete)
    {
        $usuarioId = $this->usuarioId($request);
        abort_unless($this->esDirectiva($usuarioId), 403);
        $registro = DB::table('mosquetes_locales')->where('id', $mosquete)->first();
        abort_unless($registro, 404);
        Storage::disk('public')->delete([$registro->foto_dni, $registro->foto_licencia_armas]);
        DB::table('mosquetes_locales')->where('id', $mosquete)->delete();
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
