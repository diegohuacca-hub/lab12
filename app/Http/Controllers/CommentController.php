<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Guarda un nuevo comentario en la base de datos.
     */
    public function store(Request $request, $postId)
    {
        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        Comment::create([
            'content' => $request->content,
            'user_id' => Auth::id(),
            'post_id' => $postId,
        ]);

        return redirect()->route('posts.show', $postId)
                         ->with('success', 'Comentario agregado correctamente.');
    }

    /**
     * Muestra el formulario para editar un comentario existente.
     */
    public function edit(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        return view('comments.edit', compact('comment'));
    }

    /**
     * Actualiza el comentario en la base de datos.
     */
    public function update(Request $request, Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $request->validate([
            'content' => 'required|string|max:500',
        ]);

        $comment->update([
            'content' => $request->content,
        ]);

        return redirect()->route('posts.show', $comment->post_id)
                         ->with('success', 'Comentario actualizado correctamente.');
    }

    /**
     * Elimina un comentario existente.
     */
    public function destroy(Comment $comment)
    {
        if ($comment->user_id !== Auth::id()) {
            abort(403, 'No autorizado');
        }

        $postId = $comment->post_id;
        $comment->delete();

        return redirect()->route('posts.show', $postId)
                         ->with('success', 'Comentario eliminado correctamente.');
    }
}
