<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Socio;
use App\Http\Resources\SocioResource;
use Illuminate\Support\Facades\Storage;

class SocioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'socios' => SocioResource::collection(Socio::all())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|unique:socios,nombre|max:150',
            'web' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:1024',
        ];

        $messages = [
            'titulo.required' => 'El título es requerido',
            'titulo.unique' => 'El título ya existe',
            'web.url' => 'Tiene que ser una dirección válida',
            'logo.image' => 'El logo debe ser una imagen',
            'logo.mimes' => 'El logo debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'logo.max' => 'El logo debe ser menor a 1MB',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            if ($logo != null) {
                $logo = $logo->store('socios', 'public');
            } else {
                $logo = '';
            }
        } else {
            $logo = '';
        }

        $noticia = Socio::create([
            'nombre' => $request->nombre,
            'web' => $request->web,
            'logo' => $logo,
        ]);

        $noticia->save();

        return response()->json(['message' => 'Socio creado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $socio = Socio::find($id);

        return response()->json(['socio' => $socio], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $socio = Socio::find($id);

        $rules = [
            'nombre' => 'required|unique:socios,nombre,' . $socio->id . '|max:150',
            'web' => 'nullable|url',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:1024',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'nombre.unique' => 'El nombre ya existe',
            'web.url' => 'Tiene que ser una dirección válida',
            'logo.image' => 'El logo debe ser una imagen',
            'logo.mimes' => 'El logo debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'logo.max' => 'El logo debe ser menor a 1MB',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->hasFile('logo')) {
            $logo = $request->file('logo');
            Storage::delete('public/' . $socio->logo);
            if ($logo != null) {
                $logo = $logo->store('socios', 'public');
            } else {
                $logo = $socio->logo;
            }
        } else {
            $logo = $socio->logo;
        }

        $socio->nombre = $request->nombre;
        $socio->web = $request->web;
        $socio->logo = $logo;

        $socio->save();

        return response()->json(['message' => 'Socio editado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Socio $socio)
    {
        Storage::delete('public/' . $socio->portada);

        $socio->delete();

        return response()->json(['message' => 'Socio eliminado correctamente'], 200);
    }
}
