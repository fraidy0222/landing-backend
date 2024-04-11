<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LinkRequest;
use App\Http\Resources\LinkResource;
use App\Models\CategoriaEnlace;
use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['enlaces' => LinkResource::collection(Link::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required',
            'enlace' => 'nullable|url',
            'categoria_enlace_id' => 'required|integer',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'enlace.url' => 'La dirección url tiene que ser válida',
            'categoria_enlace_id.required' => 'El enlace es requerido',
        ];

        $this->validate($request, $rules, $messages);

        $link = Link::create([
            'nombre' => $request->nombre,
            'enlace' => $request->enlace,
            'categoria_enlace_id' => $request->categoria_enlace_id,
        ]);

        $link->save();

        return response()->json(['message' => 'Enlace creado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $enlace = Link::find($id);

        $categoria = CategoriaEnlace::find($enlace->categoria_enlace_id);
        // $categoria = $enlace->with('categorias')->find($enlace->categoria_enlace_id);

        return response()->json([
            'enlace' => $enlace,
            'categoria' => $categoria
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(LinkRequest $request, string $id)
    {
        $enlace = Link::find($id);

        $rules = [
            'nombre' => 'required',
            'enlace' => 'nullable|url',
            'categoria_enlace_id' => 'required|integer',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'enlace.url' => 'La dirección url tiene que ser válida',
            'categoria_enlace_id.required' => 'El enlace es requerido',
        ];

        $this->validate($request, $rules, $messages);

        $enlace->nombre = $request->nombre;
        $enlace->enlace = $request->enlace;
        $enlace->categoria_enlace_id = $request->categoria_enlace_id;

        $enlace->save();

        return response()->json(['message' => 'Enlace editado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $enlace = Link::find($id);

        $enlace->delete();

        return response()->json(['message' => 'Enlace eliminado correctamente'], 200);
    }
}
