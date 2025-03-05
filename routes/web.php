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
Route::get('/categoria/{categorianombre}', [RecipeController::class, 'obtenerCategoria']);

// Ruta para el inventario No borrar Jared
Route::get('/ingredientes', [InventaryController::class, 'index'])->name('ingredientes.index');
Route::get('/ingredientes/show', [InventaryController::class, 'showInventary'])->name('ingredientes.showInventary');
Route::get('/ingredientes/popUp/{id}', [InventaryController::class, 'popUp'])->name('ingredientes.popUp');
Route::put('/ingredientes/update/{id}', [InventaryController::class, 'update'])->name('ingredientes.update');
Route::delete('/ingredientes/delete/{id}', [InventaryController::class, 'destroy'])->name('ingredientes.destroy');
