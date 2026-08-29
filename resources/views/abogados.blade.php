@extends('layout.app')

@section('title', 'Abogados')

@push('styles')
<style>

    .abogados-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .abogados-cabecera {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 20px;
    }

    .abogados-cabecera h1 {
        margin: 0 0 8px;
    }

    .abogados-cabecera p {
        margin: 0;
        color: #666;
    }

    .boton-editar {
        display: inline-flex;
        align-items: center;
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

    .mensaje-abogados {
        margin-bottom: 15px;
        padding: 12px 16px;
        border-radius: 6px;
        background: #d1e7dd;
        color: #0f5132;
    }

    .abogados-lista {
        display: grid;
        gap: 12px;
    }

    .abogado {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        padding: 17px 20px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .abogado-nombre {
        font-size: 16px;
        font-weight: 600;
    }

    .abogado-contacto {
        margin-top: 5px;
        color: #666;
        font-size: 13px;
    }

    .abogado-oficio {
        display: inline-block;
        margin-left: 5px;
        padding: 3px 7px;
        border-radius: 4px;
        background: #e9ecef;
        color: #495057;
        font-size: 11px;
        font-weight: bold;
    }

    .sin-abogados {
        padding: 25px;
        border-radius: 8px;
        background: white;
        color: #666;
        text-align: center;
    }

    @media (max-width: 600px) {

        .abogados-cabecera {
            align-items: flex-start;
            flex-direction: column;
        }

        .boton-editar {
            width: 100%;
            justify-content: center;
            box-sizing: border-box;
        }

        .abogado {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

    }

</style>
@endpush


@section('content')

<div class="abogados-pagina">

    <div class="abogados-cabecera">

        <div>

            <h1>
                ⚖️ Abogados
            </h1>

            <p>
                Tablón informativo de abogados disponibles.
            </p>

        </div>


        @if($esDirectiva)

            <a
                href="{{ route('abogados.edit') }}"
                class="boton-editar"
            >
                ✏️ Editar tablón
            </a>

        @endif

    </div>


    @if(session('mensaje'))

        <div class="mensaje-abogados">
            {{ session('mensaje') }}
        </div>

    @endif


    <div class="abogados-lista">

        @forelse($abogados as $abogado)

            <article class="abogado">

    <div class="abogado-info">

        <span class="abogado-nombre">
            ⚖️ {{ $abogado['nombre'] }}
        </span>

        @if(!empty($abogado['oficio']))

            @if(!empty($abogado['contacto']))

                <span class="abogado-contacto">
                    Contacto:
                    <strong>
                        {{ $abogado['contacto'] }} OFICIO
                    </strong>
                </span>

            @else

                <span class="abogado-oficio-texto">
                    <strong>OFICIO</strong>
                </span>

            @endif

        @elseif(!empty($abogado['contacto']))

            <span class="abogado-contacto">
                Contacto:
                <strong>
                    {{ $abogado['contacto'] }}
                </strong>
            </span>

        @endif

    </div>

</article>

        @empty

            <div class="sin-abogados">
                No hay abogados registrados.
            </div>

        @endforelse

    </div>

</div>

@endsection