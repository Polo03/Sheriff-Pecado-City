<?php

namespace App\Http\Controllers;

use App\Models\SujetoProcesado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SujetoProcesadoController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LISTADO
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $busqueda = trim((string) $request->input('buscar'));

        $sujetos = SujetoProcesado::query()
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                $query->where('nombre', 'like', '%' . $busqueda . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(16)
            ->withQueryString();

        return view('sujetos_procesados', [
            'sujetos' => $sujetos,
            'modo' => 'lista',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO CREAR
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $sujetos = SujetoProcesado::orderBy('id', 'desc')->get();

        return view('sujetos_procesados', [
            'sujetos' => $sujetos,
            'modo' => 'crear',
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | GUARDAR
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN DE NOMBRE Y DNI
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'dni' => [
                'required',
                'string',
                'max:50',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | COMPROBAR ERRORES DE SUBIDA
        |--------------------------------------------------------------------------
        */

        $camposFotos = [
            'foto_sujeto_procesado' => 'La foto del sujeto',
            'foto_dni' => 'La foto del DNI',
            'foto_antecedentes' => 'La foto de antecedentes',
        ];


        foreach ($camposFotos as $campo => $nombreCampo) {

            if ($request->has($campo)) {

                $archivo = $request->file($campo);

                /*
                Si PHP ha recibido el archivo
                pero existe un error de subida.
                */

                if ($archivo && $archivo->getError() !== UPLOAD_ERR_OK) {

                    $codigoError = $archivo->getError();

                    $mensajeError = match ($codigoError) {

                        UPLOAD_ERR_INI_SIZE =>
                            'El archivo supera el tamaño máximo permitido por PHP.',

                        UPLOAD_ERR_FORM_SIZE =>
                            'El archivo supera el tamaño máximo permitido por el formulario.',

                        UPLOAD_ERR_PARTIAL =>
                            'El archivo se ha subido parcialmente.',

                        UPLOAD_ERR_NO_FILE =>
                            'No se ha enviado ningún archivo.',

                        UPLOAD_ERR_NO_TMP_DIR =>
                            'PHP no encuentra la carpeta temporal de subida.',

                        UPLOAD_ERR_CANT_WRITE =>
                            'PHP no tiene permisos para escribir el archivo.',

                        UPLOAD_ERR_EXTENSION =>
                            'Una extensión de PHP ha detenido la subida.',

                        default =>
                            'Error desconocido al subir el archivo.',
                    };


                    return back()
                        ->withInput()
                        ->withErrors([
                            $campo =>
                                $nombreCampo .
                                ' no se ha podido subir. ' .
                                'Error PHP: ' .
                                $codigoError .
                                ' - ' .
                                $mensajeError,
                        ]);
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | VALIDACIÓN DE IMÁGENES
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'foto_sujeto_procesado' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'foto_dni' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'foto_antecedentes' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | CREAR SUJETO
        |--------------------------------------------------------------------------
        */

        $sujeto = new SujetoProcesado();

        $sujeto->nombre = $request->input('nombre');

        $sujeto->dni = $request->input('dni');


        /*
        |--------------------------------------------------------------------------
        | FOTO SUJETO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_sujeto_procesado')) {

            $archivo = $request->file(
                'foto_sujeto_procesado'
            );


            if ($archivo->isValid()) {

                $ruta = $archivo->store(
                    'sujetos_procesados',
                    'public'
                );


                if ($ruta === false) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'foto_sujeto_procesado' =>
                                'No se pudo guardar la foto del sujeto.',
                        ]);
                }


                $sujeto->foto_sujeto_procesado = $ruta;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FOTO DNI
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_dni')) {

            $archivo = $request->file(
                'foto_dni'
            );


            if ($archivo->isValid()) {

                $ruta = $archivo->store(
                    'sujetos_procesados',
                    'public'
                );


                if ($ruta === false) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'foto_dni' =>
                                'No se pudo guardar la foto del DNI.',
                        ]);
                }


                $sujeto->foto_dni = $ruta;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | FOTO ANTECEDENTES
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_antecedentes')) {

            $archivo = $request->file(
                'foto_antecedentes'
            );


            if ($archivo->isValid()) {

                $ruta = $archivo->store(
                    'sujetos_procesados',
                    'public'
                );


                if ($ruta === false) {

                    return back()
                        ->withInput()
                        ->withErrors([
                            'foto_antecedentes' =>
                                'No se pudo guardar la foto de antecedentes.',
                        ]);
                }


                $sujeto->foto_antecedentes = $ruta;
            }
        }


        /*
        |--------------------------------------------------------------------------
        | GUARDAR EN MYSQL
        |--------------------------------------------------------------------------
        */

        $sujeto->save();


        /*
        |--------------------------------------------------------------------------
        | VOLVER AL LISTADO
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('sujetos-procesados.index');
    }


    /*
    |--------------------------------------------------------------------------
    | VER
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $sujeto = SujetoProcesado::findOrFail($id);

        return view('sujetos_procesados', [
            'sujetos' =>
                SujetoProcesado::orderBy(
                    'id',
                    'desc'
                )->get(),

            'modo' => 'ver',

            'sujeto' => $sujeto,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | FORMULARIO EDITAR
    |--------------------------------------------------------------------------
    */

    public function edit($id)
    {
        $sujeto = SujetoProcesado::findOrFail($id);

        return view('sujetos_procesados', [
            'sujetos' =>
                SujetoProcesado::orderBy(
                    'id',
                    'desc'
                )->get(),

            'modo' => 'editar',

            'sujeto' => $sujeto,
        ]);
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $id
    ) {
        $sujeto = SujetoProcesado::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | VALIDAR DATOS
        |--------------------------------------------------------------------------
        */

        $request->validate([

            'nombre' => [
                'required',
                'string',
                'max:255',
            ],

            'dni' => [
                'required',
                'string',
                'max:50',
            ],

            'foto_sujeto_procesado' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'foto_dni' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],

            'foto_antecedentes' => [
                'nullable',
                'file',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:10240',
            ],
        ]);


        /*
        |--------------------------------------------------------------------------
        | DATOS BÁSICOS
        |--------------------------------------------------------------------------
        */

        $sujeto->nombre =
            $request->input('nombre');

        $sujeto->dni =
            $request->input('dni');


        /*
        |--------------------------------------------------------------------------
        | NUEVA FOTO DEL SUJETO
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_sujeto_procesado')) {

            $archivo =
                $request->file(
                    'foto_sujeto_procesado'
                );


            if ($archivo->isValid()) {

                if ($sujeto->foto_sujeto_procesado) {

                    Storage::disk('public')->delete(
                        $sujeto->foto_sujeto_procesado
                    );
                }


                $sujeto->foto_sujeto_procesado =
                    $archivo->store(
                        'sujetos_procesados',
                        'public'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NUEVA FOTO DEL DNI
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_dni')) {

            $archivo =
                $request->file('foto_dni');


            if ($archivo->isValid()) {

                if ($sujeto->foto_dni) {

                    Storage::disk('public')->delete(
                        $sujeto->foto_dni
                    );
                }


                $sujeto->foto_dni =
                    $archivo->store(
                        'sujetos_procesados',
                        'public'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | NUEVA FOTO DE ANTECEDENTES
        |--------------------------------------------------------------------------
        */

        if ($request->hasFile('foto_antecedentes')) {

            $archivo =
                $request->file(
                    'foto_antecedentes'
                );


            if ($archivo->isValid()) {

                if ($sujeto->foto_antecedentes) {

                    Storage::disk('public')->delete(
                        $sujeto->foto_antecedentes
                    );
                }


                $sujeto->foto_antecedentes =
                    $archivo->store(
                        'sujetos_procesados',
                        'public'
                    );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | GUARDAR CAMBIOS EN MYSQL
        |--------------------------------------------------------------------------
        */

        $sujeto->save();


        return redirect()
            ->route('sujetos-procesados.index');
    }


    /*
    |--------------------------------------------------------------------------
    | ELIMINAR
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $sujeto =
            SujetoProcesado::findOrFail($id);


        /*
        |--------------------------------------------------------------------------
        | ELIMINAR FOTO SUJETO
        |--------------------------------------------------------------------------
        */

        if ($sujeto->foto_sujeto_procesado) {

            Storage::disk('public')->delete(
                $sujeto->foto_sujeto_procesado
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ELIMINAR FOTO DNI
        |--------------------------------------------------------------------------
        */

        if ($sujeto->foto_dni) {

            Storage::disk('public')->delete(
                $sujeto->foto_dni
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ELIMINAR FOTO ANTECEDENTES
        |--------------------------------------------------------------------------
        */

        if ($sujeto->foto_antecedentes) {

            Storage::disk('public')->delete(
                $sujeto->foto_antecedentes
            );
        }


        /*
        |--------------------------------------------------------------------------
        | ELIMINAR REGISTRO MYSQL
        |--------------------------------------------------------------------------
        */

        $sujeto->delete();

    }
}