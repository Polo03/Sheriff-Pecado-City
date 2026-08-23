<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnuncioController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------------
    */

    public function index(
        Request $request,
        string $tipo = 'anuncios'
    ) {
        $usuarioId = $this->usuarioId($request);

        abort_unless(
            in_array(
                $tipo,
                [
                    'anuncios',
                    'briefing',
                    'mensajes-divisiones',
                    'busqueda-captura',
                    'plantilla-mensajes',
                ],
                true
            ),
            404
        );


        $anuncios = DB::table('anuncios')
            ->join(
                'agentes',
                'agentes.id',
                '=',
                'anuncios.agente_id'
            )
            ->where(
                'anuncios.tipo',
                $tipo
            )
            ->select(
                'anuncios.id',
                'anuncios.contenido',
                'anuncios.created_at',
                'agentes.nombre as autor'
            )
            ->orderByDesc(
                'anuncios.created_at'
            )
            ->get();


        return view(
            'anuncios',
            [
                'anuncios' => $anuncios,

                'puedePublicar' =>
                    $this->puedePublicar(
                        $usuarioId,
                        $tipo
                    ),

                'titulo' => match ($tipo) {

                    'briefing' =>
                        'Briefing',

                    'mensajes-divisiones' =>
                        'Mensajes-divisiones',

                    'busqueda-captura' =>
                        'Busqueda y captura activas',

                    'plantilla-mensajes' =>
                        'Plantilla mensajes',

                    default =>
                        'Anuncios',
                },

                'rutaPublicar' => $tipo,
            ]
        );
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        string $tipo = 'anuncios'
    ) {
        $usuarioId =
            $this->usuarioId($request);


        abort_unless(
            in_array(
                $tipo,
                [
                    'anuncios',
                    'briefing',
                    'mensajes-divisiones',
                    'busqueda-captura',
                    'plantilla-mensajes',
                ],
                true
            ),
            404
        );


        abort_unless(
            $this->puedePublicar(
                $usuarioId,
                $tipo
            ),
            403
        );


        $datos = $request->validate([
            'contenido' => [
                'required',
                'string',
                'max:2000',
            ],
        ]);


        DB::table('anuncios')->insert([

            'agente_id' =>
                $usuarioId,

            'tipo' =>
                $tipo,

            'contenido' =>
                $datos['contenido'],

            'created_at' =>
                now(),

            'updated_at' =>
                now(),

        ]);


        return redirect()->route(
            match ($tipo) {

                'briefing' =>
                    'briefing.index',

                'mensajes-divisiones' =>
                    'mensajes-divisiones.index',

                'busqueda-captura' =>
                    'busqueda-captura.index',

                'plantilla-mensajes' =>
                    'plantilla-mensajes.index',

                default =>
                    'anuncios.index',
            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy(
        Request $request,
        int $anuncio
    ) {
        $usuarioId =
            $this->usuarioId($request);


        /*
        Solo Directiva puede eliminar
        */

        abort_unless(
            $this->esDirectiva($usuarioId),
            403
        );


        /*
        Buscar anuncio
        */

        $registro = DB::table('anuncios')
            ->where(
                'id',
                $anuncio
            )
            ->first();


        abort_unless(
            $registro,
            404
        );


        /*
        Solo permitimos borrar
        estos apartados
        */

        abort_unless(
            in_array(
                $registro->tipo,
                [
                    'anuncios',
                    'briefing',
                    'plantilla-mensajes',
                ],
                true
            ),
            403
        );


        /*
        Eliminar
        */

        DB::table('anuncios')
            ->where(
                'id',
                $anuncio
            )
            ->delete();


        /*
        Volver al apartado
        correspondiente
        */

        return redirect()->route(
            match ($registro->tipo) {

                'briefing' =>
                    'briefing.index',

                'plantilla-mensajes' =>
                    'plantilla-mensajes.index',

                default =>
                    'anuncios.index',
            }
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

            return redirect()
                ->route('login');

        }


        return (int)
            $request
                ->session()
                ->get('usuario_id');
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
    | PERMISOS DE PUBLICACIÓN
    |--------------------------------------------------------------------------
    */

    private function puedePublicar(
        int $usuarioId,
        string $tipo
    ): bool {

        /*
        Mensajes-divisiones:
        cualquier agente
        */

        if (
            $tipo ===
            'mensajes-divisiones'
        ) {

            return DB::table('agentes')
                ->where(
                    'id',
                    $usuarioId
                )
                ->exists();
        }


        /*
        Búsqueda y captura:
        Fiscal o Directiva
        */

        if (
            $tipo ===
            'busqueda-captura'
        ) {

            return DB::table('agentes')

                ->leftJoin(
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
                    function ($query) {

                        $query
                            ->where(
                                'agentes.rango',
                                'Fiscal'
                            )

                            ->orWhere(
                                'rangos.escala',
                                'Directiva'
                            );

                    }
                )

                ->exists();
        }


        /*
        Anuncios,
        Briefing y
        Plantilla mensajes:
        solo Directiva
        */

        return $this->esDirectiva(
            $usuarioId
        );
    }
}