<?php

namespace App\Http\Controllers;

use App\Models\Nota;
use App\Models\Recordatorio;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotaController extends Controller
{
    /**
     * LISTAR NOTAS
     */
    public function index()
    {
        // Cargar notas con usuario y recordatorio
        $notas = Nota::with(['recordatorio', 'user'])->get();

        return view('posts.nota', compact('notas'));
    }

    /**
     * FORMULARIO PARA CREAR
     */
    public function create()
    {
        $usuarios = User::all();
        return view('posts.nota_form', compact('usuarios'));
    }

    /**
     * GUARDAR NOTA NUEVA
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'fecha_vencimiento' => 'required|date',
        ]);

        // Registrar Nota
        $nota = Nota::create([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
            'user_id' => $request->user_id,
        ]);

        // Registrar Recordatorio asociado
        Recordatorio::create([
            'nota_id' => $nota->id,
            'fecha_vencimiento' => $request->fecha_vencimiento,
            'completado' => false,
        ]);

        return redirect()->route('notas.index')
            ->with('success', 'Nota creada correctamente.');
    }

    /**
     * EDITAR NOTA (Opcional si luego lo pides)
     */
    public function edit($id)
    {
        $nota = Nota::with('recordatorio')->findOrFail($id);
        $usuarios = User::all();

        return view('posts.nota_edit', compact('nota', 'usuarios'));
    }

    /**
     * ACTUALIZAR
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'contenido' => 'required|string',
            'fecha_vencimiento' => 'required|date',
        ]);

        $nota = Nota::findOrFail($id);

        $nota->update([
            'titulo' => $request->titulo,
            'contenido' => $request->contenido,
        ]);

        if ($nota->recordatorio) {
            $nota->recordatorio->update([
                'fecha_vencimiento' => $request->fecha_vencimiento,
            ]);
        }

        return redirect()->route('notas.index')
            ->with('success', 'Nota actualizada correctamente.');
    }

    /**
     * ELIMINAR NOTA + RECORDATORIO + ACTIVIDADES
     */
    public function destroy($id)
    {
        $nota = Nota::with('recordatorio')->findOrFail($id);

        if ($nota->recordatorio) {

            // ❗Eliminar actividades relacionadas
            DB::table('actividades')
                ->where('recordatorio_id', $nota->recordatorio->id)
                ->delete();

            // ❗Eliminar recordatorio
            $nota->recordatorio->delete();
        }

        // Eliminar nota
        $nota->delete();

        return redirect()->route('notas.index')
            ->with('success', 'Nota eliminada con su recordatorio y actividades.');
    }
}
