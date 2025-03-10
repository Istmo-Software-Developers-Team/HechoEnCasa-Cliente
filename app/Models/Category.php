<?php

namespace App\Models;

use App\Models\Desserts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'categoria'; 

    // Clave primaria de la tabla
    protected $primaryKey = 'id_cat';

    // Desactivar timestamps si la tabla no tiene created_at y updated_at
    public $timestamps = false;

    // Campos que pueden ser llenados en masa
    protected $fillable = ['id_cat', 'nombre']; 
}
