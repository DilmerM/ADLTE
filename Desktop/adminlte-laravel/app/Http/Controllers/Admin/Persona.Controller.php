<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class PersonaController extends Controller
{
    public function index()
    {
        return view('admin.persona');
    }
}