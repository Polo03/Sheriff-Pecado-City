@extends('layout.app')

@section('title', 'Editar Agente')

@push('styles')
<style>
    .editar-agente { max-width: 700px; margin: 0 auto; padding: 28px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .editar-agente h1 { margin-top: 0; }
    .campo-editar { margin-bottom: 18px; }
    .campo-editar label { display: block; margin-bottom: 6px; font-weight: bold; }
    .campo-editar input, .campo-editar select { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 6px; background: white; font: inherit; }
    .acciones-editar { display: flex; gap: 10px; }
    .boton-guardar, .boton-volver { padding: 11px 16px; border: 0; border-radius: 6px; color: white; cursor: pointer; font: inherit; text-decoration: none; }
    .boton-guardar { background: #198754; }
    .boton-volver { background: #555; }
</style>
@endpush

@section('content')
    @if($errors->any())
        <div class="alerta-gestion">{{ $errors->first() }}</div>
    @endif

    <section class="editar-agente">
        <h1>Editar Agente</h1>
        <form action="{{ route('gestion-agentes.update', $agenteRegistro->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="campo-editar">
                <label for="nombre">Nombre</label>
                <input id="nombre" name="nombre" type="text" maxlength="45" value="{{ old('nombre', $agenteRegistro->nombre) }}" required>
            </div>
            <div class="campo-editar">
                <label for="placa">Número de placa</label>
                <input id="placa" name="placa" type="text" maxlength="45" value="{{ old('placa', $agenteRegistro->placa) }}" required>
            </div>
            <div class="campo-editar">
                <label for="rango_id">Rango</label>
                <select id="rango_id" name="rango_id" required>
                    <option value="">Selecciona un rango</option>
                    @foreach($rangos as $rango)
                        <option value="{{ $rango->id }}" {{ (string) old('rango_id', optional($rangos->firstWhere('rango', $agenteRegistro->rango))->id) === (string) $rango->id ? 'selected' : '' }}>{{ $rango->rango }}</option>
                    @endforeach
                </select>
            </div>
            <div class="campo-editar">
                <label for="usuario">Usuario</label>
                <input id="usuario" name="usuario" type="text" maxlength="45" value="{{ old('usuario', $agenteRegistro->usuario) }}" required>
            </div>
            <div class="campo-editar">
                <label for="contraseña">Contraseña</label>
                <input id="contraseña" name="contraseña" type="text" maxlength="45" value="{{ old('contraseña', $agenteRegistro->contraseña) }}" required>
            </div>
            <div class="acciones-editar">
                <button class="boton-guardar" type="submit">Guardar cambios</button>
                <a class="boton-volver" href="{{ route('gestion-agentes.index') }}">Cancelar</a>
            </div>
        </form>
    </section>
@endsection
