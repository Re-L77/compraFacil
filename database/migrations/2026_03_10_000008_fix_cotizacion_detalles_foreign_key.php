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
        // Eliminar la restricción actual
        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->dropForeign('Cotizacion_Detalles_ibfk_2');
        });

        // Agregar la restricción con ON DELETE CASCADE
        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->foreign('id_req_detalle')
                ->references('id_req_detalle')
                ->on('Requisicion_Detalles')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la restricción con CASCADE
        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->dropForeign(['id_req_detalle']);
        });

        // Restaurar la restricción original
        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->foreign('id_req_detalle')
                ->references('id_req_detalle')
                ->on('Requisicion_Detalles')
                ->onDelete('restrict');
        });
    }
};
