<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuarios;
use Illuminate\Testing\Fluent\Concerns\Has;
use Psr\Http\Message\ResponseInterface;

class UsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return Usuarios::with(['rol', 'departamento'])->orderByDesc('id_usuario')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate([
            'nombre' => 'required|string|max:80',
            'apellido_paterno' => 'nullable|string|max:80',
            'apellido_materno' => 'nullable|string|max:80',
            'email' => 'required|string|max:100|unique:Usuarios,email',
            'contrasena' => 'required|string|min:6',
            'id_rol' => 'required|exists:Roles,id_rol',
            'id_depto' => 'required|exists:Departamentos,id_depto'
        ]);

        $data['password_hash'] = Hash::make($data['contrasena']);
        unset($data['contrasena']);
        $user = Usuarios::create($data);
        return response()->json($user, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Usuarios $usuario)
    {
        return $usuario->load(['rol', 'departamento']);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Usuarios $usuario)
    {
        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:80',
            'apellido_paterno' => 'nullable|string|max:80',
            'apellido_materno' => 'nullable|string|max:80',
            'email' => 'sometimes|required|string|max:100|unique:Usuarios,email,' . $usuario->id_usuario . ',id_usuario',
            'contrasena' => 'nullable|string|min:6',
            'id_rol' => 'sometimes|required|exists:Roles,id_rol',
            'id_depto' => 'sometimes|required|exists:Departamentos,id_depto'
        ]);

        if(isset($data['contrasena']) && $data['contrasena'] !== null) {
            $data['password_hash'] = Hash::make($data['contrasena']);
            unset($data['contrasena']);
        }
        $usuario->update($data);
        return $usuario->fresh()->load(['rol', 'departamento']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Usuarios $usuario)
    {
        $usuario->delete();
        return response()->noContent();
    }

    public function rehashPassword(Request $request, Usuarios $usuario) {
        $data = $request->validate([
            'contrasena' => ['required', 'string', 'min:5'],
        ]);
        $usuario->password_hash = Hash::make($data['contrasena']);
        $usuario->save();

        return response()->json([
            'message' => 'Contraseña actualizada (hasheada) correctamente',
            'id' => $usuario->id_usuario,
            'email' => $usuario->email
        ]);
    }
}
