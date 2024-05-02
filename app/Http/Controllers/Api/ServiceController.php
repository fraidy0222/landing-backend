<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Http\Resources\ServiceResource;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'servicios' => ServiceResource::collection(Service::all())
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre' => 'required|max:150',
            'resumen' => 'nullable',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2024',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'imagen.image' => 'La imagen debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'imagen.max' => 'La imagen debe ser menor a 2MB',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            if ($imagen != null) {
                $imagen = $imagen->store('servicios', 'public');
            } else {
                $imagen = '';
            }
        } else {
            $imagen = '';
        }

        $service = Service::create([
            'nombre' => $request->nombre,
            'resumen' => $request->resumen,
            'imagen' => $imagen,
        ]);

        $service->save();

        return response()->json(['message' => 'Servicio creado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $service = Service::find($id);

        return response()->json(['servicios' => $service], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $service = Service::find($id);

        $rules = [
            'nombre' => 'required|max:150',
            'resumen' => 'nullable',
            'imagen' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2024',
        ];

        $messages = [
            'nombre.required' => 'El nombre es requerido',
            'imagen.image' => 'La imagen debe ser una imagen',
            'imagen.mimes' => 'La imagen debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'imagen.max' => 'La imagen debe ser menor a 2MB',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen');
            Storage::delete('public/' . $service->imagen);
            if ($imagen != null) {
                $imagen = $imagen->store('servicios', 'public');
            } else {
                $imagen = $service->imagen;
            }
        } else {
            $imagen = $service->imagen;
        }

        $service->nombre = $request->nombre;
        $service->resumen = $request->resumen;
        $service->imagen = $imagen;

        $service->save();

        return response()->json(['message' => 'Servicio editado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $service = Service::find($id);

        Storage::delete('public/' . $service->imagen);
        $service->delete();

        return response()->json(['message' => 'Servicio eliminado correctamente'], 200);
    }
}
