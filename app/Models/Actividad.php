<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Actividad extends Model
{
    use HasFactory;

    // 👇 IMPORTANTE porque Laravel intenta buscar "actividads"
    protected $table = 'actividades';

    protected $fillable = [
        'recordatorio_id',
        'descripcion',
        'estado',
        'nota'
    ];

    // Relación inversa con Recordatorio
    public function recordatorio()
    {
        return $this->belongsTo(\App\Models\Recordatorio::class);
    }

    // Scope opcional para filtrar actividades pendientes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    // Mutador: formatea descripción automáticamente
    protected function descripcion(): Attribute
    {
        return Attribute::make(
            set: fn($value) => ucfirst(strtolower($value))
        );
    }
}
