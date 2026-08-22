@extends('layout.app')

@section('title', 'Anuncios')

@push('styles')
<style>
    .anuncios-pagina { max-width: 900px; margin: 0 auto; }
    .anuncios-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 20px; margin-bottom: 20px; }
    .anuncios-cabecera h1 { margin: 0; }
    .boton-publicar { padding: 11px 16px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; font: inherit; }
    .modal-anuncio { display: none; position: fixed; inset: 0; z-index: 1500; align-items: center; justify-content: center; padding: 20px; background: rgba(0, 0, 0, 0.45); }
    .modal-anuncio.abierto { display: flex; }
    .modal-contenido { width: min(520px, 100%); padding: 24px; border-radius: 8px; background: white; box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2); }
    .modal-cabecera { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .modal-cabecera h2 { margin-top: 0; }
    .modal-cerrar { border: 0; background: transparent; color: #555; font-size: 24px; cursor: pointer; }
    .modal-contenido textarea { width: 100%; min-height: 130px; resize: vertical; padding: 11px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
    .modal-contenido .boton-publicar { margin-top: 10px; }
    .anuncio { padding: 22px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .anuncios-lista { display: grid; gap: 14px; }
    .anuncio-contenido { margin: 0 0 12px; white-space: pre-wrap; overflow-wrap: anywhere; }
    .anuncio-meta { color: #666; font-size: 13px; }
    .anuncios-vacio { color: #666; }
</style>
@endpush

@section('content')
    <div class="anuncios-pagina">
        <div class="anuncios-cabecera">
            <h1>{{ $titulo }}</h1>
            @if($puedePublicar)
                <button class="boton-publicar" type="button" id="abrir-modal-anuncio">Publicar anuncio</button>
            @endif
        </div>

        @if($puedePublicar)
            <div class="modal-anuncio" id="modal-anuncio" role="dialog" aria-modal="true" aria-labelledby="titulo-anuncio">
                <section class="modal-contenido">
                    <div class="modal-cabecera">
                        <h2 id="titulo-anuncio">Publicar {{ strtolower($titulo) }}</h2>
                        <button class="modal-cerrar" type="button" id="cerrar-modal-anuncio" aria-label="Cerrar">&times;</button>
                    </div>
                <form action="{{ route($rutaPublicar . '.store') }}" method="POST">
                    @csrf
                    <textarea name="contenido" maxlength="2000" placeholder="Escribe un anuncio..." required></textarea>
                    <button class="boton-publicar" type="submit">Publicar</button>
                </form>
                </section>
            </div>
        @endif

        <div class="anuncios-lista">
            @forelse($anuncios as $anuncio)
                <article class="anuncio">
                    <p class="anuncio-contenido">{{ $anuncio->contenido }}</p>
                    <div class="anuncio-meta">{{ $anuncio->autor }} · {{ $anuncio->created_at }}</div>
                </article>
            @empty
                <p class="anuncios-vacio">No hay anuncios publicados.</p>
            @endforelse
        </div>
    </div>
@endsection

@if($puedePublicar)
    @push('scripts')
    <script>
        const modalAnuncio = document.getElementById('modal-anuncio');
        const abrirModalAnuncio = document.getElementById('abrir-modal-anuncio');
        const cerrarModalAnuncio = document.getElementById('cerrar-modal-anuncio');

        abrirModalAnuncio.addEventListener('click', function () {
            modalAnuncio.classList.add('abierto');
        });

        cerrarModalAnuncio.addEventListener('click', function () {
            modalAnuncio.classList.remove('abierto');
        });

        modalAnuncio.addEventListener('click', function (event) {
            if (event.target === modalAnuncio) {
                modalAnuncio.classList.remove('abierto');
            }
        });
    </script>
    @endpush
@endif
