<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unity extends Model
{
    use HasFactory;

    // Nombre de la tabla
    protected $table = 'unidad_ingrediente';
    protected $primaryKey = 'id_unidad';

    // Deshabilitar timestamps
    public $timestamps = false;

    // Relación con ingredientes
    public function ingredientes()
    {
        return $this->hasMany(Inventary::class, 'id_unidad', 'id_unidad');
    }
}