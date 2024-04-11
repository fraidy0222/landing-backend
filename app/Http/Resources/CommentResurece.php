<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResurece extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre_comentario' => $this->nombre_comentario,
            'comentario' => $this->comentario,
            'correo_comentario' => $this->correo_comentario,
            'creada_por_info' => [
                'username' => $this->user->name
            ],
            'noticia_info' => [
                'titulo' => $this->noticia->titulo
            ],
            'estado_info' => [
                'nombre' => $this->estado->nombre
            ],
            'fecha_creacion' => $this->created_at->format('Y-m-d'),
            'fecha_modificacion' => $this->updated_at->format('Y-m-d')
        ];
    }
}
