@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Notas y Recordatorios</h1>

    {{-- FORMULARIO PARA CREAR NUEVA NOTA --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">Crear Nueva Nota</div>
        <div class="card-body">
            <form action="{{ route('notas.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    {{-- Usuario --}}
                    <div class="col-md-4">
                        <label class="form-label">Seleccionar Usuario</label>
                        <select name="user_id" class="form-select" required>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Título --}}
                    <div class="col-md-8">
                        <label class="form-label">Título</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Escribe el título..." required>
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="mb-3">
                    <label class="form-label">Contenido</label>
                    <textarea name="contenido" rows="3" class="form-control" placeholder="Contenido..." required></textarea>
                </div>

                {{-- Fecha de vencimiento --}}
                <div class="col-md-4 mb-3">
                    <label class="form-label">Fecha Vencimiento</label>
                    <input type="datetime-local" name="fecha_vencimiento" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Guardar Nota</button>
            </form>
        </div>
    </div>

    {{-- MENSAJES --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- LISTADO DE NOTAS AGRUPADAS POR USUARIO --}}
    @foreach($notas->groupBy('user.name') as $userName => $userNotas)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <span><strong>Usuario:</strong> {{ $userName }}</span>
                <span class="badge bg-info text-dark">{{ $userNotas->count() }} Notas</span>
            </div>

            <div class="card-body">
                @foreach($userNotas as $nota)
                    <div class="border rounded p-3 mb-3">

                        {{-- Información Nota --}}
                        <div class="d-flex justify-content-between">
                            <div>
                                <h5 class="fw-bold">{{ $nota->titulo }}</h5>
                                <p>{{ $nota->contenido }}</p>
                            </div>

                            <div class="text-end">
                                @if($nota->recordatorio)
                                    <small class="text-muted d-block">
                                        <strong>Due:</strong> {{ $nota->recordatorio->fecha_vencimiento }}
                                    </small>
                                @endif
                            </div>
                        </div>

                        {{-- BOTÓN ACTIVIDADES (link al CRUD) --}}
                        @if($nota->recordatorio)
                            <a href="{{ route('actividades.index', ['recordatorio_id' => $nota->recordatorio->id]) }}"
                            class="btn btn-outline-primary btn-sm mt-2">
                                Actividades ({{ $nota->recordatorio->actividades()->count() }})
                            </a>
                        @endif

                        {{-- BOTÓN ELIMINAR NOTA --}}
                        <form action="{{ route('notas.destroy', $nota->id) }}" method="POST" class="mt-2">
                            @csrf @method('DELETE')
                            <button class="btn btn-danger btn-sm">Eliminar nota</button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
@endsection
