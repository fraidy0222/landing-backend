<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Noticia;
use App\Http\Resources\NoticiaResource;
use Illuminate\Support\Facades\Storage;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $search = request()->input('searchNoticia');

        $noticias = Noticia::query()->when($search, function ($query, $search) {
            $query->where('titulo', 'LIKE', "%{$search}%")
                ->orWhere('user.name', 'LIKE', "%$search%");
        })->with('user', 'categorias', 'estado', 'comment')->paginate(10);

        return response()->json(
            [
                'noticias' => NoticiaResource::collection($noticias),
            ],
            200
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'titulo' => 'required|unique:noticias|max:150',
            'subtitulo' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'portada' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:1024',
            'user_id' => 'required|integer',
            'categoria_noticia_id' => 'required',
            'estado_id' => 'required|integer',
        ];

        $messages = [
            'titulo.required' => 'El título es requerido',
            'titulo.unique' => 'El título ya existe',
            'portada.image' => 'La portada debe ser una imagen',
            'portada.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'portada.max' => 'La portada debe ser menor a 1MB',
            'categoria_noticia_id.required' => 'La categoría es requerida',
            'user_id.required' => 'El usuario es requerido',
            'estado_id.required' => 'El estado es requerido',
        ];

        $this->validate($request, $rules, $messages);

        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            if ($portada != null) {
                $portada = $portada->store('portadas', 'public');
            } else {
                $portada = '';
            }
        } else {
            $portada = '';
        }

        $noticia = Noticia::create([
            'titulo' => $request->titulo,
            'subtitulo' => $request->subtitulo,
            'descripcion' => $request->descripcion,
            'portada' => $portada,
            'user_id' => $request->user_id,
            'estado_id' => $request->estado_id,
        ]);

        $noticia->categorias()->attach(explode(',', $request->categoria_noticia_id));

        $noticia->save();

        return response()->json(['message' => 'Noticia creada correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $noticia = Noticia::with('categorias')->find($id);

        // $categoriaId = $noticia->with('categorias')->pluck('id');     
        $estadoId = $noticia->with('estado')->get();

        return response()->json([
            // 'categoriasId' => $categoriaId, 
            'estadoId' => $estadoId,
            'noticias' => $noticia,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $noticia = Noticia::with('categorias')->find($id);

        $rules = [
            'titulo' => 'required|unique:noticias,titulo,' . $noticia->id . 'max:150',
            'subtitulo' => 'nullable|string',
            'descripcion' => 'nullable|string',
            'portada' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:1048',
            'user_id' => 'required|integer',
            'categorias' => 'required',
            'estado_id' => 'required|integer',
        ];

        $messages = [
            'titulo.required' => 'El título es requerido',
            'titulo.unique' => 'El título ya existe',
            'portada.image' => 'La portada debe ser una imagen',
            'portada.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'portada.max' => 'La portada debe ser menor a 1MB',
            'categorias.required' => 'La categoría es requerida',
            'user_id.required' => 'El usuario es requerido',
            'estado_id.required' => 'El estado es requerido',
        ];


        $this->validate($request, $rules, $messages);

        if ($request->hasFile('portada')) {
            $portada = $request->file('portada');
            Storage::delete('public/' . $noticia->portada);
            if ($portada != null) {
                $portada = $portada->store('portadas', 'public');
            } else {
                $portada = $noticia->portada;
            }
        } else {
            $portada = $noticia->portada;
        }

        $noticia->titulo = $request->titulo;
        $noticia->subtitulo = $request->subtitulo;
        $noticia->descripcion = $request->descripcion;
        $noticia->portada = $portada;
        $noticia->user_id = $request->user_id;
        $noticia->estado_id = $request->estado_id;

        $noticia->categorias()->sync(explode(',', $request->categorias));

        $noticia->save();

        return response()->json(['message' => 'Noticia creada correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        Storage::delete('public/' . $noticia->portada);
        $noticia->delete();

        return response()->json(['message' => 'Noticia eliminada correctamente'], 200);
    }
}
