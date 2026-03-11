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
        // Corregir Cotizacion_Detalles -> Cotizaciones
        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->dropForeign('Cotizacion_Detalles_ibfk_1');
        });

        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->foreign('id_cotizacion')
                ->references('id_cotizacion')
                ->on('Cotizaciones')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->dropForeign(['id_cotizacion']);
        });

        Schema::table('Cotizacion_Detalles', function (Blueprint $table) {
            $table->foreign('id_cotizacion')
                ->references('id_cotizacion')
                ->on('Cotizaciones')
                ->onDelete('restrict');
        });
    }
};
