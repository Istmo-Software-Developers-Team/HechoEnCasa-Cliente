<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventaryController;

use App\Http\Controllers\HomeController;
//Ruta para el index
Route::get('/', [HomeController::class, 'index']);


// Ruta para el inventario No borrar Jared
Route::prefix('ingredientes')->group(function () {
    Route::get('/', [InventaryController::class, 'index'])->name('ingredientes.index');
    Route::post('/', [InventaryController::class, 'store'])->name('ingredientes.store');
    Route::patch('/{id_ing}/update-stock', [InventaryController::class, 'updateStock'])->name('ingredientes.updateStock');
    Route::delete('/{id_ing}', [InventaryController::class, 'destroy'])->name('ingredientes.destroy');
    Route::get('/{inventary}', [InventaryController::class, 'getIngrediente'])->name('ingredientes.get');
});