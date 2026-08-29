@extends('layout.app')

@section('title', $division->nombre)

@push('styles')
<style>

    .division-pagina {
        width: 100%;
        max-width: 900px;
        margin: 0 auto;
        text-align: left;
    }


    /* =====================================================
       CABECERA
    ===================================================== */

    .division-cabecera {
        margin-bottom: 20px;
    }

    .division-cabecera h1 {
        margin: 0 0 8px;
    }

    .division-cabecera p {
        margin: 0;
        color: #666;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .division-acordeon {
        width: 100%;

        margin-bottom: 12px;

        border-radius: 8px;

        background: white;

        box-shadow:
            0 3px 12px rgba(0, 0, 0, 0.08);

        overflow: hidden;
    }

    .division-acordeon summary {
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
    }

    .division-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .division-acordeon summary::after {
        content: '›';

        margin-left: auto;

        color: #777;

        font-size: 22px;

        transition: transform 0.2s ease;
    }

    .division-acordeon[open] summary::after {
        transform: rotate(90deg);
    }


    /* =====================================================
       CONTENIDO
    ===================================================== */

    .division-contenido {
        padding: 15px 20px 20px;

        border-top: 1px solid #eee;
    }


    .division-info {
        padding: 12px;

        border-radius: 6px;

        background: #f5f5f5;

        line-height: 1.6;
    }


    /* =====================================================
       AGENTES
    ===================================================== */

    .agente-division {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding: 10px 0;

        border-bottom: 1px solid #eee;
    }

    .agente-division:last-child {
        border-bottom: none;
    }

    .agente-nombre {
        font-weight: bold;
    }

    .agente-rango {
        color: #666;

        font-size: 13px;
    }


    /* =====================================================
       POSTULACIÓN
    ===================================================== */

    .postulacion {
        padding: 12px;

        margin-bottom: 10px;

        border-radius: 6px;

        background: #f5f5f5;
    }

    .postulacion:last-child {
        margin-bottom: 0;
    }


    .mensaje {
        margin-bottom: 15px;

        padding: 12px 15px;

        border-radius: 6px;

        background: #d1e7dd;

        color: #0f5132;
    }

    .error {
        margin-bottom: 15px;

        padding: 12px 15px;

        border-radius: 6px;

        background: #f8d7da;

        color: #842029;
    }

    /* =====================================================
   POSTULACIONES
===================================================== */

.postulacion-acordeon {
    width: 100%;

    margin-bottom: 10px;

    border-radius: 7px;

    background: #f5f5f5;

    overflow: hidden;
}


.postulacion-acordeon:last-child {
    margin-bottom: 0;
}


.postulacion-acordeon summary {
    display: flex;

    align-items: center;

    gap: 10px;

    width: 100%;

    box-sizing: border-box;

    padding: 13px 15px;

    cursor: pointer;

    list-style: none;

    font-size: 14px;

    font-weight: bold;
}


.postulacion-acordeon summary::-webkit-details-marker {
    display: none;
}


.postulacion-acordeon summary::after {
    content: '›';

    margin-left: auto;

    color: #777;

    font-size: 20px;

    transition: transform .2s ease;
}


.postulacion-acordeon[open]
summary::after {
    transform: rotate(90deg);
}


.postulacion-titulo {
    flex: 1;
}


.postulacion-contenido {
    padding: 12px 15px;

    border-top: 1px solid #ddd;

    font-size: 14px;
}


.postulacion-dato {
    margin-bottom: 7px;
}


.postulacion-dato:last-child {
    margin-bottom: 0;
}


.sin-postulaciones {
    padding: 12px 15px;

    border-radius: 6px;

    background: #f5f5f5;

    color: #777;

    font-size: 14px;
}


    /* =====================================================
       MÓVIL
    ===================================================== */

    @media (max-width: 600px) {

        .division-contenido {
            padding: 12px 15px 15px;
        }

        .agente-division {
            align-items: flex-start;

            flex-direction: column;

            gap: 4px;
        }

    }

</style>
@endpush


@section('content')

<div class="division-pagina">


    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="division-cabecera">

        <h1>
            🏢 {{ $division->nombre }}
        </h1>

        <p>
            Información de tu división.
        </p>

    </div>


    {{-- =====================================================
         MENSAJES
    ===================================================== --}}

    @if(session('mensaje'))

        <div class="mensaje">
            {{ session('mensaje') }}
        </div>

    @endif


    @if(session('error'))

        <div class="error">
            {{ session('error') }}
        </div>

    @endif


    {{-- =====================================================
         MI INFORMACIÓN
    ===================================================== --}}

    <details class="division-acordeon" open>

        <summary>
            👮 Mi información
        </summary>

        <div class="division-contenido">

            <div class="division-info">

                @if($relacion->estado === 'activo')

                    <strong>
                        Perteneces a esta división.
                    </strong>

                    <br>

                    Rango dentro de la división:

                    <strong>
                        {{ $rangoDivision->nombre ?? 'Sin rango asignado' }}
                    </strong>

                @else

                    <strong>
                        Tu postulación está pendiente.
                    </strong>

                    <br>

                    Actualmente estás postulando para entrar
                    en esta división.

                @endif

            </div>

        </div>

    </details>


    {{-- =====================================================
         RANGOS
    ===================================================== --}}

    <details class="division-acordeon">

        <summary>
            🎖️ Rangos de la división
        </summary>

        <div class="division-contenido">

            @forelse($rangos as $rango)

                <div class="agente-division">

                    <span class="agente-nombre">
                        {{ $rango->nombre }}
                    </span>

                </div>

            @empty

                <span>
                    No hay rangos configurados.
                </span>

            @endforelse

        </div>

    </details>


    {{-- =====================================================
         AGENTES
    ===================================================== --}}

    @if($relacion->estado === 'activo')

        <details class="division-acordeon">

            <summary>
                👥 Agentes de la división
            </summary>

            <div class="division-contenido">

                @forelse($agentes as $agente)

                    <div class="agente-division">

                        <div>

                            <div class="agente-nombre">

                                {{ $agente->nombre }}

                                @if(
                                    isset($placas[$agente->id])
                                    &&
                                    $placas[$agente->id]
                                )

                                    · {{ $placas[$agente->id] }}

                                @endif

                            </div>

                            <div class="agente-rango">

                                {{ $agente->rango_division ?? 'Sin rango' }}

                            </div>

                        </div>

                    </div>

                @empty

                    <span>
                        No hay agentes en esta división.
                    </span>

                @endforelse

            </div>

        </details>

    @endif


    {{-- =====================================================
     POSTULACIONES
===================================================== --}}

@if($puedeVerPostulaciones)

    <details class="division-acordeon">

        <summary>
            📋 Postulaciones
        </summary>


        <div class="division-contenido">

            @forelse($postulaciones as $postulacion)

                <details class="postulacion-acordeon">

                    <summary>

                        📋

                        <span class="postulacion-titulo">

                            Postulación -

                            {{ $postulacion->nombre }}

                            @if($postulacion->placa)

                                - {{ $postulacion->placa }}

                            @endif

                        </span>

                    </summary>


                    <div class="postulacion-contenido">

                        <div class="postulacion-dato">

                            <strong>
                                Agente:
                            </strong>

                            {{ $postulacion->nombre }}

                        </div>


                        @if($postulacion->placa)

                            <div class="postulacion-dato">

                                <strong>
                                    Placa:
                                </strong>

                                {{ $postulacion->placa }}

                            </div>

                        @endif


                        <div class="postulacion-dato">

                            <strong>
                                Estado:
                            </strong>

                            Postulación pendiente

                        </div>

                    </div>

                </details>

            @empty

                <div class="sin-postulaciones">

                    No hay postulaciones pendientes
                    para esta división.

                </div>

            @endforelse

        </div>

    </details>

@endif


</div>

@endsection