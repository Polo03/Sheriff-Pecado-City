@extends('layout.app')

@section('title', 'Bindeos')

@push('styles')
<style>

    .bindeos-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .bindeos-cabecera {
        margin-bottom: 20px;
    }

    .bindeos-cabecera h1 {
        margin: 0 0 8px;
    }

    .bindeos-cabecera p {
        margin: 0;
        color: #666;
        line-height: 1.6;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .bind-acordeon {
        margin-bottom: 12px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .bind-acordeon summary {
        display: flex;
        align-items: center;
        gap: 12px;

        padding: 16px 20px;

        cursor: pointer;

        list-style: none;

        font-size: 16px;
        font-weight: bold;
    }

    .bind-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .bind-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .bind-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .bind-acordeon summary:hover {
        background: #f5f5f5;
    }

    .bind-contenido {
        padding: 5px 20px 20px;
        border-top: 1px solid #eee;
    }


    /* =====================================================
       INFORMACIÓN
    ===================================================== */

    .bind-info {
        margin: 10px 0 18px;

        color: #555;

        line-height: 1.6;
    }

    .bind-info strong {
        color: #222;
    }


    /* =====================================================
       BINDS
    ===================================================== */

    .bind-item {
        margin-bottom: 15px;
    }

    .bind-titulo {
        margin-bottom: 6px;

        font-size: 13px;

        font-weight: bold;

        color: #555;
    }


    /* =====================================================
       RECTÁNGULO DEL COMANDO
    ===================================================== */

    .bind-codigo {
        position: relative;

        display: block;

        width: 100%;
        max-width: 100%;

        box-sizing: border-box;

        padding: 10px 42px 10px 12px;

        border-radius: 5px;

        background: #1f1f1f;

        color: #f1f1f1;

        font-family: Consolas, Monaco, monospace;

        font-size: 12px;

        line-height: 1.5;

        white-space: normal;

        overflow-wrap: break-word;

        word-break: break-word;
    }


    /* =====================================================
       TEXTO DEL COMANDO
    ===================================================== */

    .texto-bind {
        display: block;

        width: 100%;

        padding-right: 5px;

        box-sizing: border-box;

        white-space: normal;

        overflow-wrap: anywhere;

        word-break: break-word;
    }


    /* =====================================================
       BOTÓN COPIAR
    ===================================================== */

    .bind-copiar {
        position: absolute;

        top: 50%;
        right: 6px;

        transform: translateY(-50%);

        width: 26px;
        height: 26px;

        padding: 0;
        margin: 0;

        display: flex;

        align-items: center;
        justify-content: center;

        border: none;

        border-radius: 4px;

        background: #444;

        color: white;

        cursor: pointer;

        font-size: 13px;

        line-height: 1;

        z-index: 2;
    }

    .bind-copiar:hover {
        background: #555;
    }

    .bind-copiado {
        background: #198754 !important;
    }


    /* =====================================================
       AVISO
    ===================================================== */

    .bind-aviso {
        margin-top: 18px;

        padding: 12px 14px;

        border-radius: 6px;

        background: #f5f5f5;

        color: #666;

        font-size: 13px;

        line-height: 1.5;
    }


    /* =====================================================
       MÓVIL
    ===================================================== */

    @media (max-width: 600px) {

        .bind-contenido {
            padding-left: 15px;
            padding-right: 15px;
        }

        .bind-codigo {
            font-size: 11px;

            padding: 9px 40px 9px 10px;
        }

        .bind-copiar {
            width: 24px;
            height: 24px;

            right: 5px;

            font-size: 12px;
        }

    }

</style>
@endpush


@section('content')

<div class="bindeos-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="bindeos-cabecera">

        <h1>
            ⌨️ Bindeos
        </h1>

        <p>
            Aquí estarán unos binds que podrán usar para hacer
            comandos de rol más rápido y mejorar la experiencia
            de rol.
        </p>

    </div>


    {{-- =====================================================
         INFORMACIÓN GENERAL
    ===================================================== --}}

    <details class="bind-acordeon">

        <summary>
            📖 Información sobre los bindeos
        </summary>

        <div class="bind-contenido">

            <div class="bind-info">

                Los binds tendrán unos números. Al copiarlos podrán
                alternar ese número entre el <strong>7 al 0</strong>.
                Esto se hace con el fin de que no confluyan con el
                menú de armas.

            </div>

        </div>

    </details>


    {{-- =====================================================
         ENCAUTAR VEHÍCULOS
    ===================================================== --}}

    <details class="bind-acordeon">

        <summary>
            🚓 Bind para encautar vehículos
        </summary>

        <div class="bind-contenido">


            {{-- LLAMAR GRÚA --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Llamar a una grúa policial
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad7" "me ^1 llama a una grúa policial para que retire el vehículo"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- LLEGADA GRÚA --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Llegada de la grúa
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad7" "do ^5 Se vería llegar una grúa policial y llevarse el vehículo"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- ANIMACIÓN --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Animación
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad7" "e wt3"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


        </div>

    </details>


    {{-- =====================================================
         10-20
    ===================================================== --}}

    <details class="bind-acordeon">

        <summary>
            📡 Bind del 10-20
        </summary>

        <div class="bind-contenido">

            <div class="bind-info">

                Sustituye <strong>(músculo qué quieras)</strong>
                por la tecla que quieras utilizar.

            </div>


            <div class="bind-item">

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "(músculo qué quieras)" "sheriff 10-20 (Rango) + (Nombre)"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>

        </div>

    </details>


    {{-- =====================================================
         BINDS GENERALES
    ===================================================== --}}

    <details class="bind-acordeon">

        <summary>
            👮 Binds generales
        </summary>

        <div class="bind-contenido">


            {{-- VEHÍCULO --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Subir / bajar de un vehículo
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "(musculo que quieras)" "me Abre la puerta/cierra, le desabrocha/pone el cinturón y lo ayuda a bajar/subir."</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- ESPOSAS --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Poner / quitar esposas
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad1" "me ^1 Le pone/quita las esposas."</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- ESCOLTAR --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Escoltar
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad2" "me ^1 le escolta"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- CACHEAR --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Cachear
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad3" "me ^1 Lo Cachea en busca de sustancias/objetos/armas ilegales"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- PREGUNTAR ARMAS --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Preguntar por armas
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad3" "do ¿Tendria algun tipo de arma?"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- RETIRAR OBJETOS --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Retirar objetos, armas o sustancias
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad4" "me ^1 Le retira cualquier objeto/arma/sustancia ilegal"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- DISPOSITIVOS --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Retirar dispositivos de comunicación
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad5" "me ^1Le retira todos los dispositivos de comunicación"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- TABLET --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Tablet y ficha policial
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad6" "me ^1Saca la tablet, realiza la foto para la ficha policial, y procede a redactar el expediente en la base de datos del Dpto. de Sheriff."</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- ABRIR TABLET --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Abrir tablet
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad6" "e tablet2"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- PLACA --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Mostrar placa
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "8" "e idcardh"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- NÚMERO PLACA --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Mostrar número de placa
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "8" "do Se vería el numero de placa (numero)"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- COMPROBAR VEHÍCULO --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Comprobar vehículo
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "(Musculo que quieras)" "me ^^1Saca la tablet, comprueba marca, modelo, y matrícula del vehículo en la base de datos del Dpto. de Sheriff."</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- TABLET VEHÍCULO --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Abrir tablet para comprobar vehículo
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "(Musculo que quieras)" "e tablet2"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- CARRY --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Cargar / soltar
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad8" "carry"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- ANIMACIÓN CARRY --}}

            <div class="bind-item">

                <div class="bind-titulo">
                    Animación de cargar / soltar
                </div>

                <div class="bind-codigo">

                    <span class="texto-bind">bind keyboard "numpad8" "me ^1 Lo carga/suelta con cuidado"</span>

                    <button
                        type="button"
                        class="bind-copiar"
                        onclick="copiarBind(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>


            {{-- AVISO --}}

            <div class="bind-aviso">

                💡 Recuerda que puedes cambiar las teclas
                <strong>numpad7, numpad8, etc.</strong> por las teclas
                que prefieras, siempre teniendo en cuenta el resto de
                controles del juego.

            </div>


        </div>

    </details>


</div>

@endsection


@push('scripts')
<script>

    function copiarBind(boton) {

        const contenedor = boton.closest('.bind-codigo');

        const elementoTexto = contenedor.querySelector('.texto-bind');

        const texto = elementoTexto.textContent.trim();


        navigator.clipboard.writeText(texto)

            .then(function () {

                boton.textContent = '✓';

                boton.classList.add('bind-copiado');


                setTimeout(function () {

                    boton.textContent = '📋';

                    boton.classList.remove('bind-copiado');

                }, 1200);

            })

            .catch(function () {

                const textarea = document.createElement('textarea');

                textarea.value = texto;

                textarea.style.position = 'fixed';

                textarea.style.opacity = '0';

                document.body.appendChild(textarea);

                textarea.focus();

                textarea.select();

                document.execCommand('copy');

                textarea.remove();


                boton.textContent = '✓';

                boton.classList.add('bind-copiado');


                setTimeout(function () {

                    boton.textContent = '📋';

                    boton.classList.remove('bind-copiado');

                }, 1200);

            });

    }

</script>
@endpush