@extends('layout.app')

@section('title', 'Ficha de agente')

@push('styles')
<style>
    .ficha-agente { max-width: 650px; margin: 0 auto; padding: 28px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); }
    .ficha-agente h1 { margin-top: 0; }
    .ficha-dato { padding: 14px 0; border-bottom: 1px solid #e5e5e5; }
    .ficha-dato strong { display: block; margin-bottom: 5px; color: #666; font-size: 13px; }
    .ficha-volver { display: inline-block; margin-top: 24px; padding: 10px 16px; border-radius: 6px; background: #555; color: white; text-decoration: none; }
</style>
@endpush

@section('content')
    @include('partials.chat_fichaje', ['ficha' => $ficha, 'mensajes' => $mensajes ?? collect()])
@endsection
