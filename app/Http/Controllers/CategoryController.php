<?php

namespace App\Http\Controllers;
use App\Models\category;
use App\Models\Desserts;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $postres = Desserts::with('categoria')->get();
        $categorias = Category::all();
        return view('Desserts.category', compact('postres', 'categorias'));
    }
    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Desserts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $datosPostres = request()->except('_token');
        Desserts::insert($datosPostres);
        return response()->json($datosPostres);
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
    