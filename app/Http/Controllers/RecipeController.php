<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RecipeController extends Controller
{    
    public function index()
    {
        return view('recipe.recipe');
    }

    function showrecipe(){
        $recetas = DB::table("receta_base")->select("nombre", "num_porciones")->get();
        return response()->json($recetas);
    }

    function obtenerIngredientes($nombre)
    {
        $resultados = DB::table('receta_base')
            ->join('receta_detalle', 'receta_base.id_receta', '=', 'receta_detalle.id_receta')
            ->join('ingrediente', 'receta_detalle.id_ing', '=', 'ingrediente.id_ing')
            ->where('receta_base.nombre', $nombre)
            ->select('ingrediente.nombre', 'receta_detalle.cantidad_usada', 'receta_detalle.gramaje')
            ->get();

        return response()->json($resultados);
    }

    function obtenerCategoria($categoriaNombre) {
        $recetas = DB::table('categoria')
            ->join('catalogo', 'categoria.id_cat', '=', 'catalogo.id_categoria')
            ->join('multi_receta', 'catalogo.id_postre', '=', 'multi_receta.id_postre')
            ->join('receta_base', 'multi_receta.id_receta', '=', 'receta_base.id_receta')
            ->where('categoria.nombre', $categoriaNombre)
            ->select('receta_base.*')
            ->get();
    
        return response()->json($recetas);
    }
    
    /*function createRecipe(){
        //$new = BD::table()
    }*/
}
