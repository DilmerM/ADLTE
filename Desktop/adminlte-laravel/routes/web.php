<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeolocalizacionController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PerfilController;
use App\Http\Controllers\Admin\MiniVistaController;


// Ruta Raíz ('/'): AHORA MUESTRA LA LANDING PAGE.
// Esta será la primera página que vean los usuarios.
Route::get('/', [LandingPageController::class, 'index'])->name('landing.index');

// Ruta para MOSTRAR el formulario de login.
// El botón de la landing page apuntará aquí.
Route::get('/login', [LoginController::class, 'index'])->name('login');


// Ruta para MOSTRAR el formulario de registro.
Route::get('/register', [RegisterController::class, 'index'])->name('register');


// Esto esta asi porque usa el sidebar e incluye adentro del sidebar los modulos osea que 
// es como una envoltura   
Route::prefix('admin')->name('admin.')->group(function () {


    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/geolocalizacion', [GeolocalizacionController::class, 'index'])->name('geolocalizacion');
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');
});