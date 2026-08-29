@extends('layout.app')

@section('title', 'Nuevo procedimiento')

@push('styles')
<style>

    .formulario-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
    }

    .formulario-cabecera {
        margin-bottom: 20px;
    }

    .formulario-cabecera h1 {
        margin: 0 0 8px;
    }

    .formulario-cabecera p {
        margin: 0;
        color: #666;
    }

    .formulario-contenedor {
        padding: 25px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .campo {
        margin-bottom: 18px;
    }

    .campo label {
        display: block;

        margin-bottom: 7px;

        font-size: 14px;

        font-weight: bold;

        color: #444;
    }

    .campo input,
    .campo textarea {
        width: 100%;

        box-sizing: border-box;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 6px;

        background: white;

        color: #222;

        font: inherit;
    }

    .campo textarea {
        min-height: 220px;

        resize: vertical;

        line-height: 1.5;
    }

    .campo input:focus,
    .campo textarea:focus {
        outline: none;

        border-color: #888;

        box-shadow: 0 0 0 2px rgba(0, 0, 0, 0.05);
    }

    .errores {
        margin-bottom: 18px;

        padding: 12px 15px;

        border-radius: 6px;

        background: #f8d7da;

        color: #842029;
    }

    .botones {
        display: flex;

        justify-content: space-between;

        gap: 10px;

        margin-top: 20px;
    }

    .boton-volver {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 10px 15px;

        border-radius: 6px;

        background: #666;

        color: white;

        text-decoration: none;

        font-weight: bold;
    }

    .boton-volver:hover {
        background: #555;

        color: white;
    }

    .boton-guardar {
        padding: 10px 15px;

        border: none;

        border-radius: 6px;

        background: #198754;

        color: white;

        cursor: pointer;

        font: inherit;

        font-weight: bold;
    }

    .boton-guardar:hover {
        background: #157347;
    }

    @media (max-width: 600px) {

        .formulario-contenedor {
            padding: 18px;
        }

        .botones {
            flex-direction: column;
        }

        .boton-volver,
        .boton-guardar {
            width: 100%;

            box-sizing: border-box;

            text-align: center;
        }

    }

</style>
@endpush


@section('content')

<div class="formulario-pagina">

    <div class="formulario-cabecera">

        <h1>
            ➕ Nuevo procedimiento
        </h1>

        <p>
            Publica un nuevo anuncio para el Departamento del Sheriff.
        </p>

    </div>


    <div class="formulario-contenedor">


        @if($errors->any())

            <div class="errores">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <form
            action="{{ route('procedimientos.store') }}"
            method="POST"
        >

            @csrf


            <div class="campo">

                <label for="titulo">
                    Título
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    value="{{ old('titulo') }}"
                    maxlength="150"
                    placeholder="Ejemplo: Procedimiento de detención"
                    required
                >

            </div>


            <div class="campo">

                <label for="contenido">
                    Contenido del procedimiento
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    placeholder="Escribe aquí el procedimiento o anuncio..."
                    required
                >{{ old('contenido') }}</textarea>

            </div>


            <div class="botones">

                <a
                    href="{{ route('procedimientos.index') }}"
                    class="boton-volver"
                >
                    ← Volver
                </a>

                <button
                    type="submit"
                    class="boton-guardar"
                >
                    📢 Publicar anuncio
                </button>

            </div>

        </form>

    </div>

</div>

@endsection