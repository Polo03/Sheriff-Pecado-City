<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PeasController extends Controller
{
    private function archivo(): string
    {
        return 'peas.json';
    }

    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        return view('peas', [
            'peas' => $this->leerPeas(),
            'esDirectiva' => $this->esDirectiva($usuarioId),
        ]);
    }

    public function edit(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        return view('editar_peas', [
            'peas' => $this->leerPeas(),
        ]);
    }

    public function update(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless($this->esDirectiva($usuarioId), 403);

        $datos = $request->validate([
            'titulo' => ['required', 'array', 'size:4'],
            'titulo.*' => ['required', 'string', 'max:100'],

            'descripcion' => ['required', 'array', 'size:4'],
            'descripcion.*' => ['required', 'string'],
        ]);

        $peas = [];

        foreach ($datos['titulo'] as $indice => $titulo) {
            $peas[] = [
                'titulo' => trim($titulo),
                'descripcion' => trim($datos['descripcion'][$indice]),
            ];
        }

        Storage::put(
            $this->archivo(),
            json_encode(
                $peas,
                JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
            )
        );

        return redirect()
            ->route('peas.index')
            ->with('mensaje', 'Los PEAS se han actualizado correctamente.');
    }

    private function leerPeas(): array
    {
        if (!Storage::exists($this->archivo())) {

            $peas = [

                [
                    'titulo' => 'PEAS 4',
                    'descripcion' => '/sheriffmsg Atención ciudadanos, el norte se encuentra en PEAS 4 debido a un evento de emergencia. Se les pide a todos los ciudadanos que se abstengan de cometer cualquier tipo de delito, ya que las fuerzas de seguridad no están disponibles para garantizar el orden público y la seguridad de todos. Cualquier infracción será sancionada con severidad. Por favor, colaboren con las autoridades. Gracias por su comprensión y cooperación.',
                ],

                [
                    'titulo' => 'PEAS 3',
                    'descripcion' => '/sheriffmsg Atención ciudadanos, el norte está en PEAS 3. Esto significa que la situación es crítica y hay un alto riesgo de atentados o disturbios. Les ordenamos que se queden en sus casas y que no salgan bajo ningún concepto. Cierren las puertas y las ventanas y no abran a nadie. Si escuchan disparos o explosiones, aléjense de las fuentes de sonido y protéjanse. La policía tiene plena autoridad para detener y registrar a cualquier persona o vehículo que no se mantenga en su casa estamos trabajando para restablecer el orden. Gracias por su colaboración.',
                ],

                [
                    'titulo' => 'PEAS 2',
                    'descripcion' => '/sheriffmsg Atención ciudadanos, el norte está en PEAS 2. Esto significa que han aumentado los crímenes y la violencia en las calles. Les recomendamos que eviten salir de noche y que no se acerquen a zonas peligrosas. Si ven algo sospechoso, avisen inmediatamente a la policía. Mantengan la calma y sigan las indicaciones de los agentes. Gracias por su colaboración.',
                ],

                [
                    'titulo' => 'PEAS 1',
                    'descripcion' => '/sheriffmsg Atención ciudadanos, el norte está en PEAS 1. Esto significa que la situación es tranquila y pueden circular con normalidad. Sin embargo, recuerden tomar las precauciones necesarias para evitar ser víctimas de la delincuencia. Respeten las normas de tráfico y cooperen con las autoridades. Gracias por su colaboración.',
                ],

            ];

            Storage::put(
                $this->archivo(),
                json_encode(
                    $peas,
                    JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
                )
            );

            return $peas;
        }

        $contenido = Storage::get($this->archivo());

        $peas = json_decode($contenido, true);

        return is_array($peas) ? $peas : [];
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