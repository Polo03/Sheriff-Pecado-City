@extends('layout.app')

@section('title', 'Drogas DNI')

@push('styles')

<style>

    .drogas-pagina {
        max-width: 1100px;
        margin: 0 auto;
    }


    .drogas-cabecera {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }


    .drogas-cabecera h1 {
        margin: 0;
    }


    .buscador-drogas {
        display: flex;
        width: min(460px, 100%);
        gap: 6px;
        margin-left: auto;
    }


    .buscador-drogas input {
        width: 100%;
        min-width: 0;
        padding: 8px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 13px;
    }


    .boton-anadir-drogas {
        padding: 8px 12px;
        border: 0;
        border-radius: 5px;
        background: #f08c00;
        color: white;
        cursor: pointer;
        font-size: 13px;
        white-space: nowrap;
    }


    .boton-anadir-drogas:hover {
        background: #d97700;
    }


    /* =====================================================
       TABLA
    ===================================================== */

    .tabla-drogas-contenedor {
        overflow-x: auto;
        border-radius: 8px;
        background: white;
        box-shadow:
            0 3px 12px rgba(0, 0, 0, 0.08);
    }


    .tabla-drogas {
        width: 100%;
        border-collapse: collapse;
    }


    .tabla-drogas th,
    .tabla-drogas td {
        padding: 14px 12px;
        border-bottom: 1px solid #e5e5e5;
        text-align: left;
        vertical-align: middle;
    }


    .tabla-drogas th {
        background: #222;
        color: white;
    }


    .tabla-drogas tr:hover {
        background: #f7f7f7;
    }


    /* =====================================================
       ACCIONES
    ===================================================== */

    .acciones-drogas {
        display: flex;
        gap: 6px;
        align-items: center;
    }


    .acciones-drogas form {
        margin: 0;
    }


    .accion-icono-drogas {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        width: 36px;
        height: 34px;

        border: 0;
        border-radius: 5px;

        color: white;

        font-size: 17px;

        text-decoration: none;

        cursor: pointer;
    }


    .accion-ver-drogas {
        background: #198754;
    }


    .accion-ver-drogas:hover {
        background: #157347;
    }


    .accion-editar-drogas {
        background: #f08c00;
    }


    .accion-editar-drogas:hover {
        background: #d97700;
    }


    .accion-eliminar-drogas {
        background: #dc3545;
    }


    .accion-eliminar-drogas:hover {
        background: #bb2d3b;
    }


    /* =====================================================
       MENSAJES
    ===================================================== */

    .mensaje-drogas {
        margin-bottom: 18px;
        padding: 12px 16px;
        border-radius: 6px;
        background: #d4edda;
        color: #155724;
    }


    .alerta-drogas {
        margin-bottom: 18px;
        padding: 12px 16px;
        border-radius: 6px;
        background: #f8d7da;
        color: #721c24;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 700px) {

        .drogas-cabecera {
            align-items: flex-start;
            flex-direction: column;
        }


        .buscador-drogas {
            width: 100%;
            margin-left: 0;
        }


        .boton-anadir-drogas {
            width: 100%;
        }

    }

</style>

@endpush


@section('content')

<section class="drogas-pagina">


    {{-- =====================================================
         MENSAJE
    ===================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje-drogas">

            {{ session('mensaje') }}

        </div>

    @endif


    {{-- =====================================================
         ERRORES
    ===================================================== --}}

    @if($errors->any())

        <div class="alerta-drogas">

            <strong>
                Se han encontrado los siguientes errores:
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


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="drogas-cabecera">

        <h1>
            Drogas DNI
        </h1>


        <form
            class="buscador-drogas"
            action="{{ route('drogas-dni.index') }}"
            method="GET"
        >

            <input
                type="search"
                name="q"
                value="{{ $busqueda }}"
                placeholder="Buscar por agente, placa o cantidad..."
                aria-label="Buscar"
            >


            @if($esDirectiva)

                <a
                    href="{{ route('drogas-dni.create') }}"
                    class="boton-anadir-drogas"
                >
                    Añadir
                </a>

            @endif

        </form>

    </div>


    {{-- =====================================================
         TABLA
    ===================================================== --}}

    <div class="tabla-drogas-contenedor">

        <table class="tabla-drogas">

            <thead>

                <tr>

                    <th>
                        Agente
                    </th>

                    <th>
                        Placa
                    </th>

                    <th>
                        Cantidad
                    </th>

                    <th>
                        Fecha de registro
                    </th>

                    <th>
                        Acciones
                    </th>

                </tr>

            </thead>


            <tbody>

                @forelse($drogas as $droga)

                    <tr>

                        <td>

                            {{ $droga->agente_nombre ?: 'Agente no encontrado' }}

                        </td>


                        <td>

                            {{ $droga->placa ?: 'Sin placa' }}

                        </td>


                        <td>

                            {{ $droga->cantidad }}

                        </td>


                        <td>

                            {{ $droga->fecha_registro }}

                        </td>


                        <td>

                            <div class="acciones-drogas">


                                {{-- VER --}}

                                <a
                                    href="{{ route('drogas-dni.show', $droga->id) }}"
                                    class="accion-icono-drogas accion-ver-drogas"
                                    title="Ver registro"
                                    aria-label="Ver registro"
                                >
                                    👁️
                                </a>


                                @if($esDirectiva)

                                    {{-- EDITAR --}}

                                    <a
                                        href="{{ route('drogas-dni.edit', $droga->id) }}"
                                        class="accion-icono-drogas accion-editar-drogas"
                                        title="Editar registro"
                                        aria-label="Editar registro"
                                    >
                                        ✏️
                                    </a>


                                    {{-- ELIMINAR --}}

                                    <form
                                        action="{{ route('drogas-dni.destroy', $droga->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Seguro que quieres eliminar este registro?');"
                                    >

                                        @csrf

                                        @method('DELETE')


                                        <button
                                            type="submit"
                                            class="accion-icono-drogas accion-eliminar-drogas"
                                            title="Eliminar registro"
                                            aria-label="Eliminar registro"
                                        >
                                            ➖
                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="5">

                            No hay registros de drogas DNI.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</section>

@endsection