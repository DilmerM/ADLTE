<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <-- AGREGA ESTA LÍNEA
class RegisterController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('register'); // Retorna la vista que creaste
    }

}
