<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Productos;
use App\Models\UnidadesMedida;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        return Productos::with('unidadMedida')->orderByDesc('id_producto')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'id_unidad' => 'required|exists:Unidades_Medida,id_unidad',
            'precio_referencia' => 'nullable|numeric|min:0',
        ]);

        $producto = Productos::create($data);
        return response()->json($producto->load('unidadMedida'), 201);
    }

    public function show($id)
    {
        $producto = Productos::with('unidadMedida')->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Productos::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'descripcion' => 'nullable|string',
            'id_unidad' => 'sometimes|required|exists:Unidades_Medida,id_unidad',
            'precio_referencia' => 'nullable|numeric|min:0',
        ]);

        $producto->update($data);
        return $producto->fresh()->load('unidadMedida');
    }

    public function destroy($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->delete();
        return response()->noContent();
    }
}

