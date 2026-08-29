@extends('layout.app')

@section('title', 'Jefes de divisiones')

@push('styles')
<style>

    .divisiones-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .divisiones-cabecera {
        margin-bottom: 20px;
    }

    .divisiones-cabecera h1 {
        margin: 0 0 8px;
    }

    .divisiones-cabecera p {
        margin: 0;
        color: #666;
    }

    /* =====================================================
       MENSAJE
    ===================================================== */

    .mensaje-division {
        margin-bottom: 15px;
        padding: 12px 16px;
        border-radius: 6px;
        background: #d1e7dd;
        color: #0f5132;
    }

    /* =====================================================
       ACORDEONES
    ===================================================== */

    .division-acordeon {
        margin-bottom: 12px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .division-acordeon summary {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 16px 20px;

        cursor: pointer;

        list-style: none;

        font-size: 17px;
        font-weight: bold;
    }

    .division-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .division-acordeon summary::after {
        content: '›';

        margin-left: auto;

        font-size: 22px;

        color: #777;

        transition: transform 0.2s ease;
    }

    .division-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .division-acordeon summary:hover {
        background: #f5f5f5;
    }

    .division-contenido {
        padding: 5px 20px 20px;
        border-top: 1px solid #eee;
    }

    /* =====================================================
       INFORMACIÓN
    ===================================================== */

    .dato-division {
        margin-top: 15px;
    }

    .dato-titulo {
        margin-bottom: 7px;

        color: #666;

        font-size: 12px;

        font-weight: bold;

        text-transform: uppercase;
    }

    .dato-contenido {
        padding: 12px 14px;

        border-radius: 6px;

        background: #f5f5f5;

        line-height: 1.5;
    }

    /* =====================================================
       PERSONAS
    ===================================================== */

    .persona-division {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding: 12px 14px;

        border-radius: 6px;

        background: #f5f5f5;
    }

    .persona-nombre {
        font-weight: 500;
    }

    .persona-placa {
        color: #666;

        font-size: 13px;

        white-space: nowrap;
    }

    .sin-persona {
        color: #888;

        font-style: italic;
    }

    /* =====================================================
       EDITAR
    ===================================================== */

    .division-acciones {
        display: flex;

        justify-content: flex-end;

        margin-top: 18px;
    }

    .boton-editar {
        display: inline-flex;

        align-items: center;

        gap: 6px;

        padding: 9px 13px;

        border-radius: 6px;

        background: #f08c00;

        color: white;

        text-decoration: none;

        font-size: 13px;

        font-weight: bold;
    }

    .boton-editar:hover {
        background: #d97700;
        color: white;
    }

    .boton-postular {
    display: inline-flex;

    align-items: center;

    gap: 6px;

    padding: 9px 13px;

    border-radius: 6px;

    background: #198754;

    color: white;

    text-decoration: none;

    font-size: 13px;

    font-weight: bold;
}

.boton-postular:hover {
    background: #157347;

    color: white;
}

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 600px) {

        .persona-division {
            align-items: flex-start;

            flex-direction: column;
        }

        .persona-placa {
            white-space: normal;
        }

    }

</style>
@endpush


@section('content')

<div class="divisiones-pagina">

    <div class="divisiones-cabecera">

        <h1>
            👮 Jefes de divisiones
        </h1>

        <p>
            Consulta los responsables y la información de las diferentes
            divisiones del Departamento del Sheriff.
        </p>

    </div>


    @if(session('mensaje'))

        <div class="mensaje-division">
            {{ session('mensaje') }}
        </div>

    @endif


    @foreach($divisiones as $division)

        @php

            $descripciones = [

                'Marshall' =>
                    'División especializada en la supervisión y gestión de los Marshalls, encargada de apoyar en operaciones especiales, control y seguridad del Departamento.',

                'Trooper' =>
                    'División dedicada a las labores de patrullaje, control de carreteras, persecuciones y actuación policial en todo el territorio.',

                'Aeronautica' =>
                    'División encargada de las operaciones aéreas del Departamento, proporcionando apoyo desde el aire y realizando labores de vigilancia y asistencia.',

                'Entrevistador' =>
                    'División especializada en la realización de entrevistas e interrogatorios, ayudando a obtener información relevante durante las investigaciones.',

                'Instruccion' =>
                    'División encargada de la formación, preparación y evaluación de los agentes, así como de su instrucción dentro del Departamento.',

                'Bani' =>
                    'División especializada en la investigación y actuación relacionada con drogas, incluyendo su identificación, clasificación y procedimientos correspondientes.',

            ];

            $descripcion = $descripciones[$division->nombre]
                ?? 'División encargada de desarrollar las funciones y responsabilidades asignadas por el Departamento del Sheriff.';

        @endphp


        <details class="division-acordeon">

            <summary>
                🛡️ {{ $division->nombre }}
            </summary>


            <div class="division-contenido">


                {{-- =============================================
                     DESCRIPCIÓN
                ============================================== --}}

                <div class="dato-division">

                    <div class="dato-titulo">
                        Función de la división
                    </div>

                    <div class="dato-contenido">
                        {{ $descripcion }}
                    </div>

                </div>


                {{-- =============================================
                     JEFE
                ============================================== --}}

                <div class="dato-division">

                    <div class="dato-titulo">
                        Jefe de la división
                    </div>


                    @if($division->jefe_nombre)

                        <div class="persona-division">

                            <span class="persona-nombre">
                                👮 {{ $division->jefe_nombre }}
                            </span>

                            <span class="persona-placa">
                                Placa:
                                <strong>
                                    {{ $division->jefe_placa ?: 'Sin placa' }}
                                </strong>
                            </span>

                        </div>

                    @else

                        <div class="persona-division">

                            <span class="sin-persona">
                                Sin jefe asignado
                            </span>

                        </div>

                    @endif

                </div>


                {{-- =============================================
                     SUBJEFE
                ============================================== --}}

                <div class="dato-division">

                    <div class="dato-titulo">
                        Subjefe de la división
                    </div>


                    @if($division->subjefe_nombre)

                        <div class="persona-division">

                            <span class="persona-nombre">
                                👮 {{ $division->subjefe_nombre }}
                            </span>

                            <span class="persona-placa">
                                Placa:
                                <strong>
                                    {{ $division->subjefe_placa ?: 'Sin placa' }}
                                </strong>
                            </span>

                        </div>

                    @else

                        <div class="persona-division">

                            <span class="sin-persona">
                                Sin subjefe asignado
                            </span>

                        </div>

                    @endif

                </div>


                {{-- =============================================
                    EDITAR / POSTULAR
                ============================================== --}}

                @if($esDirectiva)

                    <div class="division-acciones">

                        <a
                            href="{{ route('jefes-divisiones.edit', $division->id) }}"
                            class="boton-editar"
                        >
                            ✏️ Editar división
                        </a>

                    </div>

                @else

                    <div class="division-acciones">

                        <a
                            href="{{ route('postulacion-divisiones.index') }}"
                            class="boton-postular"
                        >
                            📝 Postular
                        </a>

                    </div>

                @endif


            </div>

        </details>

    @endforeach

</div>

@endsection