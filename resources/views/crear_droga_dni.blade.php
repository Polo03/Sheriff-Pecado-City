@extends('layout.app')

@section('title', 'Nuevo registro - Drogas DNI')

@push('styles')

<style>

    .formulario-drogas {
        max-width: 800px;
        margin: 0 auto;
    }


    .cabecera-drogas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }


    .cabecera-drogas h1 {
        margin: 0;
    }


    .boton-drogas {
        display: inline-block;
        padding: 10px 15px;
        border: 0;
        border-radius: 7px;
        background: #222;
        color: white;
        text-decoration: none;
        cursor: pointer;
    }


    .boton-verde-drogas {
        background: #198754;
    }


    .boton-gris-drogas {
        background: #777;
    }


    .campo-drogas {
        margin-bottom: 25px;
    }


    .campo-drogas label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }


    .campo-drogas input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-size: 15px;
    }


    .fotos-drogas {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
        margin-top: 30px;
        margin-bottom: 30px;
    }


    .campo-foto-drogas {
        flex: 1;
        min-width: 250px;
    }


    .campo-foto-drogas label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
        text-align: center;
    }


    .zona-foto-drogas {
        width: 100%;
        height: 220px;
        border: 2px dashed #aaa;
        border-radius: 10px;
        background: #f8f8f8;

        display: flex;
        justify-content: center;
        align-items: center;

        position: relative;
        overflow: hidden;

        cursor: pointer;
    }


    .zona-foto-drogas.activa {
        border-color: #198754;
        background: #eaf7ef;
    }


    .texto-pegar-drogas {
        text-align: center;
        color: #777;
        padding: 15px;
        pointer-events: none;
    }


    .texto-pegar-drogas .icono {
        display: block;
        font-size: 35px;
        margin-bottom: 8px;
    }


    .preview-drogas {
        width: 100%;
        height: 100%;
        object-fit: contain;
        position: absolute;
        inset: 0;
        display: none;
    }


    .input-foto-drogas {
        display: none;
    }


    .botones-drogas {
        display: flex;
        gap: 10px;
    }

</style>

@endpush


@section('content')

<div class="formulario-drogas">


    <div class="cabecera-drogas">

        <h1>
            Nuevo registro de Drogas DNI
        </h1>


        <a
            href="{{ route('drogas-dni.index') }}"
            class="boton-drogas boton-gris-drogas"
        >
            ← Volver
        </a>

    </div>


    @if($errors->any())

        <div>

            <ul>

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('drogas-dni.store') }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf


        <div class="campo-drogas">

            <label for="placa">
                Placa
            </label>

            <input
                type="text"
                id="placa"
                name="placa"
                value="{{ old('placa') }}"
                maxlength="45"
                required
            >

        </div>


        <div class="campo-drogas">

            <label for="cantidad">
                Cantidad
            </label>

            <input
                type="text"
                id="cantidad"
                name="cantidad"
                value="{{ old('cantidad') }}"
                maxlength="100"
                required
            >

        </div>


        <div class="fotos-drogas">


            {{-- FOTO DNI --}}

            <div class="campo-foto-drogas">

                <label>
                    Foto DNI
                </label>


                <div
                    class="zona-foto-drogas"
                    data-input="foto_dni"
                    tabindex="0"
                >

                    <div class="texto-pegar-drogas">

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
                        id="preview_foto_dni"
                        class="preview-drogas"
                        alt="Vista previa DNI"
                    >

                </div>


                <input
                    type="file"
                    id="foto_dni"
                    name="foto_dni"
                    class="input-foto-drogas"
                    accept="image/*"
                    required
                >

            </div>


            {{-- FOTO SOSPECHOSO --}}

            <div class="campo-foto-drogas">

                <label>
                    Foto sospechoso
                </label>


                <div
                    class="zona-foto-drogas"
                    data-input="foto_sospechoso"
                    tabindex="0"
                >

                    <div class="texto-pegar-drogas">

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
                        id="preview_foto_sospechoso"
                        class="preview-drogas"
                        alt="Vista previa sospechoso"
                    >

                </div>


                <input
                    type="file"
                    id="foto_sospechoso"
                    name="foto_sospechoso"
                    class="input-foto-drogas"
                    accept="image/*"
                    required
                >

            </div>


        </div>


        <div class="botones-drogas">

            <button
                type="submit"
                class="boton-drogas boton-verde-drogas"
            >
                Guardar registro
            </button>


            <a
                href="{{ route('drogas-dni.index') }}"
                class="boton-drogas boton-gris-drogas"
            >
                Cancelar
            </a>

        </div>

    </form>

</div>

@endsection


@push('scripts')

<script>

let zonaDrogasSeleccionada = null;


document
    .querySelectorAll('.zona-foto-drogas')
    .forEach(function(zona) {

        zona.addEventListener(
            'click',
            function() {

                document
                    .querySelectorAll(
                        '.zona-foto-drogas'
                    )
                    .forEach(function(z) {

                        z.classList.remove(
                            'activa'
                        );

                    });


                zona.classList.add(
                    'activa'
                );


                zonaDrogasSeleccionada =
                    zona;


                zona.focus();

            }
        );

    });


document.addEventListener(
    'paste',
    function(event) {

        if (!zonaDrogasSeleccionada) {
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
                zonaDrogasSeleccionada
                    .dataset.input;


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
                zonaDrogasSeleccionada
                    .querySelector(
                        '.texto-pegar-drogas'
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


document
    .querySelectorAll(
        '.zona-foto-drogas'
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


                zonaDrogasSeleccionada =
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
                        '.texto-pegar-drogas'
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