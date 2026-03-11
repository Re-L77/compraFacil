<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requisicion extends Model
{
    protected $table = 'Requisiciones';
    protected $primaryKey = 'id_requisicion';
    public $incrementing = true;
    public $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['folio', 'fecha_solicitud', 'justificacion', 'id_usuario_solicitante', 'id_estatus'];

    public function usuario()
    {
        return $this->belongsTo(Usuarios::class, 'id_usuario_solicitante', 'id_usuario');
    }

    public function detalles()
    {
        return $this->hasMany(RequisicionDetalle::class, 'id_requisicion', 'id_requisicion');
    }

    public function estatus()
    {
        return $this->belongsTo(Estatus::class, 'id_estatus', 'id_estatus');
    }
}
