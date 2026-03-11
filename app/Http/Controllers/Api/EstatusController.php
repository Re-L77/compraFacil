<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Estatus;

class EstatusController extends Controller
{
    public function index()
    {
        return Estatus::all();
    }
}
