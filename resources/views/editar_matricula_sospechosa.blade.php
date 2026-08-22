@extends('layout.app')
@section('title', 'Editar matrícula sospechosa')
@section('content')
<section class="gestion-panel">
    <h1>Editar matrícula sospechosa</h1>
    <form action="{{ route('matriculas-sospechosas.update', $matricula->id) }}" method="POST" enctype="multipart/form-data">
        @csrf @method('PUT')
        <p><label>Causa</label><textarea name="causa" required>{{ old('causa', $matricula->causa) }}</textarea></p>
        <p><label>Foto matrícula</label><input type="file" name="foto_matricula" accept="image/*"></p>
        <button type="submit">Guardar cambios</button>
    </form>
</section>
@endsection
