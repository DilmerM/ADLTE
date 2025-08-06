@extends('adminlte::page')

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

    {{-- Incluye tus scripts JS tal cual estaban antes --}}
    <script>


// El script para la tarjeta del clima se mantiene igual
document.addEventListener('DOMContentLoaded', function() {
    const city = 'Tegucigalpa';
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
            weatherCardBody.innerHTML = `<p class="text-danger">No se pudo cargar el clima. Revisa la consola para más detalles.</p>`;
        });

    // Aquí iría el script para la geolocalización y el buscador.
});




       // --- INICIO SCRIPT GEOLOCALIZACIÓN ---
    const btnGetLocation = document.getElementById('btnGetLocation');
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
// =========== LÓGICA DEL BUSCADOR DE PUNTOS GEOGRÁFICOS =============
// ===================================================================

const searchInput = document.getElementById('searchInput');
const tableBody = document.getElementById('resultsTableBody');
const loadingState = document.getElementById('loading-state');
const noResultsState = document.getElementById('no-results-state');

let allPuntos = [];

function renderTable(puntos) {
    tableBody.innerHTML = '';
    noResultsState.classList.add('d-none');

    if (puntos.length === 0) {
        noResultsState.classList.remove('d-none');
        noResultsState.textContent = 'No se encontraron resultados para tu búsqueda.';
        return;
    }

    puntos.forEach(punto => {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td>${punto.id}</td>
            <td>${punto.nombre}</td>
            <td>${punto.descripcion}</td>
            <td class="text-center">
                <button class="btn btn-sm btn-info btn-view-location" data-lat="${punto.latitud}" data-lon="${punto.longitud}" title="Ver en Google Maps">
                    <i class="bi bi-map-fill"></i> Ver
                </button>
            </td>
        `;
        tableBody.appendChild(row);
    });
}

async function fetchPuntosGeograficos() {
    loadingState.classList.remove('d-none');
    tableBody.innerHTML = '';
    noResultsState.classList.add('d-none');

    const apiUrl = 'http://localhost:3000/Geolocalizacion/puntos_geograficos';

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
        noResultsState.textContent = 'Error al cargar los datos. Revisa la consola o el estado de la API.';
        noResultsState.classList.remove('d-none');
    } finally {
        loadingState.classList.add('d-none');
    }
}

searchInput.addEventListener('input', (event) => {
    const searchTerm = event.target.value.toLowerCase();

    if (allPuntos.length === 0 && searchTerm) {
        noResultsState.textContent = 'Los datos aún no han cargado o no hay puntos para filtrar.';
        noResultsState.classList.remove('d-none');
        return;
    }

    const filteredPuntos = allPuntos.filter(punto =>
        (punto.nombre && punto.nombre.toLowerCase().includes(searchTerm)) ||
        (punto.descripcion && punto.descripcion.toLowerCase().includes(searchTerm))
    );

    renderTable(filteredPuntos);
});

tableBody.addEventListener('click', (event) => {
    const button = event.target.closest('.btn-view-location');
    if (button) {
        const lat = button.dataset.lat;
        const lon = button.dataset.lon;
        if (lat && lon) {
            // ✅ URL corregida para abrir Google Maps con coordenadas dinámicas
            const url = `https://www.google.com/maps?q=${lat},${lon}`;
            window.open(url, '_blank');
        }
    }
});

// ✅ Llama a la API automáticamente al cargar la página
fetchPuntosGeograficos();


        // --- INICIO: NUEVO SCRIPT PARA INTERACCIÓN DE TARJETAS DE PARQUES Y MAPA ---
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
        // --- FIN: NUEVO SCRIPT ---

    });

    // --- SCRIPT PARA EL MAPA MUNDIAL (jsvectormap) ---
    if (document.getElementById('world-map')) {
        new jsVectorMap({ selector: '#world-map', map: 'world' });
    }
    
    </script>
@endpush
