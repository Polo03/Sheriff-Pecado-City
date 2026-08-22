@extends('layout.app')

@section('title', 'Armamento')

@push('styles')
<style>
    .armamento-pagina { max-width: 1100px; margin: 0 auto; }
    .armamento-cabecera { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
    .armamento-cabecera h1 { margin: 0; }
    .buscador-armamento { display: flex; width: min(430px, 100%); gap: 6px; margin: 0 0 0 auto; }
    .buscador-armamento input { width: 100%; min-width: 0; padding: 7px 9px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; }
    .boton-anadir { padding: 7px 10px; border: 0; border-radius: 5px; color: white; cursor: pointer; font-size: 13px; white-space: nowrap; }
    .boton-anadir { background: #f08c00; }
    .modal-armamento { display: none; position: fixed; inset: 0; z-index: 1500; align-items: center; justify-content: center; padding: 20px; background: rgba(0, 0, 0, 0.45); }
    .modal-armamento.abierto { display: flex; }
    .modal-contenido { width: min(520px, 100%); padding: 24px; border-radius: 8px; background: white; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); }
    .modal-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .modal-cabecera h2 { margin-top: 0; }
    .modal-cerrar { border: 0; background: transparent; color: #555; font-size: 24px; cursor: pointer; }
    .campo-armamento { margin-bottom: 18px; }
    .campo-armamento label { display: block; margin-bottom: 6px; font-weight: bold; }
    .campo-armamento input, .campo-armamento select { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 6px; background: white; font: inherit; }
    .tabla-armamento-contenedor { overflow-x: auto; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .tabla-armamento { width: 100%; min-width: 760px; border-collapse: collapse; }
    .tabla-armamento th, .tabla-armamento td { padding: 14px 12px; border-bottom: 1px solid #e5e5e5; text-align: left; vertical-align: middle; }
    .tabla-armamento th { background: #222; color: white; }
    .tabla-armamento th:first-child { border-top-left-radius: 8px; }
    .tabla-armamento th:last-child { border-top-right-radius: 8px; }
    .sin-resultados { padding: 20px; color: #666; }
</style>
@endpush

@section('content')
    <section class="armamento-pagina">
        <div class="armamento-cabecera">
            <h1>{{ $puedeRegistrar ? 'Registrar armamento' : 'Armamento' }}</h1>
            <form class="buscador-armamento" action="{{ $puedeRegistrar ? route('registrar-armamento.index') : route('armamento.index') }}" method="GET">
                <input type="search" name="q" value="{{ $busqueda }}" placeholder="Buscar por serie, placa o agente..." aria-label="Buscar por número de serie, placa o nombre de agente">
                @if($puedeRegistrar)
                    <button class="boton-anadir" type="button" id="abrir-modal-armamento">Añadir</button>
                @endif
            </form>
        </div>

        @if(session('mensaje'))
            <p>{{ session('mensaje') }}</p>
        @endif

        @if($errors->any())
            <p>{{ $errors->first() }}</p>
        @endif

        @if($puedeRegistrar)
            <div class="modal-armamento" id="modal-armamento" role="dialog" aria-modal="true" aria-labelledby="titulo-armamento">
                <section class="modal-contenido">
                    <div class="modal-cabecera">
                        <h2 id="titulo-armamento">Añadir armamento</h2>
                        <button class="modal-cerrar" type="button" id="cerrar-modal-armamento" aria-label="Cerrar">&times;</button>
                    </div>
                    <form action="{{ route('registrar-armamento.store') }}" method="POST">
                        @csrf
                        <div class="campo-armamento">
                            <label for="tipo_arma">Tipo de arma</label>
                            <select id="tipo_arma" name="tipo_arma" required>
                                <option value="">Selecciona un arma</option>
                                <option value="Pistola reglamentaria">Pistola reglamentaria</option>
                                <option value="Taser">Taser</option>
                            </select>
                        </div>
                        <div class="campo-armamento">
                            <label for="numero_serie">Número de serie</label>
                            <input id="numero_serie" name="numero_serie" type="text" maxlength="45" required>
                        </div>
                        <button class="boton-anadir" type="submit">Añadir</button>
                    </form>
                </section>
            </div>
        @endif

        <div class="tabla-armamento-contenedor">
            <table class="tabla-armamento">
                <thead>
                    <tr>
                        <th>Agente</th>
                        <th>Placa</th>
                        <th>Tipo de arma</th>
                        <th>Número de serie</th>
                        <th>Fecha de registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($armas as $arma)
                        <tr>
                            <td>{{ $arma->agente_nombre ?: 'Agente no encontrado' }}</td>
                            <td>{{ $arma->placa ?: 'Sin placa' }}</td>
                            <td>{{ $arma->tipo_arma }}</td>
                            <td>{{ $arma->numero_serie }}</td>
                            <td>{{ $arma->fecha_registro }}</td>
                        </tr>
                    @empty
                        <tr><td class="sin-resultados" colspan="5">No hay armas registradas.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('styles')
<style>
    @media (max-width: 700px) {
        .armamento-cabecera { align-items: stretch; flex-direction: column; }
        .buscador-armamento { width: 100%; margin-left: 0; }
    }
</style>
@endpush

@if($puedeRegistrar)
    @push('scripts')
    <script>
        const modalArmamento = document.getElementById('modal-armamento');
        const abrirModalArmamento = document.getElementById('abrir-modal-armamento');
        const cerrarModalArmamento = document.getElementById('cerrar-modal-armamento');

        abrirModalArmamento.addEventListener('click', function () {
            modalArmamento.classList.add('abierto');
        });

        cerrarModalArmamento.addEventListener('click', function () {
            modalArmamento.classList.remove('abierto');
        });

        modalArmamento.addEventListener('click', function (event) {
            if (event.target === modalArmamento) {
                modalArmamento.classList.remove('abierto');
            }
        });
    </script>
    @endpush
@endif

@push('scripts')
<script>
    const buscadorArmamento = document.querySelector('.buscador-armamento input[name="q"]');
    let temporizadorArmamento;

    if (buscadorArmamento) {
        buscadorArmamento.addEventListener('input', function () {
            clearTimeout(temporizadorArmamento);
            temporizadorArmamento = setTimeout(function () {
                buscadorArmamento.form.submit();
            }, 300);
        });
    }
</script>
@endpush
