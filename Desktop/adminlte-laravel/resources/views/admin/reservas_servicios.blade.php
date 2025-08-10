@extends('admin.app')
@section('title', 'Reservas y Servicios')
@section('page-title', 'Reservas y Servicios')


@section('content')
    <div class="content-wrapper">
        <!-- Header -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                         
                    </div>
                    <div class="col-sm-6">
                        <div class="float-sm-right">
                            <button class="btn btn-primary" onclick="toggleAdminPanel()">
                                <i class="fas fa-cog"></i> Panel Administrativo
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                
                <!-- Servicios Disponibles -->
                <div id="serviciosSection">
                    <div class="row mb-4">
                        <div class="col-12">
                            <h3><i class="fas fa-concierge-bell"></i> Servicios Disponibles</h3>
                        </div>
                    </div>
                    
                    <!-- Loading Spinner -->
                    <div id="loadingServices" class="loading-spinner">
                        <div class="spinner-border" role="status">
                            <span class="sr-only">Cargando servicios...</span>
                        </div>
                    </div>
                    
                    <!-- Services Grid -->
                    <div id="servicesGrid" class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4" style="display: none;">
                        <!-- Services will be loaded here -->
                    </div>
                </div>

                <!-- Panel Administrativo -->
                <div id="adminPanel" class="admin-section" style="display: none;">
                    <div class="admin-header text-center">
                        <h2><i class="fas fa-tools"></i> Panel Administrativo</h2>
                        <p class="mb-0">Gestiona servicios y reservas</p>
                    </div>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#serviciosAdmin" role="tab">
                                <i class="fas fa-list"></i> Gestionar Servicios
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#reservasAdmin" role="tab">
                                <i class="fas fa-calendar-check"></i> Gestionar Reservas
                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        <!-- Servicios Tab -->
                        <div class="tab-pane fade show active" id="serviciosAdmin" role="tabpanel">
                            <div class="mb-3">
                                <button class="btn btn-success" onclick="showServiceModal()">
                                    <i class="fas fa-plus"></i> Nuevo Servicio
                                </button>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Costo Base</th>
                                            <th>Duración</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="serviciosTableBody">
                                        <!-- Services will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Reservas Tab -->
                        <div class="tab-pane fade" id="reservasAdmin" role="tabpanel">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Servicio</th>
                                            <th>Tipo</th>
                                            <th>Descripción</th>
                                            <th>Costo Base</th>
                                            <th>Duración</th>
                                            <th>Cliente</th>
                                            <th>Fecha Inicio</th>
                                            <th>Ubicación</th>
                                            <th>Notas</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="reservasTableBody">
                                        <!-- Reservations will be loaded here -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Modal para Reservas -->
   <div class="modal fade" id="reservaModal" tabindex="-1" role="dialog" aria-labelledby="reservaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="reservaModalLabel">Nueva Reserva</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="reservaForm">
                <div class="modal-body">
                    <input type="hidden" id="id_usuario" name="id_usuario">
                    <input type="hidden" id="nombre_persona" name="nombre_persona">
                    <input type="hidden" id="nombre_servicio" name="nombre_servicio">
                    <div class="form-group">
                        <label for="tipo_servicio">Tipo de Servicio</label>
                        <input type="text" class="form-control" id="tipo_servicio" name="tipo_servicio" readonly>
                    </div>
                    <div class="form-group">
                        <label for="descripcion_servicio">Descripción del Servicio</label>
                        <textarea class="form-control" id="descripcion_servicio" name="descripcion_servicio" rows="2" readonly></textarea>
                    </div>
                    <div class="form-group">
                        <label for="costo_base">Costo Base (L.)</label>
                        <input type="number" class="form-control" id="costo_base" name="costo_base" step="0.01" min="0" readonly>
                    </div>
                    <div class="form-group">
                        <label for="duracion_promedio_minutos">Duración Promedio (minutos)</label>
                        <input type="number" class="form-control" id="duracion_promedio_minutos" name="duracion_promedio_minutos" min="1" readonly>
                    </div>
                    <!-- <div class="form-group">
                        <label for="disponible_online">Disponible Online</label>
                        <input type="text" class="form-control" id="disponible_online" name="disponible_online" readonly>
                    </div> -->
                    <div class="form-group">
                        <label for="servicioNombre">Servicio</label>
                        <input type="text" class="form-control" id="servicioNombre" readonly>
                    </div>
                    <div class="form-group">
                        <label for="nombreUsuario">Nombre del Usuario</label>
                        <input type="text" class="form-control" id="nombreUsuario" readonly>
                    </div>
                    <div class="form-group">
                        <label for="fecha_servicio">Fecha y Hora del Servicio</label>
                        <input type="datetime-local" class="form-control" id="fecha_servicio" name="fecha_servicio" required>
                    </div>
                    <div class="form-group">
                        <label for="ubicacion">Ubicación</label>
                        <input type="text" class="form-control" id="ubicacion" name="ubicacion" required>
                    </div>
                    <div class="form-group">
                        <label for="notas">Notas</label>
                        <textarea class="form-control" id="notas" name="notas" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Confirmar Reserva</button>
                </div>
            </form>
        </div>
    </div>
</div>

    <!-- Modal para Gestión de Servicios -->
    <div class="modal fade" id="servicioModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="servicioModalTitle">Nuevo Servicio</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="servicioForm" enctype="multipart/form-data">
                    <div class="modal-body">
                        <input type="hidden" id="servicioEditId" name="id_servicio">
                        <div class="form-group">
                            <label for="nombreServicio">Nombre del Servicio</label>
                            <input type="text" class="form-control" id="nombreServicio" name="nombre_servicio" required>
                        </div>
                        <div class="form-group">
                            <label for="descripcionServicio">Descripción</label>
                            <textarea class="form-control" id="descripcionServicio" name="descripcion" rows="3" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="tipoServicio">Tipo de Servicio</label>
                            <select class="form-control" id="tipoServicio" name="tipo_servicio" required>
                                <option value="Tour">Tour</option>
                                <option value="Camping">Camping</option>
                                <option value="Avistamiento">Avistamiento</option>
                                <option value="Aventura">Aventura</option>
                                <option value="Relajación">Relajación</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="costoBase">Costo Base</label>
                            <input type="number" class="form-control" id="costoBase" name="costo_base" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label for="duracionPromedio">Duración Promedio (minutos)</label>
                            <input type="number" class="form-control" id="duracionPromedio" name="duracion_promedio_minutos" required>
                        </div>
                        <div class="form-group">
                            <label for="imagenServicio">Imagen del Servicio</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="imagenServicio" name="imagen" accept="image/*">
                                <label class="custom-file-label" for="imagenServicio">Seleccionar imagen</label>
                            </div>
                            <img id="previewImagen" src="#" alt="Vista previa" style="display:none; max-width: 100%; margin-top: 10px;">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Servicio</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal de Detalles de Reserva -->
<div class="modal fade" id="detalleReservaModal" tabindex="-1" role="dialog" aria-labelledby="detalleReservaModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title" id="detalleReservaModalLabel">
                    <i class="fas fa-info-circle"></i> Detalles de la Reserva
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-hashtag"></i> ID:</strong>
                            <span id="detalle_id"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-concierge-bell"></i> Servicio:</strong>
                            <span id="detalle_servicio"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-user-circle"></i> Nombre Cliente:</strong>
                            <span id="detalle_cliente_nombre"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-dollar-sign"></i> Costo Base:</strong>
                            <span id="detalle_costo_base"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-calendar-alt"></i> Fecha Inicio:</strong>
                            <span id="detalle_fecha_inicio"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-clock"></i> Duración:</strong>
                            <span id="detalle_duracion"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-map-marker-alt"></i> Ubicación:</strong>
                            <span id="detalle_ubicacion"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-toggle-on"></i> Estado:</strong>
                            <span id="detalle_estado"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

    <!-- Modal de Actualizar Estado de Reserva -->
<div class="modal fade" id="actualizarEstadoModal" tabindex="-1" role="dialog" aria-labelledby="actualizarEstadoModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="actualizarEstadoModalLabel">
                    <i class="fas fa-edit"></i> Actualizar Estado de Reserva
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-hashtag"></i> ID:</strong>
                            <span id="actualizar_id"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-concierge-bell"></i> Servicio:</strong>
                            <span id="actualizar_servicio"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-user-circle"></i> Cliente:</strong>
                            <span id="actualizar_cliente_nombre"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-calendar-alt"></i> Fecha:</strong>
                            <span id="actualizar_fecha_inicio"></span>
                        </div>
                        <div class="detail-item mb-3">
                            <strong><i class="fas fa-toggle-on"></i> Estado:</strong>
                            <select id="actualizar_estado" class="form-control">
                                <option value="pendiente">Pendiente</option>
                                <option value="confirmada">Confirmada</option>
                                <option value="cancelada">Cancelada</option>
                                <option value="completada">Completada</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-warning" onclick="guardarCambiosEstado()">Guardar Cambios</button>
            </div>
        </div>
    </div>
</div>

@stop


@section('css')
    <style>
        /* Ajuste del contenedor principal */
        .content-wrapper {
            margin-left: 0 !important; /* Elimina el margen izquierdo extra */
            padding-left: 0 !important; /* Elimina el padding izquierdo */
        }

        /* Ajuste del contenedor de servicios */
        .container-fluid {
            padding-left: 15px !important; /* Reduce el padding izquierdo */
            max-width: 100% !important; /* Asegura que use todo el ancho disponible */
        }

        /* Variables de colores */
        :root {
            --success-color: #28a745;
            --primary-color: #007bff;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
        }

        .content-header h1 {
            color: var(--success-color);
            font-weight: 700;
        }

        .service-card {
            transition: all 0.3s ease;
            border: 2px solid #e3f2fd;
            margin-bottom: 20px;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
            border-color: var(--success-color);
        }

        .service-card .card-img-top {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .service-card:hover .card-img-top {
            transform: scale(1.05);
        }

        .service-card .card-body {
            padding: 1.5rem;
            flex: 1 1 auto;
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
        }

        .service-card .card-title {
            color: var(--success-color);
            font-weight: 600;
            margin-bottom: 1rem;
        }

        .service-price {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--primary-color);
            margin: 10px 0;
        }

        .service-duration {
            font-size: 0.9rem;
            color: #666;
            margin-bottom: 15px;
        }

        .btn-reserve {
            background: linear-gradient(135deg, var(--success-color), #20c997);
            border: none;
            border-radius: 25px;
            padding: 10px 30px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
        }

        .btn-reserve:hover {
            background: linear-gradient(135deg, #1e7e34, #17a2b8);
            transform: translateY(-2px);
            box-shadow: 0 8px 15px rgba(0,0,0,0.2);
        }

        .modal-header {
            background: linear-gradient(135deg, var(--success-color), #20c997);
            color: white;
            border-radius: 10px 10px 0 0;
        }

        .modal-content {
            border-radius: 15px;
            border: none;
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .form-control {
            border-radius: 10px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--success-color);
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }

        .admin-section {
            background: #f8f9fa;
            border-radius: 15px;
            padding: 30px;
            margin: 30px 0;
            border: 2px solid #e9ecef;
        }

        .admin-header {
            background: linear-gradient(135deg, var(--primary-color), var(--info-color));
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
        }

        .table th {
            background: linear-gradient(135deg, #28a745, #20c997);
            color: white;
            border: none;
            padding: 12px 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            text-align: center;
        }

        .table td {
            padding: 12px 15px;
            vertical-align: middle;
            text-align: center;
            border-bottom: 1px solid #e9ecef;
        }

        .table tbody tr:hover {
            background-color: #f8f9fa;
            transition: background-color 0.2s ease;
        }

        .table {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }

        .btn-action {
            margin: 2px;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.875rem;
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }

        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }

        .loading-spinner {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 200px;
        }

        .spinner-border {
            color: var(--success-color);
        }

        .nav-tabs .nav-link.active {
            background-color: var(--success-color);
            color: white;
            border-color: var(--success-color);
        }

        .tab-content {
            padding: 25px;
            background: white;
            border-radius: 0 0 15px 15px;
        }

        .detail-item {
            padding: 10px;
            border-bottom: 1px solid #eee;
        }
        .detail-item:last-child {
            border-bottom: none;
        }
        .detail-item strong {
            display: inline-block;
            width: 120px;
            color: #666;
        }
        .detail-item i {
            margin-right: 8px;
            color: var(--info-color);
        }

        @media (max-width: 768px) {
            #servicesGrid {
                flex-direction: column !important;
            }
            .service-card {
                margin-bottom: 15px;
                height: auto;
            }
            .service-card .card-img-top {
                height: 160px;
            }
            .admin-section {
                padding: 15px;
                margin: 15px 0;
            }
        }
    </style>
@stop

@push('js')


    <!-- Scripts -->
    <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.7.32/sweetalert2.all.min.js"></script>

    <script>
        // Configuración de la API
        const API_BASE_URL = 'http://localhost:3000';
        const SERVICIOS_API = `${API_BASE_URL}/servicios`;
        const RESERVAS_API = `${API_BASE_URL}/api/reservas2`;
        
        // Variables globales
        let servicios = [];
        let reservas = [];
        let currentUser = null;

        // Inicializar aplicación
        document.addEventListener('DOMContentLoaded', function() {
            initializeApp();
        });

        function initializeApp() {
            // Verificar autenticación
            const authToken = localStorage.getItem('authToken');
            const userData = localStorage.getItem('userData');
            
            if (authToken && userData) {
                currentUser = JSON.parse(userData);
            }
            
            // Cargar datos iniciales
            loadServicios();
            
            // Configurar event listeners
            setupEventListeners();
            
            // Configurar fecha mínima en los campos de fecha
            const now = new Date();
            const minDateTime = now.toISOString().slice(0, 16);
            document.getElementById('fechaInicio').min = minDateTime;
            document.getElementById('fechaFin').min = minDateTime;
        }

        function setupEventListeners() {
            // Form de reserva
            document.getElementById('reservaForm').addEventListener('submit', handleReservaSubmit);
            
            // Form de servicio
            document.getElementById('servicioForm').addEventListener('submit', handleServicioSubmit);
            
            // Cambio de fecha de inicio para ajustar fecha fin
            document.getElementById('fechaInicio').addEventListener('change', function() {
                const fechaInicio = new Date(this.value);
                const fechaFin = document.getElementById('fechaFin');
                
                if (fechaInicio) {
                    // Establecer fecha mínima de fin como la fecha de inicio
                    fechaFin.min = this.value;
                    
                    // Si la fecha de fin es menor que la de inicio, ajustarla
                    if (fechaFin.value && new Date(fechaFin.value) <= fechaInicio) {
                        const newEndDate = new Date(fechaInicio);
                        newEndDate.setHours(newEndDate.getHours() + 2); // Por defecto 2 horas después
                        fechaFin.value = newEndDate.toISOString().slice(0, 16);
                    }
                }
                
                calculateTotalCost();
            });
            
            document.getElementById('fechaFin').addEventListener('change', calculateTotalCost);
        }

        // Cargar servicios desde la API
        async function loadServicios() {
            try {
                showLoading(true);
                const response = await fetch(SERVICIOS_API);
                
                if (!response.ok) {
                    throw new Error(`Error ${response.status}: ${response.statusText}`);
                }
                
                servicios = await response.json();
                displayServicios();
                if (document.getElementById('adminPanel').style.display !== 'none') {
                    displayServiciosAdmin();
                }
                
            } catch (error) {
                console.error('Error al cargar servicios:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al cargar servicios',
                    text: 'No se pudieron cargar los servicios. Por favor, intente nuevamente.',
                    footer: error.message
                });
            } finally {
                showLoading(false);
            }
        }

        // Mostrar servicios en cards
        function displayServicios() {
            const container = document.getElementById('servicesGrid');
            
            if (!servicios || servicios.length === 0) {
                container.innerHTML = `
                    <div class="col-12 text-center">
                        <div class="alert alert-info">
                            <h4><i class="fas fa-info-circle"></i> Sin servicios disponibles</h4>
                            <p>Actualmente no hay servicios disponibles para reservar.</p>
                        </div>
                    </div>
                `;
                return;
            }

            const cardsHtml = servicios.map(servicio => {
                const duration = formatDuration(servicio.duracion_promedio_minutos);
                const imageUrl = getServiceImage(servicio);
                return `
                    <div class="col-md-4 col-sm-6">
                        <div class="card service-card">
                            <img src="${imageUrl}" class="card-img-top" alt="${servicio.nombre_servicio}">
                            <div class="card-body">
                                <h5 class="card-title">${servicio.nombre_servicio}</h5>
                                <p class="card-text">${servicio.descripcion}</p>
                                <div class="service-price">L. ${parseFloat(servicio.costo_base).toFixed(2)}</div>
                                <div class="service-duration">
                                    <i class="fas fa-clock"></i> ${duration}
                                </div>
                                <button class="btn btn-reserve btn-block" onclick="openReservaModal(${servicio.id_servicio})">
                                    <i class="fas fa-calendar-plus"></i> Reservar
                                </button>
                            </div>
                        </div>
                    </div>
                `;
            }).join('');

            container.innerHTML = cardsHtml;
            container.style.display = 'flex';
        }

        // Obtener imagen del servicio
        function getServiceImage(servicio) {
            if (servicio.ruta_imagen) {
                return servicio.ruta_imagen;
            }
            
            // Imágenes predeterminadas según el tipo
            const images = {
                'Tour': 'https://source.unsplash.com/400x250/?forest,hiking,tour',
                'Camping': 'https://source.unsplash.com/400x250/?camping,tent,nature',
                'Avistamiento': 'https://source.unsplash.com/400x250/?birds,wildlife,binoculars',
                'Aventura': 'https://source.unsplash.com/400x250/?adventure,extreme,sports',
                'Relajación': 'https://source.unsplash.com/400x250/?spa,relax,wellness'
            };
            
            return images[servicio.tipo_servicio] || 'https://source.unsplash.com/400x250/?nature,park,green';
        }

        // Formatear duración
        function formatDuration(minutes) {
            if (minutes < 60) {
                return `${minutes} minutos`;
            } else {
                const hours = Math.floor(minutes / 60);
                const remainingMinutes = minutes % 60;
                if (remainingMinutes === 0) {
                    return `${hours} ${hours === 1 ? 'hora' : 'horas'}`;
                } else {
                    return `${hours}h ${remainingMinutes}min`;
                }
            }
        }

        // Abrir modal de reserva
        function openReservaModal(servicioId) {
            const servicio = servicios.find(s => s.id_servicio == servicioId);
            if (!servicio) {
                Swal.fire('Error', 'Servicio no encontrado', 'error');
                return;
            }
            document.getElementById('servicioNombre').value = servicio.nombre_servicio;
            document.getElementById('nombre_servicio').value = servicio.nombre_servicio;
            document.getElementById('tipo_servicio').value = servicio.tipo_servicio;
            document.getElementById('descripcion_servicio').value = servicio.descripcion;
            document.getElementById('costo_base').value = servicio.costo_base;
            document.getElementById('duracion_promedio_minutos').value = servicio.duracion_promedio_minutos;
            // document.getElementById('disponible_online').value = servicio.disponible_online ? 1 : 0;
            const userData = localStorage.getItem('userData');
            let nombreCompleto = '';
            if (userData) {
                const user = JSON.parse(userData);
                document.getElementById('id_usuario').value = user.id_usuario;
                if (user.primer_nombre || user.primer_apellido) {
                    nombreCompleto = `${user.primer_nombre || ''} ${user.primer_apellido || ''}`.trim();
                } else if (user.nombre_usuario) {
                    nombreCompleto = user.nombre_usuario;
                }
                document.getElementById('nombreUsuario').value = nombreCompleto;
                document.getElementById('nombre_persona').value = nombreCompleto;
            } else {
                document.getElementById('nombreUsuario').value = '';
                document.getElementById('nombre_persona').value = '';
            }
            document.getElementById('fecha_servicio').value = '';
            document.getElementById('ubicacion').value = '';
            document.getElementById('notas').value = '';
            $('#reservaModal').modal('show');
        }

        // Calcular costo total basado en duración
        function calculateTotalCost() {
            const servicioId = document.getElementById('servicioId').value;
            const fechaInicio = document.getElementById('fechaInicio').value;
            const fechaFin = document.getElementById('fechaFin').value;
            
            if (!servicioId || !fechaInicio || !fechaFin) return;
            
            const servicio = servicios.find(s => s.id_servicio == servicioId);
            if (!servicio) return;
            
            const inicio = new Date(fechaInicio);
            const fin = new Date(fechaFin);
            const diffMinutes = (fin - inicio) / (1000 * 60);
            
            if (diffMinutes <= 0) {
                document.getElementById('costoTotal').value = 'Fechas inválidas';
                return;
            }
            
            // Calcular costo basado en la duración
            const duracionBase = servicio.duracion_promedio_minutos;
            const costoBase = parseFloat(servicio.costo_base);
            let costoTotal = costoBase;
            
            if (diffMinutes > duracionBase) {
                // Costo adicional por tiempo extra (50% más por cada período adicional)
                const periodosExtra = Math.ceil((diffMinutes - duracionBase) / duracionBase);
                costoTotal += (costoBase * 0.5 * periodosExtra);
            }
            
            document.getElementById('costoTotal').value = `L. ${costoTotal.toFixed(2)}`;
        }


        // Función para crear reservas corregida
async function handleReservaSubmit(e) {
    e.preventDefault();
    
    const formData = new FormData(e.target);
    const authToken = localStorage.getItem('authToken');
    const userData = JSON.parse(localStorage.getItem('userData') || '{}');
    
    if (!authToken || !userData.id_persona) {
        await Swal.fire({
            icon: 'error',
            title: 'No autenticado',
            text: 'Debes iniciar sesión para hacer reservas',
        });
        return;
    }

    const costoTotal = formData.get('costo_total').replace('L. ', '');
    
    // Objeto de reserva con nombres de campos corregidos
    const reservaData = {
        id_servicio: parseInt(formData.get('id_servicio')),  // Cambiado de id_service a id_servicio
        fecha_hora_inicio: formData.get('fecha_hora_inicio'),
        fecha_hora_fin: formData.get('fecha_hora_fin') || null,
        estado_reserva: 'Pendiente',
        costo_total: parseFloat(costoTotal),
        id_ubicacion_reserva: null,
        id_evento: null,
        id_actividad: null
    };

    try {
        const response = await fetch('http://localhost:3000/reservas', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'auth-token': authToken
            },
            body: JSON.stringify(reservaData)
        });

        const data = await response.json();
        
        if (!response.ok) {
            throw new Error(data.message || 'Error al crear la reserva');
        }

        await Swal.fire({
            icon: 'success',
            title: '¡Reserva Confirmada!',
            html: `
                <div class="text-left">
                    <p><strong>ID Reserva:</strong> ${data.id_reserva}</p>
                    <p><strong>Servicio:</strong> ${formData.get('servicioNombre')}</p>
                    <p><strong>Fecha:</strong> ${new Date(reservaData.fecha_hora_inicio).toLocaleString()}</p>
                </div>
            `,
            confirmButtonText: 'Entendido'
        });

        $('#reservaModal').modal('hide');
        
    } catch (error) {
        console.error('Error al crear reserva:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Error al crear reserva',
            text: error.message
        });
    }
}
        // Toggle panel administrativo
        function toggleAdminPanel() {
            const panel = document.getElementById('adminPanel');
            const isVisible = panel.style.display !== 'none';
            
            if (isVisible) {
                panel.style.display = 'none';
                document.querySelector('button[onclick="toggleAdminPanel()"]').innerHTML = 
                    '<i class="fas fa-cog"></i> Panel Administrativo';
            } else {
                panel.style.display = 'block';
                document.querySelector('button[onclick="toggleAdminPanel()"]').innerHTML = 
                    '<i class="fas fa-eye-slash"></i> Ocultar Panel';
                loadReservas();
                displayServiciosAdmin();
            }
        }

        // Cargar reservas
        async function loadReservas() {
            try {
                const response = await fetch(RESERVAS_API);
                if (!response.ok) throw new Error('Error al cargar reservas');
                const result = await response.json();
                reservas = result.data || [];
                displayReservasAdmin();
            } catch (error) {
                console.error('Error al cargar reservas:', error);
                document.getElementById('reservasTableBody').innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center text-danger">
                            Error al cargar reservas: ${error.message}
                        </td>
                    </tr>
                `;
            }
        }

        // Mostrar servicios en tabla admin
        function displayServiciosAdmin() {
            const tbody = document.getElementById('serviciosTableBody');
            
            if (!servicios || servicios.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">No hay servicios registrados</td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = servicios.map(servicio => `
                <tr>
                    <td>${servicio.id_servicio}</td>
                    <td>${servicio.nombre_servicio}</td>
                    <td><span class="badge badge-info">${servicio.tipo_servicio}</span></td>
                    <td>L. ${parseFloat(servicio.costo_base).toFixed(2)}</td>
                    <td>${formatDuration(servicio.duracion_promedio_minutos)}</td>
                    <!-- <td>
                        ${servicio.disponible_online ? 
                            '<span class="badge badge-success">Sí</span>' : 
                            '<span class="badge badge-secondary">No</span>'
                        }
                    </td> -->
                    <td>
                        <button class="btn btn-sm btn-primary btn-action" onclick="editServicio(${servicio.id_servicio})">
    <i class="fas fa-edit"></i>
</button>
                        <button class="btn btn-sm btn-danger btn-action" onclick="deleteServicio(${servicio.id_servicio})">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        // Mostrar reservas en tabla admin
        function displayReservasAdmin() {
            const tbody = document.getElementById('reservasTableBody');
            
            if (!reservas || reservas.length === 0) {
                tbody.innerHTML = `
                    <tr>
                        <td colspan="7" class="text-center">No hay reservas registradas</td>
                    </tr>
                `;
                return;
            }

            tbody.innerHTML = reservas.map(reserva => {
                // Mostrar solo el nombre de usuario
                const clienteNombre = reserva.nombre_usuario || 'N/A';
                // Datos completos del servicio
                const servicioNombre = reserva.nombre_servicio || 'Servicio no encontrado';
                const tipoServicio = reserva.tipo_servicio || '';
                const descripcionServicio = reserva.descripcion_servicio || '';
                const costoBase = reserva.costo_base ? `L. ${parseFloat(reserva.costo_base).toFixed(2)}` : '';
                const duracion = reserva.duracion_promedio_minutos ? `${reserva.duracion_promedio_minutos} min` : '';
                // const online = reserva.disponible_online == 1 || reserva.disponible_online === '1' ? '<span class="badge badge-success">Sí</span>' : '<span class="badge badge-secondary">No</span>';
                const fechaInicio = reserva.fecha_servicio ? new Date(reserva.fecha_servicio).toLocaleString() : '';
                const ubicacion = reserva.ubicacion || '';
                const notas = reserva.notas || '';
                return `
                    <tr>
                        <td>${reserva.id_reserva}</td>
                        <td>${servicioNombre}</td>
                        <td>${tipoServicio}</td>
                        <td>${descripcionServicio}</td>
                        <td>${costoBase}</td>
                        <td>${duracion}</td>
                        <td>${clienteNombre}</td>
                        <td>${fechaInicio}</td>
                        <td>${ubicacion}</td>
                        <td>${notas}</td>
                        <td>
                            <span class="status-badge status-${reserva.estado_reserva ? reserva.estado_reserva.toLowerCase() : 'pendiente'}">
                                ${reserva.estado_reserva || 'pendiente'}
                            </span>
                        </td>
                        <!-- <td>L. ${parseFloat(reserva.costo_total || 0).toFixed(2)}</td> -->
                        <td>
                            <button class="btn btn-sm btn-info btn-action" onclick="verDetallesReserva(${reserva.id_reserva})">
                                <i class="fas fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-warning btn-action" onclick="abrirActualizarEstado(${reserva.id_reserva})">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button class="btn btn-sm btn-danger btn-action" onclick="deleteReserva(${reserva.id_reserva})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </td>
                    </tr>
                `;
            }).join('');
        }

        // Mostrar modal de servicio
        function showServiceModal(servicioId = null) {
            const modal = document.getElementById('servicioModal');
            const form = document.getElementById('servicioForm');
            const title = document.getElementById('servicioModalTitle');
            
            // Limpiar formulario
            form.reset();
            
            if (servicioId) {
                // Modo edición
                const servicio = servicios.find(s => s.id_servicio == servicioId);
                if (servicio) {
                    title.textContent = 'Editar Servicio';
                    document.getElementById('servicioEditId').value = servicio.id_servicio;
                    document.getElementById('nombreServicio').value = servicio.nombre_servicio;
                    document.getElementById('tipoServicio').value = servicio.tipo_servicio;
                    document.getElementById('descripcionServicio').value = servicio.descripcion;
                    document.getElementById('costoBase').value = servicio.costo_base;
                    document.getElementById('duracionPromedio').value = servicio.duracion_promedio_minutos;
                    
                    // Mostrar la imagen actual si existe
                    const previewImagen = document.getElementById('previewImagen');
                    if (servicio.ruta_imagen) {
                        previewImagen.src = servicio.ruta_imagen;
                        previewImagen.style.display = 'block';
                    } else {
                        previewImagen.style.display = 'none';
                    }
                }
            } else {
                // Modo creación
                title.textContent = 'Nuevo Servicio';
                document.getElementById('servicioEditId').value = '';
            }
            
            $('#servicioModal').modal('show');
        }

        // Manejar envío de servicio
        // Preview de la imagen
        document.getElementById('imagenServicio').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const preview = document.getElementById('previewImagen');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.innerHTML = `<img src="${e.target.result}" class="img-fluid" alt="Preview">`;
                }
                reader.readAsDataURL(file);
                
                // Actualizar el label con el nombre del archivo
                const label = document.querySelector('.custom-file-label');
                label.textContent = file.name;
            }
        });

        async function handleServicioSubmit(e) {
            e.preventDefault();
            
            const formData = new FormData(e.target);
            const servicioId = document.getElementById('servicioEditId').value;
            const isEdit = !!servicioId;
            
            try {
                let response;
                
                if (isEdit) {
                    // Actualizar servicio
                    response = await fetch(`${SERVICIOS_API}/${servicioId}`, {
                        method: 'PUT',
                        body: formData // Enviamos el FormData directamente
                    });
                } else {
                    // Crear servicio
                    response = await fetch(SERVICIOS_API, {
                        method: 'POST',
                        body: formData // Enviamos el FormData directamente
                    });
                }

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al guardar el servicio');
                }

                await Swal.fire({
                    icon: 'success',
                    title: isEdit ? 'Servicio Actualizado' : 'Servicio Creado',
                    text: `El servicio ha sido ${isEdit ? 'actualizado' : 'creado'} exitosamente.`,
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#servicioModal').modal('hide');
                await loadServicios(); // Recargar servicios

            } catch (error) {
                console.error('Error al guardar servicio:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al guardar servicio',
                    text: error.message || 'Ocurrió un error inesperado'
                });
            }
        }

        // Editar servicio
        function editServicio(servicioId) {
            showServiceModal(servicioId);
        }

        // Eliminar servicio
        async function deleteServicio(servicioId) {
            const servicio = servicios.find(s => s.id_servicio == servicioId);
            if (!servicio) return;

            const result = await Swal.fire({
                title: '¿Eliminar servicio?',
                text: `¿Está seguro de que desea eliminar el servicio "${servicio.nombre_servicio}"?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(`${SERVICIOS_API}/${servicioId}`, {
                    method: 'DELETE'
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al eliminar el servicio');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Servicio eliminado',
                    text: 'El servicio ha sido eliminado exitosamente.',
                    timer: 2000,
                    showConfirmButton: false
                });

                await loadServicios(); // Recargar servicios

            } catch (error) {
                console.error('Error al eliminar servicio:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al eliminar servicio',
                    text: error.message || 'Ocurrió un error inesperado'
                });
            }
        }

        // Abrir modal de actualización de estado
        function abrirActualizarEstado(id) {
            console.log('Abriendo modal de actualización para reserva:', id);
            const reserva = reservas.find(r => r.id_reserva === id);
            if (!reserva) {
                console.error('Reserva no encontrada:', id);
                Swal.fire('Error', 'Reserva no encontrada', 'error');
                return;
            }
            console.log('Reserva encontrada:', reserva);

            // Llenar los campos del modal
            document.getElementById('actualizar_id').textContent = reserva.id_reserva;
            document.getElementById('actualizar_servicio').textContent = reserva.nombre_servicio || 'Servicio no encontrado';
            document.getElementById('actualizar_cliente_nombre').textContent = reserva.nombre_usuario || 'N/A';
            
            // Formatear y mostrar la fecha
            let fechaFormateada = 'Fecha no disponible';
            if (reserva.fecha_servicio) {
                const fecha = new Date(reserva.fecha_servicio);
                if (!isNaN(fecha.getTime())) {
                    fechaFormateada = fecha.toLocaleString('es-HN', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                }
            }
            document.getElementById('actualizar_fecha_inicio').textContent = fechaFormateada;
            
            // Establecer el estado actual en el combo box
            document.getElementById('actualizar_estado').value = reserva.estado_reserva || 'pendiente';

            // Guardar el ID de la reserva actual para usarlo al guardar
            document.getElementById('actualizar_estado').setAttribute('data-reserva-id', id);

            // Mostrar el modal
            $('#actualizarEstadoModal').modal('show');
        }

        // Guardar cambios de estado
        async function guardarCambiosEstado() {
            const reservaId = document.getElementById('actualizar_estado').getAttribute('data-reserva-id');
            const nuevoEstado = document.getElementById('actualizar_estado').value;

            try {
                const reserva = reservas.find(r => r.id_reserva == reservaId);
                if (!reserva) return;

                const updatedReserva = { ...reserva, estado_reserva: nuevoEstado };

                const response = await fetch(`${RESERVAS_API}/${reservaId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(updatedReserva)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al actualizar la reserva');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Estado actualizado',
                    text: `La reserva ha sido marcada como ${nuevoEstado.toLowerCase()}.`,
                    timer: 2000,
                    showConfirmButton: false
                });

                await loadReservas(); // Recargar reservas

            } catch (error) {
                console.error('Error al actualizar reserva:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar reserva',
                    text: error.message || 'Ocurrió un error inesperado'
                });
            }
        }

        // Función para abrir el modal de actualización de estado
        function abrirActualizarEstado(id) {
            console.log('Abriendo modal de actualización para reserva:', id);
            const reserva = reservas.find(r => r.id_reserva === id);
            if (!reserva) {
                console.error('Reserva no encontrada:', id);
                Swal.fire('Error', 'Reserva no encontrada', 'error');
                return;
            }

            // Llenar los campos del modal
            document.getElementById('actualizar_id').textContent = reserva.id_reserva;
            document.getElementById('actualizar_servicio').textContent = reserva.nombre_servicio || 'Servicio no encontrado';
            document.getElementById('actualizar_cliente_nombre').textContent = reserva.nombre_usuario || 'N/A';
            
            // Formatear y mostrar la fecha
            if (reserva.fecha_servicio) {
                const fecha = new Date(reserva.fecha_servicio);
                if (!isNaN(fecha.getTime())) {
                    const fechaFormateada = fecha.toLocaleString('es-HN', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                    document.getElementById('actualizar_fecha_inicio').textContent = fechaFormateada;
                }
            }

            // Establecer el estado actual en el combo box
            document.getElementById('actualizar_estado').value = reserva.estado_reserva || 'pendiente';

            // Mostrar el modal
            $('#actualizarEstadoModal').modal('show');
        }

        // Función para guardar los cambios del estado
        async function guardarCambiosEstado() {
            const id = document.getElementById('actualizar_id').textContent;
            const nuevoEstado = document.getElementById('actualizar_estado').value;
            
            try {
                const reserva = reservas.find(r => r.id_reserva == id);
                if (!reserva) {
                    throw new Error('Reserva no encontrada');
                }

                // Solo enviamos el nuevo estado
                const datosActualizar = {
                    estado_reserva: nuevoEstado
                };

                console.log('Datos a actualizar:', datosActualizar);

                const response = await fetch(`${RESERVAS_API}/${id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify(datosActualizar)
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al actualizar la reserva');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Estado actualizado',
                    text: `La reserva ha sido actualizada a "${nuevoEstado}"`,
                    timer: 2000,
                    showConfirmButton: false
                });

                $('#actualizarEstadoModal').modal('hide');
                await loadReservas(); // Recargar reservas

            } catch (error) {
                console.error('Error al actualizar reserva:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al actualizar reserva',
                    text: error.message || 'Ocurrió un error inesperado'
                });
            }
        }

        // Ver detalles de reserva
        function verDetallesReserva(id) {
            const reserva = reservas.find(r => r.id_reserva === id);
            if (!reserva) {
                Swal.fire('Error', 'Reserva no encontrada', 'error');
                return;
            }

            const clienteNombre = reserva.nombre_usuario || 'N/A';
            const costoBase = reserva.costo_base ? `L. ${parseFloat(reserva.costo_base).toFixed(2)}` : 'N/A';

            // Formatear la fecha usando el mismo formato que la tabla
            let fechaFormateada = 'Fecha no disponible';
            if (reserva.fecha_servicio) {
                const fecha = new Date(reserva.fecha_servicio);
                if (!isNaN(fecha.getTime())) {
                    fechaFormateada = fecha.toLocaleString('es-HN', {
                        day: '2-digit',
                        month: '2-digit',
                        year: 'numeric',
                        hour: '2-digit',
                        minute: '2-digit',
                        second: '2-digit',
                        hour12: true
                    });
                }
            }

            // Formatear duración
            const duracionTexto = reserva.duracion_promedio_minutos 
                ? `${reserva.duracion_promedio_minutos} minutos`
                : '90 min';

            // Actualizar los campos del modal con los detalles de la reserva
            document.getElementById('detalle_id').textContent = reserva.id_reserva;
            document.getElementById('detalle_servicio').textContent = reserva.nombre_servicio || 'Servicio no encontrado';
            document.getElementById('detalle_cliente_nombre').textContent = clienteNombre;
            document.getElementById('detalle_fecha_inicio').textContent = fechaFormateada;
            document.getElementById('detalle_duracion').textContent = duracionTexto;
            document.getElementById('detalle_ubicacion').textContent = reserva.ubicacion || 'Tegucigalpa';
            document.getElementById('detalle_estado').textContent = reserva.estado_reserva || 'Pendiente';
            document.getElementById('detalle_costo_base').textContent = `L. ${parseFloat(reserva.costo_base).toFixed(2)}`;

            // Mostrar el modal
            $('#detalleReservaModal').modal('show');
        }

        // Eliminar reserva
        async function deleteReserva(reservaId) {
            const result = await Swal.fire({
                title: '¿Eliminar reserva?',
                text: '¿Está seguro de que desea eliminar esta reserva?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            });

            if (!result.isConfirmed) return;

            try {
                const response = await fetch(`${RESERVAS_API}/${reservaId}`, {
                    method: 'DELETE'
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Error al eliminar la reserva');
                }

                await Swal.fire({
                    icon: 'success',
                    title: 'Reserva eliminada',
                    text: 'La reserva ha sido eliminada exitosamente.',
                    timer: 2000,
                    showConfirmButton: false
                });

                await loadReservas(); // Recargar reservas

            } catch (error) {
                console.error('Error al eliminar reserva:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error al eliminar reserva',
                    text: error.message || 'Ocurrió un error inesperado'
                });
            }
        }

        // Mostrar/ocultar loading
        function showLoading(show) {
            const loadingElement = document.getElementById('loadingServices');
            const servicesGrid = document.getElementById('servicesGrid');
            
            if (show) {
                loadingElement.style.display = 'flex';
                servicesGrid.style.display = 'none';
            } else {
                loadingElement.style.display = 'none';
                servicesGrid.style.display = 'flex';
            }
        }

        // MODIFICAR SOLO LA LÓGICA DE ENVÍO DEL FORMULARIO DE RESERVA

document.addEventListener('DOMContentLoaded', function() {
    // Prellenar id_usuario al abrir el modal
    $('#reservaModal').on('show.bs.modal', function () {
        const userData = localStorage.getItem('userData');
        if (userData) {
            const user = JSON.parse(userData);
            document.getElementById('id_usuario').value = user.id_usuario;
        }
    });

    document.getElementById('reservaForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(e.target);
        // Formatear fecha_servicio para MySQL (YYYY-MM-DD HH:MM:SS)
        let fecha_servicio = formData.get('fecha_servicio');
        if (fecha_servicio) {
            fecha_servicio = fecha_servicio.replace('T', ' ') + ':00';
        }
        const data = {
            id_usuario: formData.get('id_usuario'),
            fecha_reserva: new Date().toISOString().slice(0, 19).replace('T', ' '),
            fecha_servicio: fecha_servicio,
            ubicacion: formData.get('ubicacion'),
            estado_reserva: 'pendiente',
            notas: formData.get('notas'),
            nombre_persona: formData.get('nombre_persona'),
            nombre_servicio: formData.get('nombre_servicio'),
            tipo_servicio: formData.get('tipo_servicio'),
            descripcion_servicio: formData.get('descripcion_servicio'),
            costo_base: formData.get('costo_base'),
            duracion_promedio_minutos: formData.get('duracion_promedio_minutos'),
            // disponible_online: formData.get('disponible_online')
        };
        try {
            const response = await fetch('http://localhost:3000/api/reservas2', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });
            const result = await response.json();
            if (response.ok && result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Reserva creada!',
                    text: 'La reserva se ha creado correctamente.'
                });
                $('#reservaModal').modal('hide');
                if (typeof loadReservas === 'function') loadReservas();
            } else {
                throw new Error(result.message || 'Error al crear la reserva');
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error al crear la reserva',
                text: error.message || 'No se pudo crear la reserva.'
            });
        }
    });
});
    </script>
@endpush

