<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Actualizar cantidad en Productos basado en la suma de Requisicion_Detalles
        DB::statement('
            UPDATE Productos p
            SET cantidad = (
                SELECT COALESCE(SUM(rd.cantidad), 0)
                FROM Requisicion_Detalles rd
                WHERE rd.id_producto = p.id_producto
            )
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir a 0
        DB::table('Productos')->update(['cantidad' => 0]);
    }
};
