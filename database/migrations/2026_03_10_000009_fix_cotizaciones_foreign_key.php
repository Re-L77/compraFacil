<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Eliminar la restricción actual en Cotizaciones
        Schema::table('Cotizaciones', function (Blueprint $table) {
            $table->dropForeign('Cotizaciones_ibfk_1');
        });

        // Agregar la restricción con ON DELETE CASCADE
        Schema::table('Cotizaciones', function (Blueprint $table) {
            $table->foreign('id_requisicion')
                ->references('id_requisicion')
                ->on('Requisiciones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar la restricción con CASCADE
        Schema::table('Cotizaciones', function (Blueprint $table) {
            $table->dropForeign(['id_requisicion']);
        });

        // Restaurar la restricción original
        Schema::table('Cotizaciones', function (Blueprint $table) {
            $table->foreign('id_requisicion')
                ->references('id_requisicion')
                ->on('Requisiciones')
                ->onDelete('restrict');
        });
    }
};
