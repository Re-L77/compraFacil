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
        // Corregir Requisicion_Detalles -> Requisiciones
        Schema::table('Requisicion_Detalles', function (Blueprint $table) {
            $table->dropForeign('Requisicion_Detalles_ibfk_1');
        });

        Schema::table('Requisicion_Detalles', function (Blueprint $table) {
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
        Schema::table('Requisicion_Detalles', function (Blueprint $table) {
            $table->dropForeign(['id_requisicion']);
        });

        Schema::table('Requisicion_Detalles', function (Blueprint $table) {
            $table->foreign('id_requisicion')
                ->references('id_requisicion')
                ->on('Requisiciones')
                ->onDelete('restrict');
        });
    }
};
