@extends('layout.app')

@section('title', 'Editar división')

@push('styles')
<style>

    .editar-division-pagina {
        max-width: 700px;
        margin: 0 auto;
    }

    .editar-division-cabecera {
        margin-bottom: 20px;
    }

    .editar-division-cabecera h1 {
        margin: 0 0 8px;
    }

    .editar-division-cabecera p {
        margin: 0;
        color: #666;
    }

    .formulario-division {
        padding: 24px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .campo-division {
        margin-bottom: 18px;
    }

    .campo-division label {
        display: block;

        margin-bottom: 7px;

        font-weight: bold;
    }

    .campo-division select {
        width: 100%;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 6px;

        background: white;

        font: inherit;

        box-sizing: border-box;
    }

    .error-division {
        margin-bottom: 18px;

        padding: 12px 15px;

        border-radius: 6px;

        background: #f8d7da;

        color: #842029;
    }

    .botones-division {
        display: flex;

        justify-content: space-between;

        gap: 10px;

        margin-top: 25px;
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
    }

    .boton-guardar {
        padding: 11px 16px;

        border: 0;

        border-radius: 6px;

        background: #198754;

        color: white;

        cursor: pointer;

        font: inherit;

        font-weight: bold;
    }

    @media (max-width: 600px) {

        .botones-division {
            flex-direction: column;
        }

        .boton-volver,
        .boton-guardar {
            width: 100%;

            text-align: center;

            box-sizing: border-box;
        }

    }

</style>
@endpush


@section('content')

<div class="editar-division-pagina">


    <div class="editar-division-cabecera">

        <h1>
            ✏️ Editar {{ $division->nombre }}
        </h1>

        <p>
            Selecciona el jefe y subjefe de esta división.
        </p>

    </div>


    @if($errors->any())

        <div class="error-division">

            <strong>
                Hay errores en el formulario:
            </strong>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('jefes-divisiones.update', $division->id) }}"
        method="POST"
        class="formulario-division"
    >

        @csrf

        @method('PUT')


        {{-- =============================================
             JEFE
        ============================================== --}}

        <div class="campo-division">

            <label for="jefe_id">
                👮 Jefe de la división
            </label>

            <select
                id="jefe_id"
                name="jefe_id"
            >

                <option value="">
                    Sin jefe
                </option>


                @foreach($agentes as $agente)

                    <option
                        value="{{ $agente->id }}"
                        {{ (string) old('jefe_id', $division->jefe_id) === (string) $agente->id ? 'selected' : '' }}
                    >

                        {{ $agente->nombre }}

                        @if($agente->placa)
                            | {{ $agente->placa }}
                        @endif

                    </option>

                @endforeach

            </select>

        </div>


        {{-- =============================================
             SUBJEFE
        ============================================== --}}

        <div class="campo-division">

            <label for="subjefe_id">
                👮 Subjefe de la división
            </label>

            <select
                id="subjefe_id"
                name="subjefe_id"
            >

                <option value="">
                    Sin subjefe
                </option>


                @foreach($agentes as $agente)

                    <option
                        value="{{ $agente->id }}"
                        {{ (string) old('subjefe_id', $division->subjefe_id) === (string) $agente->id ? 'selected' : '' }}
                    >

                        {{ $agente->nombre }}

                        @if($agente->placa)
                            | {{ $agente->placa }}
                        @endif

                    </option>

                @endforeach

            </select>

        </div>


        {{-- =============================================
             BOTONES
        ============================================== --}}

        <div class="botones-division">

            <a
                href="{{ route('jefes-divisiones.index') }}"
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