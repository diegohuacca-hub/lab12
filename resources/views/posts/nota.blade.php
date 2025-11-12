@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Notes y Recordatorios</h1>

    {{-- 🧾 FORMULARIO PARA CREAR NUEVA NOTA --}}
    <div class="card mb-4 shadow-sm">
        <div class="card-header fw-bold bg-light">Formulario para Crear Nota</div>
        <div class="card-body">
            <form action="{{ route('notas.store') }}" method="POST">
                @csrf

                <div class="row mb-3">
                    {{-- Usuario --}}
                    <div class="col-md-4">
                        <label for="user_id" class="form-label">Seleccionar Usuario</label>
                        <select name="user_id" id="user_id" class="form-select" required>
                            @foreach(\App\Models\User::all() as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Título --}}
                    <div class="col-md-8">
                        <label for="titulo" class="form-label">Título Nota</label>
                        <input type="text" name="titulo" id="titulo" class="form-control" placeholder="Escribe el título de la nota" required>
                    </div>
                </div>

                {{-- Contenido --}}
                <div class="mb-3">
                    <label for="contenido" class="form-label">Contenido</label>
                    <textarea name="contenido" id="contenido" rows="3" class="form-control" placeholder="Escribe aquí el contenido de la nota..." required></textarea>
                </div>

                {{-- Fecha --}}
                <div class="col-md-4 mb-3">
                    <label for="fecha_vencimiento" class="form-label">Fecha Vencimiento</label>
                    <input type="datetime-local" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Añadir Nota</button>
            </form>
        </div>
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- 📋 LISTADO DE NOTAS POR USUARIO --}}
    @foreach($notas->groupBy('user.name') as $userName => $userNotas)
        <div class="card mb-4 shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center bg-light">
                <span><strong>Usuario:</strong> {{ $userName ?? 'Sin usuario' }}</span>
                <span class="badge bg-info text-dark">{{ $userNotas->count() }} Active Notes</span>
            </div>

            <div class="card-body">
                @foreach($userNotas as $nota)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h5 class="fw-semibold mb-1">{{ $nota->titulo }}</h5>
                                <p class="mb-2">{{ $nota->contenido }}</p>
                            </div>

                            <div class="text-end">
                                @if($nota->recordatorio)
                                    @php
                                        $vencida = \Carbon\Carbon::parse($nota->recordatorio->fecha_vencimiento)->isPast();
                                    @endphp
                                    <small class="text-muted d-block">
                                        <strong>Due:</strong> {{ \Carbon\Carbon::parse($nota->recordatorio->fecha_vencimiento)->format('Y-m-d H:i') }}
                                    </small>
                                    @if($vencida && !$nota->recordatorio->completado)
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif(!$nota->recordatorio->completado)
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @else
                                        <span class="badge bg-success">Completed</span>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</div>
@endsection
