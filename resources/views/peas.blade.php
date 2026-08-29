@extends('layout.app')

@section('title', 'PEAS')

@push('styles')
<style>

    .peas-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }

    /* =====================================================
       CABECERA
    ===================================================== */

    .peas-cabecera {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        margin-bottom: 20px;

        text-align: left;
    }

    .peas-cabecera h1 {
        margin: 0 0 8px;

        text-align: left;
    }

    .peas-cabecera p {
        margin: 0;

        color: #666;

        text-align: left;
    }


    /* =====================================================
       BOTÓN EDITAR
    ===================================================== */

    .boton-editar {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 6px;

        padding: 10px 14px;

        border-radius: 6px;

        background: #f08c00;

        color: white;

        text-decoration: none;

        font-size: 14px;

        font-weight: bold;

        white-space: nowrap;
    }

    .boton-editar:hover {
        background: #d97700;

        color: white;
    }


    /* =====================================================
       MENSAJE
    ===================================================== */

    .mensaje-peas {
        margin-bottom: 15px;

        padding: 12px 16px;

        border-radius: 6px;

        background: #d1e7dd;

        color: #0f5132;

        text-align: left;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .peas-acordeon {
        width: 100%;

        margin-bottom: 12px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);

        overflow: hidden;

        text-align: left;
    }

    .peas-acordeon summary {
        display: flex;

        align-items: center;

        gap: 12px;

        width: 100%;

        box-sizing: border-box;

        padding: 16px 20px;

        cursor: pointer;

        list-style: none;

        font-size: 16px;

        font-weight: bold;

        text-align: left;
    }

    .peas-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .peas-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .peas-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .peas-acordeon summary:hover {
        background: #f5f5f5;
    }


    /* =====================================================
       CONTENIDO
    ===================================================== */

    .peas-contenido {
    width: 100%;
    box-sizing: border-box;

    padding: 0;

    border-top: 1px solid #eee;

    text-align: left;
}

.peas-descripcion {
    width: 100%;
    box-sizing: border-box;

    margin: 0;
    padding: 0;

    border-radius: 6px;

    background: #f5f5f5;

    color: #444;

    line-height: 1.6;

    text-align: left;

    white-space: pre-wrap;

    overflow-wrap: break-word;
    word-break: break-word;
}


    /* =====================================================
       DESCRIPCIÓN
    ===================================================== */

    .peas-descripcion {
        width: 100%;

        box-sizing: border-box;

        margin: 0;

        padding: 15px;

        border-radius: 6px;

        background: #f5f5f5;

        color: #444;

        line-height: 1.6;

        text-align: left;

        white-space: pre-wrap;

        overflow-wrap: break-word;

        word-break: break-word;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 600px) {

        .peas-cabecera {
            align-items: flex-start;

            flex-direction: column;
        }

        .boton-editar {
            width: 100%;

            box-sizing: border-box;
        }

        .peas-contenido {
            padding: 12px 15px 15px;
        }

        .peas-descripcion {
            padding: 12px;

            font-size: 14px;
        }

    }

</style>
@endpush


@section('content')

<div class="peas-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="peas-cabecera">

        <div>

            <h1>
                🚨 PEAS
            </h1>

            <p>
                Protocolos de emergencia y avisos destinados a los ciudadanos.
            </p>

        </div>


        @if($esDirectiva)

            <a
                href="{{ route('peas.edit') }}"
                class="boton-editar"
            >
                ✏️ Editar PEAS
            </a>

        @endif

    </div>


    {{-- =====================================================
         MENSAJE
    ===================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje-peas">
            {{ session('mensaje') }}
        </div>

    @endif


    {{-- =====================================================
         PEAS
    ===================================================== --}}

    @foreach($peas as $pea)

        <details class="peas-acordeon">

            <summary>

                🚨

                <span>
                    {{ $pea['titulo'] }}
                </span>

            </summary>


            <div class="peas-contenido">

                <div class="peas-descripcion">

                    {{ $pea['descripcion'] }}

                </div>

            </div>

        </details>

    @endforeach


</div>

@endsection