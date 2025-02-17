<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function search(Request $request)
    {
    $query = $request->input('query');

    // Ejemplo básico con datos estáticos:
    $recipes = ['Pastel de Chocolate', 'Tarta de Limón'];
    $filteredRecipes = array_filter($recipes, fn($recipe) => stripos($recipe, $query) !== false);

    return response()->json([
        'query' => $query,
        'results' => $filteredRecipes,
    ]);
    }
}