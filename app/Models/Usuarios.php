<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{

    use HasApiTokens;

    protected $table = 'Usuarios';
    protected $primaryKey = 'id_usuario';
    public $incrementing = true;
    protected $keyType = 'int';
    public $timestamps = false;
    protected $fillable = ['nombre', 'apellido_paterno', 'apellido_materno', 'email', 'password_hash', 'id_rol', 'id_depto'];
    protected $hidden = ['password_hash'];

    protected $appends = ['roles', 'empleados'];

    public function rol()
    {
        return $this->belongsTo(Roles::class, 'id_rol', 'id_rol');
    }
    
    public function departamento()
    {
        return $this->belongsTo(Departamentos::class, 'id_depto');
    }

    // Accessors para compatibilidad con el frontend
    public function getRolesAttribute()
    {
        if ($this->relationLoaded('rol') && $this->rol) {
            return [$this->rol];
        }
        return $this->rol()->get()->all();
    }

    public function getEmpleadosAttribute()
    {
        // Extraer nombre del email si no existe nombre_completo
        $nombreCompleto = $this->nombre_completo;
        
        if (!$nombreCompleto && $this->email) {
            // Extraer la parte antes del @ y convertir puntos en espacios
            $nombreCompleto = str_replace('.', ' ', explode('@', $this->email)[0]);
            $nombreCompleto = ucwords($nombreCompleto);
        }
        
        $empleado = [
            'nombre' => $nombreCompleto ?? '',
            'ap' => '',
            'am' => ''
        ];
        
        if ($this->relationLoaded('departamento') && $this->departamento) {
            $empleado['departamentos'] = [$this->departamento];
        }
        
        return [$empleado];
    }


}
