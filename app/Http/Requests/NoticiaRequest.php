<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoticiaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'titulo' => 'required',
            'subtitulo' => 'nullable',
            'descripcion' => 'nullable',
            'portada' => 'nullable',
            // 'portada' => 'nullable',
            'user_id' => 'required',
            'categorias' => 'required',
            'estado_noticia_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required' => 'El título es requerido',
            'titulo.unique' => 'El título ya existe',
            'portada.image' => 'La portada debe ser una imagen',
            'portada.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'portada.max' => 'La portada debe ser menor a 1MB',
            'categorias.required' => 'La categoría es requerida',
            'user_id.required' => 'El usuario es requerido',
            'estado_noticia_id.required' => 'El estado es requerido',
        ];
    }
}
