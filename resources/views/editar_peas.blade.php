@extends('layout.app')

@section('title', 'Editar PEAS')

@push('styles')
<style>

    .editar-peas-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .editar-peas-cabecera {
        margin-bottom: 20px;
    }

    .editar-peas-cabecera h1 {
        margin: 0 0 8px;
    }

    .editar-peas-cabecera p {
        margin: 0;
        color: #666;
    }

    .pea-formulario {
        margin-bottom: 15px;

        padding: 20px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .campo {
        margin-bottom: 15px;
    }

    .campo:last-child {
        margin-bottom: 0;
    }

    .campo label {
        display: block;

        margin-bottom: 7px;

        font-size: 13px;

        font-weight: bold;

        color: #555;
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
        min-height: 150px;

        resize: vertical;

        line-height: 1.5;
    }

    .botones {
        display: flex;

        justify-content: space-between;

        gap: 10px;

        margin-top: 20px;
    }

    .boton-volver {
        padding: 11px 16px;

        border-radius: 6px;

        background: #666;

        color: white;

        text-decoration: none;
    }

    .boton-volver:hover {
        color: white;
        background: #555;
    }

    .boton-guardar {
        padding: 11px 16px;

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

<div class="editar-peas-pagina">

    <div class="editar-peas-cabecera">

        <h1>
            ✏️ Editar PEAS
        </h1>

        <p>
            Modifica los títulos y mensajes de los diferentes niveles PEAS.
        </p>

    </div>


    @if($errors->any())

        <div style="
            margin-bottom: 15px;
            padding: 12px 16px;
            border-radius: 6px;
            background: #f8d7da;
            color: #842029;
        ">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <form
        action="{{ route('peas.update') }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        @foreach($peas as $indice => $pea)

            <div class="pea-formulario">

                <div class="campo">

                    <label>
                        Título
                    </label>

                    <input
                        type="text"
                        name="titulo[]"
                        value="{{ $pea['titulo'] }}"
                        maxlength="100"
                        required
                    >

                </div>


                <div class="campo">

                    <label>
                        Descripción / comando
                    </label>

                    <textarea
                        name="descripcion[]"
                        required
                    >{{ $pea['descripcion'] }}</textarea>

                </div>

            </div>

        @endforeach


        <div class="botones">

            <a
                href="{{ route('peas.index') }}"
                class="boton-volver"
            >
                ← Volver
            </a>

            <button
                type="submit"
                class="boton-guardar"
            >
                💾 Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection