<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],

            'email' => ['required', 'email', 'unique:users,email'],

            'cpf' => ['required', 'unique:users,cpf'],

            'link_type' => [
                'required',
                'in:interno,externo'
            ],

            'access_level' => [
                'required',
                'in:aluno,docente,visitante'
            ],

            'password' => [
                'required',
                'confirmed',
                'min:6'
            ]
        ]);

        $user = User::create([
            'name' => $request->name,

            'email' => $request->email,

            'cpf' => $request->cpf,

            'link_type' => $request->link_type,

            'access_level' => $request->access_level,

            'active' => true,

            'password' => Hash::make($request->password)
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,

            'message' => 'Usuário registrado com sucesso',

            'token' => $token,

            'user' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {

            throw ValidationException::withMessages([
                'email' => ['Credenciais inválidas']
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Login realizado',
            'token' => $token,
            'user' => $user
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logout realizado'
        ]);
    }
}
