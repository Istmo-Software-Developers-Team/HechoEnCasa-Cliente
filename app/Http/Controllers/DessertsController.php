<?php

namespace App\Http\Controllers;

use App\Models\Desserts;
use App\Models\category;
use App\Models\RecetaBase;
use App\Models\AtributosExtra;
use Illuminate\Http\Request;

class DessertsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postres = Desserts::with(['categoria', 'unidadesMedida' => function ($query) {
            $query->select('unidad_medida.id_um', 'unidad_medida.nombre_unidad', 'unidad_medida.cantidad')->distinct();
        }, 'atributosExtra'])->get();
    
        $categorias = Category::all();
        $recetas = RecetaBase::all(); // Aquí agregamos la consulta de recetas
        $atributosExtras = AtributosExtra::all(); // Si necesitas atributos extra
    
        return view('Desserts.index', compact('postres', 'categorias', 'recetas', 'atributosExtras'));
    }
    
    
    
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'nombre' => 'required|string|max:255',
            'id_categoria' => 'required|integer|exists:categoria,id_cat',
            'descripcion' => 'nullable|string|max:500',
            'stock' => 'required|integer|min:0',
            'precio_emergentes' => 'required|numeric|min:0',
            'id_receta' => 'nullable|array', // ✅ Se espera un array de recetas
            'id_receta.*' => 'integer|exists:receta_base,id_receta', // ✅ Validar que cada receta exista
        ]);
    
        $imagenPath = null;
        if ($request->hasFile('imagen')) {
            $imagenPath = $request->file('imagen')->store('postres', 'public');
        }
    
        // ✅ Insertar el postre en la tabla catalogo
        $postre = Desserts::create([
            'imagen' => $imagenPath,
            'nombre' => $request->nombre,
            'id_categoria' => $request->id_categoria,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio_emergentes' => $request->precio_emergentes
        ]);
    
        // ✅ Si el usuario seleccionó recetas, insertarlas en multi_receta
        if ($request->has('id_receta')) {
            foreach ($request->id_receta as $id_receta) {
                \DB::table('multi_receta')->insert([
                    'id_receta' => $id_receta,
                    'id_postre' => $postre->id_postre
                ]);
            }
        }
    
        return redirect()->route('postres.index')->with('success', 'Postre agregado correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Desserts $desserts)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desserts $desserts)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Desserts $desserts)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desserts $desserts)
    {
        //
    }
}
