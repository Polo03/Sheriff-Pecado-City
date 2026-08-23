@extends('layout.app')

@section('title', 'DNI Rehén')


@push('styles')

<style>

    .ver-rehen-pagina {

        max-width: 1100px;

        margin: 0 auto;

    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .cabecera-rehen {

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 30px;

    }


    .cabecera-rehen h1 {

        margin: 0;

    }


    /* =====================================================
       BOTONES
    ===================================================== */

    .boton {

        display: inline-block;

        padding: 10px 15px;

        border: none;

        border-radius: 7px;

        background: #222;

        color: white;

        text-decoration: none;

        cursor: pointer;

        font-size: 14px;

    }


    .boton-gris {

        background: #777;

    }


    .boton-gris:hover {

        background: #666;

    }


    .boton-verde {

        background: #198754;

    }


    .boton-verde:hover {

        background: #157347;

    }


    /* =====================================================
       DATOS
    ===================================================== */

    .datos {

        margin-bottom: 30px;

        padding: 20px;

        background: #f5f5f5;

        border-radius: 10px;

    }


    .dato {

        margin-bottom: 10px;

    }


    .dato:last-child {

        margin-bottom: 0;

    }


    /* =====================================================
       GALERÍA
    ===================================================== */

    .galeria {

        display: grid;

        grid-template-columns: 1fr;

        gap: 25px;

        margin-top: 25px;

    }


    .foto-contenedor {

        text-align: center;

    }


    .foto-contenedor h3 {

        margin-bottom: 15px;

        font-size: 17px;

    }


    .foto-grande {

        width: 100%;

        max-width: 700px;

        height: 500px;

        object-fit: contain;

        border-radius: 10px;

        border: 1px solid #ddd;

        background: #f5f5f5;

        display: block;

        margin: 0 auto;

    }


    .sin-foto-grande {

        width: 100%;

        max-width: 700px;

        height: 300px;

        display: flex;

        justify-content: center;

        align-items: center;

        margin: 0 auto;

        background: #f5f5f5;

        border-radius: 10px;

        color: #999;

    }


    /* =====================================================
       MENSAJE
    ===================================================== */

    .mensaje {

        margin-bottom: 20px;

        padding: 12px 16px;

        border-radius: 8px;

        background: #d4edda;

        color: #155724;

    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 700px) {

        .cabecera-rehen {

            flex-direction: column;

            align-items: flex-start;

            gap: 15px;

        }


        .foto-grande {

            height: 350px;

        }


        .sin-foto-grande {

            height: 250px;

        }

    }

</style>

@endpush



@section('content')

<div class="ver-rehen-pagina">


    {{-- =====================================================
         CABECERA
    ====================================================== --}}

    <div class="cabecera-rehen">

        <h1>
            DNI de rehén
        </h1>


        <a
            href="{{ route('dni-rehenes.index') }}"
            class="boton boton-gris"
        >
            ← Volver
        </a>

    </div>



    {{-- =====================================================
         MENSAJE
    ====================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje">

            {{ session('mensaje') }}

        </div>

    @endif



    {{-- =====================================================
         DATOS
    ====================================================== --}}

    <div class="datos">


        {{-- AGENTE --}}

        <div class="dato">

            <strong>
                Agente:
            </strong>

            {{ $rehen->agente_nombre ?: 'Agente no encontrado' }}

        </div>



        {{-- PLACA --}}

        <div class="dato">

            <strong>
                Placa:
            </strong>

            {{ $rehen->placa ?: 'Sin placa' }}

        </div>



        {{-- CAUSA --}}

        <div class="dato">

            <strong>
                Causa:
            </strong>

            {{ $rehen->causa }}

        </div>



        {{-- FECHA --}}

        <div class="dato">

            <strong>
                Fecha de registro:
            </strong>

            {{ $rehen->fecha_registro }}

        </div>


    </div>



    {{-- =====================================================
         FOTO DEL REHÉN
    ====================================================== --}}

    <div class="galeria">


        <div class="foto-contenedor">

            <h3>
                Foto del rehén
            </h3>


            @if($rehen->foto_rehen)

                <img
                    src="{{ asset('storage/' . $rehen->foto_rehen) }}"
                    class="foto-grande"
                    alt="Foto del rehén"
                >

            @else

                <div class="sin-foto-grande">

                    Sin foto

                </div>

            @endif

        </div>


    </div>


</div>

@endsection