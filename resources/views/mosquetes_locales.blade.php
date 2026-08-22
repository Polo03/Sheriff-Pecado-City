@extends('layout.app')

@section('title', 'Mosquetes locales')

@push('styles')
<style>
    .mosquetes-pagina { max-width: 1100px; margin: 0 auto; }
    .mosquetes-cabecera { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
    .mosquetes-cabecera h1 { margin: 0; }
    .buscador-mosquetes { display: flex; width: min(430px, 100%); gap: 6px; margin: 0 0 0 auto; }
    .buscador-mosquetes input { width: 100%; min-width: 0; padding: 7px 9px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; }
    .boton-anadir { padding: 11px 16px; border: 0; border-radius: 6px; background: #f08c00; color: white; cursor: pointer; font: inherit; }
    .modal-mosquete { display: none; position: fixed; inset: 0; z-index: 1500; align-items: center; justify-content: center; padding: 20px; background: rgba(0, 0, 0, 0.45); }
    .modal-mosquete.abierto { display: flex; }
    .modal-contenido { width: min(600px, 100%); padding: 24px; border-radius: 8px; background: white; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); }
    .modal-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .modal-cabecera h2 { margin-top: 0; }
    .modal-cerrar { border: 0; background: transparent; color: #555; font-size: 24px; cursor: pointer; }
    .campo-mosquete { margin-bottom: 18px; }
    .campo-mosquete label { display: block; margin-bottom: 6px; font-weight: bold; }
        .modal-contenido input, .campo-mosquete input { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
    .fotos-mosquete { display: grid; grid-template-columns: repeat(2, 1fr); gap: 14px; }
    .zona-foto-mosquete { display: flex; align-items: center; justify-content: center; min-height: 150px; padding: 12px; border: 2px dashed #aaa; border-radius: 8px; background: #fafafa; color: #666; text-align: center; cursor: pointer; }
    .zona-foto-mosquete.activa { border-color: #198754; background: #eef9f2; color: #198754; }
    .zona-foto-mosquete img { width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: 5px; }
    .input-foto-mosquete { display: none; }
    .boton-guardar { margin-top: 16px; padding: 11px 16px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; font: inherit; }
    .tabla-mosquetes-contenedor { overflow-x: auto; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .tabla-mosquetes { width: 100%; min-width: 850px; border-collapse: collapse; }
    .tabla-mosquetes th, .tabla-mosquetes td { padding: 14px 12px; border-bottom: 1px solid #e5e5e5; text-align: left; vertical-align: middle; }
    .tabla-mosquetes th { background: #222; color: white; }
    .foto-mosquete { width: 58px; height: 58px; object-fit: cover; border-radius: 5px; }
    .acciones-mosquete { display: flex; gap: 6px; }
    .accion-icono { display: inline-flex; align-items: center; justify-content: center; width: 36px; height: 34px; border: 0; border-radius: 5px; color: white; font-size: 17px; }
    .accion-ver { background: #198754; text-decoration: none; }
    .accion-editar { background: #f08c00; }
    .accion-eliminar { background: #dc3545; }
    .alerta-mosquete { margin-bottom: 18px; padding: 12px 16px; border-radius: 6px; background: #f8d7da; color: #721c24; }
    @media (max-width: 700px) { .mosquetes-cabecera { align-items: flex-start; flex-direction: column; } .boton-anadir { width: 100%; } .fotos-mosquete { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
    <section class="mosquetes-pagina">
        <div class="mosquetes-cabecera">
            <h1>Mosquetes locales</h1>
            <form class="buscador-mosquetes" action="{{ route('mosquetes-locales.index') }}" method="GET">
                <input type="search" name="q" value="{{ $busqueda }}" placeholder="Buscar por empresa, placa, agente o serie..." aria-label="Buscar por empresa, placa, agente o número de serie">
                @if($esDirectiva)
                    <button class="boton-anadir" type="button" id="abrir-modal-mosquete">Añadir</button>
                @endif
            </form>
        </div>

        @if($errors->any())
            <div class="alerta-mosquete">{{ $errors->first() }}</div>
        @endif

        @if($esDirectiva)
        <div class="modal-mosquete" id="modal-mosquete" role="dialog" aria-modal="true" aria-labelledby="titulo-mosquete">
            <section class="modal-contenido">
                <div class="modal-cabecera">
                    <h2 id="titulo-mosquete">Añadir mosquete local</h2>
                    <button class="modal-cerrar" type="button" id="cerrar-modal-mosquete" aria-label="Cerrar">&times;</button>
                </div>
                <form action="{{ route('mosquetes-locales.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="campo-mosquete">
                        <label for="empresa">Empresa/compañía</label>
                        <input id="empresa" name="empresa" type="text" maxlength="45" required>
                    </div>
                    <div class="campo-mosquete">
                        <label for="num_serie_mosquete">Número de serie</label>
                        <input id="num_serie_mosquete" name="num_serie_mosquete" type="text" maxlength="45" required>
                    </div>
                    <div class="fotos-mosquete">
                        <div>
                            <strong>Foto del DNI</strong>
                            <div class="zona-foto-mosquete" tabindex="0" data-input="foto_dni">Haz clic y pega la imagen con Ctrl+V</div>
                            <input id="foto_dni" class="input-foto-mosquete" type="file" name="foto_dni" accept="image/*" required>
                        </div>
                        <div>
                            <strong>Foto licencia de armas</strong>
                            <div class="zona-foto-mosquete" tabindex="0" data-input="foto_licencia_armas">Haz clic y pega la imagen con Ctrl+V</div>
                            <input id="foto_licencia_armas" class="input-foto-mosquete" type="file" name="foto_licencia_armas" accept="image/*" required>
                        </div>
                    </div>
                    <button class="boton-guardar" type="submit">Guardar</button>
                </form>
            </section>
        </div>
        @endif

        <div class="tabla-mosquetes-contenedor">
            <table class="tabla-mosquetes">
                <thead><tr><th>Agente</th><th>Placa</th><th>Empresa/compañía</th><th>Número de serie</th><th>Foto DNI</th><th>Licencia</th><th>Fecha de registro</th><th>Acciones</th></tr></thead>
                <tbody>
                    @forelse($mosquetes as $mosquete)
                        <tr>
                            <td>{{ $mosquete->agente_nombre ?: 'Agente no encontrado' }}</td>
                            <td>{{ $mosquete->placa ?: 'Sin placa' }}</td>
                            <td>{{ $mosquete->empresa }}</td>
                            <td>{{ $mosquete->num_serie_mosquete }}</td>
                            <td><img class="foto-mosquete" src="{{ asset('storage/' . $mosquete->foto_dni) }}" alt="Foto del DNI"></td>
                            <td><img class="foto-mosquete" src="{{ asset('storage/' . $mosquete->foto_licencia_armas) }}" alt="Foto de licencia"></td>
                            <td>{{ $mosquete->fecha_registro }}</td>
                            <td><div class="acciones-mosquete"><a class="accion-icono accion-ver" href="{{ asset('storage/' . $mosquete->foto_dni) }}" target="_blank" title="Ver registro" aria-label="Ver registro">👁️</a>@if($esDirectiva)<a class="accion-icono accion-editar" href="{{ route('mosquetes-locales.edit', $mosquete->id) }}" title="Editar" aria-label="Editar">✏️</a><form action="{{ route('mosquetes-locales.destroy', $mosquete->id) }}" method="POST" onsubmit="return confirm('¿Eliminar este registro?');">@csrf @method('DELETE')<button class="accion-icono accion-eliminar" type="submit" title="Eliminar" aria-label="Eliminar">➖</button></form>@endif</div></td>
                        </tr>
                    @empty
                        <tr><td colspan="8">No hay mosquetes locales registrados.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
@endsection

@push('scripts')
@if($esDirectiva)
<script>
    const buscadorMosquetes = document.querySelector('.buscador-mosquetes input[name="q"]');
    let temporizadorMosquetes;
    const modalMosquete = document.getElementById('modal-mosquete');
    const abrirModalMosquete = document.getElementById('abrir-modal-mosquete');
    const cerrarModalMosquete = document.getElementById('cerrar-modal-mosquete');
    let zonaMosqueteSeleccionada = null;

    if (buscadorMosquetes) {
        buscadorMosquetes.addEventListener('input', function () {
            clearTimeout(temporizadorMosquetes);
            temporizadorMosquetes = setTimeout(function () {
                buscadorMosquetes.form.submit();
            }, 300);
        });
    }

    abrirModalMosquete.addEventListener('click', function () {
        modalMosquete.classList.add('abierto');
    });

    cerrarModalMosquete.addEventListener('click', function () {
        modalMosquete.classList.remove('abierto');
    });

    modalMosquete.addEventListener('click', function (event) {
        if (event.target === modalMosquete) {
            modalMosquete.classList.remove('abierto');
        }
    });

    document.querySelectorAll('.zona-foto-mosquete').forEach(function (zona) {
        zona.addEventListener('click', function () {
            document.querySelectorAll('.zona-foto-mosquete').forEach(function (otraZona) {
                otraZona.classList.remove('activa');
            });
            zona.classList.add('activa');
            zonaMosqueteSeleccionada = zona;
        });
    });

    document.addEventListener('paste', function (event) {
        if (!zonaMosqueteSeleccionada) {
            return;
        }

        const imagen = Array.from(event.clipboardData.files).find(function (archivo) {
            return archivo.type.startsWith('image/');
        });

        if (!imagen) {
            return;
        }

        const input = document.getElementById(zonaMosqueteSeleccionada.dataset.input);
        const transferencia = new DataTransfer();
        transferencia.items.add(imagen);
        input.files = transferencia.files;

        zonaMosqueteSeleccionada.innerHTML = '';
        const preview = document.createElement('img');
        preview.src = URL.createObjectURL(imagen);
        preview.alt = 'Vista previa';
        zonaMosqueteSeleccionada.appendChild(preview);
        event.preventDefault();
    });
</script>
@endif
@endpush
