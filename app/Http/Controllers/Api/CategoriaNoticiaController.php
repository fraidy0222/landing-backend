<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoriaNoticia;
use Illuminate\Http\Request;
use App\Http\Resources\CategoriaNoticiaResource;
use App\Http\Requests\CategoriaNoticiaRequests;
use App\Models\Noticia;

class CategoriaNoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['categoriasNoticias' => CategoriaNoticiaResource::collection(CategoriaNoticia::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoriaNoticiaRequests $request)
    {
        CategoriaNoticia::create($request->validated());

        return response()->json(['message' => 'Categoria creada correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(CategoriaNoticia $categoryNew)
    {
        return $categoryNew;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoriaNoticiaRequests $request, CategoriaNoticia $categoryNew)
    {
        $categoryNew->update($request->validated());

        return response()->json(['message' => 'Categoria actualizada correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaNoticia $categoryNew)
    {

        if ($categoryNew->noticias()->exists()) {
            return response()->json(['error' => 'No se puede eliminar este recurso porque está relacionado con otros datos.'], 400);
        }

        $categoryNew->delete();

        return response()->json(['message' => 'Categoria eliminiada correctamente']);
    }
}
