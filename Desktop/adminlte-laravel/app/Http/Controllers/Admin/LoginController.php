<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <-- AGREGA ESTA LÍNEA

class LoginController extends Controller
{
    /**
     * Muestra la vista del login.
     */
    public function index()
    {
        // El nombre de la vista debe coincidir con tu archivo .blade.php
        return view('login');
    }
}