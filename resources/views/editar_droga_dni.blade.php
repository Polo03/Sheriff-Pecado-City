@extends('layout.app')

@section('title', 'Editar Drogas DNI')

@push('styles')

<style>

    .editar-drogas {
        max-width: 800px;
        margin: 0 auto;
    }


    .cabecera-editar-drogas {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }


    .cabecera-editar-drogas h1 {
        margin: 0;
    }


    .boton-drogas {
        display: inline-block;
        padding: 10px 15px;
        border: 0;
        border-radius: 7px;
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


    .campo-editar-drogas {
        margin-bottom: 25px;
    }


    .campo-editar-drogas label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }


    .campo-editar-drogas input {
        width: 100%;
        padding: 12px;
        border: 1px solid #ccc;
        border-radius: 7px;
        font-size: 15px;
    }


    .fotos-editar-drogas {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
        margin-top: 30px;
        margin-bottom: 30px;
    }


    .campo-foto-editar-drogas {
        flex: 1;
        min-width: 250px;
        text-align: center;
    }


    .campo-foto-editar-drogas label {
        display: block;
        margin-bottom: 10px;
        font-weight: bold;
    }


    .foto-actual-drogas {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 10px;
        display: block;
        margin: 0 auto 10px;
        border: 1px solid #ddd;
    }


    .zona-foto-editar-drogas {
        width: 100%;
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
    }


    .zona-foto-editar-drogas.activa {
        border-color: #198754;
        background: #eaf7ef;
    }


    .texto-pegar-editar-drogas {
        text-align: center;
        color: #777;
        pointer-events: none;
    }


    .texto-pegar-editar-drogas .icono {
        display: block;
        font-size: 30px;
        margin-bottom: 8px;
    }


    .preview-editar-drogas {
        width: 100%;
        height: 100%;
        object-fit: contain;
        position: absolute;
        inset: 0;
        display: none;
    }


    .input-foto-editar-drogas {
        display: none;
    }


    .botones-editar-drogas {
        display: flex;
        gap: 10px;
        margin-top: 25px;
    }

</style>

@endpush


@section('content')

<div class="editar-drogas">


    <div class="cabecera-editar-drogas">

        <h1>
            Editar registro
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
        action="{{ route('drogas-dni.update', $droga->id) }}"
        method="POST"
        enctype="multipart/form-data"
    >

        @csrf

        @method('PUT')


        <div class="campo-editar-drogas">

            <label for="placa">
                Placa
            </label>

            <input
                type="text"
                id="placa"
                name="placa"
                value="{{ old('placa', $droga->placa) }}"
                maxlength="45"
                required
            >

        </div>


        <div class="campo-editar-drogas">

            <label for="cantidad">
                Cantidad
            </label>

            <input
                type="text"
                id="cantidad"
                name="cantidad"
                value="{{ old('cantidad', $droga->cantidad) }}"
                maxlength="100"
                required
            >

        </div>


        <div class="fotos-editar-drogas">


            {{-- FOTO DNI --}}

            <div class="campo-foto-editar-drogas">

                <label>
                    Foto DNI
                </label>


                @if($droga->foto_dni)

                    <img
                        src="{{ asset('storage/' . $droga->foto_dni) }}"
                        class="foto-actual-drogas"
                        alt="Foto DNI actual"
                    >

                @endif


                <div
                    class="zona-foto-editar-drogas"
                    data-input="foto_dni"
                    tabindex="0"
                >

                    <div class="texto-pegar-editar-drogas">

                        <span class="icono">
                            📋
                        </span>

                        Pega aquí la nueva foto

                        <br>

                        <small>
                            Ctrl + V
                        </small>

                    </div>


                    <img
                        id="preview_foto_dni"
                        class="preview-editar-drogas"
                        alt="Nueva foto DNI"
                    >

                </div>


                <input
                    type="file"
                    id="foto_dni"
                    name="foto_dni"
                    class="input-foto-editar-drogas"
                    accept="image/*"
                >

            </div>


            {{-- FOTO SOSPECHOSO --}}

            <div class="campo-foto-editar-drogas">

                <label>
                    Foto sospechoso
                </label>


                @if($droga->foto_sospechoso)

                    <img
                        src="{{ asset('storage/' . $droga->foto_sospechoso) }}"
                        class="foto-actual-drogas"
                        alt="Foto sospechoso actual"
                    >

                @endif


                <div
                    class="zona-foto-editar-drogas"
                    data-input="foto_sospechoso"
                    tabindex="0"
                >

                    <div class="texto-pegar-editar-drogas">

                        <span class="icono">
                            📋
                        </span>

                        Pega aquí la nueva foto

                        <br>

                        <small>
                            Ctrl + V
                        </small>

                    </div>


                    <img
                        id="preview_foto_sospechoso"
                        class="preview-editar-drogas"
                        alt="Nueva foto sospechoso"
                    >

                </div>


                <input
                    type="file"
                    id="foto_sospechoso"
                    name="foto_sospechoso"
                    class="input-foto-editar-drogas"
                    accept="image/*"
                >

            </div>


        </div>


        <div class="botones-editar-drogas">

            <button
                type="submit"
                class="boton-drogas boton-verde-drogas"
            >
                Guardar cambios
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

let zonaEditarDrogasSeleccionada = null;


document
    .querySelectorAll(
        '.zona-foto-editar-drogas'
    )
    .forEach(function(zona) {

        zona.addEventListener(
            'click',
            function() {

                document
                    .querySelectorAll(
                        '.zona-foto-editar-drogas'
                    )
                    .forEach(function(z) {

                        z.classList.remove(
                            'activa'
                        );

                    });


                zona.classList.add(
                    'activa'
                );


                zonaEditarDrogasSeleccionada =
                    zona;


                zona.focus();

            }
        );

    });


document.addEventListener(
    'paste',
    function(event) {

        if (
            !zonaEditarDrogasSeleccionada
        ) {
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
                zonaEditarDrogasSeleccionada
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
                zonaEditarDrogasSeleccionada
                    .querySelector(
                        '.texto-pegar-editar-drogas'
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
        '.zona-foto-editar-drogas'
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


                zonaEditarDrogasSeleccionada =
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
                        '.texto-pegar-editar-drogas'
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