<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UsersResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['users' => UsersResource::collection(User::all())], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        User::create($request->validated());

        return response()->json(['message' => 'Usuario creado correctamente'], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['user' => new UsersResource(User::find($id))], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {

        if (is_null($request->password)) {
            // $user->password = Hash::make($request->password);
            $user->update($request->validated());
            $user->save();
            return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
        } else
            $rules = [
                'password' => Password::min(6)->numbers()->symbols(),
            ];

        $messages = [
            'password.numbers' => 'La contraseña debe contener al menos un número',
            'password.symbols' => 'La contraseña debe contener al menos un símbolo',
            'password.min' => 'La contraseña debe tener al menos 6 caracteres',
        ];


        $this->validate($request, $rules, $messages);

        $user->password = Hash::make($request->password);

        $user->update($request->validated());

        return response()->json(['message' => 'Usuario actualizado correctamente'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['message' => 'Usuario eliminado correctamente']);
    }

    public function verifyUser(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users,username'
        ];

        $messages = [
            'username.required' => 'El nombre de usuario es requerido',
            'username.unique' => 'El nombre de usuario ya existe'
        ];

        $request->validate($rules, $messages);

        return response()->json(['message' => 'El nombre de usuario es válido']);
    }

    public function verifyEmail(Request $request)
    {
        $rules = [
            'email' => 'required|unique:users,email'
        ];

        $messages = [
            'email.required' => 'El correo es requerido',
            'email.unique' => 'El correo ya existe'
        ];

        $request->validate($rules, $messages);

        return response()->json(['message' => 'El correo es válido']);
    }

    public function verifyUserById(Request $request, User $user)
    {
        if ($request->username !== $user->username) {

            $rules = [
                'username' => 'required|unique:users,username'
            ];

            $messages = [
                'username.required' => 'El nombre de usuario es requerido',
                'username.unique' => 'El nombre de usuario ya existe'
            ];

            $request->validate($rules, $messages);
        }

        return response()->json(['message' => 'El nombre de usuario es válido']);
    }

    public function verifyEmailById(Request $request, User $user)
    {

        if ($request->email !== $user->email) {

            $rules = [
                'email' => 'required|unique:users,email'
            ];

            $messages = [
                'email.required' => 'El correo es requerido',
                'email.unique' => 'El correo ya existe'
            ];

            $request->validate($rules, $messages);
        }

        return response()->json(['message' => 'El correo es válido']);
    }
}
