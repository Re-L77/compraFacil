<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Roles extends Model
{
    protected $table = 'Roles';
    protected $primaryKey = 'id_rol';
    public $timestamps = false;
    protected $fillable = ['nombre'];

    public function usuarios()
    {
        return $this->hasMany(Usuarios::class, 'id_rol', 'id_rol');
    }
}
