<?php

namespace App\Http\Controllers;

use App\Models\Desserts;
use App\Models\category;
use App\Models\RecetaBase;
use App\Models\AtributosExtra;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;

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
            'id_receta' => 'required|array|min:1', //Se espera un array de recetas
            'id_receta.*' => 'integer|exists:receta_base,id_receta', // Validar que cada receta exista
        ]);

        //guardar la imagen

        $imagenUrl = null; // Variable para almacenar la URL de ImgBB
        
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
        
            // Crear cliente HTTP para enviar la imagen a ImgBB
            $client = new Client();
            $response = $client->post('https://api.imgbb.com/1/upload', [
                'query' => [
                    'key' => 'b311b4d0732acfb2ea9dcf7f46313eca' // 🔹 Reemplaza con tu API Key
                ],
                'multipart' => [
                    [
                        'name'     => 'image',
                        'contents' => fopen($imagen->getRealPath(), 'r'), // Enviar como archivo, NO en base64
                        'filename' => $imagen->getClientOriginalName()
                    ]
                ]
            ]);
        
            // Decodificar la respuesta JSON
            $data = json_decode($response->getBody(), true);
            
            // Obtener la URL de la imagen
            if (isset($data['data']['url'])) {
                $imagenUrl = $data['data']['url']; // URL pública de ImgBB
            }
        }
        
        // Guardar el postre en la base de datos con la URL de ImgBB
        $idRecetaBase = $request->id_receta[0]; // Seleccionar la primera receta
        $postre = Desserts::create([
            'imagen' => $imagenUrl, // Guardamos la URL de ImgBB en la base de datos
            'nombre' => $request->nombre,
            'id_categoria' => $request->id_categoria,
            'descripcion' => $request->descripcion,
            'stock' => $request->stock,
            'precio_emergentes' => $request->precio_emergentes,
            'id_receta' => $idRecetaBase, // Se guarda solo la primera receta
        ]);
    
        // Si el usuario seleccionó recetas, insertarlas en multi_receta
        if (count($request->id_receta) > 1) {
            $otrasRecetas = array_slice($request->id_receta, 1); //excluimos la receta base
            foreach ($otrasRecetas as $id_receta) {
                DB::table('multi_receta')->insert([
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
     * Update the img resource in storage.
     */
    public function updateImagen(Request $request)
    {
        $request->validate([
            'id_postre' => 'required|exists:catalogo,id_postre',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048'
        ]);
    
        $postre = Desserts::find($request->id_postre);
    
        if ($postre) {
            // Guardar la nueva imagen
            $rutaImagen = $request->file('imagen')->store('public/postres');
            $postre->imagen = str_replace('public/', 'storage/', $rutaImagen);
            $postre->save();
    
            return redirect()->back()->with('success', 'Imagen actualizada correctamente.');
        }
    
        return redirect()->back()->with('error', 'No se pudo actualizar la imagen.');
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
