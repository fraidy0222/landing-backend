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
            'nombre' => 'required|max:200',
            'alias' => 'nullable|max:50',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:4024',
            'telefono' => 'nullable|min:10|max:20',
            'direccion' => 'nullable:200',
            'correo' => 'required|email|max:150',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es requerido',
            'nombre.max' => 'El nombre no puede tener más de 200 caracteres',
            'alias.max' => 'El alias no puede tener más de 50 caracteres',
            'logo.image' => 'La portada debe ser una imagen',
            'logo.mimes' => 'La portada debe ser una imagen con el formáto jpeg,jpg,png,gif,svg',
            'logo.max' => 'La portada debe ser menor a 4MB',
            'telefono.min' => 'El teléfono tiene que tener 10 dígitos como mínimo',
            'telefono.max' => 'El teléfono no puede tener más de 20 dígitos',
            'correo.required' => 'El correo es requerido',
            'correo.email' => 'El correo no es válido',
            'correo.max' => 'El correo no puede tener más de 150 caracteres',
        ];
    }
}
