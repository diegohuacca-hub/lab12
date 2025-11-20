<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActividadController extends Controller
{
    /**
     * LISTAR ACTIVIDADES
     */
    public function index(Request $request)
    {
        $recordatorioId = $request->recordatorio_id ?? null;

        if (!$recordatorioId) {
            return view('actividades.index', [
                'actividades' => collect([]),
                'recordatorioId' => null
            ]);
        }

        $actividades = DB::table('actividades')
            ->where('recordatorio_id', $recordatorioId)
            ->orderBy('estado')
            ->orderByDesc('created_at')
            ->get();

        return view('actividades.index', compact('actividades', 'recordatorioId'));
    }

    /**
     * FORMULARIO DE CREACIÓN
     */
    public function create($recordatorio_id)
    {
        return view('actividades.create', compact('recordatorio_id'));
    }

    /**
     * GUARDAR ACTIVIDAD NUEVA
     */
    public function store(Request $request)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255',
            'estado' => 'required',
        ]);

        DB::table('actividades')->insert([
            'recordatorio_id' => $request->recordatorio_id,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'nota' => $request->nota,
            'created_at' => now(),
        ]);

        return redirect()
            ->route('actividades.index', ['recordatorio_id' => $request->recordatorio_id])
            ->with('success', 'Actividad creada 🎉');
    }

    /**
     * FORMULARIO DE EDICIÓN
     */
    public function edit($id)
    {
        $actividad = DB::table('actividades')->where('id', $id)->first();

        return view('actividades.edit', compact('actividad'));
    }

    /**
     * ACTUALIZAR ACTIVIDAD (CON DETECCIÓN DE CAMBIOS)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'descripcion' => 'required|string|max:255'
        ]);

        // Obtener datos actuales
        $actividad = DB::table('actividades')->where('id', $id)->first();

        // Detectar si NO hubo cambios
        $sinCambios =
            $actividad->descripcion === $request->descripcion &&
            $actividad->estado === $request->estado &&
            $actividad->nota === $request->nota;

        if ($sinCambios) {
            return back()->with('warning', '⚠ No hubo cambios para guardar.');
        }

        // Si hubo cambios, actualizar
        DB::table('actividades')->where('id', $id)->update([
            'descripcion' => $request->descripcion,
            'estado' => $request->estado,
            'nota' => $request->nota,
            'updated_at' => now(),
        ]);

        return back()->with('success', '✔ Actividad actualizada correctamente.');
    }

    /**
     * ELIMINAR ACTIVIDAD
     */
    public function destroy($id)
    {
        $actividad = DB::table('actividades')->where('id', $id)->first();

        DB::table('actividades')->where('id', $id)->delete();

        return redirect()
            ->route('actividades.index', ['recordatorio_id' => $actividad->recordatorio_id])
            ->with('success', 'Actividad eliminada 🗑️');
    }
}
