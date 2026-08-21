<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Fichaje</title>


    <style>

        * {
            box-sizing: border-box;
        }


        body {

            margin: 0;

            min-height: 100vh;

            font-family: Arial, sans-serif;

            background: #f2f2f2;

        }


        /* =====================================================
           MENÚ LATERAL
        ===================================================== */

        .sidebar {

            position: fixed;

            top: 0;
            left: 0;

            width: 240px;

            height: 100vh;

            background: #222;

            padding: 25px 15px;

            box-shadow:
                3px 0 10px rgba(0, 0, 0, 0.15);

            z-index: 1000;

            transition: width 0.3s ease;

            overflow-y: auto;

            overflow-x: hidden;

        }


        /* =====================================================
           CABECERA SIDEBAR
        ===================================================== */

        .sidebar-header {

            display: flex;

            align-items: center;

            justify-content: space-between;

            width: 100%;

            padding: 0 5px 20px 5px;

            margin-bottom: 15px;

            border-bottom: 1px solid #444;

        }


        .sidebar-titulo {

            color: white;

            font-size: 22px;

            font-weight: bold;

            white-space: nowrap;

        }


        /* =====================================================
           BOTÓN ABRIR / CERRAR SIDEBAR
        ===================================================== */

        .sidebar-toggle {

            width: 35px;

            height: 35px;

            padding: 0;

            border: none;

            border-radius: 7px;

            background: transparent;

            color: white;

            font-size: 22px;

            cursor: pointer;

            display: flex;

            align-items: center;

            justify-content: center;

            flex-shrink: 0;

        }


        .sidebar-toggle:hover {

            background: #333;

        }


        /* =====================================================
           MENÚ PRINCIPAL SIDEBAR
        ===================================================== */

        .sidebar-menu {

            display: flex;

            flex-direction: column;

            gap: 8px;

            width: 100%;

        }


        /* =====================================================
           OPCIONES SIDEBAR
        ===================================================== */

        .sidebar-opcion {

            display: flex;

            align-items: center;

            gap: 12px;

            width: 100%;

            min-width: 0;

            padding: 13px 15px;

            border: none;

            border-radius: 8px;

            background: transparent;

            color: #ddd;

            font-family: Arial, sans-serif;

            font-size: 15px;

            text-align: left;

            text-decoration: none;

            cursor: pointer;

            transition: background 0.2s, color 0.2s;

            white-space: nowrap;

        }


        .sidebar-opcion:hover {

            background: #333;

            color: white;

        }


        .sidebar-opcion.activo {

            background: #444;

            color: white;

            font-weight: bold;

        }


        /* =====================================================
           GRUPO DIVISIONES
        ===================================================== */

        .sidebar-grupo {

            width: 100%;

            flex-shrink: 0;

        }


        /* =====================================================
           BOTÓN DIVISIONES
        ===================================================== */

        .sidebar-division {

            display: flex;

            align-items: center;

            justify-content: space-between;

            width: 100%;

        }


        .division-izquierda {

            display: flex;

            align-items: center;

            gap: 12px;

            min-width: 0;

        }


        .flecha-division {

            font-size: 10px;

            flex-shrink: 0;

        }


        /* =====================================================
           SUBMENÚ DIVISIONES
        ===================================================== */

        .submenu-divisiones {

            display: none;

            width: 100%;

            margin-top: 4px;

            padding-left: 15px;

            border-left: 1px solid #444;

        }


        .submenu-divisiones.abierto {

            display: block;

        }


        /* =====================================================
           OPCIONES SUBMENÚ
        ===================================================== */

        .submenu-opcion {

            display: block;

            width: 100%;

            padding: 9px 10px;

            color: #aaa;

            font-family: Arial, sans-serif;

            font-size: 13px;

            line-height: 1.3;

            text-decoration: none;

            border-radius: 6px;

            white-space: nowrap;

            transition:
                background 0.2s,
                color 0.2s;

        }


        .submenu-opcion:hover {

            background: #333;

            color: white;

        }


        /* =====================================================
           SIDEBAR CERRADO
        ===================================================== */

        .sidebar.cerrado {

            width: 70px;

        }


        .sidebar.cerrado .sidebar-titulo {

            display: none;

        }


        .sidebar.cerrado .sidebar-header {

            justify-content: center;

        }


        .sidebar.cerrado .sidebar-opcion {

            justify-content: center;

            padding: 13px 0;

            font-size: 0;

        }


        .sidebar.cerrado .sidebar-opcion span {

            display: none;

        }


        .sidebar.cerrado .sidebar-division {

            justify-content: center;

        }


        .sidebar.cerrado .division-izquierda {

            justify-content: center;

        }


        .sidebar.cerrado .flecha-division {

            display: none;

        }


        .sidebar.cerrado .submenu-divisiones {

            display: none !important;

        }


        /* =====================================================
           CONTENIDO PRINCIPAL
        ===================================================== */

        .contenido {

            margin-left: 240px;

            min-height: 100vh;

            position: relative;

            padding: 20px;

            transition: margin-left 0.3s ease;

        }


        .contenido.expandido {

            margin-left: 70px;

        }


        /* =====================================================
           USUARIO
        ===================================================== */

        .usuario {

            position: fixed;

            top: 20px;

            right: 20px;

            z-index: 2000;

        }


        .usuario-boton {

            width: auto;

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


        .usuario-boton:hover {

            background: #f5f5f5;

        }


        #flecha {

            margin-left: 8px;

            font-size: 11px;

        }


        /* =====================================================
           MENÚ USUARIO
        ===================================================== */

        .menu-usuario {

            display: none;

            margin-top: 5px;

            background: white;

            border-radius: 8px;

            box-shadow:
                0 3px 10px rgba(0, 0, 0, 0.15);

            overflow: hidden;

        }


        .menu-usuario form {

            margin: 0;

        }


        /* =====================================================
           LOGOUT
        ===================================================== */

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

            background: #f5f5f5;

        }


        /* =====================================================
           CONTENEDOR FICHAJE
        ===================================================== */

        .container {

            width: 400px;

            background: white;

            padding: 40px;

            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.15);

            text-align: center;

            position: absolute;

            top: 50%;

            left: 50%;

            transform: translate(-50%, -50%);

        }


        h1 {

            margin-top: 0;

            margin-bottom: 30px;

        }


        /* =====================================================
           RELOJ + CÍRCULO
        ===================================================== */

        .reloj-container {

            display: flex;

            align-items: center;

            justify-content: center;

            gap: 25px;

            margin: 30px 0;

        }


        /* =====================================================
           CÍRCULO
        ===================================================== */

        .circulo-estado {

            width: 70px;

            height: 70px;

            border-radius: 50%;

            flex-shrink: 0;

            transition: all 0.3s ease;

        }


        .circulo-verde {

            background: #198754;

            box-shadow:
                0 0 20px rgba(25, 135, 84, 0.5);

        }


        .circulo-rojo {

            background: #dc3545;

            box-shadow:
                0 0 20px rgba(220, 53, 69, 0.5);

        }


        /* =====================================================
           RELOJ
        ===================================================== */

        #reloj {

            font-size: 36px;

            font-weight: bold;

            font-family: monospace;

            color: #222;

            white-space: nowrap;

        }


        /* =====================================================
           INFORMACIÓN FICHAJE
        ===================================================== */

        .estado {

            margin: 20px 0;

            padding: 15px;

            border-radius: 8px;

            background: #f5f5f5;

        }


        .activo {

            color: #198754;

            font-weight: bold;

        }


        /* =====================================================
           BOTÓN FICHAJE
        ===================================================== */

        .fichar {

            width: 100%;

            padding: 15px;

            border: none;

            border-radius: 8px;

            background: #222;

            color: white;

            font-size: 18px;

            cursor: pointer;

        }


        .fichar:hover {

            background: #444;

        }


        /* =====================================================
           MENSAJE
        ===================================================== */

        .mensaje {

            margin-bottom: 20px;

            padding: 12px;

            border-radius: 8px;

            background: #d4edda;

            color: #155724;

        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 700px) {

            .sidebar {

                width: 70px;

            }


            .sidebar-titulo {

                display: none;

            }


            .sidebar-header {

                justify-content: center;

            }


            .sidebar-opcion {

                justify-content: center;

                padding: 13px 0;

                font-size: 0;

            }


            .sidebar-opcion span {

                display: none;

            }


            .sidebar-division {

                justify-content: center;

            }


            .division-izquierda {

                justify-content: center;

            }


            .flecha-division {

                display: none;

            }


            .submenu-divisiones {

                display: none !important;

            }


            .contenido {

                margin-left: 70px;

            }


            .container {

                width: calc(100% - 40px);

                max-width: 400px;

            }

        }

    </style>

</head>


<body>


    <!-- =====================================================
         MENÚ LATERAL
    ===================================================== -->

    <aside
        class="sidebar"
        id="sidebar"
    >


        <!-- CABECERA -->

        <div class="sidebar-header">

            <div class="sidebar-titulo">

                Sheriff

            </div>


            <button
                type="button"
                class="sidebar-toggle"
                onclick="toggleSidebar()"
            >

                ☰

            </button>

        </div>


        <!-- =================================================
             OPCIONES
        ================================================= -->

        <nav class="sidebar-menu">


            <!-- INICIO -->

            <a
                href="{{ route('fichaje.index') }}"
                class="sidebar-opcion activo"
            >

                🏠

                <span>
                    Inicio
                </span>

            </a>


            <!-- SUJETOS PROCESADOS -->

            <a
    href="{{ route('sujetos-procesados.index') }}"
    class="sidebar-opcion"
>
    ⚖️

    <span>
        Sujetos procesados
    </span>
</a>


            <!-- ARMERÍA -->

            <a
                href="#"
                class="sidebar-opcion"
            >

                ⚖️

                <span>
                    Armeria
                </span>

            </a>


            <!-- =================================================
                 DIVISIONES
            ================================================= -->

            <div class="sidebar-grupo">


                <button
                    type="button"
                    class="sidebar-opcion sidebar-division"
                    onclick="toggleDivisiones()"
                >

                    <span class="division-izquierda">

                        🏢

                        <span>
                            Divisiones
                        </span>

                    </span>


                    <span
                        id="flecha-divisiones"
                        class="flecha-division"
                    >

                        ▼

                    </span>

                </button>


                <!-- =================================================
                     SUBMENÚ
                ================================================= -->

                <div
                    id="submenu-divisiones"
                    class="submenu-divisiones"
                >


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Fiscalía
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Investigación
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Marshall
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Bani
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Aeronáutica
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Trooper
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Entrevistador
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Instrucción
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Seguridad del gobierno
                    </a>


                    <a
                        href="#"
                        class="submenu-opcion"
                    >
                        Directiva divisiones
                    </a>


                </div>

            </div>


            <!-- MI PERFIL -->

            <a
                href="#"
                class="sidebar-opcion"
            >

                👤

                <span>
                    Mi perfil
                </span>

            </a>


        </nav>


    </aside>


    <!-- =====================================================
         CONTENIDO PRINCIPAL
    ===================================================== -->

    <main
        class="contenido"
        id="contenido"
    >


        <!-- =================================================
             USUARIO
        ================================================= -->

        <div class="usuario">


            <button
                type="button"
                class="usuario-boton"
                onclick="toggleMenu()"
            >

                {{ $nombre }}

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


        </div>


        <!-- =================================================
             FICHAJE
        ================================================= -->

        <div class="container">


            <h1>
                Fichaje
            </h1>


            @if(session('mensaje'))

                <div class="mensaje">

                    {{ session('mensaje') }}

                </div>

            @endif


            <!-- RELOJ + CÍRCULO -->

            <div class="reloj-container">


                @if($fichajeActivo)

                    <div
                        class="circulo-estado circulo-verde"
                    ></div>

                @else

                    <div
                        class="circulo-estado circulo-rojo"
                    ></div>

                @endif


                <div id="reloj">
                    00:00:00
                </div>


            </div>


            <!-- INFORMACIÓN FICHAJE -->

            @if($fichajeActivo)


                <div class="estado">

                    <p>

                        Entrada:

                        <strong>
                            {{ $fichajeActivo->entrada }}
                        </strong>

                    </p>

                </div>


                <form
                    action="{{ route('fichaje.fichar') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="fichar"
                    >

                        Finalizar fichaje

                    </button>

                </form>


            @else


                <form
                    action="{{ route('fichaje.fichar') }}"
                    method="POST"
                >

                    @csrf

                    <button
                        type="submit"
                        class="fichar"
                    >

                        Fichar entrada

                    </button>

                </form>


            @endif


        </div>


    </main>


    <!-- =====================================================
         JAVASCRIPT
    ===================================================== -->

    <script>


        /* =====================================================
           ABRIR / CERRAR SIDEBAR
        ===================================================== */

        function toggleSidebar() {

            const sidebar =
                document.getElementById('sidebar');

            const contenido =
                document.getElementById('contenido');


            sidebar.classList.toggle('cerrado');

            contenido.classList.toggle('expandido');

        }


        /* =====================================================
           ABRIR / CERRAR DIVISIONES
        ===================================================== */

        function toggleDivisiones() {

            const sidebar =
                document.getElementById('sidebar');

            const submenu =
                document.getElementById('submenu-divisiones');

            const flecha =
                document.getElementById('flecha-divisiones');


            /*
             * Si el sidebar está cerrado,
             * primero lo abrimos.
             */

            if (sidebar.classList.contains('cerrado')) {

                sidebar.classList.remove('cerrado');

                document
                    .getElementById('contenido')
                    .classList.remove('expandido');

            }


            if (
                submenu.classList.contains('abierto')
            ) {

                submenu.classList.remove('abierto');

                flecha.textContent = '▼';

            } else {

                submenu.classList.add('abierto');

                flecha.textContent = '▲';

            }

        }


        /* =====================================================
           MENÚ USUARIO
        ===================================================== */

        function toggleMenu() {

            const menu =
                document.getElementById('menu-usuario');

            const flecha =
                document.getElementById('flecha');


            if (menu.style.display === 'block') {

                menu.style.display = 'none';

                flecha.textContent = '▼';

            } else {

                menu.style.display = 'block';

                flecha.textContent = '▲';

            }

        }


        /* =====================================================
           RELOJ
        ===================================================== */

        function actualizarReloj() {

            const ahora = new Date();


            const horas =
                String(
                    ahora.getHours()
                ).padStart(2, '0');


            const minutos =
                String(
                    ahora.getMinutes()
                ).padStart(2, '0');


            const segundos =
                String(
                    ahora.getSeconds()
                ).padStart(2, '0');


            document.getElementById('reloj').textContent =
                horas + ':' +
                minutos + ':' +
                segundos;

        }


        actualizarReloj();


        setInterval(
            actualizarReloj,
            1000
        );


    </script>


</body>

</html>