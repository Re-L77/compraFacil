<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Usuarios;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|string|email',
            'contrasena' => 'required|string'
        ]);

        $user = Usuarios::where('email', $data['email'])->first();
        if (!$user || !Hash::check($data['contrasena'], $user->password_hash)) {
            throw ValidationException::withMessages(['email' => ['Credenciales incorrectas.']]);
        }
        // Cargar relaciones antes de acceder
        $user->load(['rol', 'departamento']);
        $token = $user->createToken('api')->plainTextToken;
        return response()->json([
            'token' => $token,
            'usuario' => [
                'id_usuario' => $user->id_usuario,
                'nombre' => $user->nombre,
                'apellido_paterno' => $user->apellido_paterno,
                'apellido_materno' => $user->apellido_materno,
                'email' => $user->email,
                'rol'=> $user->rol ? $user->rol->nombre : null,
                'departamento' => $user->departamento ? $user->departamento->nombre: null,
            ]
        ]);
    }
    public function me(Request $request)
    {
        $user = $request->user();
        $user->load(['rol', 'departamento']);
        return response()->json($user);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->noContent();
    }
}
