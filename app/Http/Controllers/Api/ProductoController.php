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
        return Productos::with('unidadMedida', 'categoria')->orderByDesc('id_producto')->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:65535',
            'id_unidad' => 'required|exists:Unidades_Medida,id_unidad',
            'id_categoria' => 'nullable|exists:Categorias,id_categoria',
            'precio_referencia' => 'nullable|numeric|min:0|max:9999999.99',
        ]);

        $producto = Productos::create($data);
        return response()->json($producto->load('unidadMedida', 'categoria'), 201);
    }

    public function show($id)
    {
        $producto = Productos::with('unidadMedida', 'categoria')->findOrFail($id);
        return response()->json($producto);
    }

    public function update(Request $request, $id)
    {
        $producto = Productos::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'sometimes|required|string|max:100',
            'descripcion' => 'nullable|string|max:65535',
            'id_unidad' => 'sometimes|required|exists:Unidades_Medida,id_unidad',
            'id_categoria' => 'nullable|exists:Categorias,id_categoria',
            'precio_referencia' => 'nullable|numeric|min:0|max:9999999.99',
        ]);

        $producto->update($data);
        return $producto->fresh()->load('unidadMedida', 'categoria');
    }

    public function destroy($id)
    {
        $producto = Productos::findOrFail($id);
        $producto->delete();
        return response()->noContent();
    }
}

