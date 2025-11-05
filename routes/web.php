<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aquí se registran todas las rutas web de la aplicación.
| Estas rutas son cargadas por el RouteServiceProvider.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Página principal después de iniciar sesión
Route::get('/home', [HomeController::class, 'index'])->name('home');

// 🔹 Rutas para POSTS (CRUD completo)
Route::resource('posts', PostController::class);

// 🔹 Rutas para COMENTARIOS
// Crear un comentario asociado a un post específico
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

// Rutas RESTful solo para editar, actualizar y eliminar comentarios
Route::resource('comments', CommentController::class)->only(['edit', 'update', 'destroy']);
