<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamentos extends Model
{
    protected $table = 'Departamentos';
    protected $primaryKey = 'id_depto';
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'id_departamento', 'id_depto');
    }
}