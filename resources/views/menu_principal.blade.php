@extends('layout.app')

@section('title', 'Fichaje')

@push('styles')
<style>
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
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
    }

    .menu-usuario {
        display: none;
        position: absolute;
        top: 48px;
        right: 0;
        min-width: 150px;
        background: white;
        border-radius: 8px;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.15);
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

    .fichaje-container {
        width: min(400px, 100%);
        margin: 10vh auto 0;
        padding: 40px;
        border-radius: 15px;
        background: white;
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        text-align: center;
    }

    .fichaje-container h1 {
        margin-top: 0;
        margin-bottom: 30px;
    }

    .reloj-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 25px;
        margin: 30px 0;
    }

    .circulo-estado {
        width: 70px;
        height: 70px;
        flex-shrink: 0;
        border-radius: 50%;
    }

    .circulo-verde {
        background: #198754;
        box-shadow: 0 0 20px rgba(25, 135, 84, 0.5);
    }

    .circulo-rojo {
        background: #dc3545;
        box-shadow: 0 0 20px rgba(220, 53, 69, 0.5);
    }

    #reloj {
        color: #222;
        font-family: monospace;
        font-size: 36px;
        font-weight: bold;
        white-space: nowrap;
    }

    .estado {
        margin: 20px 0;
        padding: 15px;
        border-radius: 8px;
        background: #f5f5f5;
    }

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
</style>
@endpush

@section('content')
    <div class="usuario">
        <button type="button" class="usuario-boton" onclick="toggleMenu()">
            {{ $nombre }} <span id="flecha">▼</span>
        </button>

        <div id="menu-usuario" class="menu-usuario">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="logout">Cerrar sesión</button>
            </form>
        </div>
    </div>

    <div class="fichaje-container">
        <h1>Fichaje</h1>

        @if(session('mensaje'))
            <div class="mensaje">{{ session('mensaje') }}</div>
        @endif

        <div class="reloj-container">
            <div class="circulo-estado {{ $fichajeActivo ? 'circulo-verde' : 'circulo-rojo' }}"></div>
            <div id="reloj">00:00:00</div>
        </div>

        @if($fichajeActivo)
            <div class="estado">
                <p>Entrada: <strong>{{ $fichajeActivo->entrada }}</strong></p>
            </div>

            <form action="{{ route('fichaje.fichar') }}" method="POST">
                @csrf
                <button type="submit" class="fichar">Finalizar fichaje</button>
            </form>
        @else
            <form action="{{ route('fichaje.fichar') }}" method="POST">
                @csrf
                <button type="submit" class="fichar">Fichar entrada</button>
            </form>
        @endif
    </div>
@endsection

@push('scripts')
<script>
    function toggleMenu() {
        const menu = document.getElementById('menu-usuario');
        const flecha = document.getElementById('flecha');
        const abierto = menu.style.display === 'block';

        menu.style.display = abierto ? 'none' : 'block';
        flecha.textContent = abierto ? '▼' : '▲';
    }

    function actualizarReloj() {
        const ahora = new Date();
        const horas = String(ahora.getHours()).padStart(2, '0');
        const minutos = String(ahora.getMinutes()).padStart(2, '0');
        const segundos = String(ahora.getSeconds()).padStart(2, '0');

        document.getElementById('reloj').textContent = `${horas}:${minutos}:${segundos}`;
    }

    actualizarReloj();
    setInterval(actualizarReloj, 1000);
</script>
@endpush
