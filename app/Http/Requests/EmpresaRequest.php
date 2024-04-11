<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmpresaRequest extends FormRequest
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
            'nombre' => 'required',
            'alias' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2024',
            'telefono' => 'nullable',
            'direccion' => 'nullable',
            'correo' => 'required|email',
            'director' => 'nullable',
            'slogan' => 'nullable',
            'video_institucional' => 'nullable',
            // 'video_institucional' => 'nullable|mimetypes:video/avi,video/mpeg,video/mp4,video/mkv|max:2048',
            'resumen' => 'nullable',
            'facebook' => 'nullable',
            'youtube' => 'nullable',
            'twitter' => 'nullable',
            'linkend' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'logo.image' => 'La portada debe ser una imagen',
            'logo.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'logo.max' => 'La portada debe ser menor a 2MB',
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El correo no es válido',
        ];
    }
}
