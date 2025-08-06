<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <-- AGREGA ESTA LÍNEA

class MiniVistaController extends Controller
{
    /**
     * Muestra la vista del landing page.
     */
    public function index()
    {
        // El nombre de la vista debe coincidir con tu archivo .blade.php
        return view('minivista');
    }
}