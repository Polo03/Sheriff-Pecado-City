<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FichaAgenteController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO DE AGENTES
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        /*
        |--------------------------------------------------------------------------
        | AGENTES
        |--------------------------------------------------------------------------
        */

        $agentes = DB::table('agentes')

            ->leftJoin(
                'rangos',
                'rangos.rango',
                '=',
                'agentes.rango'
            )

            ->orderByDesc(
                'rangos.id'
            )

            ->orderBy(
                'agentes.nombre'
            )

            ->get([
                'agentes.id',
                'agentes.nombre',
                'agentes.usuario',
                'agentes.rango',
                'agentes.placa',
            ]);


        /*
        |--------------------------------------------------------------------------
        | RANGOS GENERALES
        |--------------------------------------------------------------------------
        */

        $rangos = DB::table('rangos')

            ->orderByDesc(
                'id'
            )

            ->get([
                'id',
                'rango',
                'escala',
            ]);


        /*
        |--------------------------------------------------------------------------
        | FICHAS
        |--------------------------------------------------------------------------
        */

        $fichas = DB::table('fichas_agentes')

            ->join(
                'agentes',
                'agentes.id',
                '=',
                'fichas_agentes.agente_id'
            )

            ->leftJoin(
                'rangos',
                'rangos.rango',
                '=',
                'agentes.rango'
            )

            ->select(
                'fichas_agentes.id',
                'fichas_agentes.agente_id',
                'agentes.placa',
                'agentes.nombre',
                'agentes.usuario',
                'agentes.rango',
                'rangos.escala'
            )

            ->orderBy(
                'agentes.nombre'
            )

            ->get();


        /*
        |--------------------------------------------------------------------------
        | DIVISIONES DE CADA AGENTE
        |--------------------------------------------------------------------------
        */

        $divisionesAgentes =
            DB::table('agentes_divisiones')

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
                    'agentes_divisiones.estado',
                    'activo'
                )

                ->select(
                    'agentes_divisiones.agente',
                    'agentes_divisiones.division',
                    'agentes_divisiones.rango_division',
                    'divisiones.nombre as division_nombre',
                    'rangos_divisiones.nombre as rango_nombre'
                )

                ->orderBy(
                    'divisiones.nombre'
                )

                ->get()
                ->groupBy('agente');


        /*
        |--------------------------------------------------------------------------
        | TODAS LAS DIVISIONES
        |--------------------------------------------------------------------------
        */

        $divisiones = DB::table('divisiones')

            ->orderBy(
                'nombre'
            )

            ->get([
                'id',
                'nombre',
            ]);


        /*
        |--------------------------------------------------------------------------
        | RANGOS DE DIVISIONES
        |--------------------------------------------------------------------------
        */

        $rangosDivisiones =
            DB::table('rangos_divisiones')

                ->orderBy(
                    'division_id'
                )

                ->orderBy(
                    'id'
                )

                ->get([
                    'id',
                    'division_id',
                    'nombre',
                ])

                ->groupBy('division_id');


        return view(
            'gestion_agentes',
            compact(
                'agentes',
                'fichas',
                'rangos',
                'divisiones',
                'rangosDivisiones',
                'divisionesAgentes'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAR DE ALTA
    |--------------------------------------------------------------------------
    */

    public function alta(Request $request)
    {
        $usuarioId =
            $this->usuarioId($request);

        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $datos = $request->validate([

            'nombre' => [
                'required',
                'string',
                'max:45',
            ],

            'placa' => [
                'required',
                'string',
                'max:45',
            ],

            'rango_id' => [
                'required',
                'integer',
                'exists:rangos,id',
            ],

        ]);


        $rango = DB::table('rangos')

            ->where(
                'id',
                $datos['rango_id']
            )

            ->first([
                'id',
                'rango',
            ]);


        $escala =
            $this->escalaPorRango(
                $rango->rango
            );


        abort_unless(
            $escala,
            422,
            'El rango seleccionado no tiene una escala configurada.'
        );


        DB::transaction(
            function () use (
                $datos,
                $usuarioId,
                $rango,
                $escala
            ) {

                DB::table('rangos')

                    ->where(
                        'id',
                        $rango->id
                    )

                    ->update([
                        'escala' =>
                            $escala,
                    ]);


                $agenteId =
                    DB::table('agentes')
                        ->insertGetId([

                            'nombre' =>
                                $datos['nombre'],

                            'placa' =>
                                $datos['placa'],

                            'rango' =>
                                $rango->rango,

                        ]);


                DB::table('fichas_agentes')
                    ->insert([

                        'agente_id' =>
                            $agenteId,

                        'creada_por' =>
                            $usuarioId,

                        'placa' =>
                            $datos['placa'],

                        'created_at' =>
                            now(),

                        'updated_at' =>
                            now(),

                    ]);
            }
        );


        return redirect()

            ->route(
                'gestion-agentes.index'
            )

            ->with(
                'mensaje',
                'Agente dado de alta correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR AGENTE
    |--------------------------------------------------------------------------
    */

    public function edit(
        Request $request,
        int $agente
    ) {
        $usuarioId =
            $this->usuarioId($request);

        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        /*
        Agente
        */

        $agenteRegistro =
            DB::table('agentes')

                ->where(
                    'id',
                    $agente
                )

                ->first();


        abort_unless(
            $agenteRegistro,
            404
        );


        /*
        Rangos generales
        */

        $rangos =
            DB::table('rangos')

                ->orderByDesc(
                    'id'
                )

                ->get([
                    'id',
                    'rango',
                    'escala',
                ]);


        /*
        Todas las divisiones
        */

        $divisiones =
            DB::table('divisiones')

                ->orderBy(
                    'nombre'
                )

                ->get([
                    'id',
                    'nombre',
                ]);


        /*
        Rangos de cada división
        */

        $rangosDivisiones =
            DB::table('rangos_divisiones')

                ->orderBy(
                    'division_id'
                )

                ->orderBy(
                    'id'
                )

                ->get([
                    'id',
                    'division_id',
                    'nombre',
                ])

                ->groupBy(
                    'division_id'
                );


        /*
        Divisiones actuales del agente
        */

        $divisionesAgente =
            DB::table('agentes_divisiones')

                ->where(
                    'agente',
                    $agente
                )

                ->where(
                    'estado',
                    'activo'
                )

                ->get([
                    'id',
                    'division',
                    'rango_division',
                    'estado',
                ]);


        return view(
            'editar_agente',
            compact(
                'agenteRegistro',
                'rangos',
                'divisiones',
                'rangosDivisiones',
                'divisionesAgente'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR AGENTE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $agente
    ) {
        $usuarioId =
            $this->usuarioId($request);

        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        /*
        Validación principal
        */

        $datos =
            $request->validate([

                'nombre' => [
                    'required',
                    'string',
                    'max:45',
                ],

                'placa' => [
                    'required',
                    'string',
                    'max:45',
                ],

                'rango_id' => [
                    'required',
                    'integer',
                    'exists:rangos,id',
                ],

                'usuario' => [
                    'required',
                    'string',
                    'max:45',
                ],

                'contraseña' => [
                    'required',
                    'string',
                    'max:45',
                ],

                'divisiones' => [
                    'nullable',
                    'array',
                ],

                'divisiones.*.division' => [
                    'required',
                    'integer',
                    'exists:divisiones,id',
                ],

                'divisiones.*.rango_division' => [
                    'nullable',
                    'integer',
                ],

            ]);


        /*
        Comprobar agente
        */

        $agenteRegistro =
            DB::table('agentes')

                ->where(
                    'id',
                    $agente
                )

                ->first();


        abort_unless(
            $agenteRegistro,
            404
        );


        /*
        Rango general
        */

        $rango =
            DB::table('rangos')

                ->where(
                    'id',
                    $datos['rango_id']
                )

                ->first([
                    'id',
                    'rango',
                ]);


        $escala =
            $this->escalaPorRango(
                $rango->rango
            );


        abort_unless(
            $escala,
            422,
            'El rango seleccionado no tiene una escala configurada.'
        );


        /*
        Divisiones seleccionadas
        */

        $divisionesSeleccionadas =
            $datos['divisiones'] ?? [];


        /*
        Evitar divisiones repetidas
        */

        $divisionesProcesadas = [];


        foreach (
            $divisionesSeleccionadas
            as $divisionData
        ) {

            $divisionId =
                (int)
                $divisionData['division'];


            /*
            No permitir repetir
            la misma división
            */

            if (
                in_array(
                    $divisionId,
                    $divisionesProcesadas,
                    true
                )
            ) {

                continue;
            }


            $divisionesProcesadas[] =
                $divisionId;


            /*
            Rango de división
            */

            $rangoDivision =
                $divisionData['rango_division']
                ?? null;


            /*
            Si no se ha elegido rango,
            usamos 0 porque la columna
            actualmente no permite NULL.
            */

            if (
                $rangoDivision === null
                ||
                $rangoDivision === ''
            ) {

                $rangoDivision = 0;

            } else {

                $rangoDivision =
                    (int)
                    $rangoDivision;


                /*
                Comprobar que el rango
                pertenece a esa división
                */

                $rangoValido =
                    DB::table(
                        'rangos_divisiones'
                    )

                    ->where(
                        'id',
                        $rangoDivision
                    )

                    ->where(
                        'division_id',
                        $divisionId
                    )

                    ->exists();


                abort_unless(
                    $rangoValido,
                    422,
                    'El rango seleccionado no pertenece a la división.'
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | GUARDAR TODO
        |--------------------------------------------------------------------------
        */

        DB::transaction(
            function () use (
                $datos,
                $agente,
                $rango,
                $escala,
                $divisionesProcesadas,
                $divisionesSeleccionadas
            ) {

                /*
                Rango general
                */

                DB::table('rangos')

                    ->where(
                        'id',
                        $rango->id
                    )

                    ->update([
                        'escala' =>
                            $escala,
                    ]);


                /*
                Datos del agente
                */

                DB::table('agentes')

                    ->where(
                        'id',
                        $agente
                    )

                    ->update([

                        'nombre' =>
                            $datos['nombre'],

                        'placa' =>
                            $datos['placa'],

                        'rango' =>
                            $rango->rango,

                        'usuario' =>
                            $datos['usuario'],

                        'contraseña' =>
                            $datos['contraseña'],

                    ]);


                /*
                Actualizar ficha
                */

                DB::table('fichas_agentes')

                    ->where(
                        'agente_id',
                        $agente
                    )

                    ->update([

                        'placa' =>
                            $datos['placa'],

                        'updated_at' =>
                            now(),

                    ]);


                /*
                Eliminar solamente
                las pertenencias activas
                */

                DB::table('agentes_divisiones')

                    ->where(
                        'agente',
                        $agente
                    )

                    ->where(
                        'estado',
                        'activo'
                    )

                    ->delete();


                /*
                Crear nuevamente
                las divisiones seleccionadas
                */

                foreach (
                    $divisionesSeleccionadas
                    as $divisionData
                ) {

                    $divisionId =
                        (int)
                        $divisionData['division'];


                    /*
                    Evitar duplicados
                    */

                    if (
                        !in_array(
                            $divisionId,
                            $divisionesProcesadas,
                            true
                        )
                    ) {

                        continue;
                    }


                    /*
                    Marcar como procesada
                    para no repetir
                    */

                    $divisionesProcesadas =
                        array_values(
                            $divisionesProcesadas
                        );


                    $indice =
                        array_search(
                            $divisionId,
                            $divisionesProcesadas,
                            true
                        );


                    if (
                        $indice === false
                    ) {

                        continue;
                    }


                    /*
                    Buscar rango
                    */

                    $rangoDivision =
                        $divisionData['rango_division']
                        ?? null;


                    if (
                        $rangoDivision === null
                        ||
                        $rangoDivision === ''
                    ) {

                        $rangoDivision = 0;

                    } else {

                        $rangoDivision =
                            (int)
                            $rangoDivision;
                    }


                    /*
                    Insertar pertenencia
                    */

                    $yaInsertado = DB::table(
                        'agentes_divisiones'
                    )

                        ->where(
                            'agente',
                            $agente
                        )

                        ->where(
                            'division',
                            $divisionId
                        )

                        ->where(
                            'estado',
                            'activo'
                        )

                        ->exists();


                    if (!$yaInsertado) {

                        DB::table(
                            'agentes_divisiones'
                        )->insert([

                            'agente' =>
                                $agente,

                            'division' =>
                                $divisionId,

                            'rango_division' =>
                                $rangoDivision,

                            'estado' =>
                                'activo',

                        ]);
                    }

                }

            }
        );


        return redirect()

            ->route(
                'gestion-agentes.index'
            )

            ->with(
                'mensaje',
                'Agente actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | MOSTRAR FICHA
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        int $ficha
    ) {
        $usuarioId =
            $this->usuarioId($request);


        $registro =
            DB::table('fichas_agentes')

                ->join(
                    'agentes',
                    'agentes.id',
                    '=',
                    'fichas_agentes.agente_id'
                )

                ->leftJoin(
                    'rangos',
                    'rangos.rango',
                    '=',
                    'agentes.rango'
                )

                ->where(
                    'fichas_agentes.id',
                    $ficha
                )

                ->select(
                    'fichas_agentes.*',
                    'agentes.nombre',
                    'agentes.usuario',
                    'agentes.rango',
                    'agentes.placa as placa_actual',
                    'rangos.escala'
                )

                ->first();


        abort_unless(
            $registro,
            404
        );


        $esDirectiva =
            $this->esDirectiva(
                $usuarioId
            );


        abort_unless(
            $esDirectiva
            ||
            $registro->agente_id === $usuarioId,
            403
        );


        $fichasMenu =
            DB::table('fichas_agentes')

                ->join(
                    'agentes',
                    'agentes.id',
                    '=',
                    'fichas_agentes.agente_id'
                )

                ->where(
                    function ($query) use (
                        $usuarioId,
                        $esDirectiva
                    ) {

                        $query->where(
                            'fichas_agentes.agente_id',
                            $usuarioId
                        );


                        if ($esDirectiva) {

                            $query->orWhereNotNull(
                                'fichas_agentes.id'
                            );

                        }

                    }
                )

                ->select(
                    'fichas_agentes.id',
                    'fichas_agentes.placa',
                    'agentes.nombre'
                )

                ->orderBy(
                    'agentes.nombre'
                )

                ->get();


        $mensajes =
            DB::table('mensajes')

                ->join(
                    'agentes',
                    'agentes.id',
                    '=',
                    'mensajes.emisor_id'
                )

                ->where(
                    function ($query) use (
                        $registro
                    ) {

                        $query->where(
                            function ($pair) use (
                                $registro
                            ) {

                                $pair

                                    ->where(
                                        'mensajes.emisor_id',
                                        $registro->agente_id
                                    )

                                    ->where(
                                        'mensajes.receptor_id',
                                        $registro->creada_por
                                    );

                            }
                        )

                        ->orWhere(
                            function ($pair) use (
                                $registro
                            ) {

                                $pair

                                    ->where(
                                        'mensajes.emisor_id',
                                        $registro->creada_por
                                    )

                                    ->where(
                                        'mensajes.receptor_id',
                                        $registro->agente_id
                                    );

                            }
                        );

                    }
                )

                ->select(
                    'mensajes.mensaje',
                    'mensajes.created_at',
                    'mensajes.emisor_id',
                    'agentes.nombre as emisor_nombre'
                )

                ->orderBy(
                    'mensajes.created_at'
                )

                ->get();


        return view(
            'ficha_agente',
            [
                'ficha' =>
                    $registro,

                'mensajes' =>
                    $mensajes,

                'fichasMenu' =>
                    $fichasMenu,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | DAR DE BAJA
    |--------------------------------------------------------------------------
    */

    public function baja(
        Request $request,
        int $agente
    ) {
        $usuarioId =
            $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $existe =
            DB::table('agentes')

                ->where(
                    'id',
                    $agente
                )

                ->exists();


        abort_unless(
            $existe,
            404
        );


        DB::transaction(
            function () use ($agente) {

                DB::table('agentes_divisiones')
                    ->where(
                        'agente',
                        $agente
                    )
                    ->delete();


                DB::table('fichas_agentes')
                    ->where(
                        'agente_id',
                        $agente
                    )
                    ->delete();


                DB::table('agentes')
                    ->where(
                        'id',
                        $agente
                    )
                    ->delete();

            }
        );


        return redirect()

            ->route(
                'gestion-agentes.index'
            )

            ->with(
                'mensaje',
                'Agente dado de baja correctamente.'
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

        abort_unless(
            $request
                ->session()
                ->has('usuario_id'),
            401
        );


        return (int)
            $request
                ->session()
                ->get('usuario_id');
    }


    /*
    |--------------------------------------------------------------------------
    | COMPROBAR DIRECTIVA
    |--------------------------------------------------------------------------
    */

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


    /*
    |--------------------------------------------------------------------------
    | ESCALA SEGÚN RANGO
    |--------------------------------------------------------------------------
    */

    private function escalaPorRango(
        string $rango
    ): ?string {

        return [

            'sheriff en practicas' =>
                'Academia',

            'sheriff en prácticas' =>
                'Academia',

            'patrulla jr' =>
                'Basica',

            'patrulla' =>
                'Basica',

            'patrulla sr' =>
                'Basica',

            'cabo i' =>
                'Basica',

            'cabo ii' =>
                'Basica',

            'cabo iii' =>
                'Basica',

            'sargento i' =>
                'Superior',

            'sargento ii' =>
                'Superior',

            'teniente' =>
                'Superior',

            'capitan' =>
                'Jefatura',

            'coronel' =>
                'Jefatura',

            'subcomisario' =>
                'Directiva',

            'comisario' =>
                'Directiva',

            'sheriff' =>
                'Directiva',

        ][
            mb_strtolower(
                trim($rango)
            )
        ]
        ?? null;
    }
}