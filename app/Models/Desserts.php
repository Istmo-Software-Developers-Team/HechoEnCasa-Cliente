<?php
    
    namespace App\Models;

    use App\Models\Category;
    use App\Models\UnidadMedida;
    use App\Models\AtributosExtra;
    use App\Http\Controllers\RecipeController;
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
        protected $fillable = [
            'id_tipo_postre', 'id_categoria', 'imagen', 'nombre', 'descripcion', 
            'stock', 'disponible', 'precio_emergentes', 'id_receta', 'id_um'
        ]; 

        /**
         * Relación con la categoría
         */
        public function categoria()
        {
            return $this->belongsTo(Category::class, 'id_categoria', 'id_cat');
        }

        /**
         * Relación con la unidad de medida
         */
        public function unidadesMedida()
        {
            return $this->belongsToMany(UnidadMedida::class, 'postrefijo', 'id_postre_elegido', 'id_um');
        }
        

        /**
         * Relación con los atributos extra
         * Se filtra por la categoría del postre
         */
        public function recetas()
        {
            return $this->belongsToMany(RecetaBase::class, 'multi_receta', 'id_postre', 'id_receta');
        }

        public function atributosExtra()
        {
            return $this->hasMany(AtributosExtra::class, 'id_tipo_postre', 'id_categoria');
        }

        
    }
