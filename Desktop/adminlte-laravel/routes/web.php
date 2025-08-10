<?php
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\GeolocalizacionController;
use App\Http\Controllers\Admin\LandingPageController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\RegisterController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\PerfilController;
use App\Http\Controllers\Admin\ReporteController;
use App\Http\Controllers\Admin\ReservasServiciosController;
use App\Http\Controllers\Admin\PruebaReservaController;
use App\Http\Controllers\Admin\AdministracionControlController;





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
    Route::get('/reporte', [ReporteController::class, 'index'])->name('reporte');
    Route::get('/reservas_servicios', [ReservasServiciosController::class, 'index'])->name('reservas_servicios');
    Route::get('/prueba_reserva', [PruebaReservaController::class, 'index'])->name('prueba_reserva');
    Route::get('/administracionControl', [AdministracionControlController::class, 'index'])->name('administracionControl');

});
