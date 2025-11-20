@extends('layouts.app')

@section('content')
<div class="container mt-4">

    {{-- Título + botón volver --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="fw-bold">Editar Actividad</h3>

        <a href="{{ route('actividades.index', ['recordatorio_id' => $actividad->recordatorio_id]) }}" 
           class="btn btn-outline-secondary">
            ⬅ Volver
        </a>
    </div>

    {{-- FORMULARIO --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="{{ route('actividades.update', $actividad->id) }}" method="POST">
                @csrf @method('PUT')

                <div class="mb-3">
                    <label class="form-label fw-semibold">Descripción</label>
                    <input type="text" name="descripcion" class="form-control form-control-lg"
                        value="{{ $actividad->descripcion }}" required>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Estado</label>
                    <select name="estado" class="form-select">
                        <option {{ $actividad->estado=='pendiente' ? 'selected' : '' }}>pendiente</option>
                        <option {{ $actividad->estado=='en progreso' ? 'selected' : '' }}>en progreso</option>
                        <option {{ $actividad->estado=='completada' ? 'selected' : '' }}>completada</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label fw-semibold">Nota (opcional)</label>
                    <textarea name="nota" class="form-control" rows="3">{{ $actividad->nota }}</textarea>
                </div>

                {{-- ✔ BOTÓN DERECHA --}}
                <div class="d-flex justify-content-end mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        Guardar Cambios
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show mt-3" role="alert">
            {{ session('warning') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

</div>

{{-- Auto cerrar alertas después de 3 segundos --}}
<script>
    setTimeout(() => {
        let alert = document.querySelector('.alert');
        if(alert) alert.style.opacity = '0';
        setTimeout(() => alert?.remove(), 500);
    }, 3000);
</script>

@endsection
