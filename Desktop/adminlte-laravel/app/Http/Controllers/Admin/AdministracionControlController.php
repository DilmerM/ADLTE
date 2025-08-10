<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdministracionControlController extends Controller
{
    public function index()
    {
        return view('admin.administracionControl');
    }
}