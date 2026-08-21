<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Iniciar sesión</title>

    <style>

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;

            min-height: 100vh;

            display: flex;

            justify-content: center;

            align-items: center;

            font-family: Arial, sans-serif;

            background: #f2f2f2;
        }


        /* =========================
           CONTENEDOR
        ========================= */

        .login-container {
            width: 400px;

            background: white;

            padding: 40px;

            border-radius: 15px;

            box-shadow:
                0 5px 20px rgba(0, 0, 0, 0.15);
        }


        h1 {
            text-align: center;

            margin-top: 0;

            margin-bottom: 30px;
        }


        /* =========================
           LABEL
        ========================= */

        label {
            display: block;

            margin-bottom: 5px;

            font-weight: bold;
        }


        /* =========================
           INPUT
        ========================= */

        input[type="text"],
        input[type="password"] {

            width: 100%;

            padding: 12px;

            margin-bottom: 20px;

            border: 1px solid #ccc;

            border-radius: 6px;

            font-size: 16px;
        }


        /* =========================
           RECORDAR
        ========================= */

        .recordar {

            display: flex;

            align-items: center;

            gap: 8px;

            margin-bottom: 20px;

            font-weight: normal;

            cursor: pointer;
        }

        .recordar input {

            width: 16px;

            height: 16px;

            cursor: pointer;
        }


        /* =========================
           BOTÓN
        ========================= */

        .login-button {

            width: 100%;

            padding: 13px;

            border: none;

            border-radius: 6px;

            background: #222;

            color: white;

            font-size: 16px;

            cursor: pointer;
        }

        .login-button:hover {

            background: #444;
        }


        /* =========================
           ERROR
        ========================= */

        .error {

            padding: 12px;

            margin-bottom: 20px;

            border-radius: 6px;

            background: #f8d7da;

            color: #721c24;
        }

    </style>

</head>


<body>


    <div class="login-container">


        <h1>
            Iniciar sesión
        </h1>


        <!-- =========================
             ERRORES
        ========================= -->

        @if($errors->any())

            <div class="error">

                @foreach($errors->all() as $error)

                    <div>
                        {{ $error }}
                    </div>

                @endforeach

            </div>

        @endif


        <!-- =========================
             LOGIN
        ========================= -->

        <form
            action="{{ route('login.post') }}"
            method="POST"
        >

            @csrf


            <!-- USUARIO -->

            <label for="usuario">
                Usuario
            </label>

            <input
                type="text"
                id="usuario"
                name="usuario"
                value="{{ old('usuario') }}"
                required
            >


            <!-- CONTRASEÑA -->

            <label for="contraseña">
                Contraseña
            </label>

            <input
                type="password"
                id="contraseña"
                name="contraseña"
                required
            >


            <!-- RECORDAR USUARIO -->

            <label class="recordar">

                <input
                    type="checkbox"
                    name="recordar"
                    value="1"
                    {{ old('recordar') ? 'checked' : '' }}
                >

                Recordarme

            </label>


            <!-- BOTÓN -->

            <button
                type="submit"
                class="login-button"
            >
                Iniciar sesión
            </button>

        </form>


    </div>


</body>

</html>