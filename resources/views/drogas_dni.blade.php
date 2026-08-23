@extends('layout.app')

@section('title', 'Drogas DNI')


@push('styles')

<style>

    .drogas-pagina {
        max-width: 1100px;
        margin: 0 auto;
    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .drogas-cabecera {
        display: flex;
        align-items: center;
        gap: 14px;
        margin-bottom: 20px;
    }


    .drogas-cabecera h1 {
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

    .tabla-drogas-contenedor {
        overflow-x: auto;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
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
    }


    .accion-ver {
        background: #198754;
    }


    .accion-ver:hover {
        background: #157347;
    }


    .accion-editar {
        background: #f08c00;
    }


    .accion-editar:hover {
        background: #d97d00;
    }


    .accion-eliminar {
        background: #dc3545;
    }


    .accion-eliminar:hover {
        background: #bb2d3b;
    }


    /* =====================================================
       MODAL
    ===================================================== */

    .modal-droga {

        display: none;

        position: fixed;

        inset: 0;

        z-index: 1500;

        align-items: center;

        justify-content: center;

        padding: 20px;

        background: rgba(0, 0, 0, 0.45);
    }


    .modal-droga.abierto {
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

        line-height: 1;
    }


    .modal-cerrar:hover {
        color: #222;
    }


    /* =====================================================
       CAMPOS
    ===================================================== */

    .campo-droga {
        margin-bottom: 22px;
    }


    .campo-droga label {

        display: block;

        margin-bottom: 8px;

        font-weight: bold;
    }


    .campo-droga input[type="text"] {

        width: 100%;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 6px;

        font: inherit;
    }


    .campo-droga input[type="text"]:focus {

        outline: none;

        border-color: #198754;
    }


    /* =====================================================
       FOTOS
    ===================================================== */

    .fotos-formulario {

        display: flex;

        gap: 25px;

        flex-wrap: wrap;

        margin-top: 20px;

        margin-bottom: 20px;
    }


    .campo-foto {

        display: flex;

        flex-direction: column;

        align-items: center;

        flex: 1;

        min-width: 200px;
    }


    .campo-foto label {

        font-weight: bold;

        margin-bottom: 10px;

        text-align: center;
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


    /* =====================================================
       TEXTO PEGAR
    ===================================================== */

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


    .texto-pegar strong {

        display: block;

        margin-bottom: 5px;

        color: #555;
    }


    /* =====================================================
       PREVIEW
    ===================================================== */

    .preview {

        width: 100%;

        height: 100%;

        object-fit: cover;

        position: absolute;

        top: 0;

        left: 0;

        display: none;
    }


    /* =====================================================
       INPUT OCULTO
    ===================================================== */

    .input-foto {

        display: none;
    }


    /* =====================================================
       BOTÓN GUARDAR
    ===================================================== */

    .boton-guardar {

        margin-top: 15px;

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
       ALERTAS
    ===================================================== */

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


        .boton-anadir {

            margin-left: 0;

            width: 100%;
        }


        .fotos-formulario {

            flex-direction: column;

            align-items: center;
        }

    }

</style>

@endpush



@section('content')

<div class="drogas-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="drogas-cabecera">

        <h1>
            Drogas DNI
        </h1>


        @if($esDirectiva ?? false)

            <button
                type="button"
                class="boton-anadir"
                id="abrir-modal-droga"
            >
                + Añadir
            </button>

        @endif

    </div>



    {{-- =====================================================
         ERRORES
    ===================================================== --}}

    @if($errors->any())

        <div class="alerta-drogas">

            {{ $errors->first() }}

        </div>

    @endif



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

                            {{ $droga->agente_nombre ?? $droga->agente ?? 'Agente no encontrado' }}

                        </td>


                        <td>

                            {{ $droga->placa ?? 'Sin placa' }}

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
                                    class="accion-icono accion-ver"
                                    title="Ver"
                                    aria-label="Ver"
                                >
                                    👁️
                                </a>



                                @if($esDirectiva ?? false)


                                    {{-- EDITAR --}}

                                    <a
                                        href="{{ route('drogas-dni.edit', $droga->id) }}"
                                        class="accion-icono accion-editar"
                                        title="Editar"
                                        aria-label="Editar"
                                    >
                                        ✏️
                                    </a>



                                    {{-- ELIMINAR --}}

                                    <form
                                        action="{{ route('drogas-dni.destroy', $droga->id) }}"
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

                            No hay registros de drogas DNI.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>



{{-- =====================================================
     MODAL CREAR
===================================================== --}}

@if($esDirectiva ?? false)

<div
    class="modal-droga"
    id="modal-droga"
    role="dialog"
    aria-modal="true"
    aria-labelledby="titulo-droga"
>

    <section class="modal-contenido">


        {{-- CABECERA MODAL --}}

        <div class="modal-cabecera">

            <h2 id="titulo-droga">
                Añadir droga DNI
            </h2>


            <button
                type="button"
                class="modal-cerrar"
                id="cerrar-modal-droga"
                aria-label="Cerrar"
            >
                &times;
            </button>

        </div>



        {{-- FORMULARIO --}}

        <form
            action="{{ route('drogas-dni.store') }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf



            {{-- CANTIDAD --}}

            <div class="campo-droga">

                <label for="cantidad">
                    Cantidad
                </label>


                <input
                    type="text"
                    id="cantidad"
                    name="cantidad"
                    value="{{ old('cantidad') }}"
                    required
                >

            </div>



            {{-- FOTOS --}}

            <div class="fotos-formulario">


                {{-- FOTO DNI --}}

                <div class="campo-foto">

                    <label>
                        Foto DNI
                    </label>


                    <div
                        class="zona-foto"
                        data-input="foto_dni"
                        tabindex="0"
                    >

                        <div class="texto-pegar">

                            <span class="icono">
                                📋
                            </span>

                            <strong>
                                Pega aquí
                            </strong>

                            Ctrl + V

                            <br>

                            <small>
                                También puedes arrastrar una imagen
                            </small>

                        </div>


                        <img
                            id="preview_foto_dni"
                            class="preview"
                            alt="Vista previa DNI"
                        >

                    </div>


                    <input
                        type="file"
                        id="foto_dni"
                        name="foto_dni"
                        class="input-foto"
                        accept="image/*"
                    >

                </div>



                {{-- FOTO SOSPECHOSO --}}

                <div class="campo-foto">

                    <label>
                        Foto sospechoso
                    </label>


                    <div
                        class="zona-foto"
                        data-input="foto_sospechoso"
                        tabindex="0"
                    >

                        <div class="texto-pegar">

                            <span class="icono">
                                📋
                            </span>

                            <strong>
                                Pega aquí
                            </strong>

                            Ctrl + V

                            <br>

                            <small>
                                También puedes arrastrar una imagen
                            </small>

                        </div>


                        <img
                            id="preview_foto_sospechoso"
                            class="preview"
                            alt="Vista previa sospechoso"
                        >

                    </div>


                    <input
                        type="file"
                        id="foto_sospechoso"
                        name="foto_sospechoso"
                        class="input-foto"
                        accept="image/*"
                    >

                </div>


            </div>



            {{-- GUARDAR --}}

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



{{-- =====================================================
     JAVASCRIPT
===================================================== --}}

@if($esDirectiva ?? false)

@push('scripts')

<script>


/*
=========================================================
MODAL
=========================================================
*/

const modalDroga =
    document.getElementById(
        'modal-droga'
    );


const abrirModalDroga =
    document.getElementById(
        'abrir-modal-droga'
    );


const cerrarModalDroga =
    document.getElementById(
        'cerrar-modal-droga'
    );



if (abrirModalDroga) {

    abrirModalDroga.addEventListener(
        'click',
        function () {

            modalDroga.classList.add(
                'abierto'
            );

        }
    );

}



if (cerrarModalDroga) {

    cerrarModalDroga.addEventListener(
        'click',
        function () {

            modalDroga.classList.remove(
                'abierto'
            );

        }
    );

}



if (modalDroga) {

    modalDroga.addEventListener(
        'click',
        function (event) {

            if (
                event.target === modalDroga
            ) {

                modalDroga.classList.remove(
                    'abierto'
                );

            }

        }
    );

}



/*
=========================================================
ZONA SELECCIONADA
=========================================================
*/

let zonaSeleccionada = null;



/*
=========================================================
SELECCIONAR ZONA
=========================================================
*/

document
    .querySelectorAll('.zona-foto')
    .forEach(function (zona) {


        zona.addEventListener(
            'click',
            function () {


                /*
                Quitamos activo de todas.
                */

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


                /*
                Activamos esta.
                */

                zona.classList.add(
                    'activa'
                );


                /*
                Guardamos la zona.
                */

                zonaSeleccionada =
                    zona;


                /*
                Damos foco.
                */

                zona.focus();

            }
        );


    });



/*
=========================================================
PEGAR CON CTRL + V
=========================================================
*/

document.addEventListener(
    'paste',
    function (event) {


        /*
        Si no hay zona seleccionada,
        no hacemos nada.
        */

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


            /*
            Comprobamos que sea imagen.
            */

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


            /*
            ID del input.
            */

            const inputId =
                zonaSeleccionada.dataset.input;


            const input =
                document.getElementById(
                    inputId
                );


            if (!input) {

                return;

            }


            /*
            Creamos DataTransfer.
            */

            const dataTransfer =
                new DataTransfer();


            dataTransfer.items.add(
                file
            );


            /*
            Metemos la imagen
            en el input file.
            */

            input.files =
                dataTransfer.files;


            /*
            Preview.
            */

            const preview =
                document.getElementById(
                    'preview_' + inputId
                );


            /*
            Texto.
            */

            const texto =
                zonaSeleccionada.querySelector(
                    '.texto-pegar'
                );


            /*
            Mostramos imagen.
            */

            preview.src =
                URL.createObjectURL(
                    file
                );


            preview.style.display =
                'block';


            /*
            Ocultamos texto.
            */

            if (texto) {

                texto.style.display =
                    'none';

            }


            /*
            Evitamos el comportamiento
            normal del navegador.
            */

            event.preventDefault();


            break;

        }

    }
);



/*
=========================================================
ARRASTRAR IMAGEN
=========================================================
*/

document
    .querySelectorAll('.zona-foto')
    .forEach(function (zona) {


        /*
        DRAGOVER
        */

        zona.addEventListener(
            'dragover',
            function (event) {

                event.preventDefault();

                zona.classList.add(
                    'activa'
                );

            }
        );



        /*
        DRAGLEAVE
        */

        zona.addEventListener(
            'dragleave',
            function () {

                zona.classList.remove(
                    'activa'
                );

            }
        );



        /*
        DROP
        */

        zona.addEventListener(
            'drop',
            function (event) {


                event.preventDefault();


                zona.classList.remove(
                    'activa'
                );


                /*
                Seleccionamos esta zona.
                */

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


                /*
                Comprobamos que sea imagen.
                */

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


                /*
                Obtenemos input.
                */

                const inputId =
                    zona.dataset.input;


                const input =
                    document.getElementById(
                        inputId
                    );


                if (!input) {

                    return;

                }


                /*
                Creamos DataTransfer.
                */

                const dataTransfer =
                    new DataTransfer();


                dataTransfer.items.add(
                    file
                );


                /*
                Guardamos archivo.
                */

                input.files =
                    dataTransfer.files;


                /*
                Preview.
                */

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


                /*
                Ocultamos texto.
                */

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