@extends('layout.app')

@section('title', 'Editar DNI Rehén')


@push('styles')

<style>

    .editar-rehen-pagina {
        max-width: 900px;
        margin: 0 auto;
    }


    .cabecera-rehen {

        display: flex;

        justify-content: space-between;

        align-items: center;

        margin-bottom: 30px;
    }


    .cabecera-rehen h1 {
        margin: 0;
    }


    .boton {

        display: inline-block;

        padding: 10px 15px;

        border: none;

        border-radius: 7px;

        background: #222;

        color: white;

        text-decoration: none;

        cursor: pointer;
    }


    .boton-gris {
        background: #777;
    }


    .boton-verde {
        background: #198754;
    }


    .boton-verde:hover {
        background: #157347;
    }


    .formulario {
        max-width: 800px;
        margin: 0 auto;
    }


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


    .campo {
        margin-bottom: 25px;
    }


    .campo label {

        display: block;

        margin-bottom: 8px;

        font-weight: bold;
    }


    .campo input {

        width: 100%;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 7px;

        font: inherit;
    }


    .fotos-formulario {

        display: flex;

        justify-content: center;

        margin-top: 30px;

        margin-bottom: 30px;
    }


    .campo-foto {

        display: flex;

        flex-direction: column;

        align-items: center;
    }


    .campo-foto label {

        font-weight: bold;

        margin-bottom: 10px;

        text-align: center;
    }


    .foto-actual {

        width: 200px;

        height: 200px;

        object-fit: contain;

        border-radius: 10px;

        display: block;

        margin-bottom: 15px;

        border: 1px solid #ddd;

        background: #f5f5f5;
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

        transition: .2s ease;
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

        font-size: 30px;

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


    .botones-formulario {

        display: flex;

        gap: 10px;

        margin-top: 25px;
    }


    .alerta {

        margin-bottom: 20px;

        padding: 15px;

        border-radius: 8px;

        background: #f8d7da;

        color: #842029;
    }


    @media (max-width: 700px) {

        .cabecera-rehen {

            flex-direction: column;

            align-items: flex-start;

            gap: 15px;
        }

    }

</style>

@endpush



@section('content')

<div class="editar-rehen-pagina">


    <div class="cabecera-rehen">

        <h1>
            Editar DNI de rehén
        </h1>


        <a
            href="{{ route('dni-rehenes.index') }}"
            class="boton boton-gris"
        >
            ← Volver
        </a>

    </div>



    @if($errors->any())

        <div class="alerta">

            <strong>
                Se han encontrado errores:
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



    <div class="formulario">


        <div class="datos">


            <div class="dato">

                <strong>
                    Agente:
                </strong>

                {{ $rehen->agente }}

            </div>


            <div class="dato">

                <strong>
                    Placa:
                </strong>

                {{ $rehen->placa }}

            </div>


            <div class="dato">

                <strong>
                    Fecha de registro:
                </strong>

                {{ $rehen->fecha_registro }}

            </div>


        </div>



        <form
            action="{{ route('dni-rehenes.update', $rehen->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >

            @csrf

            @method('PUT')



            {{-- CAUSA --}}

            <div class="campo">

                <label for="causa">
                    Causa
                </label>


                <input
                    type="text"
                    id="causa"
                    name="causa"
                    value="{{ old('causa', $rehen->causa) }}"
                    maxlength="45"
                    required
                >

            </div>



            {{-- FOTO --}}

            <div class="fotos-formulario">

                <div class="campo-foto">

                    <label>
                        Foto actual
                    </label>


                    @if($rehen->foto_rehen)

                        <img
                            src="{{ asset('storage/' . $rehen->foto_rehen) }}"
                            class="foto-actual"
                            alt="Foto actual del rehén"
                        >

                    @endif


                    <label>
                        Nueva foto
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

                            Pega aquí

                            <br>

                            <small>
                                Ctrl + V
                            </small>

                        </div>


                        <img
                            id="preview_foto_rehen"
                            class="preview"
                            alt="Nueva foto del rehén"
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



            <div class="botones-formulario">

                <button
                    type="submit"
                    class="boton boton-verde"
                >
                    Guardar cambios
                </button>


                <a
                    href="{{ route('dni-rehenes.index') }}"
                    class="boton boton-gris"
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

let zonaSeleccionada = null;


/*
|--------------------------------------------------------------------------
| SELECCIONAR ZONA
|--------------------------------------------------------------------------
*/

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
| PEGAR CTRL + V
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