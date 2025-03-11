<?php

namespace App\Http\Controllers;

use App\Models\Inventary;

class NotificationController extends Controller
{

    function countNotifications()
    {
        $ingredientesCount = Inventary::select('nombre', 'stock', 'cantidad_min')
            ->where('stock', 0)
            ->orWhereColumn('stock', '<', 'cantidad_min')
            ->count();

        return response()->json(['conteo' => $ingredientesCount]);
    }

    function ShowNotifications()
    {
        $ingredientes = Inventary::select('ingrediente.nombre', 'ingrediente.stock', 'ingrediente.cantidad_min', 'unidad_ingrediente.nombre_unidad')
            ->join('unidad_ingrediente', 'ingrediente.uni_total', '=', 'unidad_ingrediente.id_unidad') // Hacemos el JOIN
            ->where('ingrediente.stock', 0)
            ->orWhereColumn('ingrediente.stock', '<', 'ingrediente.cantidad_min')
            ->orderBy('ingrediente.stock', 'asc')
            ->get();

        return response()->json($ingredientes);
    }
}
