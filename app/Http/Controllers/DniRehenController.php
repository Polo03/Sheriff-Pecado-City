<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DniRehenController extends Controller
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


        $rehenes = DB::table('dni_rehenes')
            ->leftJoin(
                'agentes',
                'agentes.id',
                '=',
                'dni_rehenes.agente'
            )
            ->select(
                'dni_rehenes.id',
                'dni_rehenes.agente',
                'dni_rehenes.placa',
                'dni_rehenes.causa',
                'dni_rehenes.foto_rehen',
                'dni_rehenes.fecha_registro',
                'agentes.nombre as agente_nombre'
            )
            ->orderByDesc(
                'dni_rehenes.id'
            )
            ->get();


        return view(
            'dni_rehenes',
            [
                'rehenes' => $rehenes,
                'esDirectiva' => $esDirectiva,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREAR
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
        |--------------------------------------------------------------------------
        | VALIDACIÓN
        |--------------------------------------------------------------------------
        */

        $datos = $request->validate([

            'causa' => [
                'required',
                'string',
                'max:45',
            ],

            'foto_rehen' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | OBTENER AGENTE LOGUEADO
        |--------------------------------------------------------------------------
        */

        $agente = DB::table('agentes')
            ->where(
                'id',
                $usuarioId
            )
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
        |--------------------------------------------------------------------------
        | GUARDAR FOTO
        |--------------------------------------------------------------------------
        */

        $fotoRehen =
            $request
                ->file('foto_rehen')
                ->store(
                    'dni_rehenes',
                    'public'
                );


        /*
        |--------------------------------------------------------------------------
        | GUARDAR EN MYSQL
        |--------------------------------------------------------------------------
        */

        DB::table('dni_rehenes')->insert([

            'agente' => (string) $agente->id,

            'placa' => $agente->placa,

            'causa' => $datos['causa'],

            'foto_rehen' => $fotoRehen,

            'fecha_registro' => now(),

        ]);


        return redirect()
            ->route(
                'dni-rehenes.index'
            )
            ->with(
                'mensaje',
                'DNI de rehén registrado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VER
    |--------------------------------------------------------------------------
    */

    public function show(
        Request $request,
        int $rehen
    ) {
        $this->usuarioId($request);


        $registro = DB::table('dni_rehenes')
            ->leftJoin(
                'agentes',
                'agentes.id',
                '=',
                'dni_rehenes.agente'
            )
            ->select(
                'dni_rehenes.*',
                'agentes.nombre as agente_nombre'
            )
            ->where(
                'dni_rehenes.id',
                $rehen
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        return view(
            'ver_dni_rehen',
            [
                'rehen' => $registro,
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
        int $rehen
    ) {
        $usuarioId = $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $registro = DB::table('dni_rehenes')
            ->where(
                'id',
                $rehen
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        return view(
            'editar_dni_rehen',
            [
                'rehen' => $registro,
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
        int $rehen
    ) {
        $usuarioId = $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $registro = DB::table('dni_rehenes')
            ->where(
                'id',
                $rehen
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN
        |--------------------------------------------------------------------------
        */

        $datos = $request->validate([

            'causa' => [
                'required',
                'string',
                'max:45',
            ],

            'foto_rehen' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

        ]);


        $actualizaciones = [

            'causa' => $datos['causa'],

        ];


        /*
        |--------------------------------------------------------------------------
        | NUEVA FOTO
        |--------------------------------------------------------------------------
        */

        if (
            $request->hasFile('foto_rehen') &&
            $request
                ->file('foto_rehen')
                ->isValid()
        ) {


            /*
            Borrar foto anterior
            */

            if ($registro->foto_rehen) {

                Storage::disk('public')
                    ->delete(
                        $registro->foto_rehen
                    );
            }


            /*
            Guardar nueva foto
            */

            $actualizaciones['foto_rehen'] =
                $request
                    ->file('foto_rehen')
                    ->store(
                        'dni_rehenes',
                        'public'
                    );
        }


        /*
        |--------------------------------------------------------------------------
        | ACTUALIZAR MYSQL
        |--------------------------------------------------------------------------
        */

        DB::table('dni_rehenes')
            ->where(
                'id',
                $rehen
            )
            ->update(
                $actualizaciones
            );


        return redirect()
            ->route(
                'dni-rehenes.show',
                $rehen
            )
            ->with(
                'mensaje',
                'DNI de rehén actualizado correctamente.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        int $rehen
    ) {
        $usuarioId = $this->usuarioId($request);


        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        $registro = DB::table('dni_rehenes')
            ->where(
                'id',
                $rehen
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        /*
        Borrar foto
        */

        if ($registro->foto_rehen) {

            Storage::disk('public')
                ->delete(
                    $registro->foto_rehen
                );
        }


        /*
        Borrar registro
        */

        DB::table('dni_rehenes')
            ->where(
                'id',
                $rehen
            )
            ->delete();


        return redirect()
            ->route(
                'dni-rehenes.index'
            )
            ->with(
                'mensaje',
                'DNI de rehén eliminado correctamente.'
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
    | USUARIO LOGUEADO
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


        return (int) $request
            ->session()
            ->get('usuario_id');
    }
}