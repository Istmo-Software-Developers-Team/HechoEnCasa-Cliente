<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnidadIngrediente extends Model
{
    use HasFactory;

    protected $table = 'unidad_ingrediente';
    protected $primaryKey = 'id_unidad';

    protected $fillable = ['nombre_unidad', 'abreviacion'];

    public $timestamps = false;

    public function ingredientes()
    {
        return $this->hasMany(Inventary::class, 'uni_total', 'id_unidad');
    }
}
