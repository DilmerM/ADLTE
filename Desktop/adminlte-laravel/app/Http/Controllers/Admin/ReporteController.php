<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller; // <-- AGREGA ESTA LÍNEA
class ReporteController extends Controller
{
    /**
     * Muestra el formulario de login.
     */
    public function index()
    {
        return view('admin.reporte'); // Retorna la vista que creaste
    }

}
