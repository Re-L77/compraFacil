<?php

namespace App\Console\Commands;

use App\Models\Usuarios;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class HashPasswordsCommand extends Command
{
    protected $signature = 'app:hash-passwords';
    protected $description = 'Hash all unhashed passwords in Usuarios table with Bcrypt';

    public function handle()
    {
        $usuarios = Usuarios::all();
        $updated = 0;

        foreach ($usuarios as $usuario) {
            // Check if password is already hashed with Bcrypt (starts with $2y$ or $2b$)
            if (!preg_match('/^\$2[aby]\$/', $usuario->password_hash)) {
                // Hash the password
                $usuario->password_hash = Hash::make($usuario->password_hash);
                $usuario->save();
                $updated++;
                $this->info("✓ Updated: {$usuario->email}");
            }
        }

        $this->info("\nTotal passwords hashed: {$updated}");
    }
}
