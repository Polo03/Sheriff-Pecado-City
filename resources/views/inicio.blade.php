@extends('layout.app')

@section('title', 'Menú principal')

@push('styles')
<style>
    .inicio-principal { max-width: 900px; margin: 10vh auto 0; padding: 48px; border-radius: 8px; background: white; box-shadow: 0 3px 12px rgba(0, 0, 0, 0.08); text-align: center; }
    .inicio-principal h1 { margin-top: 0; }
    .inicio-principal p { color: #666; }
</style>
@endpush

@section('content')
    <section class="inicio-principal">
        <h1>Menú principal</h1>
        <p>Bienvenido, {{ $nombre }}.</p>
    </section>
@endsection
