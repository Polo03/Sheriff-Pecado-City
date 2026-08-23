@extends('layout.app')

@section('title', 'Ver Drogas DNI')

@push('styles')

<style>

    .ver-drogas {
        max-width: 1100px;
        margin: 0 auto;
    }


    .cabecera-ver-drogas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
    }


    .cabecera-ver-drogas h1 {
        margin: 0;
    }


    .boton-ver-drogas-pagina {
        display: inline-block;
        padding: 10px 15px;
        border-radius: 7px;
        background: #777;
        color: white;
        text-decoration: none;
    }


    .datos-drogas {
        margin-bottom: 30px;
        padding: 20px;
        background: #f5f5f5;
        border-radius: 10px;
    }


    .dato-drogas {
        margin-bottom: 10px;
    }


    .dato-drogas:last-child {
        margin-bottom: 0;
    }


    .galeria-drogas {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
    }


    .foto-contenedor-drogas {
        text-align: center;
    }


    .foto-contenedor-drogas h3 {
        margin-bottom: 12px;
    }


    .foto-grande-drogas {
        width: 100%;
        height: 400px;
        object-fit: contain;
        background: #f5f5f5;
        border-radius: 10px;
        border: 1px solid #ddd;
    }


    .sin-foto-drogas {
        width: 100%;
        height: 400px;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f5f5f5;
        border-radius: 10px;
        color: #999;
    }


    @media (max-width: 800px) {

        .galeria-drogas {
            grid-template-columns: 1fr;
        }


        .cabecera-ver-drogas {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

    }

</style>

@endpush


@section('content')

<div class="ver-drogas">


    <div class="cabecera-ver-drogas">

        <h1>
            Registro de Drogas DNI
        </h1>


        <a
            href="{{ route('drogas-dni.index') }}"
            class="boton-ver-drogas-pagina"
        >
            ← Volver
        </a>

    </div>


    <div class="datos-drogas">

        <div class="dato-drogas">

            <strong>
                Agente:
            </strong>

            {{ $droga->agente_nombre ?: 'Agente no encontrado' }}

        </div>


        <div class="dato-drogas">

            <strong>
                Placa:
            </strong>

            {{ $droga->placa ?: 'Sin placa' }}

        </div>


        <div class="dato-drogas">

            <strong>
                Cantidad:
            </strong>

            {{ $droga->cantidad }}

        </div>


        <div class="dato-drogas">

            <strong>
                Fecha de registro:
            </strong>

            {{ $droga->fecha_registro }}

        </div>

    </div>


    <div class="galeria-drogas">


        {{-- FOTO DNI --}}

        <div class="foto-contenedor-drogas">

            <h3>
                Foto DNI
            </h3>


            @if($droga->foto_dni)

                <img
                    src="{{ asset('storage/' . $droga->foto_dni) }}"
                    class="foto-grande-drogas"
                    alt="Foto DNI"
                >

            @else

                <div class="sin-foto-drogas">
                    Sin foto
                </div>

            @endif

        </div>


        {{-- FOTO SOSPECHOSO --}}

        <div class="foto-contenedor-drogas">

            <h3>
                Foto del sospechoso
            </h3>


            @if($droga->foto_sospechoso)

                <img
                    src="{{ asset('storage/' . $droga->foto_sospechoso) }}"
                    class="foto-grande-drogas"
                    alt="Foto del sospechoso"
                >

            @else

                <div class="sin-foto-drogas">
                    Sin foto
                </div>

            @endif

        </div>


    </div>

</div>

@endsection