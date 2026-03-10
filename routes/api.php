<?php

use App\Http\Controllers\Api\RolesController;
use App\Http\Controllers\Api\DepartamentosController;
use App\Http\Controllers\Api\UnidadesMedidaController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Api\UsuarioController;
use App\Http\Controllers\Api\ProductoController;
use App\Models\Usuarios;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function() {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/usuarios/{usuario}/rehash', [UsuarioController::class, 'rehashPassword']);
    Route::get('/roles', [RolesController::class, 'index']);
    Route::get('/departamentos', [DepartamentosController::class, 'index']);
    Route::get('/unidades-medida', [UnidadesMedidaController::class, 'index']);
    Route::apiResource('usuarios', UsuarioController::class);
    Route::apiResource('productos', ProductoController::class);
});
?>