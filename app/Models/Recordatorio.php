<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recordatorio extends Model
{
    use HasFactory;

    protected $fillable = ['nota_id', 'fecha_vencimiento', 'completado'];

    public function nota()
    {
        return $this->belongsTo(Nota::class);
    }

    // 👇 ESTA ES LA RELACIÓN QUE FALTABA
    public function actividades()
    {
        return $this->hasMany(\App\Models\Actividad::class);
    }

    // 👇 Eliminación en cascada (opcional pero recomendado)
    protected static function booted()
    {
        static::deleting(function ($recordatorio) {
            $recordatorio->actividades()->delete();
        });
    }
}
