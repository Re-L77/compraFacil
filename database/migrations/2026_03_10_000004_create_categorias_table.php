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
        Schema::create('Categorias', function (Blueprint $table) {
            $table->increments('id_categoria');
            $table->string('nombre', 50)->unique();
            $table->text('descripcion')->nullable();
        });

        // Insertar categorías por defecto
        \DB::table('Categorias')->insert([
            ['nombre' => 'Producto', 'descripcion' => 'Artículos físicos'],
            ['nombre' => 'Servicio', 'descripcion' => 'Servicios a prestar'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('Categorias');
    }
};
