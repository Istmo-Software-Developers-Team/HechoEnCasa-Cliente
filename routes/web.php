<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventaryController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DessertsController;
use App\Models\Inventary;

//Ruta para el index
Route::get('/', [HomeController::class, 'index']);

//Ruta para las notificaciones
Route::get('/notificaciones/show', [NotificationController::class, 'ShowNotifications']);
Route::get('/notificaciones/count', [NotificationController::class, 'countNotifications']);

//Rutas de recetas
Route::get('recetas', [RecipeController::class, 'index'])->name('recipe.index');
Route::get('/recetas/lista', [RecipeController::class, 'showrecipe']);
Route::get('/categoria/{categorianombre}', [RecipeController::class, 'obtenerCategoria']);
Route::get('/Ing', [RecipeController::class, 'Ingredientes']);
Route::get('/Uni', [RecipeController::class, 'Unidad']);
Route::post('/nuevo', [RecipeController::class, 'newRecipe']);
Route::post('/nuevoIng', [RecipeController::class, 'newIng']);
Route::delete('/eliminar', [RecipeController::class, 'deleteRecipe']);
Route::delete('/eliminarIng', [RecipeController::class, 'deleteIng']);

// Ruta para el inventario No borrar Jared
Route::get('/ingredientes', [InventaryController::class, 'index'])->name('ingredientes.index');
Route::get('/ingredientes/filters', [InventaryController::class, 'getFilters'])->name('ingredientes.getFilters');
Route::get('/ingredientes/filtrar', [InventaryController::class, 'filterIngredientes'])->name('ingredientes.filtrar');
Route::get('/ingredientes/show', [InventaryController::class, 'showInventary'])->name('ingredientes.showInventary');
Route::get('/ingredientes/popUp/{id}', [InventaryController::class, 'popUp'])->name('ingredientes.popUp');
Route::put('/ingredientes/update/{id}', [InventaryController::class, 'update'])->name('ingredientes.update');
Route::put('/ingredientes/updateName/{id}', [InventaryController::class, 'updateName'])->name('ingredientes.updateName');
Route::delete('/ingredientes/delete/{id}', [InventaryController::class, 'destroy'])->name('ingredientes.destroy');
Route::get('/ingredientes/unities', [InventaryController::class, 'getUnities'])->name(('ingredientes.getUnities'));
Route::post('/ingredientes/agregar', [InventaryController::class, 'store'])->name('ingredientes.store');
Route::get('/ingredientes/{id}', [InventaryController::class, 'edit'])->name('ingredientes.edit');
Route::put('/ingredientes/{id}', [InventaryController::class, 'update'])->name('ingredientes.update');
Route::post('/ingredientes/addUnity', [InventaryController::class, 'addUnity'])->name('ingredientes.addUnity');

//rutas para los postres
Route::resource('postres', 'App\Http\Controllers\DessertsController');
Route::post('/postres/update-imagen', [DessertsController::class, 'updateImagen'])->name('postres.updateImagen');
Route::resource('categorias', 'App\Http\Controllers\CategoryController');
Route::resource('emergentes', 'App\Http\Controllers\EmergentController');
Route::resource('temporada', 'App\Http\Controllers\SeasonController');
