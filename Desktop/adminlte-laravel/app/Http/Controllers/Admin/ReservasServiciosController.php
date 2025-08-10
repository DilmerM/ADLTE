<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReservasServiciosController extends Controller
{
    public function index()
    {
        return view('admin.reservas_servicios');
    }
}