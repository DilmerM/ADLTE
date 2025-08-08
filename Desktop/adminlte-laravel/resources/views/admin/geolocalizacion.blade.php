@extends('admin.app')
@section('title', 'Geolocalizacion')
@section('page-title', 'Geolocalizacion')


@section('content')
<div class="container-fluid">
    {{-- Visualizador de Lugares Turísticos --}}
    <div class="row">
        <div class="col-12"><h4 class="mt-4 mb-3">1. Visualizador de Lugares Turísticos</h4></div>
    </div>

    <div class="row align-items-center">
        {{-- Mapa inicial --}}
        <div class="col-12 col-md-5 col-lg-4 mb-4 mb-lg-0">
            <div class="phone-mockup">
                <div class="phone-screen">
                    <iframe id="embedded-map" src="https://www.openstreetmap.org/export/embed.html?bbox=-89.5,13.5,-82.5,16.5&layer=mapnik" title="Mapa del lugar turístico"></iframe>
                </div>
            </div>
        </div>

        {{-- Tarjetas de parques --}}
        <div class="col-12 col-md-7 col-lg-8">
            <h2 class="text-center mb-4">Nuestros Parques Más Populares</h2>
            <div class="parks-container-scroll">
                @php
                    $parques = [
                        ['nombre'=>'Parque Nacional La Tigra','img'=>'laTigra.jpg','desc'=>'Bosque nublado y principal fuente de agua de la capital.','lat'=>14.2333,'lon'=>-87.1],
                        ['nombre'=>'Parque Nacional Pico Bonito','img'=>'picoBonito.jpg','desc'=>'Impresionante montaña cerca del Caribe, conocida por sus cascadas.','lat'=>15.5833,'lon'=>-86.8333],
                        ['nombre'=>'Parque Nacional Celaque','img'=>'celaque.jpg','desc'=>'Contiene el punto más alto de Honduras, El Cerro de las Minas.','lat'=>14.55,'lon'=>-88.6667],
                        ['nombre'=>'Parque Nacional La Muralla','img'=>'muralla-2.jpg','desc'=>'Famoso por su bosque nuboso y ser hábitat del quetzal, ubicado en Olancho.','lat'=>15.1125,'lon'=>-86.7625],
                        ['nombre'=>'Parque Nacional Cusuco','img'=>'cusuco.jpg','desc'=>'Bosque nuboso en la Sierra del Merendón, vital para la biodiversidad de la zona.','lat'=>15.5064,'lon'=>-88.2200],
                        ['nombre'=>'Parque Nacional Warunta','img'=>'warunta.jpg','desc'=>'Complejo de lagunas en La Mosquitia, hogar de manatíes y gran diversidad de aves.','lat'=>15.0833,'lon'=>-83.7000],
                    ];
                @endphp


                @foreach($parques as $p)
                <div class="park-card">
                    <img src="{{ asset('images/' . $p['img']) }}" class="park-card-img" alt="{{ $p['nombre'] }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/600x400/28a745/white?text={{ urlencode($p['nombre']) }}';">
                    <div class="park-card-content">
                        <h5 class="park-card-title">{{ $p['nombre'] }}</h5>
                        <p class="park-card-text">{{ $p['desc'] }}</p>
                        <a href="#" class="btn btn-success park-card-btn" data-lat="{{ $p['lat'] }}" data-lon="{{ $p['lon'] }}">Ver en Mapa</a>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
<div class="container-fluid py-4">
    <div class="row">

        <div class="col-lg-7 mb-4 mb-lg-0">
            {{-- Se añadieron clases de Bootstrap para centrar y dar espaciado --}}
            <div class="text-center mb-4">
                {{-- Se añadieron clases para el tamaño y color del icono --}}
                <i class="bi bi-geo-alt-fill text-primary display-4"></i>
                <h1>Buscador de Puntos Geográficos</h1>
                <p class="lead text-muted">Busca un punto geográfico por su nombre o descripción.</p>
            </div>

            {{-- Barra de Búsqueda y Botón de Carga --}}
            <div class="row justify-content-center mb-4">
                <div class="col-md-10">
                    <div class="input-group input-group-lg mb-3">
                        <input type="text" id="searchInput" class="form-control" placeholder="Escribe para filtrar...">
                        <button class="btn btn-primary" type="button"><i class="bi bi-search"></i></button>
                    </div>
                    
                </div>
            </div>
<div class="d-flex justify-content-end mb-3">
    <div class="btn-group" role="group" aria-label="Panel de control de la tabla">
        <button type="button" id="btn-mode-create" class="btn btn-success">
            <i class="bi bi-plus-circle-fill me-1"></i> Crear
        </button>
        <button type="button" id="btn-mode-view" class="btn btn-outline-primary active">
            <i class="bi bi-eye-fill me-1"></i> Ver
        </button>
        <button type="button" id="btn-mode-delete" class="btn btn-outline-primary">
            <i class="bi bi-trash-fill me-1"></i> Borrar
        </button>
        <button type="button" id="btn-mode-edit" class="btn btn-outline-primary">
            <i class="bi bi-pencil-fill me-1"></i> Editar
        </button>
    </div>
</div>

            {{-- Tabla de Resultados --}}
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped m-0">
                            {{-- Se añadió la clase 'table-dark' para el encabezado --}}
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre del Punto</th>
                                    <th>Descripción</th>
                                    <th class="text-center">Ubicación</th>
                                </tr>
                            </thead>
                            <tbody id="resultsTableBody">
                                {{-- Las filas se insertarán aquí dinámicamente --}}
                            </tbody>
                        </table>
                    </div>
                    {{-- Se añadieron clases para los estados de carga y sin resultados --}}
                    <div id="loading-state" class="d-none text-center p-5 fst-italic text-muted">
                        <div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div>
                        <p class="mt-2 mb-0">Cargando puntos geográficos...</p>
                    </div>
                    <div id="no-results-state" class="d-none text-center p-5 fst-italic text-muted">
                        Presiona el botón para cargar los puntos geográficos.
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="card text-white bg-primary shadow-sm mb-4">
                <div class="card-header border-0">
                    <h3 class="card-title mb-0"><i class="bi bi-thermometer-sun me-2"></i>Clima Actual</h3>
                </div>
                {{-- Se añadió la clase 'fs-5' para un texto ligeramente más grande --}}
                <div class="card-body text-center d-flex flex-column justify-content-center fs-5" id="weather-card-body" style="min-height: 250px;">
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title mb-0"><i class="bi bi-pin-map-fill me-2"></i>Obtener Coordenadas</h3>
                </div>
                <div class="card-body">
                    <p class="text-muted text-center mb-3">Presiona el botón para obtener tu ubicación actual.</p>
                    <div class="d-grid gap-2 mb-4">
                        <button id="btnGetLocation" class="btn btn-primary"><i class="bi bi-geo-alt-fill me-2"></i>Obtener Mi Ubicación</button>
                    </div>
                    <form id="locationForm">
                        <div class="row">
                            <div class="col-sm-6 mb-2"><label class="form-label">Latitud</label><input type="text" class="form-control" id="latitude" readonly></div>
                            <div class="col-sm-6 mb-2"><label class="form-label">Longitud</label><input type="text" class="form-control" id="longitude" readonly></div>
                            <div class="col-12 mb-2"><label class="form-label">Barrio / Colonia</label><input type="text" class="form-control" id="address" readonly></div>
                            <div class="col-sm-6 mb-2"><label class="form-label">Ciudad</label><input type="text" class="form-control" id="city" readonly></div>
                            <div class="col-sm-6 mb-2"><label class="form-label">Código Postal</label><input type="text" class="form-control" id="postalcode" readonly></div>
                            <div class="col-12"><label class="form-label">País</label><input type="text" class="form-control" id="country" readonly></div>
                        </div>
                    </form>
                    <div id="status" class="mt-3" style="min-height: 50px;"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="toast-container">
    </div>
<div class="d-flex justify-content-end mb-3">
    <div class="btn-group" role="group" aria-label="Panel de control de la tabla">
        </div>
</div>
<div class="modal fade" id="puntoModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="puntoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="puntoModalLabel"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="puntoForm">
                    <input type="hidden" id="punto-id">

                    <div class="mb-3">
                        <label for="punto-nombre" class="form-label">Nombre del Punto</label>
                        <input type="text" class="form-control" id="punto-nombre" required>
                    </div>
                    <div class="mb-3">
                        <label for="punto-descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="punto-descripcion" rows="3" required></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="punto-latitud" class="form-label">Latitud</label>
                            <input type="number" step="any" class="form-control" id="punto-latitud" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="punto-longitud" class="form-label">Longitud</label>
                            <input type="number" step="any" class="form-control" id="punto-longitud" required>
                        </div>
                    </div>
                    <div id="modal-error" class="alert alert-danger d-none" role="alert"></div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btn-cancelar-modal">Cancelar</button>
                
                <button type="submit" form="puntoForm" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmationModalLabel">Confirmar Acción</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="confirmationModalBody">
                ¿Estás seguro de que quieres realizar esta acción?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="btn-confirm-cancel">Cancelar</button>
                <button type="button" class="btn btn-danger" id="btn-confirm-accept">Aceptar</button>
            </div>
        </div>
    </div>
</div>
</div>
@stop

@section('css')
 <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
 <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">
    {{-- Fuente personalizada --}}
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />

    {{-- Bootstrap Icons (si los necesitas explícitamente) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    {{-- AdminLTE (normalmente ya incluido por @extends, solo añade si lo personalizaste) --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css" />

    {{-- Incluye todos tus estilos CSS existentes --}}
    <style>
 /* El contenedor que anclará las notificaciones en la esquina */
    #toast-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999; /* Asegura que esté por encima de todo */
        display: flex;
        flex-direction: column-reverse; /* Las nuevas notificaciones aparecen abajo y empujan las viejas hacia arriba */
        align-items: flex-end;
    }

    /* Estilo base para cada notificación toast */
    .toast-notification {
        color: #fff;
        padding: 15px 20px;
        margin-top: 10px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 350px;
        max-width: 90vw;
        animation: slideInFromRight 0.5s ease-out forwards;
        opacity: 0;
    }

    /* Colores específicos para éxito y error */
    .toast-success {
        background-color: #28a745; /* Verde éxito */
    }

    .toast-danger {
        background-color: #dc3545; /* Rojo peligro */
    }

    /* Botón para cerrar el toast manualmente */
    .toast-notification .btn-close {
        filter: invert(1) grayscale(100%) brightness(200%); /* Hace el botón blanco */
        margin-left: 15px;
    }

    /* Animación de entrada */
    @keyframes slideInFromRight {
        to {
            transform: translateX(0);
            opacity: 1;
        }
        from {
            transform: translateX(100%);
            opacity: 0;
        }
    }

    /* Animación de salida */
    .toast-notification.fade-out {
        animation: fadeOut 0.5s ease-out forwards;
    }

    @keyframes fadeOut {
        from {
            opacity: 1;
            transform: scale(1);
        }
        to {
            opacity: 0;
            transform: scale(0.9);
        }
    }
    .action-switcher {
        cursor: pointer;
        padding: 0 8px;
        font-weight: normal;
        color: #6c757d; /* Color gris de bootstrap */
        transition: all 0.2s ease-in-out;
    }
    .action-switcher.active {
        font-weight: bold;
        color: #0d6efd; /* Color primario de bootstrap */
    }
    .action-switcher-separator {
        color: #dee2e6; /* Color de borde de bootstrap */
        margin: 0 2px;
    }
    .main-action-btn i {
        margin-right: 5px;
    }


       html, body {
  height: 100%;
  overflow-x: hidden;
  margin: 0;
  padding: 0;
}


.app-wrapper {
  min-height: 100vh;
  overflow-x: 100%;
}

/* Contenedor de teléfono */
.phone-wrapper {
  padding: 20px;
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: #f0f2f5;
}

.phone-mockup {
  position: relative;
  width: 100%;
  max-width: 320px;
  margin: 0 auto;
  border: 12px solid #1c1c1c;
  border-radius: 36px;
  background: #333;
  box-shadow: 0 15px 35px rgba(0,0,0,0.25);
  padding: 2px;
}

.phone-screen {
  background: #fff;
  border-radius: 24px;
  overflow: hidden;
  position: relative;
  padding-top: 177.77%; /* Aspect ratio 16:9 ajustado */
  height: 0;
}

.phone-screen iframe {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  border: none;
}

.phone-mockup::before {
  content: '';
  position: absolute;
  top: 2px;
  left: 50%;
  transform: translateX(-50%);
  width: 120px;
  height: 20px;
  background: #1c1c1c;
  border-radius: 0 0 12px 12px;
  z-index: 10;
}

/* Tarjetas geolocalización */
.geolocation-card, .location-card {
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  border: none;
  border-radius: .5rem;
  height: 100%;
  display: flex;
  flex-direction: column;
}

.geolocation-card .card-body, .location-card .card-body {
  flex-grow: 1;
  display: flex;
  flex-direction: column;
  justify-content: center;
}

.geolocation-card input:disabled, .location-card textarea:disabled {
  cursor: default;
  background-color: #e9ecef !important;
}

.map-container {
  flex-grow: 1;
  padding: 0;
  display: flex;
}

#embedded-map {
  width: 100%;
  height: 100%;
  min-height: 450px;
  border: none;
  border-bottom-left-radius: .5rem;
  border-bottom-right-radius: .5rem;
}

/* Módulo de búsqueda */
.search-module-container {
  background: #ffffff;
  padding: 2rem;
  border-radius: 0.75rem;
  box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
  border: 1px solid #dee2e6;
}

.table-hover tbody tr:hover {
  background-color: #e9ecef;
}

.no-results-row td {
  text-align: center;
  font-style: italic;
  color: #6c757d;
  padding: 1.5rem;
}

/* Tarjetas de parques */
.park-card {
  position: relative;
  border: none;
  border-radius: 1rem;
  overflow: hidden;
  box-shadow: 0 10px 20px rgba(0,0,0,0.1);
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  cursor: pointer;
  height: 320px;
  flex-shrink: 0;
}

.park-card:hover {
  transform: translateY(-10px);
  box-shadow: 0 15px 30px rgba(0,0,0,0.2);
}

.park-card .park-card-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
  transition: transform 0.6s ease;
}

.park-card:hover .park-card-img {
  transform: scale(1.1);
}

.park-card .park-card-content {
  position: absolute;
  bottom: 0;
  left: 0;
  right: 0;
  padding: 1.5rem 1rem 1rem;
  color: white;
  background: linear-gradient(to top, rgba(0,0,0,0.9) 10%, transparent 100%);
  transition: transform 0.5s ease;
}

.park-card .park-card-title {
  font-weight: 700;
  margin-bottom: 0.4rem;
  font-size: 1.3rem;
}

.park-card .park-card-text {
  font-size: 0.8rem;
  margin-bottom: 1rem;
  opacity: 0;
  transition: opacity 0.5s ease 0.1s;
}

.park-card .park-card-btn {
  opacity: 0;
  transform: translateY(10px);
  transition: all 0.5s ease 0.2s;
  padding: 0.4rem 1.2rem;
  border-radius: 50px;
  font-weight: 600;
  font-size: 0.85rem;
}

/* Contenedor de parques - Scroll móvil */
.parks-container-scroll {
  display: flex;
  overflow-x: auto;
  flex-wrap: nowrap;
  gap: 1.5rem;
  padding: 0.5rem;
  margin: -0.5rem;
  -webkit-overflow-scrolling: touch;
  width: 100%;
  box-sizing: border-box;
}

/* En móvil, los detalles son siempre visibles */
.parks-container-scroll .park-card {
  width: 280px;
}

.parks-container-scroll .park-card .park-card-content {
  transform: translateY(0);
}
.parks-container-scroll .park-card .park-card-text,
.parks-container-scroll .park-card .park-card-btn {
  opacity: 1;
}

/* Escritorio: grid de 2 filas */
@media (min-width: 992px) {
  .parks-container-scroll {
    display: grid;
    grid-auto-flow: column;
    grid-template-rows: repeat(2, 1fr);
    grid-auto-columns: calc(50% - 0.75rem);
    overflow-x: auto;
    max-width: 100%;
  }

  .parks-container-scroll .park-card {
    width: auto;
  }

  .parks-container-scroll .park-card .park-card-content {
    transform: translateY(calc(100% - 4.5rem));
  }

  .parks-container-scroll .park-card:hover .park-card-content {
    transform: translateY(0);
  }

  .parks-container-scroll .park-card .park-card-text,
  .parks-container-scroll .park-card .park-card-btn {
    opacity: 0;
  }

  .parks-container-scroll .park-card:hover .park-card-text,
  .parks-container-scroll .park-card:hover .park-card-btn {
    opacity: 1;
  }
}

/* Scrollbar estilizado */
.parks-container-scroll::-webkit-scrollbar {
  height: 8px;
}
.parks-container-scroll::-webkit-scrollbar-track {
  background: #e9ecef;
  border-radius: 10px;
}
.parks-container-scroll::-webkit-scrollbar-thumb {
  background: #adb5bd;
  border-radius: 10px;
}
.parks-container-scroll::-webkit-scrollbar-thumb:hover {
  background: #6c757d;
}


.search-header {
        text-align: center;
        margin-bottom: 2rem;
    }
    .search-header .icon {
        font-size: 3rem;
        color: #0d6efd;
    }
    .table thead {
        background-color: #212529;
        color: white;
        position: sticky;
        top: 0;
    }
    .btn-view-location {
        padding: 0.375rem 0.75rem;
    }
    #loading-state, #no-results-state {
        display: none; /* Ocultos por defecto */
        text-align: center;
        padding: 2.5rem;
        font-style: italic;
        color: #6c757d;
    }
    </style>
@stop


@push('js')

    <script
        src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/js/jsvectormap.min.js"
        integrity="sha256-/t1nN2956BT869E6H4V1dnt0X5pAQHPytli+1nTZm2Y="
        crossorigin="anonymous"></script>
    <script
        src="https://cdn.jsdelivr.net/npm/jsvectormap@1.5.3/dist/maps/world.js"
        integrity="sha256-XPpPaZlU8S/HWf7FZLAncLg2SAkP8ScUTII89x9D3lY="
        crossorigin="anonymous"></script>

    <script>
    // El script para la tarjeta del clima se mantiene igual
    document.addEventListener('DOMContentLoaded', function() {
        const city = 'Comayagüela'; // Actualizado a tu ubicación
        const url = `https://wttr.in/${city}?format=j1`;
        const weatherCardBody = document.getElementById('weather-card-body');

        fetch(url)
            .then(response => {
                if (!response.ok) {
                    throw new Error('La respuesta de la red no fue correcta.');
                }
                return response.json();
            })
            .then(data => {
                const location = data.nearest_area[0].areaName[0].value;
                const temp = data.current_condition[0].temp_C;
                const description = data.current_condition[0].lang_es[0].value;

                weatherCardBody.innerHTML = `
                    <h2>${location}</h2>
                    <p style="font-size: 3rem; font-weight: bold; margin: 0;">${temp}°C</p>
                    <p class="lead text-capitalize">${description}</p>
                `;
            })
            .catch(error => {
                console.error('Error al obtener el clima:', error);
                weatherCardBody.innerHTML = `<p class="text-danger">No se pudo cargar el clima.</p>`;
            });
    });

    // --- INICIO SCRIPT GEOLOCALIZACIÓN (SIN CAMBIOS)---
    const btnGetLocation = document.getElementById('btnGetLocation');
    // ... (el resto de tu código de geolocalización se mantiene aquí intacto)
    const latitudeInput = document.getElementById('latitude');
    const longitudeInput = document.getElementById('longitude');
    const addressInput = document.getElementById('address');
    const cityInput = document.getElementById('city');
    const postalcodeInput = document.getElementById('postalcode');
    const countryInput = document.getElementById('country');
    const statusDiv = document.getElementById('status');
    if (btnGetLocation) {
        btnGetLocation.addEventListener('click', () => {
            const allInputs = [latitudeInput, longitudeInput, addressInput, cityInput, postalcodeInput, countryInput];
            allInputs.forEach(input => {
                input.value = '';
                input.placeholder = 'Cargando...';
            });
            
            btnGetLocation.disabled = true;
            showStatus('<div class="alert alert-info d-flex align-items-center"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Obteniendo ubicación...</div>', 'info');

            if (!navigator.geolocation) {
                showError('Tu navegador no soporta la geolocalización.');
                return;
            }
            
            const options = { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 };
            navigator.geolocation.getCurrentPosition(success, error, options);
        });
    }

    async function success(position) {
        const latitude = position.coords.latitude;
        const longitude = position.coords.longitude;
        latitudeInput.value = latitude.toFixed(6);
        longitudeInput.value = longitude.toFixed(6);
        await getAddressFromCoordinates(latitude, longitude);
    }
     async function getAddressFromCoordinates(lat, lon) {
        showStatus('<div class="alert alert-info d-flex align-items-center"><div class="spinner-border spinner-border-sm me-2" role="status"></div>Buscando dirección...</div>', 'info');
        try {
            const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lon}`);
            if (!response.ok) throw new Error('No se pudo obtener la dirección.');
            
            const data = await response.json();
            const addr = data.address;
            addressInput.value = addr.neighbourhood || addr.suburb || addr.road || 'N/A';
            cityInput.value = addr.city || addr.town || addr.village || 'N/A';
            postalcodeInput.value = addr.postcode || 'N/A';
            countryInput.value = addr.country || 'N/A';

            showStatus('<div class="alert alert-success"><strong>¡Éxito!</strong> Ubicación y dirección obtenidas.</div>', 'success');
        } catch (err) {
            showError('No se pudo encontrar la dirección para estas coordenadas.');
        } finally {
            resetButton();
        }
    }

    function error(err) {
        let message = '';
        switch(err.code) {
            case err.PERMISSION_DENIED: message = 'Permiso denegado.'; break;
            case err.POSITION_UNAVAILABLE: message = 'Ubicación no disponible.'; break;
            case err.TIMEOUT: message = 'La solicitud ha caducado.'; break;
            default: message = 'Error desconocido.'; break;
        }
        showError(message);
    }

    function showStatus(message, type) {
        statusDiv.innerHTML = message;
        if (type === 'success') {
            setTimeout(() => {
                if (statusDiv.innerHTML.includes('Éxito')) { statusDiv.innerHTML = ''; }
            }, 5000);
        }
    }
    
    function showError(message) {
        showStatus(`<div class="alert alert-danger"><strong>Error:</strong> ${message}</div>`, 'error');
        const allInputs = [latitudeInput, longitudeInput, addressInput, cityInput, postalcodeInput, countryInput];
        allInputs.forEach(input => input.placeholder = '-');
        resetButton();
    }

    function resetButton() {
        if (btnGetLocation) {
            btnGetLocation.disabled = false;
        }
    }


    document.addEventListener('DOMContentLoaded', () => {
        // ===================================================================
        // =========== LÓGICA DEL CRUD COMPLETO DE LA TABLA ==================
        // ===================================================================

        // --- Referencias a Elementos del DOM ---
        const searchInput = document.getElementById('searchInput');
        const tableBody = document.getElementById('resultsTableBody');
        const loadingState = document.getElementById('loading-state');
        const noResultsState = document.getElementById('no-results-state');
const apiUrl = 'http://localhost:3000/api/Geolocalizacion/puntos_geograficos';
        let allPuntos = [];

        // --- Referencias a los 4 botones de control y estado ---
        const btnModeCreate = document.getElementById('btn-mode-create');
        const btnModeView = document.getElementById('btn-mode-view');
        const btnModeDelete = document.getElementById('btn-mode-delete');
        const btnModeEdit = document.getElementById('btn-mode-edit');
        const modeButtons = [btnModeView, btnModeDelete, btnModeEdit]; // Los que cambian de modo
        let currentMode = 'view'; 

        // --- Referencias a los elementos del Modal ---
        const puntoModalEl = document.getElementById('puntoModal');
        const puntoModal = new bootstrap.Modal(puntoModalEl);
        const puntoModalLabel = document.getElementById('puntoModalLabel');
        const puntoForm = document.getElementById('puntoForm');
        const puntoIdInput = document.getElementById('punto-id');
        const puntoNombreInput = document.getElementById('punto-nombre');
        const puntoDescripcionInput = document.getElementById('punto-descripcion');
        const puntoLatitudInput = document.getElementById('punto-latitud');
        const puntoLongitudInput = document.getElementById('punto-longitud');
        const modalErrorDiv = document.getElementById('modal-error');

        // --- Referencias a los elementos del Modal de Confirmación ---
        const confirmationModalEl = document.getElementById('confirmationModal');
        const confirmationModal = new bootstrap.Modal(confirmationModalEl);
        const confirmationModalBody = document.getElementById('confirmationModalBody');
        const btnConfirmAccept = document.getElementById('btn-confirm-accept');
        const btnConfirmCancel = document.getElementById('btn-confirm-cancel');
        const btnCancelModal = document.getElementById('btn-cancelar-modal');
        if (btnCancelModal) {
            btnCancelModal.addEventListener('click', () => {
                puntoModal.hide();
            });
        }
// ===================================================================
// ================== INICIO: FUNCIÓN DE NOTIFICACIONES TOAST ==================
// ===================================================================

/**
 * Muestra una notificación tipo toast en la esquina inferior derecha.
 * @param {string} message - El mensaje a mostrar. Puede contener HTML.
 * @param {string} type - El tipo de alerta ('success' para verde, 'danger' para rojo).
 */
function showCrudAlert(message, type = 'success') {
    // 1. Encuentra el contenedor principal donde vivirán los toasts.
    const toastContainer = document.getElementById('toast-container');
    if (!toastContainer) {
        console.error('El contenedor de toasts (#toast-container) no se encuentra en el DOM.');
        return;
    }
    
    // 2. Crea el elemento HTML para la nueva notificación.
    const toast = document.createElement('div');
    toast.className = `toast-notification toast-${type}`;
    
    // 3. Define el contenido del toast, incluyendo el mensaje y un botón de cierre.
    toast.innerHTML = `
        <span>${message}</span>
        <button type="button" class="btn-close" aria-label="Close"></button>
    `;

    // 4. Añade el nuevo toast al contenedor. La animación de entrada se activa por CSS.
    toastContainer.appendChild(toast);

    // 5. Define una función para remover el toast de forma elegante.
    const removeToast = () => {
        // Añade la clase que activa la animación de salida.
        toast.classList.add('fade-out');
        
        // Escucha el final de la animación para remover el elemento del DOM de forma segura.
        toast.addEventListener('animationend', () => {
            // Se asegura de que el elemento todavía existe antes de intentar removerlo.
            if (toast.parentNode === toastContainer) {
                toastContainer.removeChild(toast);
            }
        });
    };

    // 6. Si es una notificación de éxito, se oculta sola después de 5 segundos.
    if (type === 'success') {
        setTimeout(removeToast, 5000);
    }

    // 7. Permite que el usuario cierre el toast manualmente haciendo clic en la 'X'.
    toast.querySelector('.btn-close').addEventListener('click', removeToast);
}

// ===================================================================
// ============= INICIO: NUEVA FUNCIÓN DE CONFIRMACIÓN ===============
// ===================================================================
/**
 * Muestra un modal de confirmación y devuelve una promesa.
 * @param {string} message - La pregunta de confirmación a mostrar.
 * @returns {Promise<boolean>} - Resuelve en true si se acepta, rechaza en false si se cancela.
 */
function showConfirmationModal(message) {
    return new Promise((resolve, reject) => {
        confirmationModalBody.textContent = message;
        confirmationModal.show();

        // Limpiamos listeners anteriores para evitar duplicados
        let acceptHandler, cancelHandler;

        acceptHandler = () => {
            btnConfirmAccept.removeEventListener('click', acceptHandler);
            btnConfirmCancel.removeEventListener('click', cancelHandler);
            confirmationModal.hide();
            resolve(true);
        };
        
        cancelHandler = () => {
            btnConfirmAccept.removeEventListener('click', acceptHandler);
            btnConfirmCancel.removeEventListener('click', cancelHandler);
            confirmationModal.hide();
            reject(false);
        };

        btnConfirmAccept.addEventListener('click', acceptHandler);
        btnConfirmCancel.addEventListener('click', cancelHandler);
    });
}
        // ===== FUNCIÓN renderTable MODIFICADA PARA 4 MODOS =====
        function renderTable(puntos) {
            tableBody.innerHTML = '';
            noResultsState.classList.add('d-none');
            if (puntos.length === 0) {
                noResultsState.classList.remove('d-none');
                noResultsState.textContent = 'No se encontraron resultados.';
                return;
            }

            puntos.forEach(punto => {
                const row = document.createElement('tr');
                let actionButtonHtml = '';

                switch (currentMode) {
                    case 'delete':
                        actionButtonHtml = `<button class="btn btn-sm btn-danger row-action-btn" data-action="delete" title="Borrar"><i class="bi bi-trash-fill"></i> Borrar</button>`;
                        break;
                    case 'edit':
                        actionButtonHtml = `<button class="btn btn-sm btn-warning row-action-btn" data-action="edit" title="Editar"><i class="bi bi-pencil-fill"></i> Editar</button>`;
                        break;
                    case 'view':
                    default:
                        actionButtonHtml = `<button class="btn btn-sm btn-info row-action-btn" data-action="view" title="Ver en Mapa"><i class="bi bi-map-fill"></i> Ver</button>`;
                        break;
                }

                row.innerHTML = `
                    <td>${punto.id}</td>
                    <td>${punto.nombre}</td>
                    <td>${punto.descripcion}</td>
                    <td class="text-center" data-id="${punto.id}">
                        ${actionButtonHtml}
                    </td>
                `;
                tableBody.appendChild(row);
            });
        }

        async function fetchPuntosGeograficos() {
            loadingState.classList.remove('d-none');
            tableBody.innerHTML = '';
            try {
                const response = await fetch(apiUrl);
                if (!response.ok) throw new Error(`Error de red: ${response.statusText}`);
                const data = await response.json();
                if (!data || !data[0]) throw new Error("Formato de API inesperado.");
                allPuntos = data[0].map(punto => ({
                    id: punto.id_punto_geografico,
                    nombre: punto.nombre_punto,
                    descripcion: punto.descripcion,
                    latitud: punto.latitud,
                    longitud: punto.longitud
                }));
                renderTable(allPuntos);
            } catch (error) {
                console.error('Error al obtener datos de la API:', error);
                noResultsState.textContent = 'Error al cargar los datos.';
                noResultsState.classList.remove('d-none');
            } finally {
                loadingState.classList.add('d-none');
            }
        }

        searchInput.addEventListener('input', (event) => {
            const searchTerm = event.target.value.toLowerCase();
            const filteredPuntos = allPuntos.filter(punto =>
                (punto.nombre && punto.nombre.toLowerCase().includes(searchTerm)) ||
                (punto.descripcion && punto.descripcion.toLowerCase().includes(searchTerm))
            );
            renderTable(filteredPuntos);
        });

        // ===== LISTENERS PARA LOS 4 BOTONES DE CONTROL =====
        modeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const newMode = button.id.split('-')[2];
                if (currentMode === newMode) return;
                currentMode = newMode;
                modeButtons.forEach(btn => btn.classList.remove('active'));
                button.classList.add('active');
                renderTable(allPuntos);
            });
        });

        btnModeCreate.addEventListener('click', () => {
            puntoForm.reset();
            puntoIdInput.value = '';
            puntoModalLabel.textContent = 'Crear Nuevo Punto Geográfico';
            modalErrorDiv.classList.add('d-none');
            puntoModal.show();
        });

         // ===== Listener de la tabla ACTUALIZADO con el nuevo modal de confirmación =====
        tableBody.addEventListener('click', async (event) => {
            const button = event.target.closest('.row-action-btn');
            if (!button) return;

            const puntoId = button.closest('td').dataset.id;
            const action = button.dataset.action;
            const punto = allPuntos.find(p => p.id == puntoId);
            if (!punto) return;

            switch (action) {
                case 'view':
                    if (punto.latitud && punto.longitud) {
                        window.open(`https://www.google.com/maps?q=${punto.latitud},${punto.longitud}`, '_blank');
                    }
                    break;
                case 'edit':
                    puntoForm.reset();
                    modalErrorDiv.classList.add('d-none');
                    puntoModalLabel.textContent = `Editando Punto #${punto.id}`;
                    puntoIdInput.value = punto.id;
                    puntoNombreInput.value = punto.nombre;
                    puntoDescripcionInput.value = punto.descripcion;
                    puntoLatitudInput.value = punto.latitud;
                    puntoLongitudInput.value = punto.longitud;
                    puntoModal.show();
                    break;
                case 'delete':
                    try {
                        // REEMPLAZO de confirm() por nuestro nuevo modal.
                        await showConfirmationModal(`¿Seguro que quieres borrar "${punto.nombre}"?`);
                        
                        // Si el usuario acepta, el código continúa aquí.
                        const response = await fetch(`${apiUrl}/${puntoId}`, { method: 'DELETE' });
                        if (!response.ok) throw new Error('El servidor no pudo borrar el registro.');
                        
                        await fetchPuntosGeograficos();
                        showCrudAlert(`<strong>¡Éxito!</strong> El punto "${punto.nombre}" ha sido borrado.`, 'success');

                    } catch (error) {
                        // Si el usuario cancela o hay un error de red, el código entra aquí.
                        if (error && error.message) {
                            showCrudAlert(`<strong>Error:</strong> ${error.message}`, 'danger');
                        } else {
                            console.log('Borrado cancelado por el usuario.');
                        }
                    }
                    break;
            }
        });

        // ===== LISTENER PARA EL FORMULARIO DEL MODAL (INSERT/UPDATE) =====
        puntoForm.addEventListener('submit', async (event) => {
            event.preventDefault();
            const id = puntoIdInput.value;
            const esUpdate = !!id;
            const data = {
                nombre_punto: puntoNombreInput.value,
                descripcion: puntoDescripcionInput.value,
                latitud: puntoLatitudInput.value,
                longitud: puntoLongitudInput.value
            };
            const url = esUpdate ? `${apiUrl}/${id}` : apiUrl;
            const method = esUpdate ? 'PUT' : 'POST';

            try {
                const response = await fetch(url, {
                    method: method,
                    headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
                    body: JSON.stringify(data)
                });
                if (!response.ok) {
                    const errorData = await response.json().catch(() => ({ message: 'Error desconocido' }));
                    throw new Error(errorData.message);
                }
                puntoModal.hide();

                await fetchPuntosGeograficos();

              const successMessage = `<strong>¡Guardado!</strong> El punto "${data.nombre_punto}" se ha ${esUpdate ? 'actualizado' : 'creado'} con éxito.`;
        showCrudAlert(successMessage, 'success');
            } catch (error) {
                modalErrorDiv.textContent = `Error: ${error.message}`;
                modalErrorDiv.classList.remove('d-none');
                 // Pero también podemos mostrar una alerta global para mayor visibilidad.
        showCrudAlert(`<strong>Error al guardar:</strong> ${error.message}`, 'danger');
            }
        });

        // Carga inicial de datos
        fetchPuntosGeograficos();

              // --- INICIO: SCRIPT PARA INTERACCIÓN DE TARJETAS DE PARQUES Y MAPA (SIN CAMBIOS) ---
        const parkButtons = document.querySelectorAll('.park-card-btn');
        const mapIframe = document.getElementById('embedded-map');

        // Función para actualizar el mapa
        const updateMap = (lat, lon) => {
            if (!mapIframe) {
                console.error('El iframe del mapa no fue encontrado.');
                return;
            }
            // Construye la nueva URL para el iframe con un marcador en la ubicación
            const embedUrl = `https://www.openstreetmap.org/export/embed.html?bbox=${lon-0.1},${lat-0.1},${lon+0.1},${lat+0.1}&layer=mapnik&marker=${lat},${lon}`;
            mapIframe.src = embedUrl;
        };

        // Añade un listener a cada botón de parque
        parkButtons.forEach(button => {
            button.addEventListener('click', (event) => {
                event.preventDefault(); // Evita que la página salte al hacer clic en el enlace "#"
                
                // Obtiene la latitud y longitud desde los atributos data-*
                const lat = parseFloat(button.dataset.lat);
                const lon = parseFloat(button.dataset.lon);

                if (lat && lon) {
                    updateMap(lat, lon);
                } else {
                    console.error('Coordenadas no encontradas en el botón:', button);
                }
            });
        });

        // Opcional: Cargar la ubicación del primer parque por defecto al cargar la página
        if (parkButtons.length > 0) {
            const firstButton = parkButtons[0];
            const initialLat = parseFloat(firstButton.dataset.lat);
            const initialLon = parseFloat(firstButton.dataset.lon);
            if (initialLat && initialLon) {
                updateMap(initialLat, initialLon);
            }
        }
        // --- FIN: SCRIPT DE PARQUES (SIN CAMBIOS) ---

    });

    // --- SCRIPT PARA EL MAPA MUNDIAL (jsvectormap) (SIN CAMBIOS) ---
    if (document.getElementById('world-map')) {
        new jsVectorMap({ selector: '#world-map', map: 'world' });
    }
    </script>
@endpush