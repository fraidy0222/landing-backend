<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriaEnlaceRequest;
use App\Http\Resources\CategoriaEnlaceResource;
use App\Models\CategoriaEnlace;
use App\Models\Link;

class CategoriaEnlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['categorias' => CategoriaEnlaceResource::collection(CategoriaEnlace::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoriaEnlaceRequest $request)
    {
        CategoriaEnlace::create($request->validated());

        return response()->json(['message' => 'Categoría creada correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $categoria = CategoriaEnlace::find($id);

        return response()->json(['categoria' => $categoria], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreCategoriaEnlaceRequest $request, string $id)
    {
        $categoria = CategoriaEnlace::find($id);

        $categoria->update($request->validated());

        return response()->json(['message' => 'Categoría editada correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $categoria = CategoriaEnlace::find($id);

        if (Link::where('categoria_enlace_id', $id)->exists()) {
            return response()->json(['error' => 'No se puede eliminar este recurso porque está relacionado con otros datos.'], 400);
        }

        $categoria->delete();

        return response()->json(['message' => 'Categoría eliminada correctamente'], 200);
    }
}
