@extends('layout.app')

@section('title', 'PEAS')

@push('styles')
<style>

    .peas-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .peas-cabecera {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;

        margin-bottom: 20px;

        text-align: left;
    }

    .peas-cabecera h1 {
        margin: 0 0 8px;
        text-align: left;
    }

    .peas-cabecera p {
        margin: 0;
        color: #666;
        text-align: left;
    }


    /* =====================================================
       BOTÓN EDITAR
    ===================================================== */

    .boton-editar {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;

        padding: 10px 14px;

        border-radius: 6px;

        background: #f08c00;
        color: white;

        text-decoration: none;

        font-size: 14px;
        font-weight: bold;

        white-space: nowrap;
    }

    .boton-editar:hover {
        background: #d97700;
        color: white;
    }


    /* =====================================================
       MENSAJE
    ===================================================== */

    .mensaje-peas {
        margin-bottom: 15px;

        padding: 12px 16px;

        border-radius: 6px;

        background: #d1e7dd;
        color: #0f5132;

        text-align: left;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .peas-acordeon {
        width: 100%;

        margin-bottom: 12px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);

        overflow: hidden;

        text-align: left;
    }

    .peas-acordeon summary {
        display: flex;
        align-items: center;

        gap: 12px;

        width: 100%;

        box-sizing: border-box;

        padding: 16px 20px;

        cursor: pointer;

        list-style: none;

        font-size: 16px;
        font-weight: bold;

        text-align: left;
    }

    .peas-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .peas-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .peas-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .peas-acordeon summary:hover {
        background: #f5f5f5;
    }


    /* =====================================================
       CONTENIDO DEL ACORDEÓN
    ===================================================== */

    .peas-contenido {
        width: 100%;

        box-sizing: border-box;

        padding: 15px 20px 20px;

        border-top: 1px solid #eee;

        text-align: left;
    }


    /* =====================================================
       BLOQUE DEL COMANDO
    ===================================================== */

    .peas-codigo {
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

        text-align: left;

        white-space: normal;

        overflow-wrap: break-word;

        word-break: break-word;
    }


    /* =====================================================
       TEXTO
    ===================================================== */

    .texto-peas {
        display: block;

        width: 100%;

        box-sizing: border-box;

        padding-right: 5px;

        text-align: left;

        white-space: normal;

        overflow-wrap: anywhere;

        word-break: break-word;
    }


    /* =====================================================
       BOTÓN COPIAR
    ===================================================== */

    .peas-copiar {
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

    .peas-copiar:hover {
        background: #555;
    }

    .peas-copiado {
        background: #198754 !important;
    }


    /* =====================================================
       MÓVIL
    ===================================================== */

    @media (max-width: 600px) {

        .peas-cabecera {
            align-items: flex-start;
            flex-direction: column;
        }

        .boton-editar {
            width: 100%;
            box-sizing: border-box;
        }

        .peas-contenido {
            padding: 12px 15px 15px;
        }

        .peas-codigo {
            padding: 9px 40px 9px 10px;
            font-size: 11px;
        }

        .peas-copiar {
            width: 24px;
            height: 24px;

            right: 5px;

            font-size: 12px;
        }

    }

</style>
@endpush


@section('content')

<div class="peas-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="peas-cabecera">

        <div>

            <h1>
                🚨 PEAS
            </h1>

            <p>
                Protocolos de emergencia y avisos destinados a los ciudadanos.
            </p>

        </div>


        @if($esDirectiva)

            <a
                href="{{ route('peas.edit') }}"
                class="boton-editar"
            >
                ✏️ Editar PEAS
            </a>

        @endif

    </div>


    {{-- =====================================================
         MENSAJE DE ACTUALIZACIÓN
    ===================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje-peas">
            {{ session('mensaje') }}
        </div>

    @endif


    {{-- =====================================================
         PEAS
    ===================================================== --}}

    @foreach($peas as $pea)

        <details class="peas-acordeon">

            <summary>

                🚨

                <span>
                    {{ $pea['titulo'] }}
                </span>

            </summary>


            <div class="peas-contenido">

                <div class="peas-codigo">

                    <span class="texto-peas">{{ $pea['descripcion'] }}</span>

                    <button
                        type="button"
                        class="peas-copiar"
                        onclick="copiarPeas(this)"
                        title="Copiar"
                    >
                        📋
                    </button>

                </div>

            </div>

        </details>

    @endforeach


</div>

@endsection


@push('scripts')
<script>

    function copiarPeas(boton) {

        const contenedor = boton.closest('.peas-codigo');

        const elementoTexto = contenedor.querySelector('.texto-peas');

        const texto = elementoTexto.textContent.trim();


        navigator.clipboard.writeText(texto)

            .then(function () {

                boton.textContent = '✓';

                boton.classList.add('peas-copiado');


                setTimeout(function () {

                    boton.textContent = '📋';

                    boton.classList.remove('peas-copiado');

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

                boton.classList.add('peas-copiado');


                setTimeout(function () {

                    boton.textContent = '📋';

                    boton.classList.remove('peas-copiado');

                }, 1200);

            });

    }

</script>
@endpush