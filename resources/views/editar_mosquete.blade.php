@extends('layout.app')
@section('title', 'Editar mosquete local')
@section('content')
<section class="gestion-panel">
    <h1>Editar mosquete local</h1>
    <form action="{{ route('mosquetes-locales.update', $mosquete->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <p><label>Empresa/compañía</label><input name="empresa" value="{{ old('empresa', $mosquete->empresa) }}" required></p>
        <p><label>Número de serie</label><input name="num_serie_mosquete" value="{{ old('num_serie_mosquete', $mosquete->num_serie_mosquete) }}" required></p>
        <p><label>Foto DNI</label><input type="file" name="foto_dni" accept="image/*"></p>
        <p><label>Foto licencia de armas</label><input type="file" name="foto_licencia_armas" accept="image/*"></p>
        <button type="submit">Guardar cambios</button>
    </form>
</section>
@endsection
