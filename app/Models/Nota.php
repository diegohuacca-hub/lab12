<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Nota extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['user_id', 'titulo', 'contenido'];

    // Alcance global: solo mostrar notas activas
    protected static function booted()
    {
        static::addGlobalScope('activa', function (Builder $builder) {
            $builder->whereHas('recordatorio', function ($query) {
                $query->where('fecha_vencimiento', '>=', now())
                      ->where('completado', false);
            });
        });
    }

    public function getTituloFormateadoAttribute()
    {
        return $this->recordatorio->completado ? "[Completado] {$this->titulo}" : $this->titulo;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function recordatorio()
    {
        return $this->hasOne(Recordatorio::class);
    }
}