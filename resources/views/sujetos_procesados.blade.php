@extends('layout.app')

@section('title', 'Sujetos procesados')

@push('styles')
<style>
    .sujetos-header { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 24px; }
    .sujetos-header h1 { margin: 0; }
    .buscador { display: flex; flex: 1; justify-content: center; margin: 0; }
    .buscador input { width: min(360px, 100%); padding: 11px 13px; border: 1px solid #ccc; border-radius: 6px; }
    .boton-principal, .boton-secundario, .boton-peligro { display: inline-block; padding: 10px 16px; border: 0; border-radius: 6px; color: white; text-decoration: none; cursor: pointer; font-size: 14px; }
    .boton-principal { background: #198754; }
    .boton-secundario { background: #555; }
    .boton-peligro { background: #dc3545; }
    .boton-accion { display: inline-flex; align-items: center; justify-content: center; width: 42px; height: 38px; padding: 0; border: 0; border-radius: 6px; color: white; text-decoration: none; cursor: pointer; font-size: 21px; line-height: 1; }
    .boton-ver { background: #198754; }
    .boton-editar { background: #f08c00; }
    .boton-eliminar { background: #dc3545; }
    .boton-accion:hover { filter: brightness(0.9); }
    .tabla-contenedor, .formulario-contenedor, .detalle-contenedor { padding: 24px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .tablas-sujetos { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 18px; }
    .tabla-contenedor { overflow: hidden; padding: 0; }
    .tabla-sujetos { width: 100%; border-collapse: separate; border-spacing: 0; }
    .tabla-sujetos th, .tabla-sujetos td { padding: 14px 12px; border-bottom: 1px solid #e5e5e5; text-align: left; vertical-align: middle; }
    .tabla-sujetos th { background: #222; color: white; }
    .tabla-sujetos thead th:first-child { border-top-left-radius: 8px; }
    .tabla-sujetos thead th:last-child { border-top-right-radius: 8px; }
    .tabla-sujetos tbody tr:last-child td:first-child { border-bottom-left-radius: 8px; }
    .tabla-sujetos tbody tr:last-child td:last-child { border-bottom-right-radius: 8px; }
    .paginacion { display: flex; justify-content: center; margin-top: 24px; }
    .paginacion nav { display: flex; gap: 6px; }
    .paginacion a, .paginacion span { display: inline-flex; align-items: center; justify-content: center; min-width: 38px; height: 38px; padding: 0 10px; border: 1px solid #ddd; border-radius: 6px; background: white; color: #333; text-decoration: none; }
    .paginacion a:hover { background: #f0f0f0; }
    .paginacion span[aria-current="page"] { background: #198754; border-color: #198754; color: white; }
    .miniatura { width: 54px; height: 54px; object-fit: cover; border-radius: 6px; }
    .acciones, .detalle-acciones { display: flex; flex-wrap: wrap; gap: 8px; }
    .formulario-contenedor { max-width: 760px; margin: 0 auto; }
    .campo { margin-bottom: 18px; }
    .campo label { display: block; margin-bottom: 6px; font-weight: bold; }
    .campo input { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 5px; }
    .fotos-formulario, .detalle-fotos { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin: 22px 0; }
    .foto-bloque { padding: 12px; border: 1px solid #ddd; border-radius: 6px; }
    .foto-bloque img { width: 100%; aspect-ratio: 1; object-fit: cover; margin-bottom: 10px; border-radius: 5px; }
    .zona-foto { display: flex; align-items: center; justify-content: center; min-height: 190px; padding: 16px; border: 2px dashed #aaa; border-radius: 8px; background: #fafafa; color: #666; text-align: center; cursor: pointer; }
    .zona-foto.activa { border-color: #198754; background: #eef9f2; color: #198754; }
    .zona-foto .preview-foto { display: none; width: 100%; aspect-ratio: 1; object-fit: cover; border-radius: 5px; }
    .input-foto-oculto { display: none; }
    .texto-pegar { pointer-events: none; }
    .alerta { margin-bottom: 18px; padding: 12px 16px; border-radius: 6px; background: #d4edda; color: #155724; }
    .errores { margin-bottom: 18px; padding: 12px 16px; border-radius: 6px; background: #f8d7da; color: #721c24; }
    @media (max-width: 700px) { .sujetos-header { align-items: flex-start; flex-direction: column; } .tablas-sujetos { grid-template-columns: 1fr; } .tabla-contenedor { overflow-x: auto; } .fotos-formulario, .detalle-fotos { grid-template-columns: 1fr; } }
</style>
@endpush

@section('content')
    @if(session('mensaje'))
        <div class="alerta">{{ session('mensaje') }}</div>
    @endif

    @if($errors->any())
        <div class="errores">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($modo === 'lista')
        <div class="sujetos-header">
            <h1>Sujetos procesados</h1>
            <form class="buscador" action="{{ route('sujetos-procesados.index') }}" method="GET">
                <input type="search" name="buscar" value="{{ request('buscar') }}" placeholder="Buscar por nombre..." aria-label="Buscar por nombre">
            </form>
            <a class="boton-principal" href="{{ route('sujetos-procesados.create') }}">Nuevo sujeto</a>
        </div>

        @php($gruposSujetos = [$sujetos->slice(0, 8), $sujetos->slice(8, 8)])
        <div class="tablas-sujetos">
            @foreach($gruposSujetos as $grupoSujetos)
                <div class="tabla-contenedor">
                    <table class="tabla-sujetos">
                        <thead>
                            <tr><th></th><th>Nombre</th><th>DNI</th><th>Foto</th></tr>
                        </thead>
                        <tbody>
                            @forelse($grupoSujetos as $sujeto)
                                <tr>
                                    <td>
                                        <div class="acciones">
                                            <a class="boton-accion boton-ver" href="{{ route('sujetos-procesados.show', $sujeto) }}" title="Ver sujeto" aria-label="Ver sujeto">👁️</a>
                                            <a class="boton-accion boton-editar" href="{{ route('sujetos-procesados.edit', $sujeto) }}" title="Editar sujeto" aria-label="Editar sujeto">✏️</a>
                                            <form action="{{ route('sujetos-procesados.destroy', $sujeto) }}" method="POST" onsubmit="return confirm('¿Eliminar este sujeto?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="boton-accion boton-eliminar" type="submit" title="Eliminar sujeto" aria-label="Eliminar sujeto">➖</button>
                                            </form>
                                        </div>
                                    </td>
                                    <td>{{ $sujeto->nombre }}</td>
                                    <td>{{ $sujeto->dni }}</td>
                                    <td>
                                        @if($sujeto->foto_sujeto_procesado)
                                            <img class="miniatura" src="{{ asset('storage/' . $sujeto->foto_sujeto_procesado) }}" alt="Foto de {{ $sujeto->nombre }}">
                                        @else
                                            Sin foto
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4">No hay registros en este bloque.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            @endforeach
        </div>

        @if($sujetos->hasPages())
            <div class="paginacion">
                {{ $sujetos->links('pagination.numeros') }}
            </div>
        @endif
    @elseif($modo === 'crear' || $modo === 'editar')
        @php($editando = $modo === 'editar')
        <div class="sujetos-header">
            <h1>{{ $editando ? 'Editar sujeto procesado' : 'Nuevo sujeto procesado' }}</h1>
            <a class="boton-secundario" href="{{ route('sujetos-procesados.index') }}">Volver</a>
        </div>

        <div class="formulario-contenedor">
            <form action="{{ $editando ? route('sujetos-procesados.update', $sujeto) : route('sujetos-procesados.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if($editando) @method('PUT') @endif
                <div class="campo"><label for="nombre">Nombre</label><input id="nombre" type="text" name="nombre" value="{{ old('nombre', $editando ? $sujeto->nombre : '') }}" required></div>
                <div class="campo"><label for="dni">DNI</label><input id="dni" type="text" name="dni" value="{{ old('dni', $editando ? $sujeto->dni : '') }}" required></div>

                <div class="fotos-formulario">
                    @foreach(['foto_sujeto_procesado' => 'Foto del sujeto', 'foto_dni' => 'Foto del DNI', 'foto_antecedentes' => 'Foto de antecedentes'] as $campo => $etiqueta)
                        <div class="foto-bloque">
                            <strong>{{ $etiqueta }}</strong>
                            <div class="zona-foto" tabindex="0" data-input="{{ $campo }}">
                                @if($editando && $sujeto->$campo)
                                    <img class="preview-foto" style="display:block" src="{{ asset('storage/' . $sujeto->$campo) }}" alt="{{ $etiqueta }}">
                                @else
                                    <span class="texto-pegar">Haz clic aquí y pega la imagen con Ctrl+V</span>
                                @endif
                            </div>
                            <input id="{{ $campo }}" class="input-foto-oculto" type="file" name="{{ $campo }}" accept="image/*">
                        </div>
                    @endforeach
                </div>
                <button class="boton-principal" type="submit">{{ $editando ? 'Guardar cambios' : 'Guardar sujeto' }}</button>
            </form>
        </div>
    @elseif($modo === 'ver')
        <div class="sujetos-header">
            <h1>Detalle del sujeto</h1>
            <a class="boton-secundario" href="{{ route('sujetos-procesados.index') }}">Volver</a>
        </div>

        <div class="detalle-contenedor">
            <p><strong>Nombre:</strong> {{ $sujeto->nombre }}</p>
            <p><strong>DNI:</strong> {{ $sujeto->dni }}</p>
            <div class="detalle-fotos">
                @foreach(['foto_sujeto_procesado' => 'Foto del sujeto', 'foto_dni' => 'Foto del DNI', 'foto_antecedentes' => 'Foto de antecedentes'] as $campo => $etiqueta)
                    <div class="foto-bloque">
                        <strong>{{ $etiqueta }}</strong>
                        @if($sujeto->$campo)<img src="{{ asset('storage/' . $sujeto->$campo) }}" alt="{{ $etiqueta }}">@else<p>Sin archivo.</p>@endif
                    </div>
                @endforeach
            </div>
            <div class="detalle-acciones"><a class="boton-secundario" href="{{ route('sujetos-procesados.edit', $sujeto) }}">Editar</a></div>
        </div>
    @endif
@endsection

@push('scripts')
<script>
    const campoBusqueda = document.querySelector('.buscador input[name="buscar"]');
    let temporizadorBusqueda;

    if (campoBusqueda) {
        campoBusqueda.addEventListener('input', function () {
            clearTimeout(temporizadorBusqueda);

            temporizadorBusqueda = setTimeout(function () {
                const url = new URL(window.location.href);
                const texto = campoBusqueda.value.trim();

                if (texto) {
                    url.searchParams.set('buscar', texto);
                } else {
                    url.searchParams.delete('buscar');
                }

                url.searchParams.delete('page');
                window.location.href = url.toString();
            }, 350);
        });
    }
</script>
@endpush

@push('scripts')
<script>
    let zonaSeleccionada = null;

    document.querySelectorAll('.zona-foto').forEach(function (zona) {
        zona.addEventListener('click', function () {
            document.querySelectorAll('.zona-foto').forEach(function (otraZona) {
                otraZona.classList.remove('activa');
            });

            zona.classList.add('activa');
            zonaSeleccionada = zona;
            zona.focus();
        });
    });

    document.addEventListener('paste', function (event) {
        if (!zonaSeleccionada) {
            return;
        }

        const imagen = Array.from(event.clipboardData.files).find(function (archivo) {
            return archivo.type.startsWith('image/');
        });

        if (!imagen) {
            return;
        }

        const input = document.getElementById(zonaSeleccionada.dataset.input);
        const transferencia = new DataTransfer();
        transferencia.items.add(imagen);
        input.files = transferencia.files;

        let preview = zonaSeleccionada.querySelector('.preview-foto');
        let texto = zonaSeleccionada.querySelector('.texto-pegar');

        if (!preview) {
            preview = document.createElement('img');
            preview.className = 'preview-foto';
            zonaSeleccionada.appendChild(preview);
        }

        preview.src = URL.createObjectURL(imagen);
        preview.style.display = 'block';

        if (texto) {
            texto.style.display = 'none';
        }

        event.preventDefault();
    });
</script>
@endpush
