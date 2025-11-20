@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Nueva Actividad</h2>

    <form action="{{ route('actividades.store') }}" method="POST">
        @csrf
        <input type="hidden" name="recordatorio_id" value="{{ $recordatorio_id }}">

        <label>Descripción</label>
        <input type="text" class="form-control" name="descripcion" required>

        <label>Estado</label>
        <select name="estado" class="form-control">
            <option>pendiente</option>
            <option>en progreso</option>
            <option>completada</option>
        </select>

        <label>Nota</label>
        <textarea name="nota" class="form-control"></textarea>

        <button class="btn btn-success mt-2">Guardar</button>
    </form>
</div>
@endsection
