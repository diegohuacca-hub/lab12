<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Recordatorio;
use App\Models\User;
use Illuminate\Http\Request;

class NotaController extends Controller
{
    /**
     * Mostrar listado de notas.
     */
    public function index()
    {
        // Cargar notas junto a su recordatorio y usuario relacionados
        $notas = Nota::with('recordatorio', 'user')->get();

        // ✅ Cambiado: apunta a la vista dentro de la carpeta "posts"
        return view('posts.nota', compact('notas'));
    }

    /**
     * Mostrar formulario para crear una nueva nota.
     */
    public function create()
    {
        $usuarios = User::all();
        // Si tienes un formulario dentro de posts, cámbialo igual:
        return view('posts.nota_form', compact('usuarios'));
    }

    /**
     * Guardar una nueva nota en la base de datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'fecha_vencimiento' => 'required|date',
        ]);

        // Crear la nota
        $nota = Nota::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'user_id' => $request->user_id,
        ]);

        // Crear el recordatorio asociado
        Recordatorio::create([
            'nota_id' => $nota->id,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'completado' => false,
        ]);

        return redirect()->route('notas.index')->with('success', 'Nota creada correctamente.');
    }
}