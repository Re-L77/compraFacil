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
        // Corregir Ordenes_Compra -> Cotizaciones
        Schema::table('Ordenes_Compra', function (Blueprint $table) {
            $table->dropForeign('Ordenes_Compra_ibfk_1');
        });

        Schema::table('Ordenes_Compra', function (Blueprint $table) {
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
        Schema::table('Ordenes_Compra', function (Blueprint $table) {
            $table->dropForeign(['id_cotizacion']);
        });

        Schema::table('Ordenes_Compra', function (Blueprint $table) {
            $table->foreign('id_cotizacion')
                ->references('id_cotizacion')
                ->on('Cotizaciones')
                ->onDelete('restrict');
        });
    }
};
