<?php
// app/Http/Controllers/Admin/PerfilController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PerfilController extends Controller
{
    public function index()
    {
        // Esto carga el archivo: resources/views/admin/perfil.blade.php
        return view('admin.perfil');
    }
}
