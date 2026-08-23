@extends('layout.app')

@section('title', 'Mosquete local')

@push('styles')
<style>

    .detalle-mosquete {
        max-width: 1100px;
        margin: 0 auto;
    }


    /* =========================
       CABECERA
    ========================= */

    .detalle-mosquete-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .detalle-mosquete-header h1 {
        margin: 0;
    }


    /* =========================
       BOTONES
    ========================= */

    .boton-mosquete {
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

    .boton-gris-mosquete {
        background: #777;
    }

    .boton-gris-mosquete:hover {
        background: #666;
    }

    .boton-verde-mosquete {
        background: #198754;
    }

    .boton-verde-mosquete:hover {
        background: #157347;
    }


    /* =========================
       DATOS
    ========================= */

    .datos-mosquete {
        margin-bottom: 30px;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 10px;
    }

    .dato-mosquete {
        margin-bottom: 10px;
    }

    .dato-mosquete:last-child {
        margin-bottom: 0;
    }


    /* =========================
       GALERÍA
    ========================= */

    .galeria-mosquete {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-top: 25px;
    }

    .foto-contenedor-mosquete {
        text-align: center;
    }

    .foto-contenedor-mosquete h3 {
        margin-bottom: 10px;
        font-size: 15px;
    }

    .foto-grande-mosquete {
        width: 100%;
        height: 350px;
        object-fit: contain;
        background: #f5f5f5;
        border-radius: 10px;
        border: 1px solid #ddd;
    }

    .sin-foto-mosquete {
        width: 100%;
        height: 350px;
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

    .detalle-acciones-mosquete {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 700px) {

        .detalle-mosquete-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .galeria-mosquete {
            grid-template-columns: 1fr;
        }

        .foto-grande-mosquete,
        .sin-foto-mosquete {
            height: 280px;
        }

    }

</style>
@endpush


@section('content')

<div class="detalle-mosquete">


    {{-- =====================================================
         CABECERA
    ====================================================== --}}

    <div class="detalle-mosquete-header">

        <h1>
            Mosquete local
        </h1>

        <a
            href="{{ route('mosquetes-locales.index') }}"
            class="boton-mosquete boton-gris-mosquete"
        >
            ← Volver
        </a>

    </div>


    {{-- =====================================================
         DATOS
    ====================================================== --}}

    <div class="datos-mosquete">

        <div class="dato-mosquete">

            <strong>
                Agente:
            </strong>

            {{ $mosquete->agente_nombre ?: 'Agente no encontrado' }}

        </div>


        <div class="dato-mosquete">

            <strong>
                Placa:
            </strong>

            {{ $mosquete->placa ?: 'Sin placa' }}

        </div>


        <div class="dato-mosquete">

            <strong>
                Empresa/compañía:
            </strong>

            {{ $mosquete->empresa }}

        </div>


        <div class="dato-mosquete">

            <strong>
                Número de serie:
            </strong>

            {{ $mosquete->num_serie_mosquete }}

        </div>


        <div class="dato-mosquete">

            <strong>
                Fecha de registro:
            </strong>

            {{ $mosquete->fecha_registro }}

        </div>

    </div>


    {{-- =====================================================
         GALERÍA
    ====================================================== --}}

    <div class="galeria-mosquete">


        {{-- =================================================
             FOTO DNI
        ================================================== --}}

        <div class="foto-contenedor-mosquete">

            <h3>
                Foto del DNI
            </h3>


            @if($mosquete->foto_dni)

                <img
                    src="{{ asset('storage/' . $mosquete->foto_dni) }}"
                    class="foto-grande-mosquete"
                    alt="Foto del DNI"
                >

            @else

                <div class="sin-foto-mosquete">
                    Sin foto
                </div>

            @endif

        </div>


        {{-- =================================================
             LICENCIA
        ================================================== --}}

        <div class="foto-contenedor-mosquete">

            <h3>
                Foto de licencia de armas
            </h3>


            @if($mosquete->foto_licencia_armas)

                <img
                    src="{{ asset('storage/' . $mosquete->foto_licencia_armas) }}"
                    class="foto-grande-mosquete"
                    alt="Foto de licencia de armas"
                >

            @else

                <div class="sin-foto-mosquete">
                    Sin foto
                </div>

            @endif

        </div>


    </div>


    {{-- =====================================================
         ACCIONES
    ====================================================== --}}

    @if($esDirectiva)

        <div class="detalle-acciones-mosquete">

            <a
                href="{{ route('mosquetes-locales.edit', $mosquete->id) }}"
                class="boton-mosquete boton-verde-mosquete"
            >
                Editar
            </a>

        </div>

    @endif


</div>

@endsection