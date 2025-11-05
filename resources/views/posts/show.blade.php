@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>{{ $post->title }}</h1>
        <p>{{ $post->content }}</p>
        <p><small>Por: {{ $post->user->name }}</small></p>

        <a href="{{ route('posts.index') }}" class="btn btn-secondary">Volver</a>

        <hr>

        <h3>Comentarios</h3>

        @foreach($post->comments as $comment)
            <div class="border p-2 mb-2 rounded">
                <strong>{{ $comment->user->name }}</strong>:
                <p>{{ $comment->content }}</p>
                <small>{{ $comment->created_at->diffForHumans() }}</small>

                @if($comment->user_id === Auth::id())
                    <div class="mt-2">
                        <a href="{{ route('comments.edit', $comment) }}" class="btn btn-sm btn-warning">Editar</a>

                        <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </div>
                @endif
            </div>
        @endforeach

        <hr>

        <form action="{{ route('comments.store', $post->id) }}" method="POST">
            @csrf
            <div class="form-group">
                <textarea name="content" class="form-control" rows="3" placeholder="Escribe un comentario..." required></textarea>
            </div>
            <button type="submit" class="btn btn-primary mt-2">Comentar</button>
        </form>
    </div>
@endsection
