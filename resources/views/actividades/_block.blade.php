@if($nota->recordatorio)

    <button class="btn btn-outline-primary btn-sm mb-2"
            data-bs-toggle="collapse" 
            data-bs-target="#actividades-{{ $nota->recordatorio->id }}">
        📌 Actividades ({{ $nota->recordatorio->actividades()->count() }})
    </button>

    <div id="actividades-{{ $nota->recordatorio->id }}" class="collapse mt-3">

        @php 
            $actividades = $nota->recordatorio->actividades()->get(); 
        @endphp

        @if($actividades->count() > 0)
            @foreach($actividades as $actividad)
                <div class="border rounded p-2 mb-2 d-flex justify-content-between align-items-start">

                    <div>
                        <strong>{{ $actividad->descripcion }}</strong>

                        <span class="badge 
                            {{ $actividad->estado == 'completada' ? 'bg-success' : 
                               ($actividad->estado == 'en progreso' ? 'bg-warning text-dark' : 'bg-secondary') }}">
                            {{ $actividad->estado }}
                        </span>

                        <br>
                        <small class="text-muted">{{ $actividad->nota }}</small>
                    </div>

                    <form action="{{ route('actividades.destroy', $actividad->id) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="btn btn-danger btn-sm">🗑</button>
                    </form>
                </div>
            @endforeach
        @else
            <p class="text-muted fst-italic">No hay actividades aún.</p>
        @endif

        <form action="{{ route('actividades.store') }}" method="POST" class="border p-3 rounded mt-3">
            @csrf
            <input type="hidden" name="recordatorio_id" value="{{ $nota->recordatorio->id }}">

            <input type="text" name="descripcion" class="form-control mb-2" placeholder="Descripción" required>

            <textarea name="nota" class="form-control mb-2" placeholder="Nota (opcional)" rows="2"></textarea>

            <select name="estado" class="form-control mb-2">
                <option>pendiente</option>
                <option>en progreso</option>
                <option>completada</option>
            </select>

            <button class="btn btn-success btn-sm">➕ Agregar Actividad</button>
        </form>
    </div>

@else
    <p class="text-muted mt-2">
        ⚠ Esta nota no tiene recordatorio, por eso no se pueden crear actividades.
    </p>
@endif
