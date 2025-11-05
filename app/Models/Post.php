<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // Campos que se pueden asignar masivamente
    protected $fillable = ['title', 'content', 'user_id'];

    // Relación: cada post pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
    return $this->hasMany(Comment::class);
    }
}
