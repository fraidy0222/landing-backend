<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CommentResurece;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['comentarios' => CommentResurece::collection(Comment::all())]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'nombre_comentario' => 'nullable',
            'correo_comentario' => 'nullable',
            'user_comentario' => 'nullable',
            'comentario' => 'required',
            'user_id' => 'required|integer',
            'noticia_id' => 'required',
            'estado_id' => 'required|integer',
        ];

        $messages = [
            'comentario.required' => 'El comentario es requerido',
            'user_id.required' => 'El usuario es requerido',
            'noticia_id.required' => 'La noticia es requerida',
            'estado_id.required' => 'El estado es requerido',
        ];

        $this->validate($request, $rules, $messages);

        $comment = Comment::create([
            'nombre_comentario' => $request->nombre_comentario,
            'correo_comentario' => $request->correo_comentario,
            'user_comentario' => $request->user_comentario,
            'comentario' => $request->comentario,
            'user_id' => $request->user_id,
            'noticia_id' => $request->noticia_id,
            'estado_id' => $request->estado_id,
        ]);

        $comment->save();

        return response()->json(['message' => 'Comentario creado correctamente']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $comment = Comment::with('noticia', 'estado')->find($id);

        return response()->json(['comentario' => $comment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $comment = Comment::with('noticia', 'estado')->find($id);

        $rules = [
            'nombre_comentario' => 'nullable',
            'correo_comentario' => 'nullable',
            'user_comentario' => 'nullable',
            'comentario' => 'required',
            'user_id' => 'required|integer',
            'noticia_id' => 'required',
            'estado_id' => 'required|integer',
        ];

        $messages = [
            'comentario.required' => 'El comentario es requerido',
            'user_id.required' => 'El usuario es requerido',
            'noticia_id.required' => 'La noticia es requerida',
            'estado_id.required' => 'El estado es requerido',
        ];

        $this->validate($request, $rules, $messages);

        $comment->update([
            'nombre_comentario' => $request->nombre_comentario,
            'correo_comentario' => $request->correo_comentario,
            'user_comentario' => $request->user_comentario,
            'comentario' => $request->comentario,
            'user_id' => $request->user_id,
            'noticia_id' => $request->noticia_id,
            'estado_id' => $request->estado_id,
        ]);

        $comment->save();

        return response()->json(['message' => 'Comentario actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $comment = Comment::find($id);
        $comment->delete();
        return response()->json(['message' => 'Comentario eliminado correctamente']);
    }
}
