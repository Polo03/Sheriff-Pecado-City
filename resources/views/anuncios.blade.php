@extends('layout.app')

@section('title', $titulo)

@push('styles')
<style>

    .anuncios-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .anuncio-meta-cabecera {
        margin-left: auto;

        color: #777;

        font-size: 13px;

        font-weight: normal;

        white-space: nowrap;
    }

    .anuncios-cabecera {
        display: flex;
        align-items: center;
        justify-content: space-between;

        gap: 20px;
        margin-bottom: 20px;
    }

    .anuncios-cabecera h1 {
        margin: 0;
    }


    /* =====================================================
       BOTÓN PUBLICAR
    ===================================================== */

    .boton-publicar {
        display: inline-flex;
        align-items: center;
        justify-content: center;

        padding: 10px 14px;

        border: none;
        border-radius: 6px;

        background: #198754;
        color: white;

        cursor: pointer;

        font-size: 14px;
        font-weight: bold;

        white-space: nowrap;
    }

    .boton-publicar:hover {
        background: #157347;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .anuncio-acordeon {
        width: 100%;

        margin-bottom: 12px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);

        overflow: hidden;

        text-align: left;
    }

    .anuncio-acordeon summary {
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
    }

    .anuncio-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .anuncio-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .anuncio-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .anuncio-acordeon summary:hover {
        background: #f5f5f5;
    }


    /* =====================================================
       CONTENIDO
    ===================================================== */

    .anuncio-contenido {
        width: 100%;

        box-sizing: border-box;

        padding: 15px 20px 20px;

        border-top: 1px solid #eee;

        text-align: left;
    }


    /* =====================================================
       DESCRIPCIÓN
    ===================================================== */

    .anuncio-texto {
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
       AUTOR / FECHA
    ===================================================== */

    .anuncio-meta {
        margin-top: 10px;

        color: #666;

        font-size: 13px;
    }


    /* =====================================================
       ACCIONES
    ===================================================== */

    .anuncio-acciones {
        display: flex;

        align-items: center;

        justify-content: flex-end;

        gap: 8px;

        margin-top: 15px;
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

        cursor: pointer;

        font-size: 13px;
        font-weight: bold;
    }

    .boton-editar:hover {
        background: #d97700;
    }


    .boton-eliminar {
        display: inline-flex;

        align-items: center;
        justify-content: center;

        width: 32px;
        height: 32px;

        padding: 0;

        border: none;
        border-radius: 5px;

        background: #dc3545;
        color: white;

        cursor: pointer;

        font-size: 14px;
    }

    .boton-eliminar:hover {
        background: #bb2d3b;
    }


    /* =====================================================
       MODAL
    ===================================================== */

    .modal-anuncio {
        display: none;

        position: fixed;

        inset: 0;

        z-index: 1500;

        align-items: center;
        justify-content: center;

        padding: 20px;

        background: rgba(0, 0, 0, 0.45);
    }

    .modal-anuncio.abierto {
        display: flex;
    }

    .modal-contenido {
        width: min(520px, 100%);

        padding: 24px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    }

    .modal-cabecera {
        display: flex;

        align-items: center;
        justify-content: space-between;

        gap: 15px;

        margin-bottom: 20px;
    }

    .modal-cabecera h2 {
        margin: 0;
    }

    .modal-cerrar {
        border: none;

        background: transparent;

        color: #555;

        font-size: 25px;

        cursor: pointer;
    }


    /* =====================================================
       CAMPOS
    ===================================================== */

    .campo {
        margin-bottom: 17px;
    }

    .campo label {
        display: block;

        margin-bottom: 7px;

        color: #333;

        font-size: 14px;
        font-weight: bold;
    }

    .campo input,
    .campo textarea {
        width: 100%;

        box-sizing: border-box;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 6px;

        font: inherit;
    }

    .campo textarea {
        min-height: 160px;

        resize: vertical;
    }

    .campo input:focus,
    .campo textarea:focus {
        outline: none;

        border-color: #198754;
    }


    /* =====================================================
       BOTÓN GUARDAR
    ===================================================== */

    .boton-guardar {
        width: 100%;

        padding: 11px;

        border: none;
        border-radius: 6px;

        background: #198754;
        color: white;

        cursor: pointer;

        font: inherit;
        font-weight: bold;
    }

    .boton-guardar:hover {
        background: #157347;
    }


    /* =====================================================
       VACÍO
    ===================================================== */

    .anuncios-vacio {
        color: #666;
    }


    /* =====================================================
       MÓVIL
    ===================================================== */

    @media (max-width: 600px) {

        .anuncios-cabecera {
            align-items: flex-start;

            flex-direction: column;
        }

        .boton-publicar {
            width: 100%;
        }

        .anuncio-contenido {
            padding: 12px 15px 15px;
        }

        .anuncio-texto {
            font-size: 11px;
        }

    }

</style>
@endpush


@section('content')

<div class="anuncios-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="anuncios-cabecera">

        <h1>
            {{ $titulo }}
        </h1>


        @if($puedePublicar)

            <button
                type="button"
                class="boton-publicar"
                id="abrir-modal-anuncio"
            >
                📢 Publicar anuncio
            </button>

        @endif

    </div>


    {{-- =====================================================
         LISTADO
    ===================================================== --}}

    <div class="anuncios-lista">

        @forelse($anuncios as $anuncio)

            <details class="anuncio-acordeon">

                {{-- TÍTULO DEL ACORDEÓN --}}

                <summary>

                    📢

                    <span class="anuncio-titulo">
                        {{ $anuncio->titulo }}
                    </span>

                    <span class="anuncio-meta-cabecera">
                        {{ $anuncio->autor }} · {{ $anuncio->created_at }}
                    </span>

                </summary>


                {{-- CONTENIDO --}}

                <div class="anuncio-contenido">


                    {{-- DESCRIPCIÓN --}}

                    <div class="anuncio-texto">

                        {{ $anuncio->contenido }}

                    </div>

                    {{-- ACCIONES DIRECTIVA --}}

                    @if($puedePublicar)

                        <div class="anuncio-acciones">


                            {{-- EDITAR --}}

                            <button
                                type="button"
                                class="boton-editar"
                                onclick="abrirEditarAnuncio(
                                    {{ $anuncio->id }},
                                    @js($anuncio->titulo),
                                    @js($anuncio->contenido)
                                )"
                            >
                                ✏️ Editar
                            </button>


                            {{-- ELIMINAR --}}

                            <form
                                action="{{
                                    match($rutaPublicar) {

                                        'briefing' =>
                                            route(
                                                'briefing.destroy',
                                                $anuncio->id
                                            ),

                                        'plantilla-mensajes' =>
                                            route(
                                                'plantilla-mensajes.destroy',
                                                $anuncio->id
                                            ),

                                        default =>
                                            route(
                                                'anuncios.destroy',
                                                $anuncio->id
                                            ),
                                    }
                                }}"
                                method="POST"

                                onsubmit="
                                    return confirm(
                                        '¿Seguro que quieres eliminar este anuncio?'
                                    );
                                "
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    class="boton-eliminar"
                                    title="Eliminar"
                                >
                                    🗑️
                                </button>

                            </form>

                        </div>

                    @endif


                </div>

            </details>

        @empty

            <p class="anuncios-vacio">
                No hay anuncios publicados.
            </p>

        @endforelse

    </div>

</div>


{{-- =====================================================
     MODAL CREAR
===================================================== --}}

@if($puedePublicar)

<div
    class="modal-anuncio"
    id="modal-anuncio"
>

    <section class="modal-contenido">

        <div class="modal-cabecera">

            <h2>
                📢 Nuevo anuncio
            </h2>

            <button
                type="button"
                class="modal-cerrar"
                id="cerrar-modal-anuncio"
            >
                &times;
            </button>

        </div>


        <form
            action="{{ route($rutaPublicar . '.store') }}"
            method="POST"
        >

            @csrf


            {{-- TÍTULO --}}

            <div class="campo">

                <label for="titulo">
                    Título
                </label>

                <input
                    type="text"
                    id="titulo"
                    name="titulo"
                    maxlength="150"
                    placeholder="Ejemplo: Nuevo procedimiento policial"
                    required
                >

            </div>


            {{-- DESCRIPCIÓN --}}

            <div class="campo">

                <label for="contenido">
                    Descripción
                </label>

                <textarea
                    id="contenido"
                    name="contenido"
                    maxlength="2000"
                    placeholder="Escribe aquí el contenido del anuncio..."
                    required
                ></textarea>

            </div>


            <button
                type="submit"
                class="boton-guardar"
            >
                📢 Publicar anuncio
            </button>

        </form>

    </section>

</div>


{{-- =====================================================
     MODAL EDITAR
===================================================== --}}

<div
    class="modal-anuncio"
    id="modal-editar-anuncio"
>

    <section class="modal-contenido">

        <div class="modal-cabecera">

            <h2>
                ✏️ Editar anuncio
            </h2>

            <button
                type="button"
                class="modal-cerrar"
                id="cerrar-modal-editar"
            >
                &times;
            </button>

        </div>


        <form
            id="form-editar-anuncio"
            method="POST"
        >

            @csrf

            @method('PUT')


            {{-- TÍTULO --}}

            <div class="campo">

                <label for="titulo-editar">
                    Título
                </label>

                <input
                    type="text"
                    id="titulo-editar"
                    name="titulo"
                    maxlength="150"
                    required
                >

            </div>


            {{-- DESCRIPCIÓN --}}

            <div class="campo">

                <label for="contenido-editar">
                    Descripción
                </label>

                <textarea
                    id="contenido-editar"
                    name="contenido"
                    maxlength="2000"
                    required
                ></textarea>

            </div>


            <button
                type="submit"
                class="boton-guardar"
            >
                💾 Guardar cambios
            </button>

        </form>

    </section>

</div>

@endif

@endsection


@push('scripts')

<script>

    /*
    |--------------------------------------------------------------------------
    | MODAL CREAR
    |--------------------------------------------------------------------------
    */

    const modalAnuncio =
        document.getElementById('modal-anuncio');

    const abrirModalAnuncio =
        document.getElementById('abrir-modal-anuncio');

    const cerrarModalAnuncio =
        document.getElementById('cerrar-modal-anuncio');


    if (abrirModalAnuncio) {

        abrirModalAnuncio.addEventListener(
            'click',
            function () {

                modalAnuncio.classList.add('abierto');

            }
        );

    }


    if (cerrarModalAnuncio) {

        cerrarModalAnuncio.addEventListener(
            'click',
            function () {

                modalAnuncio.classList.remove('abierto');

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | MODAL EDITAR
    |--------------------------------------------------------------------------
    */

    const modalEditar =
        document.getElementById('modal-editar-anuncio');

    const cerrarModalEditar =
        document.getElementById('cerrar-modal-editar');

    const formEditar =
        document.getElementById('form-editar-anuncio');

    const tituloEditar =
        document.getElementById('titulo-editar');

    const contenidoEditar =
        document.getElementById('contenido-editar');


    function abrirEditarAnuncio(
        id,
        titulo,
        contenido
    ) {

        tituloEditar.value = titulo;

        contenidoEditar.value = contenido;


        @if($rutaPublicar === 'briefing')

            formEditar.action =
                "{{ url('/briefing') }}/" + id;

        @elseif($rutaPublicar === 'plantilla-mensajes')

            formEditar.action =
                "{{ url('/plantilla-mensajes') }}/" + id;

        @else

            formEditar.action =
                "{{ url('/anuncios') }}/" + id;

        @endif


        modalEditar.classList.add('abierto');

    }


    if (cerrarModalEditar) {

        cerrarModalEditar.addEventListener(
            'click',
            function () {

                modalEditar.classList.remove('abierto');

            }
        );

    }


    /*
    |--------------------------------------------------------------------------
    | CERRAR AL PULSAR FUERA
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'click',
        function (event) {

            if (
                event.target === modalAnuncio
            ) {

                modalAnuncio.classList.remove(
                    'abierto'
                );

            }


            if (
                event.target === modalEditar
            ) {

                modalEditar.classList.remove(
                    'abierto'
                );

            }

        }
    );


    /*
    |--------------------------------------------------------------------------
    | ESC
    |--------------------------------------------------------------------------
    */

    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key !== 'Escape') {
                return;
            }


            if (modalAnuncio) {

                modalAnuncio.classList.remove(
                    'abierto'
                );

            }


            if (modalEditar) {

                modalEditar.classList.remove(
                    'abierto'
                );

            }

        }
    );

</script>

@endpush