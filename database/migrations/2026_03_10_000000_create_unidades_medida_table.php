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
        // 1. Crear tabla Unidades_Medida
        Schema::create('Unidades_Medida', function (Blueprint $table) {
            $table->id('id_unidad');
            $table->string('nombre', 50)->unique()->notNullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });

        // Ajustar colación a utf8mb4_general_ci para compatibilidad
        DB::statement('ALTER TABLE Unidades_Medida CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci');
        DB::statement('ALTER TABLE Unidades_Medida CHANGE nombre nombre VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL');

        // 2. Insertar unidades de medida existentes
        $unidades = [
            ['nombre' => 'Pieza', 'descripcion' => 'Unidad individual'],
            ['nombre' => 'Caja', 'descripcion' => 'Caja de múltiples unidades'],
            ['nombre' => 'Paquete', 'descripcion' => 'Paquete'],
            ['nombre' => 'Servicio', 'descripcion' => 'Servicio por unidad'],
            ['nombre' => 'Metro Cd', 'descripcion' => 'Metro cuadrado'],
            ['nombre' => 'Licencia', 'descripcion' => 'Licencia de software'],
            ['nombre' => 'Galón', 'descripcion' => 'Galón de líquido'],
            ['nombre' => 'Bulto', 'descripcion' => 'Bulto de materia prima'],
            ['nombre' => 'Frasco', 'descripcion' => 'Frasco'],
            ['nombre' => 'Bobina', 'descripcion' => 'Bobina de cable/material'],
            ['nombre' => 'Viaje', 'descripcion' => 'Viaje de transporte'],
            ['nombre' => 'Par', 'descripcion' => 'Unidad en pares'],
            ['nombre' => 'Juego', 'descripcion' => 'Juego completo'],
            ['nombre' => 'Rollo', 'descripcion' => 'Rollo de material'],
            ['nombre' => 'Bote', 'descripcion' => 'Bote/recipiente'],
            ['nombre' => 'Cubeta', 'descripcion' => 'Cubeta/balde'],
        ];

        DB::table('Unidades_Medida')->insert($unidades);

        // 3. Agregar columna id_unidad a Productos (nullable mientras migramos)
        Schema::table('Productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_unidad')->nullable()->after('descripcion');
            $table->foreign('id_unidad')
                ->references('id_unidad')
                ->on('Unidades_Medida')
                ->onDelete('restrict');
        });

        // 4. Migrar datos existentes: mapear unidad_medida a id_unidad
        // Usar COLLATE para resolver diferencias de colación
        DB::statement('
            UPDATE Productos p
            SET p.id_unidad = (
                SELECT u.id_unidad 
                FROM Unidades_Medida u 
                WHERE u.nombre COLLATE utf8mb4_general_ci = p.unidad_medida COLLATE utf8mb4_general_ci
                LIMIT 1
            )
        ');

        // 5. Hacer id_unidad NOT NULL después de migrar datos
        Schema::table('Productos', function (Blueprint $table) {
            $table->unsignedBigInteger('id_unidad')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir: eliminar la clave foránea y la columna nueva
        Schema::table('Productos', function (Blueprint $table) {
            $table->dropForeign(['id_unidad']);
            $table->dropColumn('id_unidad');
        });

        // Eliminar tabla Unidades_Medida
        Schema::dropIfExists('Unidades_Medida');
    }
};
