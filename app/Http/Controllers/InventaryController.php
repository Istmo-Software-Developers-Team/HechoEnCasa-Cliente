<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inventary; // Modelo Inventary
use Illuminate\Support\Facades\DB;

class InventaryController extends Controller
{

    // Método para mostrar la vista principal 
    public function index()
    {
        return view('Inventary.inventary');
    }

    //Mostrar ingredientes
    function showInventary()
    {
        $recetas = DB::table('ingrediente as p')
            ->join('unidad_ingrediente as a', 'a.id_unidad', '=', 'p.uni_total')
            ->select('p.nombre', 'a.nombre_unidad', 'p.stock', 'p.cantidad_min', 'p.id_ing')
            ->get();
        return response()->json($recetas);
    }


    public function popUp(int $id)  // Aceptamos el ID como parámetro
    {
        // Buscar el ingrediente por su ID
        $ingrediente = Inventary::select('nombre', 'stock', 'cantidad_total', 'cantidad_min')
            ->where('id_ing', $id) // Filtramos por el ID proporcionado
            ->first();

        // Si no se encuentra el ingrediente, devolvemos un error 404 detallado
        if (!$ingrediente) {
            return response()->json([
                'error' => true,
                'message' => 'Ingrediente no encontrado',
                'code' => 404,
                'details' => [
                    'requested_id' => $id,
                    'available_ids' => Inventary::pluck('id_ing')->toArray(),  // Opcional, lista de los IDs disponibles
                ]
            ], 404);
        }

        // Si el ingrediente se encuentra, lo devolvemos como respuesta JSON
        return response()->json([
            'error' => false,
            'message' => 'Ingrediente encontrado',
            'data' => $ingrediente
        ]);
    }

    public function update(Request $request, $id)
    {
        try {
            $ingrediente = Inventary::findOrFail($id);
            $cantidad = intval($request->cantidad);

            if (!in_array($request->operacion, ['add', 'remove'])) {
                return response()->json(['error' => 'Operación inválida'], 400);
            }

            if ($request->operacion === "add") {
                $ingrediente->stock += $cantidad;
            } elseif ($request->operacion === "remove") {
                $ingrediente->stock = max(0, $ingrediente->stock - $cantidad);
            }

            $ingrediente->save();

            return response()->json([
                'success' => true,
                'stock' => $ingrediente->stock
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Error interno del servidor',
                'message' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile()
            ], 500);
        }
        $ingrediente = Inventary::find($id_ing);

        if ($ingrediente) {
            $ingrediente->nombre = $request->nombre;
            $ingrediente->save();
            return response()->json(["mensaje" => "Ingrediente actualizado"]);
        }

        return response()->json(["error" => "Ingrediente no encontrado"], 404);
    }

    public function destroy($id)
    {
        try {
            $ingrediente = Inventary::find($id);

            if (!$ingrediente) {
                return response()->json(["error" => "Ingrediente no encontrado"], 404);
            }

            DB::table('receta_detalle')->where('id_ing', $id)->delete();

            $ingrediente->delete();

            return response()->json(["mensaje" => "Ingrediente eliminado correctamente"], 200);
        } catch (\Exception $e) {
            return response()->json(["error" => "Error al eliminar ingrediente", "detalle" => $e->getMessage()], 500);
        }
    }



    //Obtener opcion de filtro
    public function filtro(Request $request)
    {
        // Obtener el filtro seleccionado
        $filter = $request->get('filter');

        // Construir la consulta base
        $query = Inventary::with('unidad');

        // Aplicar filtros según el valor seleccionado
        if ($filter === 'agotados') {
            $query->where('stock', 0); // Stock igual a 0
        } elseif ($filter === 'casi_agotados') {
            $query->where('stock', 5); // Stock igual a 5
        } elseif ($filter === 'gramos') {
            $query->whereHas('unidad', function ($q) {
                $q->where('id_unidad', 2); // uni_total igual a 2 (gramos)
            });
        } elseif ($filter === 'mililitros') {
            $query->whereHas('unidad', function ($q) {
                $q->where('id_unidad', 4); // uni_total igual a 4 (mililitros)
            });
        } elseif ($filter === 'piezas') {
            $query->whereHas('unidad', function ($q) {
                $q->where('id_unidad', 5); // uni_total igual a 5 (piezas)
            });
        }
        // Obtener los resultados
        $ingredientes = $query->get();
    }


    // Método para agregar un nuevo ingrediente
    public function store(Request $request)
    {
        // Validar los datos básicos
        $request->validate([
            'nombre' => 'required|string|max:255',
            'id_unidad' => 'required|integer|exists:unidad_ingrediente,id_unidad',
            'stock' => 'required|integer|min:0',
        ]);

        // Comprobar si ya existe un ingrediente con el mismo nombre (insensible a mayúsculas/minúsculas)
        $existingIngredient = Inventary::whereRaw('LOWER(nombre) = ?', [strtolower($request->nombre)])->first();

        if ($existingIngredient) {
            return redirect()->back()->withErrors(['nombre' => 'Ya existe un ingrediente con este nombre.'])->withInput();
        }

        // Crear el nuevo ingrediente si no existe duplicado
        Inventary::create([
            'nombre' => $request->input('nombre'),
            'id_unidad' => $request->input('id_unidad'),
            'uni_total' => $request->input('id_unidad'),
            'stock' => $request->input('stock'),
        ]);

        return redirect()->back()->with('success', 'Ingrediente añadido correctamente.');
    }

    public function updateName(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $ingrediente = Inventary::findOrFail($id);
        $ingrediente->nombre = $request->nombre;
        $ingrediente->save();

        return response()->json([
            'success' => true,
            'newName' => $ingrediente->nombre
        ]);
    }


    // Método para actualizar el stock de un ingrediente existente
    public function updateStock(Request $request, $id_ing)
    {
        $request->validate([
            'cantidad' => 'required|integer',
        ]);

        $ingrediente = Inventary::findOrFail($id_ing);

        $nuevoStock = $ingrediente->stock + $request->cantidad;

        if ($nuevoStock < 0) {
            return response()->json(['success' => false, 'error' => 'El stock no puede ser menor a 0.'], 400);
        }

        if ($nuevoStock > $ingrediente->cantidad_total) {
            return response()->json(['success' => false, 'error' => 'El stock no puede exceder el máximo permitido.'], 400);
        }

        $ingrediente->stock = $nuevoStock;
        $ingrediente->save();

        return response()->json([
            'success' => true,
            'newStock' => $ingrediente->stock,
            'maxStock' => $ingrediente->cantidad_total
        ]);
    }

    // Método para obtener un ingrediente de forma dinámica (opcional, para AJAX)
    public function getIngrediente(Inventary $inventary)
    {
        return response()->json($inventary);
    }
}
