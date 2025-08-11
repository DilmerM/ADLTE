{{-- resources/views/admin/perfil.blade.php --}}

@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <h1 class="m-0 text-dark">Editar Perfil</h1>
@stop

@section('content')
    <div class="profile-container">
        <div class="profile-card">
            <div class="profile-header">
                <div class="profile-tabs">
                    <button class="tab-btn active" data-tab="cuenta">
                        <i class="fas fa-user-shield"></i>
                        Cuenta y Seguridad
                    </button>
                    <button class="tab-btn" data-tab="personal">
                        <i class="fas fa-user-tie"></i>
                        Información Personal
                    </button>
                    <button class="tab-btn" data-tab="direccion">
                        <i class="fas fa-map-marker-alt"></i>
                        Dirección
                    </button>
                </div>
            </div>

            <div class="profile-content">
                {{-- Pestaña 1: Cuenta y Seguridad --}}
                <div class="tab-content active" id="cuenta">
                    <form id="profileForm" enctype="multipart/form-data">
                        <div class="profile-section">
                            <div class="profile-image-section">
                                <div class="profile-image-container">
                                    <img id="profileImagePreview" src="https://placehold.co/150x150/EFEFEF/3A3A3A?text=Perfil" alt="User Image">
                                </div>
                                <label for="profileImageInput" class="btn btn-change-photo">
                                    <i class="fas fa-upload"></i>
                                    Cambiar Foto
                                </label>
                                <input type="file" id="profileImageInput" name="photo" accept="image/png, image/jpeg, image/gif">
                                <small class="upload-hint">Sube una imagen (JPG, PNG, GIF)</small>
                            </div>

                            <div class="profile-form-section">
                                <input type="hidden" id="userId" name="id_usuario">
                                
                                <div class="form-group">
                                    <label for="nombre_usuario">Nombre de Usuario *</label>
                                    <input type="text" id="nombre_usuario" name="nombre_usuario" placeholder="Tu nombre de usuario" required>
                                </div>

                                <div class="password-section">
                                    <h3>Cambiar Contraseña (Opcional)</h3>
                                    
                                    <div class="form-group">
                                        <label for="contrasena_usuario">Nueva Contraseña</label>
                                        <input type="password" id="contrasena_usuario" name="contrasena_usuario" placeholder="Deja en blanco para no cambiar">
                                    </div>

                                    <div class="form-group">
                                        <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Repite la nueva contraseña">
                                    </div>
                                </div>

                                <div class="action-buttons">
                                    <button type="submit" class="btn btn-save">
                                        <i class="fas fa-save"></i>
                                        Guardar Cambios
                                    </button>
                                    <button type="button" id="logout-button" class="btn btn-logout">
                                        <i class="fas fa-sign-out-alt"></i>
                                        Cerrar Sesión
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Pestaña 2: Información Personal (Editable) --}}
                <div class="tab-content" id="personal">
                    <form id="personalForm">
                        <div class="info-section">
                            <p class="section-description">Edita tu información personal.</p>
                            
                            <input type="hidden" id="personal_user_id" name="personal_user_id">
                            <input type="hidden" id="nombre_usuario_hidden" name="nombre_usuario">
                            
                            <div class="personal-form-grid">
                                <!-- Columna Izquierda -->
                                <div class="form-column">
                                    <div class="form-group">
                                        <label for="primer_nombre">Primer Nombre *</label>
                                        <input type="text" id="primer_nombre" name="primer_nombre" placeholder="Tu primer nombre" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="primer_apellido">Primer Apellido *</label>
                                        <input type="text" id="primer_apellido" name="primer_apellido" placeholder="Tu primer apellido" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="tipo_identificacion">Tipo de Identificación</label>
                                        <select id="tipo_identificacion" name="tipo_identificacion" class="form-control">
                                            <option value="DNI">DNI</option>
                                            <option value="Pasaporte">Pasaporte</option>
                                            <option value="Cedula">Cédula</option>
                                            <option value="RTN">RTN</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="fecha_nacimiento">Fecha de Nacimiento</label>
                                        <input type="date" id="fecha_nacimiento" name="fecha_nacimiento">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="nacionalidad">Nacionalidad</label>
                                        <input type="text" id="nacionalidad" name="nacionalidad" placeholder="Tu nacionalidad">
                                    </div>
                                </div>

                                <!-- Columna Derecha -->
                                <div class="form-column">
                                    <div class="form-group">
                                        <label for="segundo_nombre">Segundo Nombre</label>
                                        <input type="text" id="segundo_nombre" name="segundo_nombre" placeholder="Tu segundo nombre (opcional)">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="segundo_apellido">Segundo Apellido</label>
                                        <input type="text" id="segundo_apellido" name="segundo_apellido" placeholder="Tu segundo apellido">
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="numero_identificacion">Número de Identificación *</label>
                                        <input type="text" id="numero_identificacion" name="numero_identificacion" placeholder="Número de identificación" required>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="genero">Género</label>
                                        <select id="genero" name="genero" class="form-control">
                                            <option value="Masculino">Masculino</option>
                                            <option value="Femenino">Femenino</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label for="estado_civil">Estado Civil</label>
                                        <select id="estado_civil" name="estado_civil" class="form-control">
                                            <option value="Soltero/a">Soltero/a</option>
                                            <option value="Casado/a">Casado/a</option>
                                            <option value="Divorciado/a">Divorciado/a</option>
                                            <option value="Viudo/a">Viudo/a</option>
                                            <option value="Unión libre">Unión libre</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="action-buttons">
                                <button type="submit" class="btn btn-save-personal">
                                    <i class="fas fa-save"></i>
                                    Guardar Información Personal
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

                {{-- Pestaña 3: Dirección (Editable) --}}
                <div class="tab-content" id="direccion">
                    <form id="addressForm">
                        <div class="address-section">
                            <p class="section-description">Edita la información de tu dirección principal.</p>
                            
                            <input type="hidden" id="id_direccion" name="id_direccion">
                            
                            <div class="form-group">
                                <label for="ciudad">Ciudad *</label>
                                <div class="input-group">
                                    <input type="text" id="ciudad" name="ciudad" placeholder="Ej: Tegucigalpa" required>
                                    <button type="button" id="btnAutoFillAddress" class="btn btn-primary">
                                        <i class="fas fa-map-marker-alt"></i>
                                        Obtener Ubicación
                                    </button>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="estado">Estado/Departamento</label>
                                <input type="text" id="estado" name="estado" placeholder="Ej: Francisco Morazán">
                            </div>

                            <div class="form-group">
                                <label for="codigo_postal">Código Postal</label>
                                <input type="text" id="codigo_postal" name="cod_postal" placeholder="Ej: 11101">
                            </div>

                            <div class="form-group">
                                <label for="pais">País *</label>
                                <input type="text" id="pais" name="pais" placeholder="Ej: Honduras" required>
                            </div>

                            <div class="action-buttons">
                                <button type="submit" class="btn btn-save-address">
                                    <i class="fas fa-save"></i>
                                    Guardar Dirección
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">
    <style>
        .profile-container {
            min-height: 100vh;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 20px;
        }

        .profile-card {
            max-width: 1000px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            overflow: hidden;
        }

        .profile-header {
            background: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .profile-tabs {
            display: flex;
        }

        .tab-btn {
            flex: 1;
            padding: 15px 20px;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #6c757d;
            font-size: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .tab-btn.active {
            background: #007bff;
            color: white;
        }

        .tab-btn:hover:not(.active) {
            background: #e9ecef;
            color: #495057;
        }

        .profile-content {
            padding: 30px;
        }

        .tab-content {
            display: none;
        }

        .tab-content.active {
            display: block;
        }

        .profile-section {
            display: flex;
            gap: 40px;
            align-items: flex-start;
        }

        .profile-image-section {
            flex: 0 0 200px;
            text-align: center;
        }

        .profile-image-container {
            width: 150px;
            height: 150px;
            margin: 0 auto 20px;
            border-radius: 50%;
            border: 3px solid #dee2e6;
            overflow: hidden;
            position: relative;
        }

        .profile-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 14px;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            text-decoration: none;
        }

        .btn-change-photo {
            background: #007bff;
            color: white;
            margin-bottom: 10px;
        }

        .btn-change-photo:hover {
            background: #0056b3;
        }

        .btn-save, .btn-save-address, .btn-save-personal {
            background: #28a745;
            color: white;
        }

        .btn-save:hover, .btn-save-address:hover, .btn-save-personal:hover {
            background: #218838;
        }

        .btn-logout {
            background: #dc3545;
            color: white;
        }

        .btn-logout:hover {
            background: #c82333;
        }

        .upload-hint {
            display: block;
            color: #6c757d;
            font-size: 12px;
            margin-top: 5px;
        }

        #profileImageInput {
            display: none;
        }

        .profile-form-section {
            flex: 1;
        }

        .form-group {
            margin-bottom: 0; /* Quitamos el margin-bottom porque ya usamos gap */
            position: relative;
            min-height: 85px; /* Aseguramos espacio suficiente para el contenido */
            width: 100%;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            color: #333;
            margin-bottom: 8px;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            background: white;
        }

        .form-group input:focus {
            outline: none;
            border-color: #007bff;
        }

        .form-group select {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s ease;
            background: white;
            color: #333;
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='%23333' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14L2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
            white-space: normal;
            text-overflow: ellipsis;
            min-width: 200px;
            max-width: 100%;
            height: auto;
        }

        .form-group select:focus {
            outline: none;
            border-color: #007bff;
        }

        .password-section {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
        }

        .password-section h3 {
            margin-bottom: 20px;
            color: #333;
            font-size: 18px;
        }

        .action-buttons {
            margin-top: 30px;
            display: flex;
            gap: 15px;
        }

        .info-section, .address-section {
            max-width: 600px;
        }

        .section-description {
            color: #6c757d;
            margin-bottom: 25px;
            font-size: 14px;
        }

        .input-group {
            display: flex;
            gap: 10px;
        }

        #btnAutoFillAddress {
            white-space: nowrap;
            height: 100%;
        }

        .input-group input {
            flex: 1;
        }

        /* Estilos para el formulario personal */
        .personal-form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr; /* Dos columnas de igual tamaño */
            gap: 30px; /* Espacio entre columnas */
            margin-bottom: 20px;
        }

        .form-column {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* Responsive: en pantallas pequeñas, una sola columna */
        @media (max-width: 768px) {
            .personal-form-grid {
                grid-template-columns: 1fr; /* Una sola columna */
                gap: 15px; /* Menos espacio entre elementos en móvil */
            }

            .form-column {
                gap: 15px;
            }
        }

        /* Mejoras visuales adicionales */
        .info-section {
            max-width: 900px; /* Aumentamos el ancho máximo para acomodar las dos columnas */
            margin: 0 auto;
            padding: 20px;
        }

        /* Error styling */
        .form-group.error input,
        .form-group.error select {
            border-color: #dc3545;
        }

        .error-message {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
            display: block;
        }

        @media (max-width: 768px) {
            .profile-tabs {
                flex-direction: column;
            }

            .profile-section {
                flex-direction: column;
                text-align: center;
            }

            .profile-image-section {
                flex: none;
            }

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
@stop


@push('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const API_BASE_URL = 'http://localhost:3000/api'; 
    const GEO_API_URL = `${API_BASE_URL}/geolocalizacion`;

    
    // Elementos del DOM
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    const profileForm = document.getElementById('profileForm');
    const personalForm = document.getElementById('personalForm');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const profileImageInput = document.getElementById('profileImageInput');
    const userIdInput = document.getElementById('userId');
    const nameInput = document.getElementById('nombre_usuario');
    const passwordInput = document.getElementById('contrasena_usuario');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const logoutButton = document.getElementById('logout-button');
    const nombreUsuarioHiddenInput = document.getElementById('nombre_usuario_hidden');
    
    // Elementos de información personal
    const personalUserIdInput = document.getElementById('personal_user_id');
    const primerNombreInput = document.getElementById('primer_nombre');
    const segundoNombreInput = document.getElementById('segundo_nombre');
    const primerApellidoInput = document.getElementById('primer_apellido');
    const segundoApellidoInput = document.getElementById('segundo_apellido');
    const tipoIdentificacionInput = document.getElementById('tipo_identificacion');
    const numeroIdentificacionInput = document.getElementById('numero_identificacion');
    const fechaNacimientoInput = document.getElementById('fecha_nacimiento');
    const generoInput = document.getElementById('genero');
    const nacionalidadInput = document.getElementById('nacionalidad');
    const estadoCivilInput = document.getElementById('estado_civil');
    
    const addressForm = document.getElementById('addressForm');
    const addressIdInput = document.getElementById('id_direccion');
    const cityInput = document.getElementById('ciudad');
    const stateInput = document.getElementById('estado');
    const postalCodeInput = document.getElementById('codigo_postal');
    const countryInput = document.getElementById('pais');
    
    const authToken = localStorage.getItem('authToken');
    
    // Verificar autenticación
    if (!authToken) {
        Swal.fire({
            icon: 'warning', 
            title: 'Sesión no válida', 
            text: 'Por favor, inicia sesión de nuevo.',
            confirmButtonText: 'Ir a Login', 
            allowOutsideClick: false, 
            allowEscapeKey: false
        }).then(() => {
            window.location.href = "{{ route('login') }}"; 
        });
        return;
    }

    // Obtener datos del usuario desde localStorage
    let initialUserData = null;
    try {
        const userDataString = localStorage.getItem('userData');
        if (userDataString) {
            initialUserData = JSON.parse(userDataString);
        } else {
            throw new Error("No hay datos de usuario en localStorage");
        }
    } catch (e) {
        console.error("Error al parsear userData de localStorage:", e);
        Swal.fire({
            icon: 'error',
            title: 'Error al cargar datos',
            text: 'No se pudieron cargar los datos del usuario. Por favor, inicia sesión nuevamente.'
        }).then(() => {
            localStorage.removeItem('authToken');
            localStorage.removeItem('userData');
            window.location.href = "{{ route('login') }}";
        });
        return;
    }

    // Validar datos iniciales del usuario
    if (!initialUserData || !initialUserData.id_usuario) {
        Swal.fire({
            icon: 'error',
            title: 'Datos incompletos',
            text: 'Los datos del usuario están incompletos. Por favor, inicia sesión nuevamente.'
        }).then(() => {
            localStorage.removeItem('authToken');
            localStorage.removeItem('userData');
            window.location.href = "{{ route('login') }}";
        });
        return;
    }

    // Manejo de tabs
    tabBtns.forEach((btn, index) => {
        btn.addEventListener('click', () => {
            const tabName = btn.getAttribute('data-tab');
            
            // Remover clases activas
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Agregar clases activas
            btn.classList.add('active');
            document.getElementById(tabName).classList.add('active');
        });
    });

    // Función para construir la URL de la imagen
    function buildImageUrl(rutaFoto) {
        if (!rutaFoto || rutaFoto === 'null' || rutaFoto === null) {
            return "https://placehold.co/150x150/EFEFEF/3A3A3A?text=Perfil";
        }
        
        if (rutaFoto.startsWith('http')) {
            return rutaFoto;
        }
        
        let cleanPath = rutaFoto.replace(/^\/+/, '');
        
        if (cleanPath.startsWith('storage/')) {
            return `{{ url('/') }}/${cleanPath}`;
        } else if (cleanPath.startsWith('fotos_perfil/') || cleanPath.startsWith('uploads/')) {
            return `{{ url('/') }}/storage/${cleanPath}`;
        } else {
            return `{{ url('/') }}/storage/fotos_perfil/${cleanPath}`;
        }
    }

    // Función para validar si una imagen existe
    function validateImageUrl(url) {
        return new Promise((resolve) => {
            const img = new Image();
            img.onload = () => resolve(true);
            img.onerror = () => resolve(false);
            img.src = url;
        });
    }

    // Función para cargar imagen con fallbacks
    async function loadProfileImage(rutaFoto) {
        if (!rutaFoto || rutaFoto === 'null' || rutaFoto === null) {
            profileImagePreview.src = "https://placehold.co/150x150/EFEFEF/3A3A3A?text=Perfil";
            return;
        }

        const possibleUrls = [
            buildImageUrl(rutaFoto),
            `{{ url('/') }}/storage/${rutaFoto}`,
            `{{ url('/') }}/storage/fotos_perfil/${rutaFoto}`,
            `{{ url('/') }}/${rutaFoto}`,
            rutaFoto
        ];

        for (const url of possibleUrls) {
            const isValid = await validateImageUrl(url);
            if (isValid) {
                profileImagePreview.src = url;
                return;
            }
        }

        profileImagePreview.src = "https://placehold.co/150x150/EFEFEF/3A3A3A?text=Perfil";
    }

    // Función para recargar datos desde la base de datos
    async function reloadUserDataFromDB() {
        const userId = parseInt(initialUserData.id_usuario);
        
        try {
            const profileResponse = await fetch(`${GEO_API_URL}/perfil-completo/${userId}`, {
                headers: { 
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json'
                }
            });
            
            if (!profileResponse.ok) {
                throw new Error(`Error al obtener datos actualizados: ${profileResponse.status}`);
            }
            
            const result = await profileResponse.json();
            if (result && result.usuario) {
                // Actualizar localStorage con los datos frescos de la DB
                localStorage.setItem('userData', JSON.stringify(result.usuario));
                return result.usuario;
            }
            
            return null;
        } catch (error) {
            console.error("Error al recargar datos:", error);
            return null;
        }
    }
    // Función para cargar el perfil del usuario - MODIFICADA PARA MANEJAR ESTRUCTURA DE DATOS CORRECTA
    async function loadUserProfile() {
        const userId = parseInt(initialUserData.id_usuario);
        if (isNaN(userId)) {
            console.error("El id_usuario no es un número válido:", initialUserData.id_usuario);
            Swal.fire('Error Crítico', 'El ID del usuario no es válido.', 'error');
            return;
        }

        Swal.fire({
            title: 'Cargando perfil...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const profileResponse = await fetch(`${GEO_API_URL}/perfil-completo/${userId}`, {
                headers: { 
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json'
                }
            });
            
            if (!profileResponse.ok) {
                const errorText = await profileResponse.text();
                throw new Error(`Error en la API: ${profileResponse.status} ${profileResponse.statusText}. Respuesta: ${errorText}`);
            }
            
            const result = await profileResponse.json();

            if (!result || !result.usuario) {
                throw new Error("La respuesta de la API no contiene los datos del usuario.");
            }

            const freshUserData = result.usuario;
            localStorage.setItem('userData', JSON.stringify(freshUserData));

            // Poblar campos del formulario - AJUSTADO PARA NUEVA ESTRUCTURA
            userIdInput.value = freshUserData.id_usuario;
            personalUserIdInput.value = freshUserData.id_persona || freshUserData.id_usuario; // Compatibilidad
            nameInput.value = freshUserData.nombre_usuario || '';
            nombreUsuarioHiddenInput.value = freshUserData.nombre_usuario || '';
            
            // Cargar imagen de perfil
            await loadProfileImage(freshUserData.ruta_foto_perfil);

            // Cargar información personal - AHORA VIENE DE LA TABLA PERSONAS
            primerNombreInput.value = freshUserData.primer_nombre || '';
            segundoNombreInput.value = freshUserData.segundo_nombre || '';
            primerApellidoInput.value = freshUserData.primer_apellido || '';
            segundoApellidoInput.value = freshUserData.segundo_apellido || '';
            tipoIdentificacionInput.value = freshUserData.tipo_identificacion || 'DNI';
            numeroIdentificacionInput.value = freshUserData.numero_identificacion || '';
            
            if (freshUserData.fecha_nacimiento) {
                try {
                    const fecha = new Date(freshUserData.fecha_nacimiento);
                    if (!isNaN(fecha.getTime())) {
                        fechaNacimientoInput.value = fecha.toISOString().split('T')[0];
                    }
                } catch (dateError) {
                    console.warn("Error al formatear fecha:", dateError);
                }
            }
            
            generoInput.value = freshUserData.genero || 'Masculino';
            nacionalidadInput.value = freshUserData.nacionalidad || '';
            estadoCivilInput.value = freshUserData.estado_civil || 'Soltero/a';
            
            // Cargar datos de dirección - AHORA VIENE DE LA TABLA DIRECCIONES
            if (freshUserData.id_direccion) {
                addressIdInput.value = freshUserData.id_direccion;
                cityInput.value = freshUserData.ciudad || '';
                stateInput.value = freshUserData.estado || '';
                postalCodeInput.value = freshUserData.cod_postal || '';
                countryInput.value = freshUserData.pais || '';
            } else {
                // Limpiar campos si no hay dirección
                addressIdInput.value = '';
                cityInput.value = '';
                stateInput.value = '';
                postalCodeInput.value = '';
                countryInput.value = '';
            }

            Swal.close();
            
        } catch (error) {
            console.error("Error al cargar el perfil:", error);
            Swal.fire({
                icon: 'error', 
                title: 'Error al cargar el perfil', 
                text: `No se pudieron obtener los datos. Error: ${error.message}`,
                confirmButtonText: 'Entendido'
            }).then(() => {
                if (error.message.includes('401') || error.message.includes('token')) {
                    localStorage.removeItem('authToken');
                    localStorage.removeItem('userData');
                    window.location.href = "{{ route('login') }}";
                }
            });
        }
    }
    // Función para limpiar errores de validación
    function clearFormErrors(form) {
        const errorGroups = form.querySelectorAll('.form-group.error');
        errorGroups.forEach(group => {
            group.classList.remove('error');
            const errorMsg = group.querySelector('.error-message');
            if (errorMsg) {
                errorMsg.remove();
            }
        });
    }

    // Función para mostrar errores de validación
    function showFieldError(field, message) {
        const formGroup = field.closest('.form-group');
        if (formGroup) {
            formGroup.classList.add('error');
            
            const existingError = formGroup.querySelector('.error-message');
            if (existingError) {
                existingError.remove();
            }
            
            const errorDiv = document.createElement('div');
            errorDiv.className = 'error-message';
            errorDiv.textContent = message;
            formGroup.appendChild(errorDiv);
            
            if (formGroup.getBoundingClientRect().top < 0) {
                formGroup.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

// Event listeners
    profileImageInput.addEventListener('change', function(event) {
        if (event.target.files && event.target.files[0]) {
            const file = event.target.files[0];
            
            if (!file.type.match(/^image\/(jpeg|jpg|png|gif)$/)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo inválido',
                    text: 'Solo se permiten archivos JPG, PNG o GIF'
                });
                event.target.value = '';
                return;
            }
            
            if (file.size > 5 * 1024 * 1024) {
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo muy grande',
                    text: 'La imagen no puede ser mayor a 5MB'
                });
                event.target.value = '';
                return;
            }


            const reader = new FileReader();
            reader.onload = function(e) {
                profileImagePreview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Función para validar contraseña
    function validatePassword(password) {
        if (!password) return true; // Contraseña opcional
        
        // Mínimo 8 caracteres, al menos una mayúscula, una minúscula y un número
        const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;
        return regex.test(password);
    }

 profileForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        if (passwordInput.value !== passwordConfirmationInput.value) {
            Swal.fire({ icon: 'error', title: 'Error en Contraseña', text: 'Las contraseñas no coinciden.' });
            return;
        }
        const endpoint = `${API_BASE_URL}/usuarios/perfil/actualizar/${userIdInput.value}`;
        const formData = new FormData(profileForm);
        if (profileImageInput.files.length === 0) { formData.delete('photo'); }
        if (!passwordInput.value.trim()) { formData.delete('contrasena_usuario'); }
        
        try {
            const response = await fetch(endpoint, {
                method: 'PATCH', 
                headers: { 'Authorization': `Bearer ${authToken}`, 'Accept': 'application/json' },
                body: formData
            });
            const result = await response.json();
            if (!response.ok) { throw new Error(result.message || `Error ${response.status}.`); }
            
            Swal.fire({ icon: 'success', title: '¡Éxito!', text: 'Tu perfil ha sido actualizado.' });
            
            if (result.nuevaRutaFoto) {
                 profileImagePreview.src = `{{ url('/') }}/${result.nuevaRutaFoto}`;
                 const currentData = JSON.parse(localStorage.getItem('userData'));
                 currentData.ruta_foto_perfil = result.nuevaRutaFoto;
                 localStorage.setItem('userData', JSON.stringify(currentData));
            }
            passwordInput.value = '';
            passwordConfirmationInput.value = '';
        } catch (error) {
            console.error('Error al actualizar el perfil:', error);
            Swal.fire({ icon: 'error', title: 'Error al Actualizar', text: error.message });
        }
    });
    // Evento para enviar el formulario de información personal - MODIFICADO PARA NUEVA ESTRUCTURA
    personalForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearFormErrors(personalForm);

        const formData = {
            id_persona: personalUserIdInput.value,  // Ahora usamos id_persona
            primer_nombre: primerNombreInput.value.trim(),
            segundo_nombre: segundoNombreInput.value.trim(),
            primer_apellido: primerApellidoInput.value.trim(),
            segundo_apellido: segundoApellidoInput.value.trim(),
            tipo_identificacion: tipoIdentificacionInput.value,
            numero_identificacion: numeroIdentificacionInput.value.trim(),
            fecha_nacimiento: fechaNacimientoInput.value || null,
            genero: generoInput.value,
            nacionalidad: nacionalidadInput.value.trim(),
            estado_civil: estadoCivilInput.value
        };

       // Validaciones
        let isValid = true;

        if (!formData.primer_nombre) {
            showFieldError(primerNombreInput, 'El primer nombre es requerido');
            isValid = false;
        }

        if (!formData.primer_apellido) {
            showFieldError(primerApellidoInput, 'El primer apellido es requerido');
            isValid = false;
        }

        if (!formData.numero_identificacion) {
            showFieldError(numeroIdentificacionInput, 'El número de identificación es requerido');
            isValid = false;
        }

        if (!isValid) return;

        try {
            const response = await fetch(`${GEO_API_URL}/actualizar-info-personal`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            // Manejo mejorado de errores
            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || 'Error en la respuesta del servidor');
            }

            const result = await response.json();

            // Actualizar datos en localStorage
            const updatedUserData = await reloadUserDataFromDB();
            if (updatedUserData) {
                localStorage.setItem('userData', JSON.stringify(updatedUserData));
            }

            Swal.fire({
                icon: 'success',
                title: 'Información guardada',
                text: 'Los datos personales se actualizaron correctamente',
                timer: 2000,
                showConfirmButton: false
            });

        } catch (error) {
            console.error('Error al actualizar información personal:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error al actualizar',
                text: error.message || 'Ocurrió un error al guardar los cambios',
                footer: typeof error === 'object' ? JSON.stringify(error) : ''
            });
        }
    });

    // Evento para enviar el formulario de dirección - MODIFICADO PARA NUEVA ESTRUCTURA
    addressForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearFormErrors(addressForm);

        const formData = {
            id_usuario: initialUserData.id_usuario,
            id_direccion: addressIdInput.value || null,
            ciudad: cityInput.value.trim(),
            estado: stateInput.value.trim(),
            cod_postal: postalCodeInput.value.trim(),
            pais: countryInput.value.trim()
        };

        // Validaciones
        let isValid = true;

        if (!formData.ciudad) {
            showFieldError(cityInput, 'La ciudad es requerida');
            isValid = false;
        }

        if (!formData.pais) {
            showFieldError(countryInput, 'El país es requerido');
            isValid = false;
        }

        if (!isValid) return;

        try {
            const response = await fetch(`${GEO_API_URL}/direcciones/gestionar`, {
                method: 'POST',
                headers: {
                    'Authorization': `Bearer ${authToken}`,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            });

            const result = await response.json();

            if (!result.success) {
                throw new Error(result.error || 'Error al procesar la solicitud');
            }

            // Actualizar los datos en el formulario con la respuesta
            if (result.datos) {
                addressIdInput.value = result.datos.id_direccion || '';
                cityInput.value = result.datos.ciudad || '';
                stateInput.value = result.datos.estado || '';
                postalCodeInput.value = result.datos.cod_postal || '';
                countryInput.value = result.datos.pais || '';

                // Actualizar localStorage
                localStorage.setItem('userData', JSON.stringify(result.datos));
            }

            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: result.mensaje,
                timer: 2000,
                showConfirmButton: false
            });

        } catch (error) {
            console.error('Error al gestionar dirección:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message || 'Ocurrió un error al guardar la dirección'
            });
        }
    });
    
// Evento para cerrar sesión
    logoutButton.addEventListener('click', function() {
        Swal.fire({
            title: '¿Cerrar sesión?',
            text: '¿Estás seguro de que deseas salir de tu cuenta?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem('authToken');
                localStorage.removeItem('userData');
                window.location.href = "{{ route('login') }}";
            }
        });
    });

    loadUserProfile();

    const btnAutoFillAddress = document.getElementById('btnAutoFillAddress');

    // Función para obtener la ubicación actual y llenar los campos
    btnAutoFillAddress.addEventListener('click', function(e) {
        e.preventDefault();
        
        Swal.fire({
            title: 'Obteniendo ubicación...',
            text: 'Por favor, permite el acceso a tu ubicación',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        if ("geolocation" in navigator) {
            navigator.geolocation.getCurrentPosition(async function(position) {
                try {
                    const latitude = position.coords.latitude;
                    const longitude = position.coords.longitude;
                    
                    // Usar la API de OpenStreetMap para obtener la dirección
                    const response = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}&addressdetails=1`);
                    const data = await response.json();
                    
                    // Llenar los campos con la información obtenida
                    cityInput.value = data.address.city || data.address.town || data.address.village || '';
                    stateInput.value = data.address.state || data.address.county || '';
                    postalCodeInput.value = data.address.postcode || '';
                    countryInput.value = data.address.country || '';

                    Swal.fire({
                        icon: 'success',
                        title: '¡Ubicación obtenida!',
                        text: 'Los campos han sido actualizados con tu ubicación actual.',
                        timer: 2000,
                        showConfirmButton: false
                    });

                } catch (error) {
                    console.error('Error al obtener la dirección:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo obtener la dirección automáticamente'
                    });
                }
            }, function(error) {
                console.error('Error al obtener la ubicación:', error);
                let errorMessage = 'Error al obtener la ubicación';
                switch(error.code) {
                    case error.PERMISSION_DENIED:
                        errorMessage = 'Necesitamos permiso para acceder a tu ubicación';
                        break;
                    case error.POSITION_UNAVAILABLE:
                        errorMessage = 'La información de ubicación no está disponible';
                        break;
                    case error.TIMEOUT:
                        errorMessage = 'Se agotó el tiempo para obtener la ubicación';
                        break;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Tu navegador no soporta geolocalización'
            });
        }
    });
});
</script>
@endpush