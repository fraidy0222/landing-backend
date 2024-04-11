<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class DirectivoResource extends JsonResource
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
            'nombre' => $this->nombre,
            'prioridad' => $this->prioridad,
            'cargo' => $this->cargo,
            'imagen' => asset('storage/' . $this->imagen),
            'biografia' => $this->biografia
        ];
    }
}
