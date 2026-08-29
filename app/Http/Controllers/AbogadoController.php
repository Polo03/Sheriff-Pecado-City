<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AbogadoController extends Controller
{
    private function archivo(): string
    {
        return 'abogados.json';
    }

    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        $abogados = $this->leerAbogados();

        return view('abogados', [
            'abogados' => $abogados,
            'esDirectiva' => $this->esDirectiva($usuarioId),
        ]);
    }

    public function edit(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        return view('editar_abogados', [
            'abogados' => $this->leerAbogados(),
        ]);
    }

    public function update(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'nombre' => ['required', 'array'],
            'nombre.*' => ['required', 'string', 'max:255'],

            'contacto' => ['nullable', 'array'],
            'contacto.*' => ['nullable', 'string', 'max:100'],

            'oficio' => ['nullable', 'array'],
        ]);

        $abogados = [];

        foreach ($datos['nombre'] as $i => $nombre) {
            $abogados[] = [
                'nombre' => trim($nombre),
                'contacto' => trim($datos['contacto'][$i] ?? ''),
                'oficio' => isset($datos['oficio'][$i]),
            ];
        }

        Storage::put(
            $this->archivo(),
            json_encode(
                $abogados,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );

        return redirect()
            ->route('abogados.index')
            ->with('mensaje', 'El tablón de abogados se ha actualizado correctamente.');
    }

    private function leerAbogados(): array
    {
        if (!Storage::exists($this->archivo())) {
            $abogados = [
                [
                    'nombre' => 'Ernesto Fonseca',
                    'contacto' => '',
                    'oficio' => false,
                ],
                [
                    'nombre' => 'Daniel Cortes',
                    'contacto' => '',
                    'oficio' => false,
                ],
                [
                    'nombre' => 'Brittany Scott',
                    'contacto' => '',
                    'oficio' => false,
                ],
                [
                    'nombre' => 'Fary Navajas',
                    'contacto' => '',
                    'oficio' => false,
                ],
                [
                    'nombre' => 'Layla Cabral',
                    'contacto' => '(602)758-3453',
                    'oficio' => true,
                ],
                [
                    'nombre' => 'Marcos Rosi',
                    'contacto' => '(602)501-1978',
                    'oficio' => true,
                ],
                [
                    'nombre' => 'Marc Solis',
                    'contacto' => '',
                    'oficio' => false,
                ],
                [
                    'nombre' => 'Anna Hübner Grey',
                    'contacto' => '(602)696-8753',
                    'oficio' => true,
                ],
                [
                    'nombre' => 'Thomas Cooper',
                    'contacto' => '(205)241-0653',
                    'oficio' => true,
                ],
                [
                    'nombre' => 'Haizea Hernández',
                    'contacto' => '(907)365-8147',
                    'oficio' => true,
                ],
            ];

            Storage::put(
                $this->archivo(),
                json_encode(
                    $abogados,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            return $abogados;
        }

        $contenido = Storage::get($this->archivo());

        $abogados = json_decode($contenido, true);

        return is_array($abogados) ? $abogados : [];
    }

    private function esDirectiva(int $usuarioId): bool
    {
        return \DB::table('agentes')
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