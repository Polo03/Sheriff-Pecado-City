@extends('layout.app')

@section('title', 'Editar mosquete local')

@push('styles')
<style>

    /* =========================
       CABECERA
    ========================= */

    .mosquete-editar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .mosquete-editar-header h1 {
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

    .boton-verde-mosquete {
        background: #198754;
    }

    .boton-verde-mosquete:hover {
        background: #157347;
    }

    .boton-gris-mosquete {
        background: #777;
    }

    .boton-gris-mosquete:hover {
        background: #666;
    }


    /* =========================
       FORMULARIO
    ========================= */

    .formulario-mosquete {
        max-width: 760px;
        margin: 0 auto;
    }

    .campo-mosquete-editar {
        margin-bottom: 25px;
    }

    .campo-mosquete-editar label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .campo-mosquete-editar input[type="text"] {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-size: 15px;
        font-family: inherit;
    }

    .campo-mosquete-editar input[type="text"]:focus {
        outline: none;
        border-color: #222;
    }


    /* =========================
       FOTOS
    ========================= */

    .fotos-mosquete-editar {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 25px;
        margin-top: 30px;
        margin-bottom: 30px;
    }

    .campo-foto-mosquete {
        display: flex;
        flex-direction: column;
    }

    .campo-foto-mosquete > label {
        font-weight: bold;
        margin-bottom: 10px;
        text-align: center;
    }

    .foto-actual-mosquete {
        width: 150px;
        height: 150px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        margin: 0 auto 12px auto;
        border: 1px solid #ddd;
    }

    .texto-foto-actual {
        text-align: center;
        color: #777;
        font-size: 13px;
        margin-bottom: 10px;
    }


    /* =========================
       ZONA PEGAR
    ========================= */

    .zona-foto-mosquete-editar {
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

    .zona-foto-mosquete-editar:hover {
        border-color: #222;
        background: #f1f1f1;
    }

    .zona-foto-mosquete-editar.activa {
        border-color: #198754;
        background: #eaf7ef;
    }


    /* =========================
       TEXTO PEGAR
    ========================= */

    .texto-pegar-mosquete {
        text-align: center;
        color: #777;
        font-size: 13px;
        padding: 15px;
        pointer-events: none;
    }

    .texto-pegar-mosquete .icono {
        display: block;
        font-size: 30px;
        margin-bottom: 8px;
    }


    /* =========================
       PREVIEW
    ========================= */

    .preview-mosquete {
        width: 100%;
        height: 100%;
        object-fit: cover;

        position: absolute;
        top: 0;
        left: 0;

        display: none;
    }


    /* =========================
       INPUT OCULTO
    ========================= */

    .input-foto-mosquete-oculto {
        display: none;
    }


    /* =========================
       BOTONES FORMULARIO
    ========================= */

    .botones-formulario-mosquete {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }


    /* =========================
       MENSAJES
    ========================= */

    .errores-mosquete {
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 8px;
        background: #f8d7da;
        color: #842029;
    }

    .errores-mosquete ul {
        margin: 0;
        padding-left: 20px;
    }


    /* =========================
       RESPONSIVE
    ========================= */

    @media (max-width: 700px) {

        .mosquete-editar-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .fotos-mosquete-editar {
            grid-template-columns: 1fr;
        }

    }

</style>
@endpush


@section('content')

    {{-- =====================================================
         ERRORES
    ====================================================== --}}

    @if($errors->any())

        <div class="errores-mosquete">

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
    ====================================================== --}}

    <div class="mosquete-editar-header">

        <h1>
            Editar mosquete local
        </h1>

        <a
            href="{{ route('mosquetes-locales.index') }}"
            class="boton-mosquete boton-gris-mosquete"
        >
            ← Volver
        </a>

    </div>


    {{-- =====================================================
         FORMULARIO
    ====================================================== --}}

    <div class="formulario-mosquete">

        <form
            action="{{ route('mosquetes-locales.update', $mosquete->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')


            {{-- =================================================
                 EMPRESA
            ================================================== --}}

            <div class="campo-mosquete-editar">

                <label for="empresa">
                    Empresa/compañía
                </label>

                <input
                    type="text"
                    id="empresa"
                    name="empresa"
                    value="{{ old('empresa', $mosquete->empresa) }}"
                    maxlength="45"
                    required
                >

            </div>


            {{-- =================================================
                 NÚMERO DE SERIE
            ================================================== --}}

            <div class="campo-mosquete-editar">

                <label for="num_serie_mosquete">
                    Número de serie
                </label>

                <input
                    type="text"
                    id="num_serie_mosquete"
                    name="num_serie_mosquete"
                    value="{{ old('num_serie_mosquete', $mosquete->num_serie_mosquete) }}"
                    maxlength="45"
                    required
                >

            </div>


            {{-- =================================================
                 FOTOS
            ================================================== --}}

            <div class="fotos-mosquete-editar">


                {{-- =============================================
                     FOTO DNI
                ============================================== --}}

                <div class="campo-foto-mosquete">

                    <label>
                        Foto del DNI
                    </label>


                    @if($mosquete->foto_dni)

                        <img
                            src="{{ asset('storage/' . $mosquete->foto_dni) }}"
                            class="foto-actual-mosquete"
                            alt="Foto actual del DNI"
                        >

                        <div class="texto-foto-actual">
                            Foto actual
                        </div>

                    @endif


                    <div
                        class="zona-foto-mosquete-editar"
                        data-input="foto_dni"
                        tabindex="0"
                    >

                        <div class="texto-pegar-mosquete">

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
                            id="preview_foto_dni"
                            class="preview-mosquete"
                            alt="Vista previa foto DNI"
                        >

                    </div>


                    <input
                        type="file"
                        id="foto_dni"
                        name="foto_dni"
                        class="input-foto-mosquete-oculto"
                        accept="image/*"
                    >

                </div>


                {{-- =============================================
                     FOTO LICENCIA
                ============================================== --}}

                <div class="campo-foto-mosquete">

                    <label>
                        Foto licencia de armas
                    </label>


                    @if($mosquete->foto_licencia_armas)

                        <img
                            src="{{ asset('storage/' . $mosquete->foto_licencia_armas) }}"
                            class="foto-actual-mosquete"
                            alt="Foto actual de la licencia"
                        >

                        <div class="texto-foto-actual">
                            Foto actual
                        </div>

                    @endif


                    <div
                        class="zona-foto-mosquete-editar"
                        data-input="foto_licencia_armas"
                        tabindex="0"
                    >

                        <div class="texto-pegar-mosquete">

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
                            id="preview_foto_licencia_armas"
                            class="preview-mosquete"
                            alt="Vista previa licencia de armas"
                        >

                    </div>


                    <input
                        type="file"
                        id="foto_licencia_armas"
                        name="foto_licencia_armas"
                        class="input-foto-mosquete-oculto"
                        accept="image/*"
                    >

                </div>


            </div>


            {{-- =================================================
                 BOTONES
            ================================================== --}}

            <div class="botones-formulario-mosquete">

                <button
                    type="submit"
                    class="boton-mosquete boton-verde-mosquete"
                >
                    Guardar cambios
                </button>


                <a
                    href="{{ route('mosquetes-locales.index') }}"
                    class="boton-mosquete boton-gris-mosquete"
                >
                    Cancelar
                </a>

            </div>


        </form>

    </div>

@endsection


@push('scripts')

<script>

let zonaMosqueteSeleccionada = null;


/*
=========================================================
SELECCIONAR ZONA
=========================================================
*/

document
    .querySelectorAll('.zona-foto-mosquete-editar')
    .forEach(function(zona) {

        zona.addEventListener('click', function() {

            document
                .querySelectorAll(
                    '.zona-foto-mosquete-editar'
                )
                .forEach(function(otraZona) {

                    otraZona.classList.remove(
                        'activa'
                    );

                });


            zona.classList.add('activa');

            zonaMosqueteSeleccionada = zona;

            zona.focus();

        });

    });


/*
=========================================================
PEGAR CON CTRL + V
=========================================================
*/

document.addEventListener(
    'paste',
    function(event) {

        if (!zonaMosqueteSeleccionada) {
            return;
        }


        const items =
            event.clipboardData.items;


        for (
            let i = 0;
            i < items.length;
            i++
        ) {

            const item = items[i];


            if (!item.type.startsWith('image/')) {
                continue;
            }


            const file = item.getAsFile();


            if (!file) {
                continue;
            }


            const inputId =
                zonaMosqueteSeleccionada.dataset.input;


            const input =
                document.getElementById(inputId);


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
                zonaMosqueteSeleccionada.querySelector(
                    '.texto-pegar-mosquete'
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
        '.zona-foto-mosquete-editar'
    )
    .forEach(function(zona) {

        zona.addEventListener(
            'dragover',
            function(event) {

                event.preventDefault();

                zona.classList.add('activa');

            }
        );


        zona.addEventListener(
            'dragleave',
            function() {

                zona.classList.remove('activa');

            }
        );


        zona.addEventListener(
            'drop',
            function(event) {

                event.preventDefault();


                zona.classList.remove('activa');


                zonaMosqueteSeleccionada =
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


                if (!file.type.startsWith('image/')) {

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
                        '.texto-pegar-mosquete'
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