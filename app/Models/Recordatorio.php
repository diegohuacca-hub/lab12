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
}