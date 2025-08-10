<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PruebaReservaController extends Controller
{
    public function index()
    {
        return view('admin.prueba_reserva');
    }
}