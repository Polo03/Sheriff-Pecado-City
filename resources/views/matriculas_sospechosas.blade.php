@extends('layout.app')

@section('title', 'Matriculas sospechosas')

@push('styles')
<style>
    .matriculas-pagina { max-width: 1100px; margin: 0 auto; }
    .matriculas-cabecera { display: flex; align-items: center; gap: 14px; margin-bottom: 20px; }
    .matriculas-cabecera h1 { margin: 0; }
    .buscador-matriculas { display: flex; width: min(460px, 100%); gap: 6px; margin: 0 0 0 auto; }
    .buscador-matriculas input { width: 100%; min-width: 0; padding: 7px 9px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; }
    .boton-anadir { padding: 7px 10px; border: 0; border-radius: 5px; background: #f08c00; color: white; cursor: pointer; font-size: 13px; white-space: nowrap; }
    .modal-matricula { display: none; position: fixed; inset: 0; z-index: 1500; align-items: center; justify-content: center; padding: 20px; background: rgba(0, 0, 0, 0.45); }
    .modal-matricula.abierto { display: flex; }
    .modal-contenido { width: min(520px, 100%); padding: 24px; border-radius: 8px; background: white; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); }
    .modal-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .modal-cabecera h2 { margin-top: 0; }
    .modal-cerrar { border: 0; background: transparent; color: #555; font-size: 24px; cursor: pointer; }
    .campo-matricula { margin-bottom: 18px; }
    .campo-matricula label { display: block; margin-bottom: 6px; font-weight: bold; }
    .campo-matricula input, .campo-matricula textarea { width: 100%; padding: 11px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
    .campo-matricula textarea { min-height: 100px; resize: vertical; }
    .zona-foto-matricula { display: flex; align-items: center; justify-content: center; min-height: 180px; padding: 12px; border: 2px dashed #aaa; border-radius: 8px; background: #fafafa; color: #666; text-align: center; cursor: pointer; }
    .zona-foto-matricula.activa { border-color: #198754; background: #eef9f2; color: #198754; }
    .zona-foto-matricula img { width: 100%; max-height: 240px; object-fit: contain; border-radius: 5px; }
    .input-foto-matricula { display: none; }
    .boton-guardar { margin-top: 16px; padding: 11px 16px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; font: inherit; }
    .tabla-matriculas-contenedor { overflow-x: auto; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .tabla-matriculas { width: 100%; min-width: 720px; border-collapse: collapse; }
    .tabla-matriculas th, .tabla-matriculas td { padding: 14px 12px; border-bottom: 1px solid #e5e5e5; text-align: left; vertical-align: middle; }
    .tabla-matriculas th { background: #222; color: white; }
    .acciones-matricula {
    display: flex;
    gap: 6px;
    align-items: center;
}

.acciones-matricula form {
    margin: 0;
}

.accion-icono {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    width: 36px;
    height: 34px;

    border: 0;
    border-radius: 5px;

    color: white;

    font-size: 17px;

    text-decoration: none;

    cursor: pointer;
}

.accion-ver {
    background: #198754;
}

.accion-ver:hover {
    background: #157347;
}

.accion-editar {
    background: #f08c00;
}

.accion-editar:hover {
    background: #d97700;
}

.accion-eliminar {
    background: #dc3545;
}

.accion-eliminar:hover {
    background: #bb2d3b;
}
    @media (max-width: 700px) { .matriculas-cabecera { align-items: flex-start; flex-direction: column; } .buscador-matriculas { width: 100%; margin-left: 0; } .boton-anadir { width: 100%; } }
</style>
@endpush

@section('content')
    <section class="matriculas-pagina">
        <div class="matriculas-cabecera">
            <h1>Matriculas sospechosas</h1>
            <form class="buscador-matriculas" action="{{ route('matriculas-sospechosas.index') }}" method="GET">
                <input type="search" name="q" value="{{ $busqueda }}" placeholder="Buscar por agente, placa o causa..." aria-label="Buscar por agente, placa o causa">
                @if($esDirectiva)
                    <button class="boton-anadir" type="button" id="abrir-modal-matricula">Añadir</button>
                @endif
            </form>
        </div>

        @if($errors->any())
            <div class="alerta-matricula">{{ $errors->first() }}</div>
        @endif

        @if($esDirectiva)
        <div class="modal-matricula" id="modal-matricula" role="dialog" aria-modal="true" aria-labelledby="titulo-matricula">
            <section class="modal-contenido">
                <div class="modal-cabecera">
                    <h2 id="titulo-matricula">Añadir matrícula sospechosa</h2>
                    <button class="modal-cerrar" type="button" id="cerrar-modal-matricula" aria-label="Cerrar">&times;</button>
                </div>
                <form action="{{ route('matriculas-sospechosas.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="campo-matricula">
                        <label for="causa">Causa</label>
                        <textarea id="causa" name="causa" maxlength="255" required></textarea>
                    </div>
                    <div class="campo-matricula">
                        <label>Foto matrícula</label>
                        <div class="zona-foto-matricula" tabindex="0" data-input="foto_matricula">Haz clic y pega la imagen con Ctrl+V</div>
                        <input id="foto_matricula" class="input-foto-matricula" type="file" name="foto_matricula" accept="image/*" required>
                    </div>
                    <button class="boton-guardar" type="submit">Guardar</button>
                </form>
            </section>
        </div>
        @endif

        <div class="tabla-matriculas-contenedor">

    <table class="tabla-matriculas">

        <thead>

            <tr>

                <th>
                    Agente
                </th>

                <th>
                    Placa
                </th>

                <th>
                    Causa
                </th>

                <th>
                    Fecha de registro
                </th>

                <th>
                    Acciones
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($matriculas as $matricula)

                <tr>

                    {{-- AGENTE --}}

                    <td>
                        {{ $matricula->agente_nombre ?: 'Agente no encontrado' }}
                    </td>


                    {{-- PLACA --}}

                    <td>
                        {{ $matricula->placa ?: 'Sin placa' }}
                    </td>


                    {{-- CAUSA --}}

                    <td>
                        {{ $matricula->causa }}
                    </td>


                    {{-- FECHA --}}

                    <td>
                        {{ $matricula->fecha_registro }}
                    </td>


                    {{-- ACCIONES --}}

                    <td>

                        <div class="acciones-matricula">


                            {{-- VER --}}

                            <a
                                href="{{ route('matriculas-sospechosas.show', $matricula->id) }}"
                                class="accion-icono accion-ver"
                                title="Ver matrícula"
                                aria-label="Ver matrícula"
                            >
                                👁️
                            </a>


                            @if($esDirectiva)

                                {{-- EDITAR --}}

                                <a
                                    href="{{ route('matriculas-sospechosas.edit', $matricula->id) }}"
                                    class="accion-icono accion-editar"
                                    title="Editar matrícula"
                                    aria-label="Editar matrícula"
                                >
                                    ✏️
                                </a>


                                {{-- ELIMINAR --}}

                                <form
                                    action="{{ route('matriculas-sospechosas.destroy', $matricula->id) }}"
                                    method="POST"
                                    onsubmit="return confirm('¿Eliminar este registro?');"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="accion-icono accion-eliminar"
                                        title="Eliminar matrícula"
                                        aria-label="Eliminar matrícula"
                                    >
                                        ➖
                                    </button>

                                </form>

                            @endif

                        </div>

                    </td>

                </tr>


            @empty

                <tr>

                    <td colspan="5">

                        No hay matrículas sospechosas registradas.

                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>

</div>
    </section>
@endsection

@push('scripts')
@if($esDirectiva)
<script>
    const buscadorMatriculas = document.querySelector('.buscador-matriculas input[name="q"]');
    let temporizadorMatriculas;
    const modalMatricula = document.getElementById('modal-matricula');
    const abrirModalMatricula = document.getElementById('abrir-modal-matricula');
    const cerrarModalMatricula = document.getElementById('cerrar-modal-matricula');
    let zonaMatriculaSeleccionada = null;

    buscadorMatriculas.addEventListener('input', function () {
        clearTimeout(temporizadorMatriculas);
        temporizadorMatriculas = setTimeout(function () {
            buscadorMatriculas.form.submit();
        }, 300);
    });

    abrirModalMatricula.addEventListener('click', function () {
        modalMatricula.classList.add('abierto');
    });

    cerrarModalMatricula.addEventListener('click', function () {
        modalMatricula.classList.remove('abierto');
    });

    modalMatricula.addEventListener('click', function (event) {
        if (event.target === modalMatricula) {
            modalMatricula.classList.remove('abierto');
        }
    });

    document.querySelector('.zona-foto-matricula').addEventListener('click', function (event) {
        zonaMatriculaSeleccionada = event.currentTarget;
        zonaMatriculaSeleccionada.classList.add('activa');
    });

    document.addEventListener('paste', function (event) {
        if (!zonaMatriculaSeleccionada) return;
        const imagen = Array.from(event.clipboardData.files).find(function (archivo) {
            return archivo.type.startsWith('image/');
        });
        if (!imagen) return;
        const input = document.getElementById(zonaMatriculaSeleccionada.dataset.input);
        const transferencia = new DataTransfer();
        transferencia.items.add(imagen);
        input.files = transferencia.files;
        zonaMatriculaSeleccionada.innerHTML = '';
        const preview = document.createElement('img');
        preview.src = URL.createObjectURL(imagen);
        preview.alt = 'Vista previa de matrícula';
        zonaMatriculaSeleccionada.appendChild(preview);
        event.preventDefault();
    });
</script>
@endif
@endpush
