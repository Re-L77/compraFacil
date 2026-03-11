<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AsignarCategoriasProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Productos con categoría "Producto" (id_categoria = 1)
        $productosIds = [
            1, 2, 3, 4, 5, 6, 7, 8, 9, 10,
            12, 13, 14, 15, 16, 17, 18, 19, 20, 21,
            22, 23, 24, 25, 26, 27, 28, 29, 30, 31,
            32, 33, 34, 35, 36, 39, 40, 41, 42, 43,
            44, 45, 46, 47, 48, 49, 50
        ];

        // Servicios con categoría "Servicio" (id_categoria = 2)
        $serviciosIds = [
            11, // Servicio de Limpieza
            37, // Servicio de Flete
            38  // Mantenimiento AA
        ];

        // Asignar categoría "Producto" (id_categoria = 1)
        DB::table('Productos')
            ->whereIn('id_producto', $productosIds)
            ->update(['id_categoria' => 1]);

        // Asignar categoría "Servicio" (id_categoria = 2)
        DB::table('Productos')
            ->whereIn('id_producto', $serviciosIds)
            ->update(['id_categoria' => 2]);
    }
}
