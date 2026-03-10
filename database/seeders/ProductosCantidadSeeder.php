<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosCantidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Productos sin cantidad asignada - agregar valores realistas
        $cantidadesAgregarPorId = [
            4 => 15,    // Teclado Mecánico
            13 => 5,    // Antivirus ESET
            17 => 25,   // Cable HDMI 5m
            18 => 12,   // Extension Eléctrica
            19 => 8,    // Regulador de Voltaje
            24 => 50,   // Jabón de Manos
            25 => 30,   // Toallas de Papel
            40 => 20,   // Brocha 4 pulgadas
            41 => 10,   // Thinner
            44 => 100,  // Contacto Doble
            48 => 6,    // Router WiFi
            49 => 2,    // Servidor Dell PowerEdge
        ];

        foreach ($cantidadesAgregarPorId as $id => $cantidad) {
            DB::table('Productos')
                ->where('id_producto', $id)
                ->update(['cantidad' => $cantidad]);
        }
    }
}
