<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InventaryController;
use App\Http\Controllers\EmergentController;
use App\Http\Controllers\RecipeController;
use App\Http\Controllers\CalendaryController;
use App\Http\Controllers\AlertController;

// Ruta para la página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// Ruta para el calendario
Route::get('/calendario', [CalendaryController::class, 'index'])->name('calendario.index');

// Ruta para las recetas
Route::get('/recetas', [RecipeController::class, 'index'])->name('recetas.index');

// Rutas para el inventario
Route::prefix('ingredientes')->name('ingredientes.')->group(function () {
    Route::get('/', [InventaryController::class, 'index'])->name('index');
    Route::patch('/{id_ing}/update-stock', [InventaryController::class, 'updateStock'])->name('updateStock');
    Route::delete('/{id_ing}', [InventaryController::class, 'destroy'])->name('destroy');
    Route::get('/{inventary}', [InventaryController::class, 'getIngrediente'])->name('get');
    Route::post('/', [InventaryController::class, 'store'])->name('store');
});

// Ruta para emergentes
Route::get('/emergentes', [EmergentController::class, 'index'])->name('emergentes.index');

// Ruta para alertas
Route::get('/alerts', [AlertController::class, 'index'])->name('alerts.index');
