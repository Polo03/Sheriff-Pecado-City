<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Gestión de Rangos</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            margin: 0;
            padding: 40px;
        }

        .container {
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            margin-top: 0;
        }

        .buttons {
            display: flex;
            gap: 10px;
            margin-bottom: 30px;
        }

        button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            background: #222;
            color: white;
        }

        button:hover {
            background: #444;
        }

        form {
            margin-bottom: 25px;
            padding: 20px;
            background: #f5f5f5;
            border-radius: 8px;
        }

        input {
            display: block;
            width: 100%;
            box-sizing: border-box;
            padding: 10px;
            margin: 8px 0 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #222;
            color: white;
        }

        .mensaje {
            padding: 12px;
            margin-bottom: 20px;
            background: #d4edda;
            color: #155724;
            border-radius: 5px;
        }

        .error {
            padding: 12px;
            margin-bottom: 20px;
            background: #f8d7da;
            color: #721c24;
            border-radius: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Gestión de Rangos</h1>

    @if(session('mensaje'))
        <div class="mensaje">
            {{ session('mensaje') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    <!-- BOTONES -->

    <div class="buttons">

        <form action="{{ route('rangos.select') }}" method="POST">
            @csrf
            <button type="submit">SELECT</button>
        </form>

        <button onclick="mostrar('insert')">
            INSERT
        </button>

        <button onclick="mostrar('update')">
            UPDATE
        </button>

        <button onclick="mostrar('delete')">
            DELETE
        </button>

    </div>


    <!-- INSERT -->

    <div id="insert" style="display:none;">

        <h2>Insertar rango</h2>

        <form action="{{ route('rangos.insert') }}" method="POST">

            @csrf

            <label>Rango</label>
            <input type="text" name="rango" required>

            <label>Sueldo base</label>
            <input type="number" step="0.01" name="sueldo_base" required>

            <label>Sueldo hora extra</label>
            <input type="number" step="0.01" name="sueldo_hora_extra" required>

            <button type="submit">
                Insertar
            </button>

        </form>

    </div>


    <!-- UPDATE -->

    <div id="update" style="display:none;">

        <h2>Actualizar rango</h2>

        <form action="{{ route('rangos.update') }}" method="POST">

            @csrf

            <label>ID del rango</label>
            <input type="number" name="id" required>

            <label>Rango</label>
            <input type="text" name="rango" required>

            <label>Sueldo base</label>
            <input type="number" step="0.01" name="sueldo_base" required>

            <label>Sueldo hora extra</label>
            <input type="number" step="0.01" name="sueldo_hora_extra" required>

            <button type="submit">
                Actualizar
            </button>

        </form>

    </div>


    <!-- DELETE -->

    <div id="delete" style="display:none;">

        <h2>Eliminar rango</h2>

        <form action="{{ route('rangos.delete') }}" method="POST">

            @csrf

            <label>ID del rango</label>
            <input type="number" name="id" required>

            <button type="submit">
                Eliminar
            </button>

        </form>

    </div>


    <!-- RESULTADO SELECT -->

    @isset($rangos)

        <h2>Rangos</h2>

        <table>

            <thead>
                <tr>
                    <th>ID</th>
                    <th>Rango</th>
                    <th>Sueldo base</th>
                    <th>Sueldo hora extra</th>
                </tr>
            </thead>

            <tbody>

                @forelse($rangos as $rango)

                    <tr>
                        <td>{{ $rango->id }}</td>
                        <td>{{ $rango->rango }}</td>
                        <td>{{ $rango->{'sueldo base'} }}</td>
                        <td>{{ $rango->sueldo_hora_extra }}</td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            No hay rangos registrados.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>

    @endisset

</div>


<script>

    function mostrar(elemento) {

        document.getElementById('insert').style.display = 'none';
        document.getElementById('update').style.display = 'none';
        document.getElementById('delete').style.display = 'none';

        document.getElementById(elemento).style.display = 'block';
    }

</script>

</body>
</html>