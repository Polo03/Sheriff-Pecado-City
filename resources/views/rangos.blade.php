@extends('layout.app')

@section('title', 'Gestión de Rangos')

@push('styles')
<style>
    .rangos-container {
        max-width: 1000px;
        margin: 0 auto;
        padding: 30px;
        border-radius: 10px;
        background: white;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .rangos-container h1 {
        margin-top: 0;
    }

    .rangos-buttons {
        display: flex;
        gap: 10px;
        margin-bottom: 30px;
    }

    .rangos-container button {
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        background: #222;
        color: white;
        cursor: pointer;
    }

    .rangos-container form {
        margin-bottom: 25px;
        padding: 20px;
        border-radius: 8px;
        background: #f5f5f5;
    }

    .rangos-container input {
        display: block;
        width: 100%;
        box-sizing: border-box;
        margin: 8px 0 15px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
    }

    .rangos-container table {
        width: 100%;
        margin-top: 20px;
        border-collapse: collapse;
    }

    .rangos-container th,
    .rangos-container td {
        padding: 12px;
        border-bottom: 1px solid #ddd;
        text-align: left;
    }

    .rangos-container th {
        background: #222;
        color: white;
    }

    .mensaje {
        margin-bottom: 20px;
        padding: 12px;
        border-radius: 5px;
        background: #d4edda;
        color: #155724;
    }

    .error {
        margin-bottom: 20px;
        padding: 12px;
        border-radius: 5px;
        background: #f8d7da;
        color: #721c24;
    }
</style>
@endpush

@section('content')
    <div class="rangos-container">
        <h1>Gestión de Rangos</h1>

        @if(session('mensaje'))
            <div class="mensaje">{{ session('mensaje') }}</div>
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

        <div class="rangos-buttons">
            <form action="{{ route('rangos.select') }}" method="POST">
                @csrf
                <button type="submit">SELECT</button>
            </form>
            <button type="button" onclick="mostrar('insert')">INSERT</button>
            <button type="button" onclick="mostrar('update')">UPDATE</button>
            <button type="button" onclick="mostrar('delete')">DELETE</button>
        </div>

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
                <button type="submit">Insertar</button>
            </form>
        </div>

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
                <button type="submit">Actualizar</button>
            </form>
        </div>

        <div id="delete" style="display:none;">
            <h2>Eliminar rango</h2>
            <form action="{{ route('rangos.delete') }}" method="POST">
                @csrf
                <label>ID del rango</label>
                <input type="number" name="id" required>
                <button type="submit">Eliminar</button>
            </form>
        </div>

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
                            <td colspan="4">No hay rangos registrados.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        @endisset
    </div>
@endsection

@push('scripts')
<script>
    function mostrar(elemento) {
        document.getElementById('insert').style.display = 'none';
        document.getElementById('update').style.display = 'none';
        document.getElementById('delete').style.display = 'none';
        document.getElementById(elemento).style.display = 'block';
    }
</script>
@endpush
