<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DivisionController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MENÚ DE DIVISIONES DEL AGENTE
    |--------------------------------------------------------------------------
    */

    public function menu(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        /*
        |--------------------------------------------------------------------------
        | DIVISIONES A LAS QUE PERTENECE
        |--------------------------------------------------------------------------
        */

        $divisiones = DB::table('agentes_divisiones')

            ->join(
                'divisiones',
                'divisiones.id',
                '=',
                'agentes_divisiones.division'
            )

            ->leftJoin(
                'rangos_divisiones',
                'rangos_divisiones.id',
                '=',
                'agentes_divisiones.rango_division'
            )

            ->where(
                'agentes_divisiones.agente',
                $usuarioId
            )

            ->where(
                'agentes_divisiones.estado',
                'activo'
            )

            ->select(
                'divisiones.id',
                'divisiones.nombre',
                'rangos_divisiones.nombre as rango_division'
            )

            ->orderBy(
                'divisiones.nombre'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | POSTULACIONES
        |--------------------------------------------------------------------------
        */

        $postulaciones = DB::table('agentes_divisiones')

            ->join(
                'divisiones',
                'divisiones.id',
                '=',
                'agentes_divisiones.division'
            )

            ->where(
                'agentes_divisiones.agente',
                $usuarioId
            )

            ->where(
                'agentes_divisiones.estado',
                'postulacion'
            )

            ->select(
                'agentes_divisiones.id',
                'agentes_divisiones.division',
                'divisiones.nombre'
            )

            ->orderBy(
                'divisiones.nombre'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | SI NO PERTENECE A NINGUNA DIVISIÓN
        |--------------------------------------------------------------------------
        */

        return view(
            'divisiones.menu',
            [
                'divisiones' =>
                    $divisiones,

                'postulaciones' =>
                    $postulaciones,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | INFORMACIÓN DE UNA DIVISIÓN
    |--------------------------------------------------------------------------
    */

    public function show(
    Request $request,
    int $division
) {
    $usuarioId = $this->usuarioId($request);


    /*
    |--------------------------------------------------------------------------
    | BUSCAR DIVISIÓN
    |--------------------------------------------------------------------------
    */

    $divisionData = DB::table('divisiones')
        ->where(
            'id',
            $division
        )
        ->first();


    abort_unless(
        $divisionData,
        404
    );


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR SI ES DIRECTIVA
    |--------------------------------------------------------------------------
    */

    $esDirectiva = $this->esDirectiva(
        $usuarioId
    );


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR SI ES JEFE O SUBJEFE
    |--------------------------------------------------------------------------
    */

    $esJefe = (
        (int) $divisionData->jefe_id ===
        (int) $usuarioId
    );


    $esSubjefe = (
        (int) $divisionData->subjefe_id ===
        (int) $usuarioId
    );


    /*
    |--------------------------------------------------------------------------
    | PUEDE VER POSTULACIONES
    |--------------------------------------------------------------------------
    */

    $puedeVerPostulaciones =
        $esDirectiva
        ||
        $esJefe
        ||
        $esSubjefe;


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR RELACIÓN DEL AGENTE
    |--------------------------------------------------------------------------
    |
    | Directiva puede entrar en cualquier división.
    |
    */

    $relacion = DB::table('agentes_divisiones')

        ->where(
            'agente',
            $usuarioId
        )

        ->where(
            'division',
            $division
        )

        ->whereIn(
            'estado',
            [
                'activo',
                'postulacion',
            ]
        )

        ->first();


    /*
    |--------------------------------------------------------------------------
    | SI NO ES DIRECTIVA Y NO PERTENECE
    |--------------------------------------------------------------------------
    */

    if (
        !$esDirectiva
        &&
        !$relacion
    ) {

        abort(403);
    }


    /*
    |--------------------------------------------------------------------------
    | RANGO DEL AGENTE EN LA DIVISIÓN
    |--------------------------------------------------------------------------
    */

    $rangoDivision = null;


    if (
        $relacion
        &&
        $relacion->estado === 'activo'
        &&
        $relacion->rango_division
    ) {

        $rangoDivision =
            DB::table('rangos_divisiones')

                ->where(
                    'id',
                    $relacion->rango_division
                )

                ->first();
    }


    /*
    |--------------------------------------------------------------------------
    | RANGOS DE LA DIVISIÓN
    |--------------------------------------------------------------------------
    */

    $rangos = DB::table('rangos_divisiones')

        ->where(
            'division_id',
            $division
        )

        ->orderBy(
            'id'
        )

        ->get();


    /*
    |--------------------------------------------------------------------------
    | AGENTES DE LA DIVISIÓN
    |--------------------------------------------------------------------------
    */

    $agentes = DB::table('agentes_divisiones')

        ->join(
            'agentes',
            'agentes.id',
            '=',
            'agentes_divisiones.agente'
        )

        ->leftJoin(
            'rangos_divisiones',
            'rangos_divisiones.id',
            '=',
            'agentes_divisiones.rango_division'
        )

        ->where(
            'agentes_divisiones.division',
            $division
        )

        ->where(
            'agentes_divisiones.estado',
            'activo'
        )

        ->select(
            'agentes.id',
            'agentes.nombre',
            'agentes.placa',
            'agentes.rango',
            'rangos_divisiones.nombre as rango_division'
        )

        ->orderBy(
            'agentes.nombre'
        )

        ->get();


    /*
    |--------------------------------------------------------------------------
    | POSTULACIONES
    |--------------------------------------------------------------------------
    |
    | Solamente cargamos esto si puede verlas.
    |
    */

    $postulaciones = collect();


    if ($puedeVerPostulaciones) {

        $postulaciones = DB::table(
            'agentes_divisiones'
        )

            ->join(
                'agentes',
                'agentes.id',
                '=',
                'agentes_divisiones.agente'
            )

            ->where(
                'agentes_divisiones.division',
                $division
            )

            ->where(
                'agentes_divisiones.estado',
                'postulacion'
            )

            ->select(
                'agentes_divisiones.id',
                'agentes_divisiones.agente',
                'agentes_divisiones.division',
                'agentes.nombre',
                'agentes.placa'
            )

            ->orderBy(
                'agentes.nombre'
            )

            ->get();
    }


    /*
    |--------------------------------------------------------------------------
    | DEVOLVER VISTA
    |--------------------------------------------------------------------------
    */

    return view(
        'divisiones.show',
        [
            'division' =>
                $divisionData,

            'relacion' =>
                $relacion,

            'rangoDivision' =>
                $rangoDivision,

            'rangos' =>
                $rangos,

            'agentes' =>
                $agentes,

            'postulaciones' =>
                $postulaciones,

            'esDirectiva' =>
                $esDirectiva,

            'esJefe' =>
                $esJefe,

            'esSubjefe' =>
                $esSubjefe,

            'puedeVerPostulaciones' =>
                $puedeVerPostulaciones,
        ]
    );
}


    /*
    |--------------------------------------------------------------------------
    | POSTULARSE A UNA DIVISIÓN
    |--------------------------------------------------------------------------
    */

    public function postular(
    Request $request,
    int $division
) {
    $usuarioId = $this->usuarioId($request);


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR QUE LA DIVISIÓN EXISTE
    |--------------------------------------------------------------------------
    */

    $divisionData = DB::table('divisiones')
        ->where(
            'id',
            $division
        )
        ->first();


    abort_unless(
        $divisionData,
        404
    );


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR SI YA PERTENECE
    |--------------------------------------------------------------------------
    */

    $yaPertenece = DB::table('agentes_divisiones')
        ->where(
            'agente',
            $usuarioId
        )
        ->where(
            'division',
            $division
        )
        ->where(
            'estado',
            'activo'
        )
        ->exists();


    if ($yaPertenece) {

        return back()->with(
            'error',
            'Ya perteneces a esta división.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR SI YA ESTÁ POSTULANDO
    |--------------------------------------------------------------------------
    */

    $yaPostula = DB::table('agentes_divisiones')
        ->where(
            'agente',
            $usuarioId
        )
        ->where(
            'division',
            $division
        )
        ->where(
            'estado',
            'postulacion'
        )
        ->exists();


    if ($yaPostula) {

        return back()->with(
            'error',
            'Ya tienes una postulación activa para esta división.'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR POSTULACIÓN
    |--------------------------------------------------------------------------
    |
    | Una postulación todavía no tiene rango,
    | por eso rango_division = NULL.
    |
    */

    DB::table('agentes_divisiones')
        ->insert([

            'agente' =>
                $usuarioId,

            'division' =>
                $division,

            'rango_division' =>
                null,

            'estado' =>
                'postulacion',

        ]);


    /*
    |--------------------------------------------------------------------------
    | VOLVER A LA PÁGINA
    |--------------------------------------------------------------------------
    */

    return back()->with(
        'mensaje',
        'Tu postulación para ' .
        $divisionData->nombre .
        ' se ha enviado correctamente.'
    );
}


    /*
    |--------------------------------------------------------------------------
    | USUARIO
    |--------------------------------------------------------------------------
    */

    private function usuarioId(
        Request $request
    ): int {

        if (
            !$request
                ->session()
                ->has('usuario_id')
        ) {

            abort(
                redirect()
                    ->route('login')
            );
        }


        return (int)
            $request
                ->session()
                ->get('usuario_id');
    }

    private function esDirectiva(
    int $usuarioId
): bool {

    return DB::table('agentes')

        ->join(
            'rangos',
            'rangos.rango',
            '=',
            'agentes.rango'
        )

        ->where(
            'agentes.id',
            $usuarioId
        )

        ->where(
            'rangos.escala',
            'Directiva'
        )

        ->exists();
}
}