<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadMedida extends Model
{
    use HasFactory;

    protected $table = 'unidad_medida'; 
    protected $primaryKey = 'id_um';
    public $timestamps = false;

    protected $fillable = ['nombre_unidad', 'cantidad', 'requiere_minimo'];
}
    