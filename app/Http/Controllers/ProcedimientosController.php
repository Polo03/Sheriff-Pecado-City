<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProcedimientosController extends Controller
{
    private function archivo(): string
    {
        return 'procedimientos.json';
    }

    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        return view('procedimientos', [
            'procedimientos' => $this->leerProcedimientos(),
            'esDirectiva' => $this->esDirectiva($usuarioId),
        ]);
    }

    public function create(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        return view('crear_procedimiento');
    }

    public function store(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'contenido' => ['required', 'string'],
        ]);

        $procedimientos = $this->leerProcedimientos();

        $procedimientos[] = [
            'id' => $this->siguienteId($procedimientos),
            'titulo' => trim($datos['titulo']),
            'contenido' => trim($datos['contenido']),
            'fecha' => now()->format('d/m/Y H:i'),
        ];

        $this->guardarProcedimientos($procedimientos);

        return redirect()
            ->route('procedimientos.index')
            ->with('mensaje', 'El procedimiento se ha publicado correctamente.');
    }

    public function edit(Request $request, int $id)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $procedimientos = $this->leerProcedimientos();

        $procedimiento = collect($procedimientos)
            ->firstWhere('id', $id);

        abort_unless($procedimiento, 404);

        return view('editar_procedimiento', [
            'procedimiento' => $procedimiento,
        ]);
    }

    public function update(Request $request, int $id)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'titulo' => ['required', 'string', 'max:150'],
            'contenido' => ['required', 'string'],
        ]);

        $procedimientos = $this->leerProcedimientos();

        $encontrado = false;

        foreach ($procedimientos as &$procedimiento) {

            if ((int) $procedimiento['id'] === $id) {

                $procedimiento['titulo'] = trim($datos['titulo']);
                $procedimiento['contenido'] = trim($datos['contenido']);
                $procedimiento['fecha'] = now()->format('d/m/Y H:i');

                $encontrado = true;

                break;
            }
        }

        unset($procedimiento);

        abort_unless($encontrado, 404);

        $this->guardarProcedimientos($procedimientos);

        return redirect()
            ->route('procedimientos.index')
            ->with('mensaje', 'El procedimiento se ha actualizado correctamente.');
    }

    public function destroy(Request $request, int $id)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $procedimientos = $this->leerProcedimientos();

        $procedimientos = array_values(
            array_filter(
                $procedimientos,
                fn ($procedimiento) => (int) $procedimiento['id'] !== $id
            )
        );

        $this->guardarProcedimientos($procedimientos);

        return redirect()
            ->route('procedimientos.index')
            ->with('mensaje', 'El procedimiento se ha eliminado correctamente.');
    }

    private function leerProcedimientos(): array
    {
        if (!Storage::exists($this->archivo())) {
            Storage::put(
                $this->archivo(),
                json_encode(
                    [],
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            return [];
        }

        $contenido = Storage::get($this->archivo());

        $procedimientos = json_decode($contenido, true);

        return is_array($procedimientos)
            ? $procedimientos
            : [];
    }

    private function guardarProcedimientos(array $procedimientos): void
    {
        Storage::put(
            $this->archivo(),
            json_encode(
                $procedimientos,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );
    }

    private function siguienteId(array $procedimientos): int
    {
        if (empty($procedimientos)) {
            return 1;
        }

        return max(
            array_map(
                fn ($procedimiento) => (int) $procedimiento['id'],
                $procedimientos
            )
        ) + 1;
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
            abort(401);
        }

        return (int) $request->session()->get('usuario_id');
    }
}