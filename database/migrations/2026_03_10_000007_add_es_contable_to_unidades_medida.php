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
        Schema::table('Unidades_Medida', function (Blueprint $table) {
            $table->boolean('es_contable')->default(true)->after('descripcion')->comment('true=contable (piezas, unidades), false=incontable (litros, kilos)');
        });

        // Actualizar unidades incontables (que no pueden ser fraccionadas)
        $unidadesIncontables = ['Pieza', 'Caja', 'Paquete', 'Servicio', 'Licencia', 'Juego', 'Par', 'Bote', 'Cubeta'];
        
        DB::table('Unidades_Medida')
            ->whereIn('nombre', $unidadesIncontables)
            ->update(['es_contable' => true]);

        $unidadesContables = ['Metro Cd', 'Galón', 'Bulto', 'Frasco', 'Bobina', 'Viaje', 'Rollo'];
        
        DB::table('Unidades_Medida')
            ->whereIn('nombre', $unidadesContables)
            ->update(['es_contable' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('Unidades_Medida', function (Blueprint $table) {
            $table->dropColumn('es_contable');
        });
    }
};
