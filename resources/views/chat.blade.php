@extends('layout.app')

@section('title', 'Chat')

@push('styles')
<style>
    .chat-pagina { display: grid; grid-template-columns: 260px minmax(0, 1fr); gap: 20px; }
    .chat-contactos, .chat-conversacion { min-height: 520px; padding: 20px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .chat-contactos h1, .chat-conversacion h1 { margin-top: 0; font-size: 22px; }
    .chat-contacto { display: block; padding: 12px; border-radius: 6px; color: #333; text-decoration: none; }
    .chat-contacto:hover, .chat-contacto.activo { background: #eaf6ef; color: #198754; }
    .chat-contacto strong, .chat-contacto small { display: block; }
    .chat-contacto small { margin-top: 4px; color: #777; }
    .chat-mensajes { display: flex; flex-direction: column; gap: 10px; height: 390px; margin-bottom: 16px; padding: 16px; overflow-y: auto; background: #f5f5f5; border-radius: 6px; }
    .chat-mensaje { max-width: 75%; padding: 10px 13px; border-radius: 8px; background: #ddd; }
    .chat-mensaje-propio { align-self: flex-end; background: #198754; color: white; }
    .chat-mensaje p { margin: 0 0 5px; white-space: pre-wrap; overflow-wrap: anywhere; }
    .chat-mensaje small { opacity: 0.75; }
    .chat-formulario { display: flex; gap: 10px; }
    .chat-formulario textarea { flex: 1; min-height: 46px; resize: vertical; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
    .chat-formulario button { padding: 10px 18px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; }
    .chat-vacio { color: #666; }
    @media (max-width: 700px) { .chat-pagina { grid-template-columns: 1fr; } .chat-contactos { min-height: auto; } .chat-mensajes { height: 330px; } }
</style>
@endpush

@section('content')
    <div class="chat-pagina">
        <aside class="chat-contactos">
            <h1>Contactos</h1>
            @forelse($destinatarios as $contacto)
                <a class="chat-contacto {{ $destinatario && $destinatario->id === $contacto->id ? 'activo' : '' }}" href="{{ route('fichaje.chat.show', $contacto->id) }}">
                    <strong>{{ $contacto->nombre }}</strong>
                    <small>{{ $contacto->rango }} · {{ $contacto->escala }}</small>
                </a>
            @empty
                <p class="chat-vacio">No hay contactos disponibles.</p>
            @endforelse
        </aside>

        <section class="chat-conversacion">
            @if($destinatario)
                <h1>{{ $destinatario->nombre }}</h1>
                <div class="chat-mensajes">
                    @forelse($mensajes as $mensaje)
                        <div class="chat-mensaje {{ $mensaje->emisor_id === session('usuario_id') ? 'chat-mensaje-propio' : '' }}">
                            <p>{{ $mensaje->mensaje }}</p>
                            <small>{{ $mensaje->created_at }}</small>
                        </div>
                    @empty
                        <p class="chat-vacio">Todavía no hay mensajes. Inicia la conversación.</p>
                    @endforelse
                </div>
                <form class="chat-formulario" action="{{ route('fichaje.chat.store', $destinatario->id) }}" method="POST">
                    @csrf
                    <textarea name="mensaje" maxlength="2000" placeholder="Escribe un mensaje..." required></textarea>
                    <button type="submit">Enviar</button>
                </form>
            @else
                <h1>Chat</h1>
                <p class="chat-vacio">Selecciona un contacto para comenzar.</p>
            @endif
        </section>
    </div>
@endsection
