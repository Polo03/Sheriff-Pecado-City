@extends('layout.app')

@section('title', 'Procedimientos')

@push('styles')
<style>

    .procedimientos-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .procedimientos-cabecera {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        margin-bottom: 20px;

        text-align: left;
    }

    .procedimientos-cabecera h1 {
        margin: 0 0 8px;
        text-align: left;
    }

    .procedimientos-cabecera p {
        margin: 0;
        color: #666;
        text-align: left;
    }


    /* =====================================================
       BOTÓN NUEVO
    ===================================================== */

    .boton-nuevo {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        gap: 6px;

        padding: 10px 14px;

        border-radius: 6px;

        background: #198754;
        color: white;

        text-decoration: none;

        font-size: 14px;
        font-weight: bold;

        white-space: nowrap;
    }

    .boton-nuevo:hover {
        background: #157347;
        color: white;
    }


    /* =====================================================
       MENSAJE
    ===================================================== */

    .mensaje-procedimientos {
        margin-bottom: 15px;

        padding: 12px 16px;

        border-radius: 6px;

        background: #d1e7dd;

        color: #0f5132;

        text-align: left;
    }


    /* =====================================================
       ACORDEÓN
    ===================================================== */

    .procedimiento-acordeon {
        width: 100%;

        margin-bottom: 12px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);

        overflow: hidden;

        text-align: left;
    }

    .procedimiento-acordeon summary {
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

    .procedimiento-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .procedimiento-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .procedimiento-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .procedimiento-acordeon summary:hover {
        background: #f5f5f5;
    }


    /* =====================================================
       CONTENIDO
    ===================================================== */

    .procedimiento-contenido {
        width: 100%;

        box-sizing: border-box;

        padding: 15px 20px 20px;

        border-top: 1px solid #eee;

        text-align: left;
    }


    /* =====================================================
       FECHA
    ===================================================== */

    .procedimiento-fecha {
        margin: 0 0 8px;

        color: #888;

        font-size: 12px;

        text-align: left;
    }


    /* =====================================================
       TEXTO DEL PROCEDIMIENTO
       MISMO ESTILO QUE PEAS Y BINDEOS
    ===================================================== */

    .procedimiento-texto {
        display: block;

        width: 100%;

        box-sizing: border-box;

        margin: 0;

        padding: 10px 12px;

        border-radius: 5px;

        background: #1f1f1f;

        color: #f1f1f1;

        font-family: Consolas, Monaco, monospace;

        font-size: 12px;

        line-height: 1.5;

        text-align: left;

        white-space: normal;

        overflow-wrap: anywhere;

        word-break: break-word;
    }


    /* =====================================================
       ACCIONES DIRECTIVA
    ===================================================== */

    .procedimiento-acciones {
        display: flex;

        align-items: center;

        gap: 8px;

        margin-top: 15px;

        text-align: left;
    }


    .boton-editar {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 7px 11px;

        border: none;

        border-radius: 5px;

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


    .boton-eliminar {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        padding: 7px 11px;

        border: none;

        border-radius: 5px;

        background: #dc3545;

        color: white;

        cursor: pointer;

        font-size: 13px;

        font-weight: bold;
    }

    .boton-eliminar:hover {
        background: #bb2d3b;
    }


    /* =====================================================
       SIN PROCEDIMIENTOS
    ===================================================== */

    .sin-procedimientos {
        padding: 40px 20px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);

        text-align: center;

        color: #777;
    }

    .sin-procedimientos .icono {
        display: block;

        margin-bottom: 10px;

        font-size: 35px;
    }


    /* =====================================================
       MÓVIL
    ===================================================== */

    @media (max-width: 600px) {

        .procedimientos-cabecera {
            align-items: flex-start;

            flex-direction: column;
        }

        .boton-nuevo {
            width: 100%;

            box-sizing: border-box;
        }

        .procedimiento-contenido {
            padding: 12px 15px 15px;
        }

        .procedimiento-texto {
            padding: 9px 10px;

            font-size: 11px;
        }

        .procedimiento-acciones {
            flex-wrap: wrap;
        }

    }

</style>
@endpush


@section('content')

<div class="procedimientos-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="procedimientos-cabecera">

        <div>

            <h1>
                📢 Procedimientos
            </h1>

            <p>
                Tablón oficial de procedimientos y comunicados del Departamento del Sheriff.
            </p>

        </div>


        @if($esDirectiva)

            <a
                href="{{ route('procedimientos.create') }}"
                class="boton-nuevo"
            >
                ➕ Nuevo anuncio
            </a>

        @endif

    </div>


    {{-- =====================================================
         MENSAJE
    ===================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje-procedimientos">
            {{ session('mensaje') }}
        </div>

    @endif


    {{-- =====================================================
         PROCEDIMIENTOS
    ===================================================== --}}

    @forelse($procedimientos as $procedimiento)

        <details class="procedimiento-acordeon">

            <summary>

                📢

                <span>
                    {{ $procedimiento['titulo'] }}
                </span>

            </summary>


            <div class="procedimiento-contenido">

                {{-- CONTENIDO --}}

                <div class="procedimiento-texto">

                    {{ $procedimiento['contenido'] }}

                </div>


                {{-- ACCIONES DE DIRECTIVA --}}

                @if($esDirectiva)

                    <div class="procedimiento-acciones">

                        <a
                            href="{{ route('procedimientos.edit', $procedimiento['id']) }}"
                            class="boton-editar"
                        >
                            ✏️ Editar
                        </a>


                        <form
                            action="{{ route('procedimientos.destroy', $procedimiento['id']) }}"
                            method="POST"
                            onsubmit="return confirm('¿Seguro que quieres eliminar este procedimiento?');"
                        >

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="boton-eliminar"
                            >
                                🗑️ Eliminar
                            </button>

                        </form>

                    </div>

                @endif


            </div>

        </details>

    @empty

        <div class="sin-procedimientos">

            <span class="icono">
                📢
            </span>

            <strong>
                No hay procedimientos publicados.
            </strong>

            <p>
                Cuando la Directiva publique un procedimiento,
                aparecerá aquí.
            </p>

        </div>

    @endforelse


</div>

@endsection