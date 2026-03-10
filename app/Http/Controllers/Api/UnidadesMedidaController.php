<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UnidadesMedida;

class UnidadesMedidaController extends Controller
{
    public function index()
    {
        return UnidadesMedida::all();
    }

    public function show($id)
    {
        return UnidadesMedida::findOrFail($id);
    }
}
