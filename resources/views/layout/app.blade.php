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


            {{-- INICIO --}}

            <a
                href="{{ url('/') }}"
                class="{{ request()->is('/') ? 'activo' : '' }}"
            >

                <span class="sidebar-icono">
                    🏠
                </span>

                <span class="texto-menu">
                    Inicio
                </span>

            </a>


            {{-- SUJETOS PROCESADOS --}}

            <a
                href="{{ route('sujetos-procesados.index') }}"
                class="{{ request()->routeIs('sujetos-procesados.*') ? 'activo' : '' }}"
            >

                <span class="sidebar-icono">
                    👤
                </span>

                <span class="texto-menu">
                    Sujetos procesados
                </span>

            </a>


            <a
                href="{{ route('rangos.index') }}"
                class="{{ request()->routeIs('rangos.*') ? 'activo' : '' }}"
            >

                <span class="sidebar-icono">
                    📊
                </span>

                <span class="texto-menu">
                    Rangos
                </span>

            </a>


            {{-- AÑADE AQUÍ MÁS OPCIONES --}}

            {{--

            <a href="#">
                <span class="sidebar-icono">
                    🚓
                </span>

                <span class="texto-menu">
                    Patrullas
                </span>
            </a>


            <a href="#">
                <span class="sidebar-icono">
                    📋
                </span>

                <span class="texto-menu">
                    Informes
                </span>
            </a>


            <a href="#">
                <span class="sidebar-icono">
                    👮
                </span>

                <span class="texto-menu">
                    Agentes
                </span>
            </a>

            --}}

        </nav>


    </aside>



    {{-- =====================================================
         CONTENIDO DE CADA PÁGINA
    ====================================================== --}}

    <main class="contenido">

        <div class="contenido-interno">

            @yield('content')

        </div>

    </main>


</div>


@stack('scripts')

</body>

</html>