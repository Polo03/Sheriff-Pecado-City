@extends('layout.app')

@section('title', 'Editar Agente')

@push('styles')

<style>

    .editar-agente {
        width: 100%;
        max-width: 800px;

        margin: 0 auto;

        padding: 28px;

        box-sizing: border-box;

        border-radius: 8px;

        background: white;

        box-shadow:
            0 3px 12px rgba(0, 0, 0, 0.08);
    }


    .editar-agente h1 {
        margin-top: 0;

        margin-bottom: 8px;
    }


    .editar-descripcion {
        margin-bottom: 25px;

        color: #666;
    }


    /* =====================================================
       CAMPOS
    ===================================================== */

    .campo-editar {
        margin-bottom: 18px;
    }


    .campo-editar label {
        display: block;

        margin-bottom: 6px;

        font-weight: bold;
    }


    .campo-editar input,
    .campo-editar select {
        width: 100%;

        box-sizing: border-box;

        padding: 11px;

        border: 1px solid #ccc;

        border-radius: 6px;

        background: white;

        font: inherit;
    }


    /* =====================================================
       DIVISIONES
    ===================================================== */

    .divisiones-seccion {
        margin-top: 30px;

        padding-top: 25px;

        border-top: 1px solid #eee;
    }


    .divisiones-titulo {
        margin-bottom: 6px;
    }


    .divisiones-descripcion {
        margin-bottom: 18px;

        color: #666;

        font-size: 14px;
    }


    .division-fila {
        display: grid;

        grid-template-columns:
            1fr 1fr auto;

        gap: 10px;

        align-items: end;

        margin-bottom: 10px;

        padding: 12px;

        border-radius: 7px;

        background: #f5f5f5;
    }


    .division-campo label {
        display: block;

        margin-bottom: 5px;

        font-size: 13px;

        font-weight: bold;
    }


    .division-campo select {
        width: 100%;

        box-sizing: border-box;

        padding: 9px;

        border: 1px solid #ccc;

        border-radius: 5px;

        background: white;

        font: inherit;
    }


    .boton-quitar-division {
        width: 36px;

        height: 36px;

        border: none;

        border-radius: 5px;

        background: #dc3545;

        color: white;

        cursor: pointer;

        font-size: 15px;
    }


    .boton-quitar-division:hover {
        background: #bb2d3b;
    }


    .boton-anadir-division {
        margin-top: 5px;

        padding: 9px 13px;

        border: none;

        border-radius: 6px;

        background: #198754;

        color: white;

        cursor: pointer;

        font: inherit;

        font-weight: bold;
    }


    .boton-anadir-division:hover {
        background: #157347;
    }


    .sin-divisiones {
        padding: 12px;

        margin-bottom: 10px;

        border-radius: 6px;

        background: #f5f5f5;

        color: #666;

        font-size: 14px;
    }


    /* =====================================================
       BOTONES
    ===================================================== */

    .acciones-editar {
        display: flex;

        gap: 10px;

        margin-top: 30px;
    }


    .boton-guardar,
    .boton-volver {
        padding: 11px 16px;

        border: 0;

        border-radius: 6px;

        color: white;

        cursor: pointer;

        font: inherit;

        font-weight: bold;

        text-decoration: none;
    }


    .boton-guardar {
        background: #198754;
    }


    .boton-guardar:hover {
        background: #157347;
    }


    .boton-volver {
        background: #555;
    }


    .boton-volver:hover {
        background: #444;
    }


    /* =====================================================
       ERRORES
    ===================================================== */

    .alerta-gestion {
        margin-bottom: 18px;

        padding: 12px 16px;

        border-radius: 6px;

        background: #f8d7da;

        color: #842029;
    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 700px) {

        .editar-agente {
            padding: 20px;
        }


        .division-fila {
            grid-template-columns: 1fr;
        }


        .boton-quitar-division {
            width: 100%;
        }


        .acciones-editar {
            flex-direction: column;
        }


        .boton-guardar,
        .boton-volver {
            width: 100%;

            text-align: center;

            box-sizing: border-box;
        }

    }

</style>

@endpush


@section('content')

<div class="editar-agente">


    {{-- =====================================================
         CABECERA
    ====================================================== --}}

    <h1>
        ✏️ Editar Agente
    </h1>


    <div class="editar-descripcion">

        Modifica los datos del agente y sus divisiones.

    </div>


    {{-- =====================================================
         ERRORES
    ====================================================== --}}

    @if($errors->any())

        <div class="alerta-gestion">

            @foreach($errors->all() as $error)

                <div>
                    {{ $error }}
                </div>

            @endforeach

        </div>

    @endif


    {{-- =====================================================
         FORMULARIO
    ====================================================== --}}

    <form
        action="{{ route('gestion-agentes.update', $agenteRegistro->id) }}"
        method="POST"
    >

        @csrf

        @method('PUT')


        {{-- =================================================
             NOMBRE
        ================================================== --}}

        <div class="campo-editar">

            <label for="nombre">
                Nombre
            </label>

            <input
                id="nombre"
                name="nombre"
                type="text"
                maxlength="45"
                value="{{ old('nombre', $agenteRegistro->nombre) }}"
                required
            >

        </div>


        {{-- =================================================
             PLACA
        ================================================== --}}

        <div class="campo-editar">

            <label for="placa">
                Número de placa
            </label>

            <input
                id="placa"
                name="placa"
                type="text"
                maxlength="45"
                value="{{ old('placa', $agenteRegistro->placa) }}"
                required
            >

        </div>


        {{-- =================================================
             RANGO
        ================================================== --}}

        <div class="campo-editar">

            <label for="rango_id">
                Rango
            </label>

            <select
                id="rango_id"
                name="rango_id"
                required
            >

                <option value="">
                    Selecciona un rango
                </option>

                @foreach($rangos as $rango)

                    <option
                        value="{{ $rango->id }}"

                        {{
                            (string)
                            old(
                                'rango_id',
                                optional(
                                    $rangos->firstWhere(
                                        'rango',
                                        $agenteRegistro->rango
                                    )
                                )->id
                            )
                            ===
                            (string)
                            $rango->id
                                ? 'selected'
                                : ''
                        }}
                    >

                        {{ $rango->rango }}

                    </option>

                @endforeach

            </select>

        </div>


        {{-- =================================================
             USUARIO
        ================================================== --}}

        <div class="campo-editar">

            <label for="usuario">
                Usuario
            </label>

            <input
                id="usuario"
                name="usuario"
                type="text"
                maxlength="45"
                value="{{ old('usuario', $agenteRegistro->usuario) }}"
                required
            >

        </div>


        {{-- =================================================
             CONTRASEÑA
        ================================================== --}}

        <div class="campo-editar">

            <label for="contraseña">
                Contraseña
            </label>

            <input
                id="contraseña"
                name="contraseña"
                type="text"
                maxlength="45"
                value="{{ old('contraseña', $agenteRegistro->contraseña) }}"
                required
            >

        </div>


        {{-- =================================================
             DIVISIONES
        ================================================== --}}

        <div class="divisiones-seccion">


            <h2 class="divisiones-titulo">
                🏢 Divisiones
            </h2>


            <div class="divisiones-descripcion">

                Añade las divisiones a las que pertenece este agente
                y selecciona su rango dentro de cada una.

            </div>


            <div id="divisiones-contenedor">


                @forelse($divisionesAgente as $index => $divisionAgente)

                    <div
                        class="division-fila"
                        data-division-fila
                    >


                        {{-- DIVISIÓN --}}

                        <div class="division-campo">

                            <label>
                                División
                            </label>

                            <select
                                name="divisiones[{{ $index }}][division]"
                                class="select-division"
                                required
                            >

                                <option value="">
                                    Selecciona una división
                                </option>

                                @foreach($divisiones as $division)

                                    <option
                                        value="{{ $division->id }}"

                                        {{
                                            (int)
                                            $divisionAgente->division
                                            ===
                                            (int)
                                            $division->id
                                                ? 'selected'
                                                : ''
                                        }}
                                    >

                                        {{ $division->nombre }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- RANGO DE DIVISIÓN --}}

                        <div class="division-campo">

                            <label>
                                Rango en la división
                            </label>

                            <select
                                name="divisiones[{{ $index }}][rango_division]"
                                class="select-rango-division"
                            >

                                <option value="">
                                    Sin rango
                                </option>


                                @if(
                                    isset(
                                        $rangosDivisiones[
                                            $divisionAgente->division
                                        ]
                                    )
                                )

                                    @foreach(
                                        $rangosDivisiones[
                                            $divisionAgente->division
                                        ]
                                        as $rangoDivision
                                    )

                                        <option
                                            value="{{ $rangoDivision->id }}"

                                            {{
                                                (int)
                                                $divisionAgente->rango_division
                                                ===
                                                (int)
                                                $rangoDivision->id
                                                    ? 'selected'
                                                    : ''
                                            }}
                                        >

                                            {{ $rangoDivision->nombre }}

                                        </option>

                                    @endforeach

                                @endif

                            </select>

                        </div>


                        {{-- QUITAR --}}

                        <button
                            type="button"
                            class="boton-quitar-division"
                            onclick="quitarDivision(this)"
                            title="Quitar división"
                        >
                            🗑️
                        </button>


                    </div>

                @empty

                    <div
                        class="sin-divisiones"
                        id="sin-divisiones"
                    >

                        Este agente no pertenece actualmente
                        a ninguna división.

                    </div>

                @endforelse


            </div>


            {{-- AÑADIR --}}

            <button
                type="button"
                class="boton-anadir-division"
                onclick="anadirDivision()"
            >

                ➕ Añadir división

            </button>


        </div>


        {{-- =================================================
             BOTONES
        ================================================== --}}

        <div class="acciones-editar">

            <button
                class="boton-guardar"
                type="submit"
            >
                💾 Guardar cambios
            </button>


            <a
                class="boton-volver"
                href="{{ route('gestion-agentes.index') }}"
            >
                Cancelar
            </a>

        </div>


    </form>

</div>


{{-- =====================================================
     PLANTILLA DE RANGOS
====================================================== --}}

<script>

    const rangosDivisiones = @json($rangosDivisiones);


    let contadorDivisiones =
        {{ $divisionesAgente->count() }};


    /*
    |--------------------------------------------------------------------------
    | AÑADIR DIVISIÓN
    |--------------------------------------------------------------------------
    */

    function anadirDivision()
    {
        const contenedor =
            document.getElementById(
                'divisiones-contenedor'
            );


        const sinDivisiones =
            document.getElementById(
                'sin-divisiones'
            );


        if (sinDivisiones) {

            sinDivisiones.remove();

        }


        const index =
            contadorDivisiones;


        contadorDivisiones++;


        const fila =
            document.createElement(
                'div'
            );


        fila.className =
            'division-fila';


        fila.setAttribute(
            'data-division-fila',
            ''
        );


        fila.innerHTML = `

            <div class="division-campo">

                <label>
                    División
                </label>

                <select
                    name="divisiones[${index}][division]"
                    class="select-division"
                    onchange="actualizarRangos(this)"
                    required
                >

                    <option value="">
                        Selecciona una división
                    </option>

                    @foreach($divisiones as $division)

                        <option
                            value="{{ $division->id }}"
                        >
                            {{ $division->nombre }}
                        </option>

                    @endforeach

                </select>

            </div>


            <div class="division-campo">

                <label>
                    Rango en la división
                </label>

                <select
                    name="divisiones[${index}][rango_division]"
                    class="select-rango-division"
                >

                    <option value="">
                        Sin rango
                    </option>

                </select>

            </div>


            <button
                type="button"
                class="boton-quitar-division"
                onclick="quitarDivision(this)"
                title="Quitar división"
            >
                🗑️
            </button>

        `;


        contenedor.appendChild(
            fila
        );
    }


    /*
    |--------------------------------------------------------------------------
    | ACTUALIZAR RANGOS
    |--------------------------------------------------------------------------
    */

    function actualizarRangos(
        selectDivision
    )
    {
        const fila =
            selectDivision.closest(
                '[data-division-fila]'
            );


        const selectRango =
            fila.querySelector(
                '.select-rango-division'
            );


        const divisionId =
            selectDivision.value;


        selectRango.innerHTML = `

            <option value="">
                Sin rango
            </option>

        `;


        if (!divisionId) {

            return;

        }


        const rangos =
            rangosDivisiones[
                divisionId
            ] || [];


        rangos.forEach(
            function (rango)
            {

                const option =
                    document.createElement(
                        'option'
                    );


                option.value =
                    rango.id;


                option.textContent =
                    rango.nombre;


                selectRango.appendChild(
                    option
                );

            }
        );
    }


    /*
    |--------------------------------------------------------------------------
    | QUITAR DIVISIÓN
    |--------------------------------------------------------------------------
    */

    function quitarDivision(
        boton
    )
    {
        const fila =
            boton.closest(
                '[data-division-fila]'
            );


        if (fila) {

            fila.remove();

        }


        const contenedor =
            document.getElementById(
                'divisiones-contenedor'
            );


        const filas =
            contenedor.querySelectorAll(
                '[data-division-fila]'
            );


        if (
            filas.length === 0
        ) {

            const aviso =
                document.createElement(
                    'div'
                );


            aviso.className =
                'sin-divisiones';


            aviso.id =
                'sin-divisiones';


            aviso.textContent =
                'Este agente no pertenece actualmente a ninguna división.';


            contenedor.appendChild(
                aviso
            );

        }
    }


    /*
    |--------------------------------------------------------------------------
    | INICIALIZAR SELECTS EXISTENTES
    |--------------------------------------------------------------------------
    */

    document
        .querySelectorAll(
            '.select-division'
        )
        .forEach(
            function (select)
            {

                select.addEventListener(
                    'change',
                    function ()
                    {

                        actualizarRangos(
                            this
                        );

                    }
                );

            }
        );

</script>

@endsection