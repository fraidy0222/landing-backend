<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmpresaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // $redes = [
        //     'facebook' => $this->facebook,
        //     'twitter' => $this->twitter,
        //     'youtube' => $this->youtube,
        //     'linkedin' => $this->linkedin,
        // ];

        // $redesObjetos = array_map(function ($nombre, $url) {
        //     return [
        //         'name' => ucfirst($nombre),
        //         'url' => $url,
        //     ];
        // }, array_keys($redes), $redes);

        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'alias' => $this->alias,
            'logo' =>  asset('storage/' . $this->logo),
            'telefono' => $this->telefono,
            'direccion' => $this->direccion,
            'correo' => $this->correo,
            'director' => $this->director,
            'slogan' => $this->slogan,
            'video_institucional' => $this->video_institucional ? asset('storage/' . $this->video_institucional) : '',
            'resumen' => $this->resumen,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'youtube' => $this->youtube,
            'linkedin' => $this->linkedin,
            // 'redes' => $redesObjetos,
        ];
    }
}
