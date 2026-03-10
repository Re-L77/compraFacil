<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Departamentos;
use Illuminate\Http\Request;

class DepartamentosController extends Controller
{
    public function index()
    {
        return Departamentos::orderBy('nombre')->get();
    }
}
