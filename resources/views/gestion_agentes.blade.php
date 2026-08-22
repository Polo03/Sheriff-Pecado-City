@extends('layout.app')

@section('title', 'Gestión Agentes')

@push('styles')
<style>
    .gestion-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 20px; }
    .gestion-cabecera h1 { margin: 0; font-size: 24px; }
    .boton-alta { padding: 11px 16px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; font: inherit; }
    .modal-alta { display: none; position: fixed; inset: 0; z-index: 1500; align-items: center; justify-content: center; padding: 20px; background: rgba(0, 0, 0, 0.45); }
    .modal-alta.abierto { display: flex; }
    .modal-contenido { width: min(440px, 100%); padding: 24px; border-radius: 8px; background: white; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); }
    .modal-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .modal-cabecera h2 { margin-top: 0; }
    .modal-cerrar { border: 0; background: transparent; color: #555; font-size: 24px; cursor: pointer; }
    .gestion-panel { padding: 24px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .gestion-panel h2 { margin-top: 0; font-size: 20px; }
    .campo-gestion { margin-bottom: 18px; }
    .campo-gestion label { display: block; margin-bottom: 6px; font-weight: bold; }
    .campo-gestion input, .campo-gestion select { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 6px; background: white; font: inherit; }
    .boton-gestion { padding: 11px 16px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; font: inherit; }
    .tabla-agentes { width: 100%; border-collapse: collapse; }
    .tabla-agentes th, .tabla-agentes td { padding: 13px 12px; border-bottom: 1px solid #e5e5e5; text-align: left; vertical-align: middle; }
    .tabla-agentes th { background: #222; color: white; }
    .tabla-agentes th:first-child { border-top-left-radius: 6px; }
    .tabla-agentes th:last-child { border-top-right-radius: 6px; }
    .acciones-agente { display: flex; flex-wrap: wrap; gap: 8px; }
    .accion-enlace { display: inline-block; padding: 8px 10px; border-radius: 5px; background: #198754; color: white; text-decoration: none; font-size: 13px; }
    .accion-baja { padding: 8px 10px; border: 0; border-radius: 5px; background: #dc3545; color: white; cursor: pointer; font: inherit; font-size: 13px; }
    .alerta-gestion { margin-bottom: 18px; padding: 12px 16px; border-radius: 6px; background: #d4edda; color: #155724; }
    @media (max-width: 700px) { .gestion-cabecera { align-items: flex-start; flex-direction: column; } .gestion-alta { width: 100%; } .gestion-alta summary { display: block; text-align: center; } .tabla-contenedor { overflow-x: auto; } .tabla-agentes { min-width: 680px; } }
</style>
@endpush

@section('content')
    @if(session('mensaje'))
        <div class="alerta-gestion">{{ session('mensaje') }}</div>
    @endif

    @if($errors->any())
        <div class="alerta-gestion">{{ $errors->first() }}</div>
    @endif

    <div class="gestion-cabecera">
        <h1>Gestión Agentes</h1>
        <button class="boton-alta" type="button" id="abrir-alta">Dar de alta</button>
    </div>

    <div class="modal-alta" id="modal-alta" role="dialog" aria-modal="true" aria-labelledby="titulo-alta">
        <section class="modal-contenido">
            <div class="modal-cabecera">
                <h2 id="titulo-alta">Dar de alta agente</h2>
                <button class="modal-cerrar" type="button" id="cerrar-alta" aria-label="Cerrar">&times;</button>
            </div>
            <form action="{{ route('gestion-agentes.alta') }}" method="POST">
                @csrf
                <div class="campo-gestion">
                    <label for="nombre">Nombre</label>
                    <input id="nombre" name="nombre" type="text" maxlength="45" required>
                </div>
                <div class="campo-gestion">
                    <label for="placa">Número de placa</label>
                    <input id="placa" name="placa" type="text" maxlength="45" required>
                </div>
                <div class="campo-gestion">
                    <label for="rango_id">Rango</label>
                    <select id="rango_id" name="rango_id" required>
                        <option value="">Selecciona un rango</option>
                        @foreach($rangos as $rango)
                            <option value="{{ $rango->id }}">{{ $rango->rango }}</option>
                        @endforeach
                    </select>
                </div>
                <button class="boton-gestion" type="submit">Dar de alta agente</button>
            </form>
        </section>
    </div>

    <section class="gestion-panel">
        <div class="tabla-contenedor">
            <table class="tabla-agentes">
                <thead>
                    <tr><th>Nombre</th><th>Placa</th><th>Rango</th><th>Escala</th><th>Acciones</th></tr>
                </thead>
                <tbody>
                @forelse($agentes as $agente)
                    @php($fichaAgente = $fichas->firstWhere('agente_id', $agente->id))
                    <tr>
                        <td>{{ $agente->nombre }}</td>
                        <td>{{ $agente->placa }}</td>
                        <td>{{ $agente->rango ?: 'Sin rango asignado' }}</td>
                        <td>{{ $fichaAgente->escala ?? 'Sin escala asignada' }}</td>
                        <td>
                            <div class="acciones-agente">
                                @if($fichaAgente)
                                    <a class="accion-enlace" href="{{ route('fichas-agentes.show', $fichaAgente->id) }}">Ver ficha</a>
                                @endif
                                <a class="accion-enlace" href="{{ route('gestion-agentes.edit', $agente->id) }}">Editar Agente</a>
                                <form action="{{ route('gestion-agentes.baja', $agente->id) }}" method="POST" onsubmit="return confirm('¿Dar de baja este agente y eliminar su ficha?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="accion-baja" type="submit">Dar de baja</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5">No hay agentes registrados.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    const modalAlta = document.getElementById('modal-alta');
    const abrirAlta = document.getElementById('abrir-alta');
    const cerrarAlta = document.getElementById('cerrar-alta');

    abrirAlta.addEventListener('click', function () {
        modalAlta.classList.add('abierto');
    });

    cerrarAlta.addEventListener('click', function () {
        modalAlta.classList.remove('abierto');
    });

    modalAlta.addEventListener('click', function (event) {
        if (event.target === modalAlta) {
            modalAlta.classList.remove('abierto');
        }
    });
</script>
@endpush
