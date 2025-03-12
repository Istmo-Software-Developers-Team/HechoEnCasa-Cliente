<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecetaBase extends Model
{
    use HasFactory;

    protected $table = 'receta_base'; // Asegúrate de que el nombre de la tabla sea correcto
    protected $primaryKey = 'id_receta';
    public $timestamps = false;

    protected $fillable = ['nombre', 'num_porciones']; // Ajusta los campos según tu BD
}
