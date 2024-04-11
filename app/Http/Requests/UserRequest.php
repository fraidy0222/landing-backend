<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
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
            'name' => 'required|max:80',
            'last_name' => 'required|max:150',
            'username' => 'required|max:80|unique:users,username',
            'password' => ['required', Password::min(6)->symbols()->numbers()],
            'email' => 'required|unique:users,email',
            'role' => 'required',
            'is_active' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.max' => 'El nombre no puede tener más de 80 caracteres',
            'last_name.required' => 'El apellido es requerido',
            'last_name.max' => 'El apellido no puede tener más de 150 caracteres',
            'username.required' => 'El nombre de usuario es requerido',
            'username.unique' => 'El nombre de usuario ya está en uso',
            'username.max' => 'El nombre de usuario no puede tener más de 80 caracteres',
            'password.required' => 'La contraseña es requerida',
            'password.numbers' => 'La contraseña debe contener al menos un número',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
            'email.required' => 'El correo electrónico es requerido',
            'email.unique' => 'El correo electrónico ya está en uso',
            'role.required' => 'El rol es requerido',
            'is_active.requires' => 'La condición activo es requerida'
        ];
    }
}
