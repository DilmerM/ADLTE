<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;  

class LoginController extends Controller
{
    /**
     * Muestra la vista del login.
     */
    public function index()
    {
        return view('login');
    }
}