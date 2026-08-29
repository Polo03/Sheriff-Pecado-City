<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Sheriff Pecado City')
    </title>


    <style>

        * {
            box-sizing: border-box;
        }


        html,
        body {

            margin: 0;
            padding: 0;
            min-height: 100%;

        }


        body {

            font-family: Arial, sans-serif;

            background: #f2f2f2;

        }


        /* =====================================================
           ESTRUCTURA PRINCIPAL
        ===================================================== */

        .layout {

            display: flex;

            min-height: 100vh;

        }


        /* =====================================================
           BARRA LATERAL
        ===================================================== */

        .sidebar {

            width: 250px;

            min-height: 100vh;

            background: #171717;

            color: white;

            position: fixed;

            left: 0;

            top: 0;

            bottom: 0;

            display: flex;

            flex-direction: column;

            z-index: 1000;

            box-shadow:
                3px 0 15px rgba(0, 0, 0, 0.20);

        }


        /* =====================================================
           LOGO
        ===================================================== */

        .sidebar-logo {

            padding: 25px 20px;

            text-align: center;

            border-bottom: 1px solid #333;

        }


        .sidebar-logo h2 {

            margin: 0;

            font-size: 20px;

        }


        .sidebar-logo span {

            display: block;

            margin-top: 5px;

            font-size: 12px;

            color: #aaa;

        }


        /* =====================================================
           MENU
        ===================================================== */

        .sidebar-menu {

            padding: 20px 12px;

            flex: 1;

        }


        .sidebar-menu a {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 13px 15px;

            margin-bottom: 6px;

            border-radius: 8px;

            color: #ddd;

            text-decoration: none;

            font-size: 14px;

            transition: 0.2s ease;

        }


        .sidebar-menu a:hover {

            background: #2b2b2b;

            color: white;

        }


        .sidebar-menu a.activo {

            background: #198754;

            color: white;

        }


        .sidebar-menu details {

            margin-bottom: 6px;

        }


        .sidebar-menu summary {

            display: flex;

            align-items: center;

            gap: 12px;

            padding: 13px 15px;

            border-radius: 8px;

            color: #ddd;

            cursor: pointer;

            font-size: 14px;

            list-style: none;

            transition: 0.2s ease;

        }


        .sidebar-menu summary::-webkit-details-marker {

            display: none;

        }


        .sidebar-menu summary::after {

            content: '›';

            margin-left: auto;

            font-size: 20px;

            transition: transform 0.2s ease;

        }


        .sidebar-menu summary:hover,
        .sidebar-menu details[open] summary,
        .sidebar-menu summary.activo {

            background: #2b2b2b;

            color: white;

        }


        .sidebar-menu details[open] summary::after {

            transform: rotate(90deg);

        }


        .submenu-lateral {

            padding: 4px 0 0 52px;

        }


        .sidebar-menu .submenu-lateral a {

            padding: 9px 12px;

            margin-bottom: 2px;

            font-size: 13px;

        }


        .menu-contextual-ficha {

            position: fixed;

            z-index: 2000;

            display: none;

            padding: 8px 12px;

            border: 1px solid #ccc;

            border-radius: 6px;

            background: white;

            color: #dc3545;

            cursor: pointer;

            box-shadow:
                0 3px 12px rgba(0, 0, 0, 0.2);

        }


        .sidebar-icono {

            width: 25px;

            text-align: center;

            font-size: 18px;

        }


        /* =====================================================
           CONTENIDO
        ===================================================== */

        .contenido {

            width: calc(100% - 250px);

            margin-left: 250px;

            min-height: 100vh;

            padding: 40px;

        }


        .usuario {

            display: flex;

            justify-content: flex-end;

            margin-bottom: 30px;

            position: relative;

        }


        .usuario-boton {

            padding: 10px 15px;

            border: none;

            border-radius: 8px;

            background: white;

            color: #222;

            font-size: 15px;

            font-weight: bold;

            cursor: pointer;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, 0.15);

        }


        .menu-usuario {

            display: none;

            position: absolute;

            top: 48px;

            right: 0;

            min-width: 160px;

            background: white;

            border-radius: 8px;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, 0.15);

            overflow: hidden;

            z-index: 2;

        }


        .menu-usuario form {

            margin: 0;

        }


        .logout {

            width: 100%;

            padding: 10px 15px;

            border: none;

            background: white;

            color: #dc3545;

            font-size: 14px;

            text-align: left;

            cursor: pointer;

        }


        .logout:hover {

            background: #f8f8f8;

        }


        .login-link {

            display: block;

            width: 100%;

            padding: 10px 15px;

            background: white;

            color: #198754;

            font-size: 14px;

            text-align: left;

            text-decoration: none;

            cursor: pointer;

        }


        .login-link:hover {

            background: #f8f8f8;

        }


        .contenido-interno {

            max-width: 1400px;

            margin: 0 auto;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 800px) {

            .sidebar {

                width: 70px;

            }


            .sidebar-logo h2,
            .sidebar-logo span,
            .sidebar-menu .texto-menu {

                display: none;

            }


            .sidebar-logo {

                padding: 20px 5px;

            }


            .sidebar-menu {

                padding: 15px 8px;

            }


            .sidebar-menu a {

                justify-content: center;

                padding: 13px 5px;

            }


            .submenu-lateral {

                display: none;

            }


            .sidebar-icono {

                width: auto;

            }


            .contenido {

                width: calc(100% - 70px);

                margin-left: 70px;

                padding: 20px;

            }

        }

    </style>


    @stack('styles')

</head>


<body>


<div class="layout">


    {{-- =====================================================
         BARRA LATERAL
    ====================================================== --}}

    <aside class="sidebar">


        {{-- LOGO --}}

        <div class="sidebar-logo">

            <h2>
                🚔 Sheriff
            </h2>

            <span>
                Pecado City
            </span>

        </div>


        {{-- MENU --}}

        <nav class="sidebar-menu">

            @php

                $usuarioMenuId = session('usuario_id');

                $esDirectivaMenu = $usuarioMenuId &&
                    \Illuminate\Support\Facades\DB::table('agentes')
                        ->join(
                            'rangos',
                            'rangos.rango',
                            '=',
                            'agentes.rango'
                        )
                        ->where(
                            'agentes.id',
                            $usuarioMenuId
                        )
                        ->where(
                            'rangos.escala',
                            'Directiva'
                        )
                        ->exists();


                $fichasMenu =
                    \Illuminate\Support\Facades\DB::table(
                        'fichas_agentes'
                    )
                    ->join(
                        'agentes',
                        'agentes.id',
                        '=',
                        'fichas_agentes.agente_id'
                    )
                    ->where(
                        function ($query) use (
                            $usuarioMenuId,
                            $esDirectivaMenu
                        ) {

                            $query->where(
                                'fichas_agentes.agente_id',
                                $usuarioMenuId
                            );


                            if ($esDirectivaMenu) {

                                $query->orWhereNotNull(
                                    'fichas_agentes.id'
                                );

                            }

                        }
                    )
                    ->select(
                        'fichas_agentes.id',
                        'fichas_agentes.placa',
                        'agentes.nombre'
                    )
                    ->orderBy(
                        'agentes.nombre'
                    )
                    ->get();

            @endphp


            {{-- INICIO --}}

            <a
                href="{{ route('menu.principal') }}"
                class="{{ request()->routeIs('menu.principal') ? 'activo' : '' }}"
            >

                <span class="sidebar-icono">
                    🏠
                </span>

                <span class="texto-menu">
                    Inicio
                </span>

            </a>


            @if(session()->has('usuario_id'))


                {{-- INFORMACION --}}

                <details>

                    <summary>

                        <span class="sidebar-icono">
                            📚
                        </span>

                        <span class="texto-menu">
                            Información
                        </span>

                    </summary>

                    <div class="submenu-lateral">

                        <a
                            href="{{ route('plantilla.index') }}"
                            class="{{ request()->routeIs('plantilla.*') ? 'activo' : '' }}"
                        >
                            📄 Plantilla
                        </a>

                        <a
                            href="{{ route('procedimientos.index') }}"
                            class="{{ request()->routeIs('procedimientos.*') ? 'activo' : '' }}"
                        >
                            📢 Procedimientos
                        </a>

                        <a
                            href="{{ route('jefes-divisiones.index') }}"
                            class="{{ request()->routeIs('jefes-divisiones.*') ? 'activo' : '' }}"
                        >
                            👮 Divisiones
                        </a>

                        <a
                            href="{{ route('bindeos.index') }}"
                            class="{{ request()->routeIs('bindeos.*') ? 'activo' : '' }}"
                        >
                            ⌨️ Bindeos
                        </a>

                        <a
                            href="{{ route('certificado-antecedentes.index') }}"
                            class="{{ request()->routeIs('certificado-antecedentes.*') ? 'activo' : '' }}"
                        >
                            📜 Certificado de antecedentes
                        </a>

                        <a
                            href="{{ route('abogados.index') }}"
                            class="{{ request()->routeIs('abogados.*') ? 'activo' : '' }}"
                        >
                            ⚖️ Abogados
                        </a>

                        <a
                            href="{{ route('peas.index') }}"
                            class="{{ request()->routeIs('peas.*') ? 'activo' : '' }}"
                        >
                            🚨 PEAS
                        </a>

                        <a href="#">
                            👕 Uniformes
                        </a>

                    </div>

                </details>


                {{-- COMUNICACIONES --}}

                <details>

                    <summary>

                        <span class="sidebar-icono">
                            📡
                        </span>

                        <span class="texto-menu">
                            Comunicaciones
                        </span>

                    </summary>

                    <div class="submenu-lateral">

                        <a
                            href="{{ route('anuncios.index') }}"
                            class="{{ request()->routeIs('anuncios.*') ? 'activo' : '' }}"
                        >
                            📢 Anuncios
                        </a>

                        <a
                            href="{{ route('briefing.index') }}"
                            class="{{ request()->routeIs('briefing.*') ? 'activo' : '' }}"
                        >
                            📋 Briefing
                        </a>

                        <a
                            href="{{ route('comunicaciones.show', 'general-ic') }}"
                            class="{{ request()->route('canal') === 'general-ic' ? 'activo' : '' }}"
                        >
                            📡 General-IC
                        </a>

                        <a
                            href="{{ route('comunicaciones.show', 'general-ooc') }}"
                            class="{{ request()->route('canal') === 'general-ooc' ? 'activo' : '' }}"
                        >
                            💬 General-OOC
                        </a>

                        <a
                            href="{{ route('mensajes-divisiones.index') }}"
                            class="{{ request()->routeIs('mensajes-divisiones.*') ? 'activo' : '' }}"
                        >
                            🏢 Mensajes-divisiones
                        </a>

                        <a
                            href="{{ route('busqueda-captura.index') }}"
                            class="{{ request()->routeIs('busqueda-captura.*') ? 'activo' : '' }}"
                        >
                            🔎 Busqueda y captura activas
                        </a>

                </details>


                {{-- COMANDANCIA --}}

                <details
                    {{
                        request()->routeIs(
                            'sujetos-procesados.*',
                            'armamento.*',
                            'registrar-armamento.*'
                        )
                            ? 'open'
                            : ''
                    }}
                >

                    <summary
                        class="{{
                            request()->routeIs(
                                'sujetos-procesados.*',
                                'armamento.*',
                                'registrar-armamento.*'
                            )
                                ? 'activo'
                                : ''
                        }}"
                    >

                        <span class="sidebar-icono">
                            ⭐
                        </span>

                        <span class="texto-menu">
                            Comandancia
                        </span>

                    </summary>


                    <div class="submenu-lateral">

                        <a
                            href="{{ route('registrar-armamento.index') }}"
                            class="{{ request()->routeIs('registrar-armamento.*') ? 'activo' : '' }}"
                        >
                            🔫 Registrar armamento
                        </a>


                        <a
                            href="{{ route('plantilla-mensajes.index') }}"
                            class="{{ request()->routeIs('plantilla-mensajes.*') ? 'activo' : '' }}"
                        >
                            📌 Plantilla mensajes
                        </a>


                        <a
                            href="{{ route('sujetos-procesados.index') }}"
                            class="{{ request()->routeIs('sujetos-procesados.*') ? 'activo' : '' }}"
                        >
                            👤 Sujetos procesados
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            ⚔️ Armeria
                        </a>


                        <a
                            href="{{ route('mosquetes-locales.index') }}"
                            class="{{ request()->routeIs('mosquetes-locales.*') ? 'activo' : '' }}"
                        >
                            🔫 Mosquetes locales
                        </a>


                        <a
                            href="{{ route('matriculas-sospechosas.index') }}"
                            class="{{ request()->routeIs('matriculas-sospechosas.*') ? 'activo' : '' }}"
                        >
                            🚗 Matriculas sospechosas
                        </a>

                        <a href="{{ route('drogas-dni.index') }}">
                            💊 Drogas DNI
                        </a>

                        <a href="{{ route('dni-rehenes.index') }}">
                            🪪 DNI Rehenes
                        </a>

                    </div>

                </details>


                {{-- DIVISIONES --}}

                <details
                    {{ request()->is('divisiones/*') ? 'open' : '' }}
                >

                    <summary>

                        <span class="sidebar-icono">
                            🏢
                        </span>

                        <span class="texto-menu">
                            Divisiones
                        </span>

                    </summary>

                    <div class="submenu-lateral">

                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            ⚖️ Fiscalia
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            🔎 Investigacion
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            ⭐ Marshall
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            🚓 Bani
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            ✈️ Aeronautica
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            🚔 Trooper
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            🎙️ Entrevistador
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            📚 Instruccion
                        </a>


                        <a
                            href="{{ route('menu.principal') }}"
                        >
                            🛡️ Seguridad de gobierno
                        </a>


                    </div>

                </details>


                {{-- FICHAJE --}}

                <details
                    {{
                        request()->routeIs(
                            'fichaje.*',
                            'fichas-agentes.*'
                        )
                            ? 'open'
                            : ''
                    }}
                >

                    <summary>

                        <span class="sidebar-icono">
                            🕒
                        </span>

                        <span class="texto-menu">
                            Fichaje
                        </span>

                    </summary>

                    <div class="submenu-lateral">

                        <a href="{{ route('fichaje.index') }}">
                            Fichaje
                        </a>


                        @foreach($fichasMenu as $fichaMenu)

                            <a
                                href="{{ route('fichas-agentes.show', $fichaMenu->id) }}"
                                class="{{
                                    request()->routeIs('fichas-agentes.show')
                                    &&
                                    (int) request()->route('ficha') === $fichaMenu->id
                                        ? 'activo'
                                        : ''
                                }}"
                            >
                                {{ $fichaMenu->nombre }}
                                -
                                {{ $fichaMenu->placa }}
                            </a>

                        @endforeach

                    </div>

                </details>


                @php

                    $puedeGestionarAgentes =
                        \Illuminate\Support\Facades\DB::table('agentes')
                            ->join(
                                'rangos',
                                'rangos.rango',
                                '=',
                                'agentes.rango'
                            )
                            ->where(
                                'agentes.id',
                                session('usuario_id')
                            )
                            ->where(
                                'rangos.escala',
                                'Directiva'
                            )
                            ->exists();

                @endphp


                @if($puedeGestionarAgentes)

                    <details
                        {{
                            request()->routeIs('gestion-agentes.*')
                                ? 'open'
                                : ''
                        }}
                    >

                        <summary
                            class="{{
                                request()->routeIs('gestion-agentes.*')
                                    ? 'activo'
                                    : ''
                            }}"
                        >

                            <span class="sidebar-icono">
                                👥
                            </span>

                            <span class="texto-menu">
                                Gestión Sheriff
                            </span>

                        </summary>


                        <div class="submenu-lateral">

                            <a
                                href="{{ route('gestion-agentes.index') }}"
                                class="{{ request()->routeIs('gestion-agentes.*') ? 'activo' : '' }}"
                            >
                                Agentes
                            </a>

                            <a
                                href="{{ route('armamento.index') }}"
                                class="{{ request()->routeIs('armamento.*') ? 'activo' : '' }}"
                            >
                                Armamento
                            </a>

                            <a href="{{ route('menu.principal') }}">
                                Armería
                            </a>

                        </div>

                    </details>

                @endif

            @endif

        </nav>

    </aside>


    {{-- =====================================================
         CONTENIDO DE CADA PÁGINA
    ====================================================== --}}

    <main class="contenido">

        <div class="contenido-interno">


            {{-- =================================================
                 USUARIO / VISITANTE
            ================================================== --}}

            <div class="usuario">


                @if(session()->has('usuario_id'))

                    {{-- ================================
                         USUARIO LOGUEADO
                    ================================= --}}

                    <button
                        type="button"
                        class="usuario-boton"
                        onclick="toggleMenu()"
                    >

                        {{ session('nombre', 'Agente') }}

                        <span id="flecha">
                            ▼
                        </span>

                    </button>


                    <div
                        id="menu-usuario"
                        class="menu-usuario"
                    >

                        <form
                            action="{{ route('logout') }}"
                            method="POST"
                        >

                            @csrf

                            <button
                                type="submit"
                                class="logout"
                            >
                                Cerrar sesión
                            </button>

                        </form>

                    </div>


                @else

                    {{-- ================================
                         VISITANTE
                    ================================= --}}

                    <button
                        type="button"
                        class="usuario-boton"
                        onclick="toggleMenu()"
                    >

                        Visitante

                        <span id="flecha">
                            ▼
                        </span>

                    </button>


                    <div
                        id="menu-usuario"
                        class="menu-usuario"
                    >

                        <a
                            href="{{ route('login') }}"
                            class="login-link"
                        >
                            Iniciar sesión
                        </a>

                    </div>

                @endif


            </div>


            @yield('content')


        </div>

    </main>


</div>


@stack('scripts')


<script>

    function toggleMenu() {

        const menu =
            document.getElementById(
                'menu-usuario'
            );

        const flecha =
            document.getElementById(
                'flecha'
            );

        const abierto =
            menu.style.display === 'block';


        menu.style.display =
            abierto
                ? 'none'
                : 'block';


        flecha.textContent =
            abierto
                ? '▼'
                : '▲';

    }

</script>


</body>

</html>