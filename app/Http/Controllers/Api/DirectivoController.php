<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Directivo;
use App\Http\Resources\DirectivoResource;
use Illuminate\Support\Facades\Storage;

class DirectivoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'directivos' => DirectivoResource::collection(Directivo::all())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:150',
            'prioridad' => 'integer',
            'cargo' => 'nullable|string',
            'biografia' => 'nullable|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:1024',
        ];

        $messages = [
            'nombre.required' => 'El título es requerido',
            'imagen.image' => 'La portada debe ser una imagen',
            'imagen.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'imagen.max' => 'La portada debe ser menor a 1MB',
        ];

        $this->validate($request, $rules, $messages);
 
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            if ($imagen != null) {
                $imagen = $imagen->store('directivos', 'public');
            } else {
                $imagen = '';
            }
        } else {
            $imagen = '';
        }

        $directivo = Directivo::create([
            'nombre' => $request->nombre,
            'prioridad' => $request->prioridad,
            'cargo' => $request->cargo,
            'biografia' => $request->biografia,
            'imagen' => $imagen
        ]);

        $directivo->save();
        
        return response()->json(['message' => 'Directivo creado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $directivo = Directivo::find($id);

        return response()->json(['directivo' => $directivo], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $directivo = Directivo::find($id);

        $rules = [
            'nombre' => 'required|max:150',
            'prioridad' => 'integer',
            'cargo' => 'nullable|string',
            'biografia' => 'nullable|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:1024',
        ];

        $messages = [
            'nombre.required' => 'El título es requerido',
            'imagen.image' => 'La portada debe ser una imagen',
            'imagen.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'imagen.max' => 'La portada debe ser menor a 1MB',
        ];

        $this->validate($request, $rules, $messages);
 
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            Storage::delete('public/' . $directivo->imagen);
            if ($imagen != null) {
                $imagen = $imagen->store('directivos', 'public');
            } else {
                $imagen = $directivo->imagen;
            }
        } else {
            $imagen = $directivo->imagen;
        }

        $directivo->nombre = $request->nombre;
        $directivo->prioridad = $request->prioridad ;
        $directivo->cargo = $request->cargo ;
        $directivo->biografia = $request->biografia ;
        $directivo->imagen = $imagen ;

        $directivo->save();

        return response()->json(['message' => 'Directivo editado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $directivo = Directivo::find($id);

        Storage::delete('public/' . $directivo->imagen);

        $directivo->delete();

        return response()->json(['message' => 'Directivo eliminado correctamente'], 200);        
    }
}
