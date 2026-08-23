@extends('layout.app')

@section('title', 'Editar matrícula sospechosa')

@push('styles')

<style>

    /* =========================
       CONTENEDOR
    ========================= */

    .editar-matricula {
        max-width: 760px;
        margin: 0 auto;
    }


    /* =========================
       CABECERA
    ========================= */

    .editar-matricula-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }


    .editar-matricula-header h1 {
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


    .boton-verde-matricula {
        background: #198754;
    }


    .boton-verde-matricula:hover {
        background: #157347;
    }


    .boton-gris-matricula {
        background: #777;
    }


    .boton-gris-matricula:hover {
        background: #666;
    }


    /* =========================
       FORMULARIO
    ========================= */

    .formulario-matricula {
        width: 100%;
    }


    .campo-matricula-editar {
        margin-bottom: 25px;
    }


    .campo-matricula-editar label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }


    .campo-matricula-editar textarea {
        width: 100%;
        min-height: 120px;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-size: 15px;
        font-family: inherit;
        resize: vertical;
    }


    .campo-matricula-editar textarea:focus {
        outline: none;
        border-color: #222;
    }


    /* =========================
       FOTO ACTUAL
    ========================= */

    .foto-actual-matricula {
        width: 150px;
        height: 150px;
        object-fit: contain;
        border-radius: 10px;
        display: block;
        margin: 0 auto 15px auto;
        border: 1px solid #ddd;
        background: #f5f5f5;
    }


    .texto-foto-actual {
        text-align: center;
        color: #777;
        font-size: 13px;
        margin-bottom: 10px;
    }


    /* =========================
       ZONA DE FOTO
    ========================= */

    .zona-foto-matricula-editar {

        width: 100%;
        height: 190px;

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


    .zona-foto-matricula-editar:hover {
        border-color: #222;
        background: #f1f1f1;
    }


    .zona-foto-matricula-editar.activa {
        border-color: #198754;
        background: #eaf7ef;
    }


    /* =========================
       TEXTO PEGAR
    ========================= */

    .texto-pegar-matricula {

        text-align: center;

        color: #777;

        font-size: 13px;

        padding: 15px;

        pointer-events: none;

    }


    .texto-pegar-matricula .icono {

        display: block;

        font-size: 30px;

        margin-bottom: 8px;

    }


    /* =========================
       PREVIEW
    ========================= */

    .preview-matricula {

        width: 100%;
        height: 100%;

        object-fit: contain;

        position: absolute;

        top: 0;
        left: 0;

        display: none;

        background: #f5f5f5;

    }


    /* =========================
       INPUT OCULTO
    ========================= */

    .input-foto-matricula {
        display: none;
    }


    /* =========================
       BOTONES FORMULARIO
    ========================= */

    .botones-formulario-matricula {

        display: flex;

        gap: 10px;

        margin-top: 25px;

    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 700px) {

        .editar-matricula-header {

            flex-direction: column;

            align-items: flex-start;

            gap: 15px;

        }

    }

</style>

@endpush


@section('content')

<div class="editar-matricula">


    {{-- =====================================================
         CABECERA
    ====================================================== --}}

    <div class="editar-matricula-header">

        <h1>
            Editar matrícula sospechosa
        </h1>


        <a
            href="{{ route('matriculas-sospechosas.index') }}"
            class="boton-matricula boton-gris-matricula"
        >
            ← Volver
        </a>

    </div>


    {{-- =====================================================
         FORMULARIO
    ====================================================== --}}

    <div class="formulario-matricula">

        <form
            action="{{ route('matriculas-sospechosas.update', $matricula->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            {{-- =================================================
                 CAUSA
            ================================================== --}}

            <div class="campo-matricula-editar">

                <label for="causa">
                    Causa
                </label>


                <textarea
                    id="causa"
                    name="causa"
                    maxlength="255"
                    required
                >{{ old('causa', $matricula->causa) }}</textarea>

            </div>


            {{-- =================================================
                 FOTO
            ================================================== --}}

            <div class="campo-matricula-editar">

                <label>
                    Foto matrícula
                </label>


                @if($matricula->foto_matricula)

                    <img
                        src="{{ asset('storage/' . $matricula->foto_matricula) }}"
                        class="foto-actual-matricula"
                        alt="Foto actual de matrícula"
                    >


                    <div class="texto-foto-actual">
                        Foto actual
                    </div>

                @endif


                <div
                    class="zona-foto-matricula-editar"
                    data-input="foto_matricula"
                    tabindex="0"
                >

                    <div class="texto-pegar-matricula">

                        <span class="icono">
                            📋
                        </span>

                        Pega aquí una nueva imagen

                        <br>

                        <small>
                            Ctrl + V
                        </small>

                    </div>


                    <img
                        id="preview_foto_matricula"
                        class="preview-matricula"
                        alt="Nueva foto de matrícula"
                    >

                </div>


                <input
                    type="file"
                    id="foto_matricula"
                    name="foto_matricula"
                    class="input-foto-matricula"
                    accept="image/*"
                >

            </div>


            {{-- =================================================
                 BOTONES
            ================================================== --}}

            <div class="botones-formulario-matricula">

                <button
                    type="submit"
                    class="boton-matricula boton-verde-matricula"
                >
                    Guardar cambios
                </button>


                <a
                    href="{{ route('matriculas-sospechosas.index') }}"
                    class="boton-matricula boton-gris-matricula"
                >
                    Cancelar
                </a>

            </div>


        </form>

    </div>

</div>

@endsection


@push('scripts')

<script>

let zonaMatriculaSeleccionada = null;


/*
=========================================================
SELECCIONAR ZONA
=========================================================
*/

document
    .querySelectorAll(
        '.zona-foto-matricula-editar'
    )
    .forEach(function(zona) {

        zona.addEventListener(
            'click',
            function() {

                document
                    .querySelectorAll(
                        '.zona-foto-matricula-editar'
                    )
                    .forEach(
                        function(otraZona) {

                            otraZona.classList.remove(
                                'activa'
                            );

                        }
                    );


                zona.classList.add('activa');

                zonaMatriculaSeleccionada =
                    zona;

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
    function(event) {

        if (!zonaMatriculaSeleccionada) {
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
                zonaMatriculaSeleccionada
                    .dataset
                    .input;


            const input =
                document.getElementById(
                    inputId
                );


            if (!input) {
                return;
            }


            const dataTransfer =
                new DataTransfer();


            dataTransfer.items.add(file);


            input.files =
                dataTransfer.files;


            const preview =
                document.getElementById(
                    'preview_' + inputId
                );


            const texto =
                zonaMatriculaSeleccionada
                    .querySelector(
                        '.texto-pegar-matricula'
                    );


            preview.src =
                URL.createObjectURL(file);


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
=========================================================
ARRASTRAR IMAGEN
=========================================================
*/

document
    .querySelectorAll(
        '.zona-foto-matricula-editar'
    )
    .forEach(function(zona) {

        zona.addEventListener(
            'dragover',
            function(event) {

                event.preventDefault();

                zona.classList.add(
                    'activa'
                );

            }
        );


        zona.addEventListener(
            'dragleave',
            function() {

                zona.classList.remove(
                    'activa'
                );

            }
        );


        zona.addEventListener(
            'drop',
            function(event) {

                event.preventDefault();


                zona.classList.remove(
                    'activa'
                );


                zonaMatriculaSeleccionada =
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


                dataTransfer.items.add(file);


                input.files =
                    dataTransfer.files;


                const preview =
                    document.getElementById(
                        'preview_' + inputId
                    );


                preview.src =
                    URL.createObjectURL(file);


                preview.style.display =
                    'block';


                const texto =
                    zona.querySelector(
                        '.texto-pegar-matricula'
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