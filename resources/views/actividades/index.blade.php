@extends('layouts.app')

@section('content')
<div class="container">

    {{-- 🏷️ Título y botón volver alineados --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="m-0">Actividades</h2>

        <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
            ⬅ Volver
        </a>
    </div>

    @if($recordatorioId)
        <a href="{{ route('actividades.create', $recordatorioId) }}" class="btn btn-primary mb-3">
            + Crear Actividad
        </a>
    @else
        <div class="alert alert-warning">
            ⚠ No se ha seleccionado una nota. Regresa y elige una.
        </div>
        <a href="{{ route('notas.index') }}" class="btn btn-secondary">⬅ Volver a Notas</a>
    @endif


    @if(session('success'))
        <div class="alert alert-success mt-2">{{ session('success') }}</div>
    @endif

    @foreach($actividades as $actividad)
        <div class="border p-3 mb-2">
            <strong>{{ $actividad->descripcion }}</strong>
            <span class="badge bg-secondary">{{ $actividad->estado }}</span>
            <p>{{ $actividad->nota }}</p>

            <a href="{{ route('actividades.edit', $actividad->id) }}" class="btn btn-warning btn-sm">Editar</a>

            <form action="{{ route('actividades.destroy', $actividad->id) }}" method="POST" class="d-inline">
                @csrf @method('DELETE')
                <button class="btn btn-danger btn-sm">Eliminar</button>
            </form>
        </div>
    @endforeach
</div>
@endsection
