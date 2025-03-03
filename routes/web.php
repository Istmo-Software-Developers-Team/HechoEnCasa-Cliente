<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventaryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\HomeController;
use App\Models\Inventary;

//Ruta para el index
Route::get('/', [HomeController::class, 'index']);

//Rutas de recetas
Route::get('recetas', [RecipeController::class, 'index'])->name('recipe.index');
Route::get('/recetas/lista', [RecipeController::class, 'showrecipe']);
Route::get('/ingredientes/{nombre}', [RecipeController::class, 'obtenerIngredientes']);
Route::get('/categoria/{categorianombre}', [RecipeController::class, 'obtenerCategoria']);

// Ruta para el inventario No borrar Jared
// Define la ruta que apunta al método showInventary del InventaryController
Route::get('/ingredientes', [InventaryController::class, 'index'])->name('ingredientes.index');  
Route::get('/ingredientes', [InventaryController::class, 'showInventary'])->name('ingredientes.showInventary');
