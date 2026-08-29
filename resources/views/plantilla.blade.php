@extends('layout.app')

@section('title', 'Plantilla')

@push('styles')
<style>

    .plantilla-pagina {
        max-width: 900px;
        margin: 0 auto;
    }

    .plantilla-cabecera {
        margin-bottom: 20px;
    }

    .plantilla-cabecera h1 {
        margin: 0 0 8px;
    }

    .plantilla-cabecera p {
        margin: 0;
        color: #666;
    }

    /* =====================================================
       ACORDEONES
    ===================================================== */

    .plantilla-acordeon {
        margin-bottom: 12px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .plantilla-acordeon summary {
        display: flex;
        align-items: center;
        gap: 10px;

        padding: 16px 20px;

        cursor: pointer;

        list-style: none;

        font-size: 16px;
        font-weight: bold;
    }

    .plantilla-acordeon summary::-webkit-details-marker {
        display: none;
    }

    .plantilla-acordeon summary::after {
        content: '›';

        margin-left: 10px;

        font-size: 22px;

        color: #777;

        transition: transform 0.2s ease;
    }

    .plantilla-acordeon[open] summary::after {
        transform: rotate(90deg);
    }

    .plantilla-acordeon summary:hover {
        background: #f5f5f5;
    }

    /* =====================================================
       RANGO + ESCALA
    ===================================================== */

    .rango-nombre {
        font-weight: bold;
    }

    .rango-escala {
        margin-left: auto;

        padding: 5px 10px;

        border-radius: 5px;

        background: #f1f1f1;

        color: #666;

        font-size: 12px;

        font-weight: normal;
    }

    /* =====================================================
       AGENTES
    ===================================================== */

    .agentes-rango {
        padding: 5px 20px 18px;

        border-top: 1px solid #eee;
    }

    .agente-plantilla {
        display: flex;

        align-items: center;

        justify-content: space-between;

        gap: 15px;

        padding: 11px 13px;

        margin-top: 7px;

        border-radius: 6px;

        background: #f5f5f5;
    }

    .agente-nombre {
        font-weight: 500;
    }

    .agente-placa {
        color: #666;

        font-size: 13px;

        white-space: nowrap;
    }

    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 600px) {

        .plantilla-pagina {
            margin: 0 5px;
        }

        .agente-plantilla {
            align-items: flex-start;
            flex-direction: column;
            gap: 5px;
        }

        .rango-escala {
            margin-left: auto;
        }

    }

</style>
@endpush


@section('content')

<div class="plantilla-pagina">

    {{-- =====================================================
         CABECERA
    ===================================================== --}}

    <div class="plantilla-cabecera">

        <h1>
            👮 Plantilla del Departamento
        </h1>

        <p>
            Consulta los agentes actualmente registrados,
            organizados por rango.
        </p>

    </div>


    {{-- =====================================================
         DIRECTIVA
    ===================================================== --}}

    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Sheriff
            </span>

            <span class="rango-escala">
                Directiva
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Sheriff', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Comisario
            </span>

            <span class="rango-escala">
                Directiva
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Comisario', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Sub Comisario
            </span>

            <span class="rango-escala">
                Directiva
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Sub Comisario', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    {{-- =====================================================
         JEFATURA
    ===================================================== --}}

    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Coronel
            </span>

            <span class="rango-escala">
                Jefatura
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Coronel', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Capitán
            </span>

            <span class="rango-escala">
                Jefatura
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Capitán', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    {{-- =====================================================
         SUPERIOR
    ===================================================== --}}

    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Teniente
            </span>

            <span class="rango-escala">
                Superior
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Teniente', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Sargento II
            </span>

            <span class="rango-escala">
                Superior
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Sargento II', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Sargento
            </span>

            <span class="rango-escala">
                Superior
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Sargento', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    {{-- =====================================================
         BÁSICA
    ===================================================== --}}

    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Cabo III
            </span>

            <span class="rango-escala">
                Básica
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Cabo III', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Cabo II
            </span>

            <span class="rango-escala">
                Básica
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Cabo II', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Cabo
            </span>

            <span class="rango-escala">
                Básica
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Cabo', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Patrulla Sr.
            </span>

            <span class="rango-escala">
                Básica
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Patrulla Sr.', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Patrulla
            </span>

            <span class="rango-escala">
                Básica
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Patrulla', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Patrulla Jr.
            </span>

            <span class="rango-escala">
                Básica
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Patrulla Jr.', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


    {{-- =====================================================
         ACADEMIA
    ===================================================== --}}

    <details class="plantilla-acordeon">

        <summary>
            <span class="rango-nombre">
                🎖️ Sheriff en prácticas
            </span>

            <span class="rango-escala">
                Academia
            </span>
        </summary>

        <div class="agentes-rango">

            @foreach($plantilla->get('Sheriff en prácticas', collect()) as $agente)

                <div class="agente-plantilla">

                    <span class="agente-nombre">
                        👮 {{ $agente->nombre }}
                    </span>

                    <span class="agente-placa">
                        Placa: <strong>{{ $agente->placa }}</strong>
                    </span>

                </div>

            @endforeach

        </div>

    </details>


</div>

@endsection