@extends('layout.app')

@section('title', 'DNI Rehenes')


@push('styles')

<style>

    .rehenes-pagina {
        max-width: 1100px;
        margin: 0 auto;
    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .rehenes-cabecera {

        display: flex;

        align-items: center;

        gap: 14px;

        margin-bottom: 20px;
    }


    .rehenes-cabecera h1 {
        margin: 0;
    }


    .boton-anadir {

        margin-left: auto;

        padding: 8px 12px;

        border: 0;

        border-radius: 6px;

        background: #198754;

        color: white;

        cursor: pointer;

        font-size: 14px;
    }


    .boton-anadir:hover {
        background: #157347;
    }


    /* =====================================================
       TABLA
    ===================================================== */

    .tabla-rehenes-contenedor {

        overflow-x: auto;

        border-radius: 8px;

        background: white;

        box-shadow:
            0 3px 12px rgba(0, 0, 0, 0.08);
    }


    .tabla-rehenes {

        width: 100%;

        border-collapse: collapse;
    }


    .tabla-rehenes th,
    .tabla-rehenes td {

        padding: 14px 12px;

        border-bottom: 1px solid #e5e5e5;

        text-align: left;

        vertical-align: middle;
    }


    .tabla-rehenes th {

        background: #222;

        color: white;

        font-weight: bold;
    }


    .tabla-rehenes tr:hover {

        background: #f7f7f7;
    }


    /* =====================================================
       COLUMNA ACCIONES
    ===================================================== */

    .tabla-rehenes th:last-child,
    .tabla-rehenes td:last-child {

        text-align: left;

        white-space: nowrap;
    }


    .acciones-rehenes {

        display: flex;

        align-items: center;

        justify-content: flex-start;

        gap: 6px;

        white-space: nowrap;
    }


    .acciones-rehenes form {

        margin: 0;

        padding: 0;
    }


    /* =====================================================
       BOTONES ACCIONES
    ===================================================== */

    .accion-icono {

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

        transition: 0.15s ease;
    }


    /* VER */

    .accion-ver {

        background: #198754;
    }


    .accion-ver:hover {

        background: #157347;
    }


    /* EDITAR */

    .accion-editar {

        background: #f08c00;
    }


    .accion-editar:hover {

        background: #d97d00;
    }


    /* ELIMINAR */

    .accion-eliminar {

        background: #dc3545;
    }


    .accion-eliminar:hover {

        background: #bb2d3b;
    }


    /* =====================================================
       MODAL
    ===================================================== */

    .modal-rehen {

        display: none;

        position: fixed;

        inset: 0;

        z-index: 1500;

        align-items: center;

        justify-content: center;

        padding: 20px;

        background: rgba(0, 0, 0, 0.45);
    }


    .modal-rehen.abierto {

        display: flex;
    }


    .modal-contenido {

        width: min(650px, 100%);

        max-height: 90vh;

        overflow-y: auto;

        padding: 24px;

        border-radius: 10px;

        background: white;

        box-shadow:
            0 5px 20px rgba(0, 0, 0, 0.2);
    }


    .modal-cabecera {

        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 16px;

        margin-bottom: 20px;
    }


    .modal-cabecera h2 {

        margin: 0;
    }


    .modal-cerrar {

        border: 0;

        background: transparent;

        color: #555;

        font-size: 28px;

        cursor: pointer;
    }


    /* =====================================================
       FORMULARIO
    ===================================================== */

    .campo-rehen {

        margin-bottom: 20px;
    }


    .campo-rehen label {

        display: block;

        margin-bottom: 8px;

        font-weight: bold;
    }


    .campo-rehen input {

        width: 100%;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 6px;

        font: inherit;
    }


    /* =====================================================
       FOTOS
    ===================================================== */

    .fotos-formulario {

        display: flex;

        justify-content: center;

        margin: 25px 0;
    }


    .campo-foto {

        display: flex;

        flex-direction: column;

        align-items: center;
    }


    .campo-foto label {

        font-weight: bold;

        margin-bottom: 10px;
    }


    .zona-foto {

        width: 200px;

        height: 200px;

        border: 2px dashed #aaa;

        border-radius: 10px;

        background: #f8f8f8;

        display: flex;

        justify-content: center;

        align-items: center;

        position: relative;

        overflow: hidden;

        cursor: pointer;

        transition: 0.2s ease;
    }


    .zona-foto:hover {

        border-color: #222;

        background: #f1f1f1;
    }


    .zona-foto.activa {

        border-color: #198754;

        background: #eaf7ef;
    }


    .texto-pegar {

        text-align: center;

        color: #777;

        font-size: 13px;

        padding: 15px;

        pointer-events: none;
    }


    .texto-pegar .icono {

        display: block;

        font-size: 32px;

        margin-bottom: 8px;
    }


    .preview {

        width: 100%;

        height: 100%;

        object-fit: cover;

        position: absolute;

        inset: 0;

        display: none;
    }


    .input-foto {

        display: none;
    }


    .boton-guardar {

        padding: 11px 16px;

        border: 0;

        border-radius: 6px;

        background: #198754;

        color: white;

        cursor: pointer;

        font: inherit;
    }


    .boton-guardar:hover {

        background: #157347;
    }


    /* =====================================================
       MENSAJES
    ===================================================== */

    .alerta-rehen {

        margin-bottom: 18px;

        padding: 12px 16px;

        border-radius: 6px;

        background: #f8d7da;

        color: #721c24;
    }


    .mensaje-rehen {

        margin-bottom: 18px;

        padding: 12px 16px;

        border-radius: 6px;

        background: #d4edda;

        color: #155724;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 700px) {

        .rehenes-cabecera {

            align-items: flex-start;

            flex-direction: column;
        }


        .boton-anadir {

            margin-left: 0;

            width: 100%;
        }

    }

</style>

@endpush



@section('content')

<div class="rehenes-pagina">


    {{-- =====================================================
         CABECERA
    ====================================================== --}}

    <div class="rehenes-cabecera">

        <h1>
            DNI Rehenes
        </h1>


        @if($esDirectiva)

            <button
                type="button"
                class="boton-anadir"
                id="abrir-modal-rehen"
            >
                + Añadir
            </button>

        @endif

    </div>



    {{-- =====================================================
         MENSAJE
    ====================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje-rehen">

            {{ session('mensaje') }}

        </div>

    @endif



    {{-- =====================================================
         ERRORES
    ====================================================== --}}

    @if($errors->any())

        <div class="alerta-rehen">

            {{ $errors->first() }}

        </div>

    @endif



    {{-- =====================================================
         TABLA
    ====================================================== --}}

    <div class="tabla-rehenes-contenedor">

        <table class="tabla-rehenes">

            <thead>

                <tr>

                    <th>
                        Agente
                    </th>

                    <th>
                        Placa
                    </th>

                    <th>
                        Causa
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

                @forelse($rehenes as $rehen)

                    <tr>

                        {{-- AGENTE --}}

                        <td>

                            {{ $rehen->agente_nombre ?: 'Agente no encontrado' }}

                        </td>


                        {{-- PLACA --}}

                        <td>

                            {{ $rehen->placa ?: 'Sin placa' }}

                        </td>


                        {{-- CAUSA --}}

                        <td>

                            {{ $rehen->causa }}

                        </td>


                        {{-- FECHA --}}

                        <td>

                            {{ $rehen->fecha_registro }}

                        </td>


                        {{-- ACCIONES --}}

                        <td>

                            <div class="acciones-rehenes">


                                {{-- VER --}}

                                <a
                                    href="{{ route('dni-rehenes.show', $rehen->id) }}"
                                    class="accion-icono accion-ver"
                                    title="Ver"
                                    aria-label="Ver"
                                >
                                    👁️
                                </a>



                                @if($esDirectiva)


                                    {{-- EDITAR --}}

                                    <a
                                        href="{{ route('dni-rehenes.edit', $rehen->id) }}"
                                        class="accion-icono accion-editar"
                                        title="Editar"
                                        aria-label="Editar"
                                    >
                                        ✏️
                                    </a>



                                    {{-- ELIMINAR --}}

                                    <form
                                        action="{{ route('dni-rehenes.destroy', $rehen->id) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar este registro?');"
                                    >

                                        @csrf

                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="accion-icono accion-eliminar"
                                            title="Eliminar"
                                            aria-label="Eliminar"
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

                            No hay DNI de rehenes registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- =========================================================
     MODAL CREAR
========================================================= --}}

@if($esDirectiva)

<div
    class="modal-rehen"
    id="modal-rehen"
    role="dialog"
    aria-modal="true"
    aria-labelledby="titulo-modal-rehen"
>

    <section class="modal-contenido">


        <div class="modal-cabecera">

            <h2 id="titulo-modal-rehen">

                Añadir DNI de rehén

            </h2>


            <button
                type="button"
                class="modal-cerrar"
                id="cerrar-modal-rehen"
                aria-label="Cerrar"
            >

                &times;

            </button>

        </div>



        <form
            action="{{ route('dni-rehenes.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf



            {{-- CAUSA --}}

            <div class="campo-rehen">

                <label for="causa">

                    Causa

                </label>


                <input
                    type="text"
                    id="causa"
                    name="causa"
                    maxlength="45"
                    required
                >

            </div>



            {{-- FOTO REHÉN --}}

            <div class="fotos-formulario">

                <div class="campo-foto">

                    <label>

                        Foto rehén

                    </label>


                    <div
                        class="zona-foto"
                        data-input="foto_rehen"
                        tabindex="0"
                    >

                        <div class="texto-pegar">

                            <span class="icono">

                                📋

                            </span>


                            <strong>

                                Pega aquí

                            </strong>


                            <br>


                            Ctrl + V


                            <br>


                            <small>

                                También puedes arrastrar una imagen

                            </small>

                        </div>


                        <img
                            id="preview_foto_rehen"
                            class="preview"
                            alt="Vista previa rehén"
                        >

                    </div>


                    <input
                        type="file"
                        id="foto_rehen"
                        name="foto_rehen"
                        class="input-foto"
                        accept="image/*"
                    >

                </div>

            </div>



            {{-- BOTÓN --}}

            <button
                type="submit"
                class="boton-guardar"
            >

                Guardar

            </button>


        </form>

    </section>

</div>

@endif

@endsection



{{-- =========================================================
     JAVASCRIPT
========================================================= --}}

@if($esDirectiva)

@push('scripts')

<script>


/*
|--------------------------------------------------------------------------
| MODAL
|--------------------------------------------------------------------------
*/

const modalRehen =
    document.getElementById(
        'modal-rehen'
    );


const abrirModalRehen =
    document.getElementById(
        'abrir-modal-rehen'
    );


const cerrarModalRehen =
    document.getElementById(
        'cerrar-modal-rehen'
    );


if (abrirModalRehen) {

    abrirModalRehen.addEventListener(
        'click',
        function () {

            modalRehen.classList.add(
                'abierto'
            );

        }
    );

}


if (cerrarModalRehen) {

    cerrarModalRehen.addEventListener(
        'click',
        function () {

            modalRehen.classList.remove(
                'abierto'
            );

        }
    );

}


if (modalRehen) {

    modalRehen.addEventListener(
        'click',
        function (event) {

            if (
                event.target === modalRehen
            ) {

                modalRehen.classList.remove(
                    'abierto'
                );

            }

        }
    );

}



/*
|--------------------------------------------------------------------------
| ZONA DE FOTO
|--------------------------------------------------------------------------
*/

let zonaSeleccionada = null;


document
    .querySelectorAll('.zona-foto')
    .forEach(function (zona) {


        zona.addEventListener(
            'click',
            function () {


                document
                    .querySelectorAll(
                        '.zona-foto'
                    )
                    .forEach(
                        function (z) {

                            z.classList.remove(
                                'activa'
                            );

                        }
                    );


                zona.classList.add(
                    'activa'
                );


                zonaSeleccionada =
                    zona;


                zona.focus();

            }
        );

    });



/*
|--------------------------------------------------------------------------
| PEGAR CON CTRL + V
|--------------------------------------------------------------------------
*/

document.addEventListener(
    'paste',
    function (event) {


        if (!zonaSeleccionada) {

            return;

        }


        const items =
            event.clipboardData.items;


        for (
            let i = 0;
            i < items.length;
            i++
        ) {


            const item =
                items[i];


            if (
                !item.type.startsWith(
                    'image/'
                )
            ) {

                continue;

            }


            const file =
                item.getAsFile();


            if (!file) {

                continue;

            }


            const inputId =
                zonaSeleccionada.dataset.input;


            const input =
                document.getElementById(
                    inputId
                );


            if (!input) {

                return;

            }


            const dataTransfer =
                new DataTransfer();


            dataTransfer.items.add(
                file
            );


            input.files =
                dataTransfer.files;


            const preview =
                document.getElementById(
                    'preview_' + inputId
                );


            const texto =
                zonaSeleccionada.querySelector(
                    '.texto-pegar'
                );


            preview.src =
                URL.createObjectURL(
                    file
                );


            preview.style.display =
                'block';


            if (texto) {

                texto.style.display =
                    'none';

            }


            event.preventDefault();


            break;

        }

    }
);



/*
|--------------------------------------------------------------------------
| ARRASTRAR IMAGEN
|--------------------------------------------------------------------------
*/

document
    .querySelectorAll('.zona-foto')
    .forEach(function (zona) {


        zona.addEventListener(
            'dragover',
            function (event) {

                event.preventDefault();

                zona.classList.add(
                    'activa'
                );

            }
        );


        zona.addEventListener(
            'dragleave',
            function () {

                zona.classList.remove(
                    'activa'
                );

            }
        );


        zona.addEventListener(
            'drop',
            function (event) {


                event.preventDefault();


                zona.classList.remove(
                    'activa'
                );


                zonaSeleccionada =
                    zona;


                const files =
                    event.dataTransfer.files;


                if (
                    !files ||
                    files.length === 0
                ) {

                    return;

                }


                const file =
                    files[0];


                if (
                    !file.type.startsWith(
                        'image/'
                    )
                ) {

                    alert(
                        'Solo puedes subir imágenes.'
                    );

                    return;

                }


                const inputId =
                    zona.dataset.input;


                const input =
                    document.getElementById(
                        inputId
                    );


                if (!input) {

                    return;

                }


                const dataTransfer =
                    new DataTransfer();


                dataTransfer.items.add(
                    file
                );


                input.files =
                    dataTransfer.files;


                const preview =
                    document.getElementById(
                        'preview_' + inputId
                    );


                preview.src =
                    URL.createObjectURL(
                        file
                    );


                preview.style.display =
                    'block';


                const texto =
                    zona.querySelector(
                        '.texto-pegar'
                    );


                if (texto) {

                    texto.style.display =
                        'none';

                }

            }
        );

    });

</script>

@endpush

@endif