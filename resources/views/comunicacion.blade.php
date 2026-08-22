@extends('layout.app')

@section('title', $titulo)

@push('styles')
<style>
    .comunicacion { max-width: 900px; margin: 0 auto; }
    .comunicacion h1 { margin: 0 0 20px; }
    .comunicacion-panel { padding: 22px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .mensajes-canal { display: flex; flex-direction: column; gap: 10px; height: 500px; margin-bottom: 16px; padding: 16px; overflow-y: auto; background: #f5f5f5; border-radius: 6px; }
    .mensaje-canal { max-width: 75%; padding: 10px 13px; border-radius: 8px; background: #ddd; }
    .mensaje-canal-propio { align-self: flex-end; background: #198754; color: white; }
    .mensaje-canal p { margin: 0 0 5px; white-space: pre-wrap; overflow-wrap: anywhere; }
    .mensaje-canal small { opacity: 0.75; }
    .formulario-canal { display: flex; gap: 10px; }
    .formulario-canal textarea { flex: 1; min-height: 46px; resize: vertical; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
    .formulario-canal button { padding: 10px 18px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; }
    .canal-vacio { color: #666; }
</style>
@endpush

@section('content')
    <section class="comunicacion">
        <h1>{{ $titulo }}</h1>
        <div class="comunicacion-panel">
            <div class="mensajes-canal">
                @forelse($mensajes as $mensaje)
                    <div class="mensaje-canal {{ $mensaje->emisor_id === $usuarioId ? 'mensaje-canal-propio' : '' }}">
                        <p><strong>{{ $mensaje->emisor_nombre }}</strong></p>
                        <p>{{ $mensaje->mensaje }}</p>
                        <small>{{ $mensaje->created_at }}</small>
                    </div>
                @empty
                    <p class="canal-vacio">Todavía no hay mensajes.</p>
                @endforelse
            </div>
            <form class="formulario-canal" action="{{ route('comunicaciones.store', $canal) }}" method="POST">
                @csrf
                <textarea name="mensaje" maxlength="2000" placeholder="Escribe un mensaje..." required></textarea>
                <button type="submit">Enviar</button>
            </form>
        </div>
    </section>
@endsection
