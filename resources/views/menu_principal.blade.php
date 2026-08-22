@extends('layout.app')

@section('title', 'Fichaje')

@push('styles')
<style>
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

    .pluses-container {
        width: min(400px, 100%);
        margin: 24px auto 0;
        padding: 20px;
        border-radius: 8px;
        background: white;
        box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08);
    }

    .pluses-container label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    .pluses-container select {
        width: 100%;
        padding: 11px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: white;
        font: inherit;
    }
</style>
@endpush

@section('content')
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

    <div class="pluses-container">
        <label for="plus">Pluses</label>
        <select id="plus" name="plus">
            <option value="">Selecciona un plus</option>
        </select>
    </div>

@endsection

@push('scripts')
<script>
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
