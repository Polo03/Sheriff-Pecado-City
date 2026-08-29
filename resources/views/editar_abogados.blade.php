@extends('layout.app')

@section('title', 'Editar abogados')

@push('styles')
<style>

    .editar-abogados-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .editar-abogados-cabecera {
        margin-bottom: 20px;
    }

    .editar-abogados-cabecera h1 {
        margin: 0 0 8px;
    }

    .editar-abogados-cabecera p {
        margin: 0;
        color: #666;
    }

    .formulario-abogados {
        display: grid;
        gap: 12px;
    }

    .abogado-formulario {
        padding: 18px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .abogado-formulario-grid {
        display: grid;
        grid-template-columns: 1.4fr 1fr auto;
        align-items: end;
        gap: 12px;
    }

    .campo-abogado label {
        display: block;
        margin-bottom: 6px;
        font-size: 13px;
        font-weight: bold;
    }

    .campo-abogado input[type="text"] {
        width: 100%;
        box-sizing: border-box;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 6px;
        font: inherit;
    }

    .campo-oficio {
        display: flex;
        align-items: center;
        gap: 7px;
        height: 40px;
    }

    .campo-oficio label {
        margin: 0;
    }

    .botones-abogados {
        display: flex;
        justify-content: space-between;
        gap: 10px;
        margin-top: 10px;
    }

    .boton-volver {
        padding: 11px 16px;
        border-radius: 6px;
        background: #666;
        color: white;
        text-decoration: none;
    }

    .boton-volver:hover {
        color: white;
    }

    .boton-guardar {
        padding: 11px 16px;
        border: 0;
        border-radius: 6px;
        background: #198754;
        color: white;
        cursor: pointer;
        font: inherit;
        font-weight: bold;
    }

    .boton-anadir {
        width: 100%;
        padding: 11px;
        border: 1px dashed #aaa;
        border-radius: 6px;
        background: #f8f9fa;
        color: #555;
        cursor: pointer;
        font: inherit;
    }

    .boton-eliminar {
        padding: 9px 12px;
        border: 0;
        border-radius: 6px;
        background: #dc3545;
        color: white;
        cursor: pointer;
        font: inherit;
    }

    @media (max-width: 700px) {

        .abogado-formulario-grid {
            grid-template-columns: 1fr;
        }

        .botones-abogados {
            flex-direction: column;
        }

        .boton-volver,
        .boton-guardar {
            width: 100%;
            text-align: center;
            box-sizing: border-box;
        }

    }

</style>
@endpush


@section('content')

<div class="editar-abogados-pagina">

    <div class="editar-abogados-cabecera">

        <h1>
            ✏️ Editar abogados
        </h1>

        <p>
            Modifica, añade o elimina abogados del tablón.
        </p>

    </div>


    @if($errors->any())

        <div style="
            margin-bottom: 15px;
            padding: 12px 16px;
            border-radius: 6px;
            background: #f8d7da;
            color: #842029;
        ">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    <form
        action="{{ route('abogados.update') }}"
        method="POST"
        class="formulario-abogados"
        id="formulario-abogados"
    >

        @csrf

        @method('PUT')


        <div id="lista-abogados">

            @foreach($abogados as $indice => $abogado)

                <div class="abogado-formulario">

                    <div class="abogado-formulario-grid">

                        <div class="campo-abogado">

                            <label>
                                Nombre
                            </label>

                            <input
                                type="text"
                                name="nombre[]"
                                value="{{ $abogado['nombre'] }}"
                                maxlength="255"
                                required
                            >

                        </div>


                        <div class="campo-abogado">

                            <label>
                                Contacto
                            </label>

                            <input
                                type="text"
                                name="contacto[]"
                                value="{{ $abogado['contacto'] ?? '' }}"
                                maxlength="100"
                                placeholder="Teléfono"
                            >

                        </div>


                        <div>

                            <div class="campo-oficio">

                                <input
                                    type="checkbox"
                                    name="oficio[{{ $indice }}]"
                                    value="1"
                                    id="oficio-{{ $indice }}"
                                    {{ !empty($abogado['oficio']) ? 'checked' : '' }}
                                >

                                <label for="oficio-{{ $indice }}">
                                    OFICIO
                                </label>

                            </div>

                        </div>

                    </div>


                    <div style="margin-top: 10px; text-align: right;">

                        <button
                            type="button"
                            class="boton-eliminar"
                            onclick="eliminarAbogado(this)"
                        >
                            🗑️ Eliminar
                        </button>

                    </div>

                </div>

            @endforeach

        </div>


        <button
            type="button"
            class="boton-anadir"
            onclick="anadirAbogado()"
        >
            ➕ Añadir abogado
        </button>


        <div class="botones-abogados">

            <a
                href="{{ route('abogados.index') }}"
                class="boton-volver"
            >
                ← Volver
            </a>

            <button
                type="submit"
                class="boton-guardar"
            >
                💾 Guardar cambios
            </button>

        </div>

    </form>

</div>

@endsection


@push('scripts')
<script>

    let contadorAbogados = {{ count($abogados) }};


    function anadirAbogado() {

        const lista = document.getElementById('lista-abogados');

        const bloque = document.createElement('div');

        bloque.className = 'abogado-formulario';

        bloque.innerHTML = `
            <div class="abogado-formulario-grid">

                <div class="campo-abogado">

                    <label>
                        Nombre
                    </label>

                    <input
                        type="text"
                        name="nombre[]"
                        maxlength="255"
                        placeholder="Nombre del abogado"
                        required
                    >

                </div>


                <div class="campo-abogado">

                    <label>
                        Contacto
                    </label>

                    <input
                        type="text"
                        name="contacto[]"
                        maxlength="100"
                        placeholder="Teléfono"
                    >

                </div>


                <div>

                    <div class="campo-oficio">

                        <input
                            type="checkbox"
                            name="oficio[${contadorAbogados}]"
                            value="1"
                            id="oficio-${contadorAbogados}"
                        >

                        <label for="oficio-${contadorAbogados}">
                            OFICIO
                        </label>

                    </div>

                </div>

            </div>


            <div style="margin-top: 10px; text-align: right;">

                <button
                    type="button"
                    class="boton-eliminar"
                    onclick="eliminarAbogado(this)"
                >
                    🗑️ Eliminar
                </button>

            </div>
        `;

        lista.appendChild(bloque);

        contadorAbogados++;
    }


    function eliminarAbogado(boton) {

        const bloque = boton.closest('.abogado-formulario');

        if (bloque) {
            bloque.remove();
        }
    }

</script>
@endpush