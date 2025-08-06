<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class GeolocalizacionController extends Controller
{
    public function index()
    {
        return view('admin.geolocalizacion');
    }
}