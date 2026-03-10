<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasApiTokens;

    protected $table = 'Productos';
    protected $primaryKey = 'id_producto';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion', 'unidad_medida', 'id_unidad', 'precio_referencia'];

    public function unidadMedida()
    {
        return $this->belongsTo(UnidadesMedida::class, 'id_unidad', 'id_unidad');
    }
}
