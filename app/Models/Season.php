<?php

namespace App\Models;

use App\Models\category;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desserts extends Model
{
    use HasFactory;

    // Nombre de la tabla en la base de datos
    protected $table = 'catalogo'; 

    // Clave primaria de la tabla
    protected $primaryKey = 'id_postre';

    // Desactivar timestamps si la tabla no tiene created_at y updated_at
    public $timestamps = false;

    // Campos que pueden ser llenados en masa
    protected $fillable = ['id_tipo_postre', 'id_categoria', 'imagen', 'nombre', 'descripcion', 'stock', 'disponible', 'precio_emergentes', 'id_receta']; 

    /**
     * Relación con la categoría
     */
    public function categoria()
    {
        return $this->belongsTo(Category::class, 'id_categoria', 'id_cat');
    }
    
}
