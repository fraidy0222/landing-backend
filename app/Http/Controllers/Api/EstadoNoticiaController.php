<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\EstadoNoticia;
use Illuminate\Http\Request;
use App\Http\Resources\EstadoNoticiaResource;
use App\Http\Requests\EstadoNoticiaRequest;
use App\Models\Noticia;

class EstadoNoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['estadoNoticias' => EstadoNoticiaResource::collection(EstadoNoticia::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EstadoNoticiaRequest $request)
    {
        EstadoNoticia::create($request->validated());

        return response()->json(['message' => 'Estado de noticia creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(EstadoNoticia $estadoNew)
    {
        return $estadoNew;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EstadoNoticiaRequest $request, EstadoNoticia $estadoNew)
    {
        $estadoNew->update($request->validated());

        return response()->json(['message' => 'Estado de noticia editado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EstadoNoticia $estadoNew)
    {
        if (Noticia::where('estado_id', $estadoNew->id)->exists()) {
            return response()->json(['error' => 'No se puede eliminar este recurso porque está relacionado con otros datos.'], 400);
        }

        $estadoNew->delete();

        return response()->json(['message' => 'Estado de noticia eliminado correctamente']);
    }
}
