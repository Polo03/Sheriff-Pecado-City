@extends('layout.app')

@section('title', 'Matrícula sospechosa')

@push('styles')

<style>

    .detalle-matricula {
        max-width: 1100px;
        margin: 0 auto;
    }


    /* =========================
       CABECERA
    ========================= */

    .detalle-matricula-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .detalle-matricula-header h1 {
        margin: 0;
    }


    /* =========================
       BOTONES
    ========================= */

    .boton-matricula {
        display: inline-block;
        padding: 10px 15px;
        border: none;
        border-radius: 7px;
        color: white;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
        font-family: inherit;
    }


    .boton-gris-matricula {
        background: #777;
    }

    .boton-gris-matricula:hover {
        background: #666;
    }


    .boton-verde-matricula {
        background: #198754;
    }

    .boton-verde-matricula:hover {
        background: #157347;
    }


    /* =========================
       DATOS
    ========================= */

    .datos-matricula {
        margin-bottom: 30px;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 10px;
    }


    .dato-matricula {
        margin-bottom: 10px;
    }


    .dato-matricula:last-child {
        margin-bottom: 0;
    }


    /* =========================
       GALERÍA
    ========================= */

    .galeria-matricula {
        display: grid;
        grid-template-columns: 1fr;
        gap: 20px;
        margin-top: 25px;
    }


    .foto-contenedor-matricula {
        text-align: center;
    }


    .foto-contenedor-matricula h3 {
        margin-bottom: 10px;
        font-size: 15px;
    }


    .foto-grande-matricula {
        width: 100%;
        max-width: 900px;
        height: 400px;
        object-fit: contain;
        background: #f5f5f5;
        border-radius: 10px;
        border: 1px solid #ddd;
    }


    .sin-foto-matricula {
        width: 100%;
        max-width: 900px;
        height: 400px;
        margin: 0 auto;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
        border-radius: 10px;
        color: #999;
    }


    /* =========================
       ACCIONES
    ========================= */

    .acciones-matricula-detalle {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 700px) {

        .detalle-matricula-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }


        .foto-grande-matricula,
        .sin-foto-matricula {
            height: 280px;
        }

    }

</style>

@endpush


@section('content')

<div class="detalle-matricula">


    {{-- =====================================================
         CABECERA
    ====================================================== --}}

    <div class="detalle-matricula-header">

        <h1>
            Matrícula sospechosa
        </h1>


        <a
            href="{{ route('matriculas-sospechosas.index') }}"
            class="boton-matricula boton-gris-matricula"
        >
            ← Volver
        </a>

    </div>


    {{-- =====================================================
         DATOS
    ====================================================== --}}

    <div class="datos-matricula">


        <div class="dato-matricula">

            <strong>
                Agente:
            </strong>

            {{ $matricula->agente_nombre ?: 'Agente no encontrado' }}

        </div>


        <div class="dato-matricula">

            <strong>
                Placa:
            </strong>

            {{ $matricula->placa ?: 'Sin placa' }}

        </div>


        <div class="dato-matricula">

            <strong>
                Causa:
            </strong>

            {{ $matricula->causa }}

        </div>


        <div class="dato-matricula">

            <strong>
                Fecha de registro:
            </strong>

            {{ $matricula->fecha_registro }}

        </div>


    </div>


    {{-- =====================================================
         FOTO
    ====================================================== --}}

    <div class="galeria-matricula">


        <div class="foto-contenedor-matricula">

            <h3>
                Foto de la matrícula
            </h3>


            @if($matricula->foto_matricula)

                <img
                    src="{{ asset('storage/' . $matricula->foto_matricula) }}"
                    class="foto-grande-matricula"
                    alt="Foto de la matrícula"
                >

            @else

                <div class="sin-foto-matricula">
                    Sin foto
                </div>

            @endif

        </div>


    </div>


    {{-- =====================================================
         ACCIONES
    ====================================================== --}}

    @if($esDirectiva)

        <div class="acciones-matricula-detalle">

            <a
                href="{{ route('matriculas-sospechosas.edit', $matricula->id) }}"
                class="boton-matricula boton-verde-matricula"
            >
                Editar
            </a>

        </div>

    @endif


</div>

@endsection