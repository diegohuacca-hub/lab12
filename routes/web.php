<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\NotaController;
use App\Http\Controllers\ActividadController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas web de la aplicación.
| Estas rutas son cargadas automáticamente por el RouteServiceProvider.
|
*/

// =====================================================
// 🔹 PÁGINA PRINCIPAL (PÚBLICA)
// =====================================================
Route::get('/', function () {
    return view('welcome');
});

// =====================================================
// 🔹 AUTENTICACIÓN (Login, Registro, Logout)
// =====================================================
Auth::routes();

// =====================================================
// 🔹 RUTAS PROTEGIDAS (Solo para usuarios autenticados)
// =====================================================
Route::middleware(['auth'])->group(function () {

    // =====================================================
    // 🏠 DASHBOARD PRINCIPAL
    // =====================================================
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    // =====================================================
    // 📰 SECCIÓN: BLOG (Posts y Comentarios)
    // =====================================================

    // CRUD completo de Posts
    Route::resource('posts', PostController::class);

    // Crear comentario asociado a un post específico
    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])
        ->name('comments.store');

    // Editar, actualizar y eliminar comentarios
    Route::resource('comments', CommentController::class)
        ->only(['edit', 'update', 'destroy']);

    // =====================================================
    // 🗒️ SECCIÓN: NOTAS Y RECORDATORIOS (Eloquent avanzado)
    // =====================================================

    // Listar todas las notas con sus recordatorios
    Route::get('/notas', [NotaController::class, 'index'])->name('notas.index');

    // Formulario de creación
    Route::get('/notas/crear', [NotaController::class, 'create'])->name('notas.create');

    // Guardar una nueva nota
    Route::post('/notas', [NotaController::class, 'store'])->name('notas.store');

    // Formulario de edición de nota
    Route::get('/notas/{id}/editar', [NotaController::class, 'edit'])->name('notas.edit');

    // Actualizar nota existente
    Route::put('/notas/{id}', [NotaController::class, 'update'])->name('notas.update');

    // Eliminar nota
    Route::delete('/notas/{id}', [NotaController::class, 'destroy'])->name('notas.destroy');

    Route::get('/actividades', [ActividadController::class, 'index'])->name('actividades.index');
    Route::get('/actividades/create/{recordatorio_id}', [ActividadController::class, 'create'])->name('actividades.create');
    Route::post('/actividades', [ActividadController::class, 'store'])->name('actividades.store');
    Route::get('/actividades/{id}/edit', [ActividadController::class, 'edit'])->name('actividades.edit');
    Route::put('/actividades/{id}', [ActividadController::class, 'update'])->name('actividades.update');
    Route::delete('/actividades/{id}', [ActividadController::class, 'destroy'])->name('actividades.destroy');
    Route::delete('/notas/{id}', [NotaController::class, 'destroy'])->name('notas.destroy');


});


