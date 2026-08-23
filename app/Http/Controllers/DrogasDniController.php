<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DrogasDniController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        $esDirectiva = $this->esDirectiva($usuarioId);

        $busqueda = trim(
            (string) $request->input('q')
        );


        $drogas = DB::table('drogas_dni')
            ->leftJoin(
                'agentes',
                'agentes.id',
                '=',
                'drogas_dni.agente'
            )

            ->when(
                $busqueda !== '',
                function ($query) use ($busqueda) {

                    $query->where(
                        function ($filtro) use ($busqueda) {

                            $filtro
                                ->where(
                                    'agentes.nombre',
                                    'like',
                                    '%' . $busqueda . '%'
                                )

                                ->orWhere(
                                    'drogas_dni.placa',
                                    'like',
                                    '%' . $busqueda . '%'
                                )

                                ->orWhere(
                                    'drogas_dni.cantidad',
                                    'like',
                                    '%' . $busqueda . '%'
                                );
                        }
                    );
                }
            )

            ->select(
                'drogas_dni.id',
                'drogas_dni.agente',
                'drogas_dni.placa',
                'drogas_dni.cantidad',
                'drogas_dni.foto_dni',
                'drogas_dni.foto_sospechoso',
                'drogas_dni.fecha_registro',
                'agentes.nombre as agente_nombre'
            )

            ->orderByDesc(
                'drogas_dni.id'
            )

            ->get();


        return view(
            'drogas_dni',
            [
                'drogas' => $drogas,

                'busqueda' => $busqueda,

                'esDirectiva' => $esDirectiva,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $usuarioId = $this->usuarioId($request);

        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        return view(
            'crear_droga_dni'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
{
    $usuarioId = $this->usuarioId($request);

    abort_unless(
        $this->esDirectiva($usuarioId),
        403
    );


    /*
    |----------------------------------------------------------------------
    | VALIDACIÓN
    |----------------------------------------------------------------------
    */

    $datos = $request->validate([

        'cantidad' => [
            'required',
            'string',
            'max:255',
        ],

        'foto_dni' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:10240',
        ],

        'foto_sospechoso' => [
            'required',
            'image',
            'mimes:jpg,jpeg,png,webp',
            'max:10240',
        ],

    ]);


    /*
    |----------------------------------------------------------------------
    | OBTENER AGENTE LOGUEADO
    |----------------------------------------------------------------------
    */

    $agente = DB::table('agentes')
        ->where('id', $usuarioId)
        ->first([
            'id',
            'nombre',
            'placa',
        ]);


    abort_unless(
        $agente,
        403
    );


    /*
    |----------------------------------------------------------------------
    | GUARDAR FOTOS
    |----------------------------------------------------------------------
    */

    $fotoDni =
        $request
            ->file('foto_dni')
            ->store(
                'drogas_dni',
                'public'
            );


    $fotoSospechoso =
        $request
            ->file('foto_sospechoso')
            ->store(
                'drogas_dni',
                'public'
            );


    /*
    |----------------------------------------------------------------------
    | INSERTAR REGISTRO
    |----------------------------------------------------------------------
    */

    DB::table('drogas_dni')->insert([

        /*
        Agente que está logueado
        */

        'agente' => $agente->id,


        /*
        Placa del agente logueado
        */

        'placa' => $agente->placa,


        /*
        Datos del formulario
        */

        'cantidad' => $datos['cantidad'],


        /*
        Fotos
        */

        'foto_dni' => $fotoDni,

        'foto_sospechoso' => $fotoSospechoso,


        /*
        Fecha
        */

        'fecha_registro' => now(),

    ]);


    return redirect()
        ->route('drogas-dni.index');
}


    /*
    |--------------------------------------------------------------------------
    | VER
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        int $droga
    ) {
        $this->usuarioId($request);


        $registro = DB::table('drogas_dni')
            ->leftJoin(
                'agentes',
                'agentes.id',
                '=',
                'drogas_dni.agente'
            )

            ->select(
                'drogas_dni.*',
                'agentes.nombre as agente_nombre'
            )

            ->where(
                'drogas_dni.id',
                $droga
            )

            ->first();


        abort_unless(
            $registro,
            404
        );


        return view(
            'ver_droga_dni',
            [
                'droga' => $registro,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit(
        Request $request,
        int $droga
    ) {
        $usuarioId = $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $registro = DB::table('drogas_dni')
            ->where(
                'id',
                $droga
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        return view(
            'editar_droga_dni',
            [
                'droga' => $registro,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        int $droga
    ) {
        $usuarioId = $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $registro = DB::table('drogas_dni')
            ->where(
                'id',
                $droga
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        $datos = $request->validate([

            'placa' => [
                'required',
                'string',
                'max:45',
            ],

            'cantidad' => [
                'required',
                'string',
                'max:100',
            ],

            'foto_dni' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'foto_sospechoso' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

        ]);


        $actualizaciones = [

            'placa' =>
                $datos['placa'],

            'cantidad' =>
                $datos['cantidad'],

        ];


        /*
        |--------------------------------------------------------------------------
        | NUEVA FOTO DNI
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'foto_dni'
            )
        ) {

            Storage::disk('public')
                ->delete(
                    $registro->foto_dni
                );


            $actualizaciones['foto_dni'] =
                $request
                    ->file('foto_dni')
                    ->store(
                        'drogas_dni',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | NUEVA FOTO SOSPECHOSO
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile(
                'foto_sospechoso'
            )
        ) {

            Storage::disk('public')
                ->delete(
                    $registro->foto_sospechoso
                );


            $actualizaciones['foto_sospechoso'] =
                $request
                    ->file('foto_sospechoso')
                    ->store(
                        'drogas_dni',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR
        |--------------------------------------------------------------------------
        */

        DB::table('drogas_dni')
            ->where(
                'id',
                $droga
            )
            ->update(
                $actualizaciones
            );


        return redirect()
            ->route(
                'drogas-dni.index'
            )
            ->with(
                'mensaje',
                'Registro actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        int $droga
    ) {
        $usuarioId = $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $registro = DB::table('drogas_dni')
            ->where(
                'id',
                $droga
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        /*
        Borrar foto DNI
        */

        if (
            $registro->foto_dni
        ) {

            Storage::disk('public')
                ->delete(
                    $registro->foto_dni
                );
        }


        /*
        Borrar foto sospechoso
        */

        if (
            $registro->foto_sospechoso
        ) {

            Storage::disk('public')
                ->delete(
                    $registro->foto_sospechoso
                );
        }


        /*
        Borrar registro
        */

        DB::table('drogas_dni')
            ->where(
                'id',
                $droga
            )
            ->delete();


        return redirect()
            ->route(
                'drogas-dni.index'
            )
            ->with(
                'mensaje',
                'Registro eliminado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DIRECTIVA
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
}