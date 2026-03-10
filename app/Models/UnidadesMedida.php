<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UnidadesMedida extends Model
{
    protected $table = 'Unidades_Medida';
    protected $primaryKey = 'id_unidad';
    public $timestamps = true;
    protected $fillable = ['nombre', 'descripcion'];

    public function productos()
    {
        return $this->hasMany(Productos::class, 'id_unidad', 'id_unidad');
    }
}
