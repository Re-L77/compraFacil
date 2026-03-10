<?php

namespace Database\Seeders;

use App\Models\Usuarios;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Usuarios::firstOrCreate(
            ['email' => 'admin@comprafacil.com'],
            [
                'nombre' => 'Admin',
                'apellido_paterno' => 'System',
                'apellido_materno' => '',
                'password_hash' => Hash::make('admin123'),
                'id_rol' => 1,
                'id_depto' => 1,
            ]
        );

        Usuarios::firstOrCreate(
            ['email' => 'user@comprafacil.com'],
            [
                'nombre' => 'Test',
                'apellido_paterno' => 'User',
                'apellido_materno' => '',
                'password_hash' => Hash::make('user123'),
                'id_rol' => 2,
                'id_depto' => 1,
            ]
        );
    }
}
