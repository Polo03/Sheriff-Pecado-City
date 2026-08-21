@extends('layouts.app')

@section('title', 'Sujetos procesados')

@section('content')

    {{-- TODO EL HTML DE TU PÁGINA AQUÍ --}}


    @if($modo === 'lista')

        {{-- LISTADO --}}


    @elseif($modo === 'crear')

        {{-- FORMULARIO --}}


    @elseif($modo === 'ver')

        {{-- VER SUJETO --}}

    @endif


    {{-- =====================================================
         JAVASCRIPT
    ====================================================== --}}

    <script>

        let zonaSeleccionada = null;


        document
            .querySelectorAll('.zona-foto')
            .forEach(function(zona) {

                zona.addEventListener('click', function() {

                    document
                        .querySelectorAll('.zona-foto')
                        .forEach(function(z) {

                            z.classList.remove('activa');

                        });


                    zona.classList.add('activa');

                    zonaSeleccionada = zona;

                    zona.focus();

                });

            });


        document.addEventListener(
            'paste',
            function(event) {

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
                        !item.type.startsWith('image/')
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
                        zonaSeleccionada.querySelector(
                            '.texto-pegar'
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


        document
            .querySelectorAll('.zona-foto')
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

                        zonaSeleccionada = zona;


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
                            !file.type.startsWith('image/')
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

@endsection