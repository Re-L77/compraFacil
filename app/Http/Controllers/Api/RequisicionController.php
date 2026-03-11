<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Requisicion;
use App\Models\RequisicionDetalle;
use App\Models\Productos;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class RequisicionController extends Controller
{
    public function index()
    {
        return Requisicion::with('usuario', 'detalles.producto', 'estatus')
            ->orderByDesc('id_requisicion')
            ->get();
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'folio' => 'required|string|max:20|unique:Requisiciones,folio',
            'justificacion' => 'required|string|max:65535',
            'id_usuario_solicitante' => 'required|exists:Usuarios,id_usuario',
            'id_estatus' => 'required|exists:Estatus,id_estatus',
            'detalles' => 'required|array|min:1',
            'detalles.*.id_producto' => 'required|exists:Productos,id_producto',
            'detalles.*.cantidad' => 'required|numeric|min:0.01|max:9999999.99',
        ]);

        // Validar que las cantidades respeten la unidad de medida
        foreach ($data['detalles'] as $idx => $detalle) {
            $producto = Productos::with('unidadMedida')->find($detalle['id_producto']);
            if ($producto && $producto->unidadMedida && $producto->unidadMedida->es_contable) {
                if (floor($detalle['cantidad']) != $detalle['cantidad']) {
                    return response()->json([
                        'message' => "El producto \"{$producto->nombre}\" solo acepta cantidades enteras."
                    ], 422);
                }
            }
        }

        try {
            $requisicion = Requisicion::create([
                'folio' => $data['folio'],
                'fecha_solicitud' => now(),
                'justificacion' => $data['justificacion'],
                'id_usuario_solicitante' => $data['id_usuario_solicitante'],
                'id_estatus' => $data['id_estatus'],
            ]);

            foreach ($data['detalles'] as $detalle) {
                RequisicionDetalle::create([
                    'id_requisicion' => $requisicion->id_requisicion,
                    'id_producto' => $detalle['id_producto'],
                    'cantidad' => $detalle['cantidad'],
                ]);
            }

            return response()->json($requisicion->load('usuario', 'detalles.producto', 'estatus'), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al guardar: ' . $e->getMessage()], 400);
        }
    }

    public function show($id)
    {
        $requisicion = Requisicion::with('usuario', 'detalles.producto', 'estatus')->findOrFail($id);
        return response()->json($requisicion);
    }

    public function update(Request $request, $id)
    {
        $requisicion = Requisicion::findOrFail($id);

        $data = $request->validate([
            'folio' => 'sometimes|required|string|max:20|unique:Requisiciones,folio,' . $id . ',id_requisicion',
            'justificacion' => 'sometimes|required|string|max:65535',
            'id_usuario_solicitante' => 'sometimes|required|exists:Usuarios,id_usuario',
            'id_estatus' => 'sometimes|required|exists:Estatus,id_estatus',
            'detalles' => 'sometimes|array|min:1',
            'detalles.*.id_req_detalle' => 'nullable|exists:Requisicion_Detalles,id_req_detalle',
            'detalles.*.id_producto' => 'required|exists:Productos,id_producto',
            'detalles.*.cantidad' => 'required|numeric|min:0.01|max:9999999.99',
        ]);

        // Validar que las cantidades respeten la unidad de medida
        if (isset($data['detalles'])) {
            foreach ($data['detalles'] as $detalle) {
                $producto = Productos::with('unidadMedida')->find($detalle['id_producto']);
                if ($producto && $producto->unidadMedida && $producto->unidadMedida->es_contable) {
                    if (floor($detalle['cantidad']) != $detalle['cantidad']) {
                        return response()->json([
                            'message' => "El producto \"{$producto->nombre}\" solo acepta cantidades enteras."
                        ], 422);
                    }
                }
            }
        }

        try {
            $requisicion->update($data);

            if (isset($data['detalles'])) {
                // Eliminar detalles que no están en la lista
                $detalleIds = collect($data['detalles'])->pluck('id_req_detalle')->filter()->values();
                RequisicionDetalle::where('id_requisicion', $id)
                    ->whereNotIn('id_req_detalle', $detalleIds)
                    ->delete();

                // Actualizar o crear detalles
                foreach ($data['detalles'] as $detalle) {
                    if ($detalle['id_req_detalle'] ?? false) {
                        RequisicionDetalle::where('id_req_detalle', $detalle['id_req_detalle'])
                            ->update([
                                'id_producto' => $detalle['id_producto'],
                                'cantidad' => $detalle['cantidad'],
                            ]);
                    } else {
                        RequisicionDetalle::create([
                            'id_requisicion' => $id,
                            'id_producto' => $detalle['id_producto'],
                            'cantidad' => $detalle['cantidad'],
                        ]);
                    }
                }
            }

            return $requisicion->fresh()->load('usuario', 'detalles.producto', 'estatus');
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar: ' . $e->getMessage()], 400);
        }
    }

    public function destroy($id)
    {
        $requisicion = Requisicion::findOrFail($id);
        RequisicionDetalle::where('id_requisicion', $id)->delete();
        $requisicion->delete();
        return response()->noContent();
    }
}
