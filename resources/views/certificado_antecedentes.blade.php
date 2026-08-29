@extends('layout.app')

@section('title', 'Certificado de antecedentes')

@push('styles')
<style>
    .certificado-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .certificado-cabecera {
        margin-bottom: 20px;
    }

    .certificado-cabecera h1 {
        margin: 0 0 8px;
    }

    .certificado-cabecera p {
        margin: 0;
        color: #666;
    }

    /* =====================================================
       ACORDEONES
    ===================================================== */

    .certificado-acordeon {
        margin-bottom: 12px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .certificado-acordeon summary {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 20px;
        cursor: pointer;
        list-style: none;
        font-weight: bold;
        font-size: 16px;
    }

    .certificado-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .certificado-acordeon summary::after {
        content: '›';
        margin-left: auto;
        font-size: 22px;
        transition: transform 0.2s ease;
    }

    .certificado-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .certificado-acordeon summary:hover {
        background: #f5f5f5;
    }

    .certificado-contenido {
        padding: 0 20px 20px;
        border-top: 1px solid #eee;
    }

    .certificado-contenido h2 {
        margin: 18px 0 12px;
        font-size: 18px;
    }

    .texto-certificado {
        margin: 0;
        padding: 16px;
        border-radius: 6px;
        background: #f5f5f5;
        color: #333;
        line-height: 1.6;
        white-space: pre-wrap;
    }

    .etiqueta-situacion {
        display: inline-block;
        margin-top: 18px;
        padding: 6px 10px;
        border-radius: 5px;
        font-size: 12px;
        font-weight: bold;
    }

    .etiqueta-no-antecedentes {
        background: #d1e7dd;
        color: #0f5132;
    }

    .etiqueta-antecedentes {
        background: #f8d7da;
        color: #842029;
    }
</style>
@endpush

@section('content')

<div class="certificado-pagina">

    <div class="certificado-cabecera">

        <h1>📜 Certificado de antecedentes</h1>

        <p>
            Plantillas para la realización de certificados de antecedentes.
        </p>

    </div>


    {{-- =====================================================
         EN CASO DE NO TENER ANTECEDENTES
    ====================================================== --}}

    <details class="certificado-acordeon">

        <summary>
            ➡️ En caso de no tener antecedentes
        </summary>

        <div class="certificado-contenido">

            <span class="etiqueta-situacion etiqueta-no-antecedentes">
                SIN ANTECEDENTES
            </span>

            <h2>📄 Plantilla</h2>

            <p class="texto-certificado">/do En el certificado se vería que (Nombre persona) no consta que a día (00/00/00) tenga ningún tipo de antecedente en la base datos. Fdo: (Rango y Apellido y nº de placa)</p>

        </div>

    </details>


    {{-- =====================================================
         EN CASO DE TENER ANTECEDENTES
    ====================================================== --}}

    <details class="certificado-acordeon">

        <summary>
            🔺 En caso de tener antecedentes
        </summary>

        <div class="certificado-contenido">

            <span class="etiqueta-situacion etiqueta-antecedentes">
                CON ANTECEDENTES
            </span>

            <h2>📄 Plantilla</h2>

            <p class="texto-certificado">/do En el certificado se vería que (Nombre persona) consta con (Numero de antecedentes) antecedente, (Artículos que tendría en sus antecedentes) con un total de (suma total de los meses) en la base de datos. A la Fecha de (00/00/00). Fdo: (Rango y Apellido y nº de placa)</p>

        </div>

    </details>

</div>

@endsection