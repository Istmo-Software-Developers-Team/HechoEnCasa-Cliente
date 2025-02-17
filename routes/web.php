<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InventaryController;

use App\Http\Controllers\HomeController;
//Ruta para el index

Route::get('/', [HomeController::class, 'index']);


// Ruta para el inventario No borrar Jared
Route::get('/ingredientes', [InventaryController::class, 'index'])->name('ingredientes.index');
Route::patch('/ingredientes/{id_ing}/update-stock', [InventaryController::class, 'updateStock'])->name('ingredientes.updateStock');
Route::delete('/ingredientes/{id_ing}', [InventaryController::class, 'destroy'])->name('ingredientes.destroy');
Route::get('/ingredientes/{inventary}', [InventaryController::class, 'getIngrediente'])->name('ingredientes.get');
Route::post('/ingredientes', [InventaryController::class, 'store'])->name('ingredientes.store');

