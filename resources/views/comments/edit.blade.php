@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Comentario</h1>
    <form action="{{ route('comments.update', $comment->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="content" class="form-label">Contenido</label>
            <textarea name="content" id="content" class="form-control" rows="4" required>{{ $comment->content }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('posts.show', $comment->post_id) }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
