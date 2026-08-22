@push('styles')
<style>
    .chat-fichaje { max-width: 900px; margin: 24px auto 0; }
    .chat-conversacion { min-height: 520px; padding: 20px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .chat-conversacion h2 { margin-top: 0; font-size: 22px; }
    .chat-mensajes { display: flex; flex-direction: column; gap: 10px; height: 390px; margin-bottom: 16px; padding: 16px; overflow-y: auto; background: #f5f5f5; border-radius: 6px; }
    .chat-mensaje { max-width: 75%; padding: 10px 13px; border-radius: 8px; background: #ddd; }
    .chat-mensaje-propio { align-self: flex-end; background: #198754; color: white; }
    .chat-mensaje p { margin: 0 0 5px; white-space: pre-wrap; overflow-wrap: anywhere; }
    .chat-mensaje small { opacity: 0.75; }
    .chat-formulario { display: flex; gap: 10px; }
    .chat-formulario textarea { flex: 1; min-height: 46px; resize: vertical; padding: 10px; border: 1px solid #ccc; border-radius: 6px; font: inherit; }
    .chat-formulario button { padding: 10px 18px; border: 0; border-radius: 6px; background: #198754; color: white; cursor: pointer; }
    .chat-vacio { color: #666; }
    @media (max-width: 700px) { .chat-mensajes { height: 330px; } }
</style>
@endpush

<div class="chat-fichaje">
    <section class="chat-conversacion">
        <h2>{{ $ficha->nombre }} - {{ $ficha->placa }}</h2>
        <div class="chat-mensajes">
            @forelse(($mensajes ?? collect()) as $mensaje)
                <div class="chat-mensaje {{ $mensaje->emisor_id === session('usuario_id') ? 'chat-mensaje-propio' : '' }}">
                    <p><strong>{{ $mensaje->emisor_nombre }}</strong></p>
                    <p>{{ $mensaje->mensaje }}</p>
                    <small>{{ $mensaje->created_at }}</small>
                </div>
            @empty
                <p class="chat-vacio">Todavía no hay mensajes. Inicia la conversación.</p>
            @endforelse
        </div>
        <form class="chat-formulario" action="{{ route('fichaje.chat.store', $ficha->id) }}" method="POST">
            @csrf
            <textarea name="mensaje" maxlength="2000" placeholder="Escribe un mensaje..." required></textarea>
            <button type="submit">Enviar</button>
        </form>
    </section>
</div>
