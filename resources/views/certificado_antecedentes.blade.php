@extends('layout.app')

@section('title', 'Certificado de antecedentes')

@push('styles')
<style>

    .antecedentes-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }

    /* =====================================================
       CABECERA
    ===================================================== */

    .antecedentes-cabecera {
        margin-bottom: 20px;
        text-align: left;
    }

    .antecedentes-cabecera h1 {
        margin: 0 0 8px;
        text-align: left;
    }

    .antecedentes-cabecera p {
        margin: 0;
        color: #666;
        text-align: left;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .antecedentes-acordeon {
        width: 100%;

        margin-bottom: 12px;

        border-radius: 8px;

        background: white;

        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);

        overflow: hidden;

        text-align: left;
    }

    .antecedentes-acordeon summary {
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

    .antecedentes-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .antecedentes-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .antecedentes-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .antecedentes-acordeon summary:hover {
        background: #f5f5f5;
    }


    /* =====================================================
       CONTENIDO
    ===================================================== */

    .antecedentes-contenido {
        width: 100%;

        box-sizing: border-box;

        padding: 15px 20px 20px;

        border-top: 1px solid #eee;

        text-align: left;
    }


    /* =====================================================
       BLOQUE DEL TEXTO
    ===================================================== */

    .antecedentes-codigo {
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

    .texto-antecedentes {
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

    .antecedentes-copiar {
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

    .antecedentes-copiar:hover {
        background: #555;
    }

    .antecedentes-copiado {
        background: #198754 !important;
    }


    /* =====================================================
       MÓVIL
    ===================================================== */

    @media (max-width: 600px) {

        .antecedentes-contenido {
            padding: 12px 15px 15px;
        }

        .antecedentes-codigo {
            padding: 9px 40px 9px 10px;

            font-size: 11px;
        }

        .antecedentes-copiar {
            width: 24px;
            height: 24px;

            right: 5px;

            font-size: 12px;
        }

    }

</style>
@endpush


@section('content')

<div class="antecedentes-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="antecedentes-cabecera">

        <h1>
            📜 Certificado de antecedentes
        </h1>

        <p>
            Plantillas para la elaboración de certificados de antecedentes.
        </p>

    </div>


    {{-- =====================================================
         SIN ANTECEDENTES
    ===================================================== --}}

    <details class="antecedentes-acordeon">

        <summary>

            🟢

            <span>
                En caso de no tener antecedentes
            </span>

        </summary>


        <div class="antecedentes-contenido">

            <div class="antecedentes-codigo">

                <span class="texto-antecedentes">/do En el certificado se vería que (Nombre persona) no consta que a día (00/00/00) tenga ningún tipo de antecedente en la base datos. Fdo: (Rango y Apellido y nº de placa)</span>

                <button
                    type="button"
                    class="antecedentes-copiar"
                    onclick="copiarAntecedentes(this)"
                    title="Copiar"
                >
                    📋
                </button>

            </div>

        </div>

    </details>


    {{-- =====================================================
         CON ANTECEDENTES
    ===================================================== --}}

    <details class="antecedentes-acordeon">

        <summary>

            🔴

            <span>
                En caso de tener antecedentes
            </span>

        </summary>


        <div class="antecedentes-contenido">

            <div class="antecedentes-codigo">

                <span class="texto-antecedentes">/do En el certificado se vería que (Nombre persona) consta con (Numero de antecedentes) antecedente, (Artículos que tendría en sus antecedentes) con un total de (suma total de los meses) en la base de datos. A la Fecha de (00/00/00). Fdo: (Rango y Apellido y nº de placa)</span>

                <button
                    type="button"
                    class="antecedentes-copiar"
                    onclick="copiarAntecedentes(this)"
                    title="Copiar"
                >
                    📋
                </button>

            </div>

        </div>

    </details>


</div>

@endsection


@push('scripts')
<script>

    function copiarAntecedentes(boton) {

        const contenedor = boton.closest('.antecedentes-codigo');

        const elementoTexto = contenedor.querySelector('.texto-antecedentes');

        const texto = elementoTexto.textContent.trim();


        navigator.clipboard.writeText(texto)

            .then(function () {

                boton.textContent = '✓';

                boton.classList.add('antecedentes-copiado');


                setTimeout(function () {

                    boton.textContent = '📋';

                    boton.classList.remove('antecedentes-copiado');

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

                boton.classList.add('antecedentes-copiado');


                setTimeout(function () {

                    boton.textContent = '📋';

                    boton.classList.remove('antecedentes-copiado');

                }, 1200);

            });

    }

</script>
@endpush