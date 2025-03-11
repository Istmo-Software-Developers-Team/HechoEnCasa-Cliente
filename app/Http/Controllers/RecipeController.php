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
    
    function newRecipe(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'num_porciones' => 'required|integer|min:1'
        ]);

        DB::table('receta_base')->insert([
            'nombre' => $request->input('nombre'),
            'num_porciones' => $request->input('num_porciones'),
        ]);

        return response()->json(['message' => 'Receta agregada con éxito']);
    }

    function deleteRecipe(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string'
        ]);

        $deleted = DB::table('receta_base')
            ->where('nombre', $validated['nombre'])
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Receta eliminada con éxito']);
        } else {
            return response()->json(['message' => 'No se encontró ninguna receta con ese nombre'], 404);
        }
    }

    function Ingredientes(){
        $ingredientes = DB::table('ingrediente')->get();
        return response()->json($ingredientes);
    }

    function Unidad(){
        $unidad = DB::table('unidad_ingrediente')->get();
        return response()->json($unidad);
    }

    public function newIng(Request $request)
    {
        $request->validate([
            'id_receta' => 'required|integer',
            'id_ing' => 'required|integer',
            'gramaje' => 'required|string|max:255',
            'cantidad_usada' => 'required|numeric',
        ]);

        // Inserción en la base de datos
        DB::table('receta_detalle')->insert([
            'id_receta' => $request->input('id_receta'),
            'id_ing' => $request->input('id_ing'),
            'gramaje' => $request->input('gramaje'),
            'cantidad_usada' => $request->input('cantidad_usada'),
        ]);

        return response()->json(['message' => 'Receta agregada con éxito']);
    }

    function deleteIng(Request $request)
    {
        $request->validate([
            'cantidad_usada' => 'required|numeric',
            'gramaje' => 'required|string',
        ]);

        $deleted = DB::table('receta_detalle')
            ->where('cantidad_usada', $request->input('cantidad_usada'))
            ->where('gramaje', $request->input('gramaje'))
            ->delete();

        if ($deleted) {
            return response()->json(['message' => 'Receta eliminada con éxito']);
        } else {
            return response()->json(['message' => 'No se encontró ninguna receta con esos parámetros'], 404);
        }
    }



}
