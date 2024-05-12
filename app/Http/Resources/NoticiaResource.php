<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NoticiaResource extends JsonResource
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
            'titulo' => $this->titulo,
            'portada' => $this->portada ? asset('storage/' . $this->portada) : '',
            'subtitulo' => $this->subtitulo,
            'descripcion' => $this->descripcion,
            'user_id' => $this->user->id,

            'usuario' => [
                'name' => $this->user->name,
                'email' => $this->user->email,
            ],
            'categorias' => $this->categorias,
            'estado' => [
                'nombre' => $this->estado->nombre,
            ],
            'fecha_creacion' => $this->created_at->format('Y-m-d - h:m'),
            'fecha_modificacion' => $this->updated_at->format('Y-m-d - h:m')
        ];
    }
}
