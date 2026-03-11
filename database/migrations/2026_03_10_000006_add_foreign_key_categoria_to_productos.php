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
        // Agregar foreign key a id_categoria en Productos
        // Primero cambiar el tipo de la columna
        DB::statement('ALTER TABLE Productos MODIFY id_categoria INT UNSIGNED NULL');
        
        // Luego agregar la foreign key
        Schema::table('Productos', function (Blueprint $table) {
            $table->foreign('id_categoria')->references('id_categoria')->on('Categorias')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Productos', function (Blueprint $table) {
            $table->dropForeign(['id_categoria']);
        });
    }
};
