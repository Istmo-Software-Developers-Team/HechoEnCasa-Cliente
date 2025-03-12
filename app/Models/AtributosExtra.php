<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtributosExtra extends Model
{
    use HasFactory;

    protected $table = 'atributos_extra';
    protected $primaryKey = 'id_atributo';
    public $timestamps = false;

    protected $fillable = ['id_tipo_postre', 'nom_atributo', 'precio_a', 'id_tipo_atributo'];

    /**
     * Relación con la categoría de postres
     * (Un atributo extra pertenece a una categoría específica de postres)
     */
    public function categoria()
    {
        return $this->belongsTo(Category::class, 'id_tipo_postre', 'id_cat');
    }

    /**
     * Relación con los postres a través de la categoría
     */
    public function postres()
    {
        return $this->hasMany(Desserts::class, 'id_categoria', 'id_tipo_postre');
    }
}
