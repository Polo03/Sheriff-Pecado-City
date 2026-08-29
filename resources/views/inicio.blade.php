@extends('layout.app')

@section('title', 'Inicio')

@push('styles')
<style>

    /* =====================================================
       PÁGINA PRINCIPAL
    ===================================================== */

    .inicio-pagina {
        max-width: 1150px;
        margin: 0 auto;
    }

    /* =====================================================
    ACORDEÓN DE BIENVENIDA
    ===================================================== */

    .acordeon-bienvenida {
        margin-bottom: 12px;
    }

    .acordeon-bienvenida .acordeon-contenido p {
        margin: 0 0 14px 0;
        color: #666;
        font-size: 16px;
        line-height: 1.6;
    }

    .acordeon-bienvenida .acordeon-contenido p:last-of-type {
        margin-bottom: 0;
    }

    /* =====================================================
       CABECERA
    ===================================================== */

    .inicio-bienvenida {
        background: white;
        border-radius: 14px;
        padding: 30px;
        margin-bottom: 25px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.10);
    }

    .inicio-bienvenida h1 {
        margin: 0 0 10px 0;
        font-size: 30px;
    }

    .inicio-bienvenida p {
        margin: 0;
        color: #666;
        font-size: 16px;
        line-height: 1.6;
    }


    /* =====================================================
       ACORDEONES
    ===================================================== */

    .inicio-acordeones {
        display: grid;
        gap: 12px;
        margin-bottom: 25px;
    }

    .acordeon {
        background: white;
        border-radius: 10px;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
        overflow: hidden;
    }

    .acordeon summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 18px 20px;
        cursor: pointer;
        font-size: 18px;
        font-weight: bold;
        list-style: none;
        user-select: none;
        transition: background 0.15s ease;
    }

    .acordeon summary::-webkit-details-marker {
        display: none;
    }

    .acordeon summary::after {
        content: "⌄";
        font-size: 22px;
        color: #666;
        transition: transform 0.2s ease;
    }

    .acordeon[open] summary::after {
        transform: rotate(180deg);
    }

    .acordeon summary:hover {
        background: #f5f5f5;
    }

    .acordeon[open] summary {
        border-bottom: 1px solid #e5e5e5;
        background: #fafafa;
    }

    .acordeon-contenido {
        padding: 20px;
    }

    .acordeon-contenido hr {
        border: 0;
        border-top: 1px solid #ddd;
        margin: 22px 0;
    }


    /* =====================================================
       RANGOS
    ===================================================== */

    .rangos-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 15px;
    }

    .rango {
        padding: 16px;
        border-radius: 9px;
        background: #f5f5f5;
    }

    .rango h3 {
        margin: 0 0 10px 0;
        font-size: 16px;
    }

    .rango ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .rango li {
        padding: 4px 0;
        color: #444;
    }


    /* =====================================================
       CÓDIGOS
    ===================================================== */

    .codigo-seccion h3 {
        margin-top: 0;
        margin-bottom: 12px;
    }

    .codigos-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 8px;
    }

    .codigo {
        display: flex;
        gap: 10px;
        padding: 10px 12px;
        border-radius: 7px;
        background: #f5f5f5;
    }

    .codigo strong {
        min-width: 100px;
    }


    /* =====================================================
       DERECHOS
    ===================================================== */

    .derechos {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .derechos li {
        padding: 10px 0;
        line-height: 1.5;
        border-bottom: 1px solid #eee;
    }

    .derechos li:last-child {
        border-bottom: none;
    }


    /* =====================================================
       PDF
    ===================================================== */

    .pdf-contenedor {
        width: 100%;
        height: 750px;
        overflow: hidden;
        border-radius: 8px;
        background: #f5f5f5;
    }

    .pdf-contenedor iframe {
        width: 100%;
        height: 100%;
        border: none;
        display: block;
    }

    /* =====================================================
    BOTONES PDF
    ===================================================== */

    .boton-pdf {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        padding: 11px 16px;

        border-radius: 6px;

        background: #222;

        color: white;

        text-decoration: none;

        font-weight: bold;

        transition: background 0.2s ease;

    }


    .boton-pdf:hover {

        background: #198754;

        color: white;

    }

    /* =====================================================
    DISCORD
    ===================================================== */

    .discord-tarjeta {

        display: flex;

        align-items: center;

        gap: 18px;

        margin-top: 25px;

        padding: 20px;

        border-radius: 10px;

        background: #f5f5f5;

        border: 1px solid #e5e5e5;

    }


    .discord-icono {

        display: flex;

        align-items: center;

        justify-content: center;

        width: 55px;

        height: 55px;

        flex-shrink: 0;

        border-radius: 12px;

        background: #5865F2;

        color: white;

        font-size: 28px;

    }


    .discord-info {

        flex: 1;

    }


    .discord-info h2 {

        margin: 0 0 5px 0;

        font-size: 18px;

    }


    .discord-info p {

        margin: 0;

        color: #666;

        font-size: 14px;

        line-height: 1.5;

    }


    .boton-discord {

        display: inline-flex;

        align-items: center;

        justify-content: center;

        padding: 11px 16px;

        border-radius: 6px;

        background: #5865F2;

        color: white;

        text-decoration: none;

        font-weight: bold;

        white-space: nowrap;

        transition: background 0.2s ease;

    }


    .boton-discord:hover {

        background: #4752C4;

        color: white;

    }


    @media (max-width: 700px) {

        .discord-tarjeta {

            align-items: flex-start;

            flex-direction: column;

        }


        .boton-discord {

            width: 100%;

        }

    }


    /* =====================================================
       RESPONSIVE
    ===================================================== */

    @media (max-width: 700px) {

        .rangos-grid {
            grid-template-columns: 1fr;
        }

        .codigos-grid {
            grid-template-columns: 1fr;
        }

        .pdf-contenedor {
            height: 600px;
        }
    }


    @media (max-width: 600px) {

        .inicio-pagina {
            margin: 0 5px;
        }

        .inicio-bienvenida {
            padding: 22px;
        }

        .inicio-bienvenida h1 {
            font-size: 25px;
        }

        .acordeon-contenido {
            padding: 15px;
        }

        .pdf-contenedor {
            height: 550px;
        }
    }

</style>
@endpush


@section('content')

<div class="inicio-pagina">


    {{-- =====================================================
        BIENVENIDA
    ===================================================== --}}

    <details class="acordeon acordeon-bienvenida">

        <summary>
            🏠 Bienvenido al Departamento del Sheriff
        </summary>

        <div class="acordeon-contenido">

            <p>
                Bienvenido al sistema interno del
                <strong>Departamento del Sheriff - Pecado City</strong>.
            </p>

            <p>
                Desde este portal podrás consultar toda la información
                necesaria para el desempeño de tus funciones como agente,
                incluyendo los rangos del departamento, códigos de radio,
                derechos, normativa y diferentes herramientas de gestión.
            </p>

            <p>
                Mantente informado de las novedades, comunicados y
                procedimientos oficiales del Departamento para garantizar
                una actuación coordinada y eficaz.
            </p>


            {{-- =================================================
                DISCORD
            ================================================== --}}

            <div class="discord-tarjeta">

                <div class="discord-icono">
                    💬
                </div>

                <div class="discord-info">

                    <h2>
                        Únete a nuestro Discord
                    </h2>

                    <p>
                        Accede al servidor oficial del Departamento del
                        Sheriff para consultar comunicaciones, recibir
                        información, contactar con otros agentes y estar
                        al día de todas las novedades.
                    </p>

                </div>

                <a
                    href="https://discord.gg/2bCkCKQreb"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="boton-discord"
                >
                    💬 Entrar al Discord
                </a>

            </div>

        </div>

    </details>


    {{-- =====================================================
         ACORDEONES
    ===================================================== --}}

    <div class="inicio-acordeones">


        {{-- =================================================
             RANGOS
        ================================================== --}}

        <details class="acordeon">

            <summary>
                🎖️ Rangos del Departamento del Sheriff
            </summary>

            <div class="acordeon-contenido">

                <div class="rangos-grid">


                    {{-- DIRECTIVA --}}

                    <div class="rango">

                        <h3>
                            🔹 Escala Directiva
                        </h3>

                        <ul>
                            <li>🔸 Sheriff</li>
                            <li>🔸 Comisario</li>
                            <li>🔸 Subcomisaro</li>
                        </ul>

                    </div>


                    {{-- JEFATURA --}}

                    <div class="rango">

                        <h3>
                            🔹 Escala Jefatura
                        </h3>

                        <ul>
                            <li>🔸 Coronel</li>
                            <li>🔸 Capitán</li>
                        </ul>

                    </div>


                    {{-- SUPERIOR --}}

                    <div class="rango">

                        <h3>
                            🔹 Escala Superior
                        </h3>

                        <ul>
                            <li>🔸 Teniente</li>
                            <li>🔸 Sargento II</li>
                            <li>🔸 Sargento I</li>
                        </ul>

                    </div>


                    {{-- BÁSICA --}}

                    <div class="rango">

                        <h3>
                            🔹 Escala Básica
                        </h3>

                        <ul>
                            <li>🔸 Cabo III</li>
                            <li>🔸 Cabo II</li>
                            <li>🔸 Cabo I</li>
                            <li>🔸 Patrulla Senior</li>
                            <li>🔸 Patrulla</li>
                            <li>🔸 Patrulla Junior</li>
                        </ul>

                    </div>


                    {{-- ACADEMIA --}}

                    <div class="rango">

                        <h3>
                            🔹 Escala Academia
                        </h3>

                        <ul>
                            <li>🔸 Sheriff en Prácticas</li>
                        </ul>

                    </div>


                </div>

            </div>

        </details>


        {{-- =================================================
             CÓDIGOS DE RADIO
        ================================================== --}}

        <details class="acordeon">

            <summary>
                📡 Códigos de radio
            </summary>

            <div class="acordeon-contenido">


                {{-- CÓDIGOS 10 --}}

                <div class="codigo-seccion">

                    <h3>
                        🔹 Códigos 10
                    </h3>

                    <div class="codigos-grid">

                        <div class="codigo">
                            <strong>10-0</strong>
                            <span>Precaución</span>
                        </div>

                        <div class="codigo">
                            <strong>10-4</strong>
                            <span>Afirmativo</span>
                        </div>

                        <div class="codigo">
                            <strong>10-5</strong>
                            <span>Negativo</span>
                        </div>

                        <div class="codigo">
                            <strong>10-6</strong>
                            <span>Ocupado</span>
                        </div>

                        <div class="codigo">
                            <strong>10-7</strong>
                            <span>Breve descanso</span>
                        </div>

                        <div class="codigo">
                            <strong>10-8</strong>
                            <span>Parada de tráfico</span>
                        </div>

                        <div class="codigo">
                            <strong>10-9</strong>
                            <span>Repetir mensaje</span>
                        </div>

                        <div class="codigo">
                            <strong>10-10</strong>
                            <span>Salida de servicio</span>
                        </div>

                        <div class="codigo">
                            <strong>10-13</strong>
                            <span>Oficial caído</span>
                        </div>

                        <div class="codigo">
                            <strong>10-14</strong>
                            <span>Persona sospechosa</span>
                        </div>

                        <div class="codigo">
                            <strong>10-15</strong>
                            <span>Traslado de detenido</span>
                        </div>

                        <div class="codigo">
                            <strong>10-20</strong>
                            <span>Ubicación</span>
                        </div>

                        <div class="codigo">
                            <strong>10-29</strong>
                            <span>Chequear si está en busca y captura</span>
                        </div>

                        <div class="codigo">
                            <strong>10-30</strong>
                            <span>Sin novedad</span>
                        </div>

                        <div class="codigo">
                            <strong>10-32</strong>
                            <span>Solicito refuerzos</span>
                        </div>

                        <div class="codigo">
                            <strong>10-37</strong>
                            <span>Solicito grúa</span>
                        </div>

                        <div class="codigo">
                            <strong>10-38</strong>
                            <span>Solicito ambulancia</span>
                        </div>

                        <div class="codigo">
                            <strong>10-64</strong>
                            <span>Esperando asignación</span>
                        </div>

                        <div class="codigo">
                            <strong>10-70</strong>
                            <span>Sujeto a salvo</span>
                        </div>

                        <div class="codigo">
                            <strong>10-80</strong>
                            <span>Reasignación en comisaría</span>
                        </div>

                        <div class="codigo">
                            <strong>10-90</strong>
                            <span>Falsa alarma</span>
                        </div>

                        <div class="codigo">
                            <strong>10-95</strong>
                            <span>Procesamiento de sujeto</span>
                        </div>

                        <div class="codigo">
                            <strong>10-97</strong>
                            <span>Llegada al objetivo</span>
                        </div>

                        <div class="codigo">
                            <strong>10-98</strong>
                            <span>Misión completada</span>
                        </div>

                        <div class="codigo">
                            <strong>10-99</strong>
                            <span>Vehículo robado</span>
                        </div>

                    </div>

                </div>


                <hr>


                {{-- CÓDIGOS 2 Y 3 --}}

                <div class="codigo-seccion">

                    <h3>
                        🔹 Códigos 2 y 3
                    </h3>

                    <div class="codigos-grid">

                        <div class="codigo">
                            <strong>2-07</strong>
                            <span>Secuestro</span>
                        </div>

                        <div class="codigo">
                            <strong>2-11</strong>
                            <span>Robo</span>
                        </div>

                        <div class="codigo">
                            <strong>2-15</strong>
                            <span>Tiroteo en curso</span>
                        </div>

                        <div class="codigo">
                            <strong>2-20</strong>
                            <span>Robo de vehículo</span>
                        </div>

                        <div class="codigo">
                            <strong>3-20</strong>
                            <span>Venta de droga</span>
                        </div>

                        <div class="codigo">
                            <strong>2-54-Papa</strong>
                            <span>Persecución a pie</span>
                        </div>

                        <div class="codigo">
                            <strong>2-54-Charlie</strong>
                            <span>Persecución en vehículo</span>
                        </div>

                        <div class="codigo">
                            <strong>2-54-Mike</strong>
                            <span>Persecución en moto</span>
                        </div>

                        <div class="codigo">
                            <strong>2-90</strong>
                            <span>Sujeto drogado</span>
                        </div>

                    </div>

                </div>


                <hr>


                {{-- PATRULLAJE --}}

                <div class="codigo-seccion">

                    <h3>
                        🔹 Códigos de patrullaje y respuesta
                    </h3>

                    <div class="codigos-grid">

                        <div class="codigo">
                            <strong>Código 1</strong>
                            <span>Último aviso</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 2</strong>
                            <span>Sin luces ni sirenas</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 3</strong>
                            <span>Con luces sin sirenas</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 4</strong>
                            <span>Con luces y sirenas</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 5</strong>
                            <span>Patrullaje</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 6</strong>
                            <span>Investigando el área</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 7</strong>
                            <span>Estado de patrullaje</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 8</strong>
                            <span>Todo limpio</span>
                        </div>

                    </div>

                </div>


                <hr>


                {{-- OTROS CÓDIGOS --}}

                <div class="codigo-seccion">

                    <h3>
                        🔹 Otros códigos clave
                    </h3>

                    <div class="codigos-grid">

                        <div class="codigo">
                            <strong>QRR</strong>
                            <span>Agente en peligro</span>
                        </div>

                        <div class="codigo">
                            <strong>Charlie Charlie</strong>
                            <span>Silencio en radio</span>
                        </div>

                        <div class="codigo">
                            <strong>Código 100</strong>
                            <span>Bloqueo de calle con el vehículo</span>
                        </div>

                        <div class="codigo">
                            <strong>Clave Robert</strong>
                            <span>Disparar a las ruedas</span>
                        </div>

                        <div class="codigo">
                            <strong>Papa Hotel</strong>
                            <span>Persona herida</span>
                        </div>

                        <div class="codigo">
                            <strong>Clave PIT</strong>
                            <span>Golpe desestabilizador</span>
                        </div>

                        <div class="codigo">
                            <strong>5/5</strong>
                            <span>Alto y Claro</span>
                        </div>

                    </div>

                </div>

            </div>

        </details>


        {{-- =================================================
             DERECHOS
        ================================================== --}}

        <details class="acordeon">

            <summary>
                📜 Derechos
            </summary>

            <div class="acordeon-contenido">

                <ul class="derechos">

                    <li>
                        <strong>a)</strong>
                        Tienes derecho a permanecer en silencio.
                        Todo lo que digas puede ser utilizado en tu contra.
                    </li>

                    <li>
                        <strong>b)</strong>
                        Tienes derecho a comida y bebida.
                    </li>

                    <li>
                        <strong>c)</strong>
                        Tienes derecho a asistencia médica/sanitaria.
                    </li>

                    <li>
                        <strong>d)</strong>
                        Tienes derecho a conocer los motivos de tu detención.
                    </li>

                    <li>
                        <strong>e)</strong>
                        Tienes derecho a una llamada de hasta 5 minutos,
                        siempre en presencia de un agente de la ley y con
                        el altavoz activado.
                    </li>

                    <li>
                        <strong>f)</strong>
                        Tienes derecho a un abogado.
                        Si no tienes, se te asignará uno de oficio.
                    </li>

                </ul>

            </div>

        </details>


        {{-- =================================================
            CÓDIGO PENAL
        ================================================== --}}

        <details class="acordeon">

            <summary>
                ⚖️ Código Penal
            </summary>

            <div class="acordeon-contenido">

                <a
                    href="{{ asset('pdf/codigo-penal.pdf') }}"
                    download
                    class="boton-pdf"
                >
                    📥 Descargar Código Penal
                </a>

            </div>

        </details>


        {{-- =================================================
            CONSTITUCIÓN
        ================================================== --}}

        <details class="acordeon">

            <summary>
                📜 Constitución
            </summary>

            <div class="acordeon-contenido">

                <a
                    href="{{ asset('pdf/constitucion.pdf') }}"
                    download
                    class="boton-pdf"
                >
                    📥 Descargar Constitución
                </a>

            </div>

        </details>


    </div>

</div>

@endsection