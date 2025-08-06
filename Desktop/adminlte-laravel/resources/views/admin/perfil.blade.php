{{-- resources/views/admin/perfil.blade.php --}}

@extends('adminlte::page')

@section('title', 'Perfil de Usuario')

@section('content_header')
    <h1 class="m-0 text-dark">Editar Perfil</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            {{-- Nuevo diseño con pestañas para mejor organización --}}
            <div class="card">
                <div class="card-header p-2">
                    <ul class="nav nav-pills">
                        <li class="nav-item"><a class="nav-link active" href="#cuenta" data-toggle="tab"><i class="fas fa-user-shield mr-2"></i>Cuenta y Seguridad</a></li>
                        <li class="nav-item"><a class="nav-link" href="#personal" data-toggle="tab"><i class="fas fa-user-tie mr-2"></i>Información Personal</a></li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        {{-- Pestaña 1: Cuenta y Seguridad --}}
                        <div class="active tab-pane" id="cuenta">
                            <form id="profileForm" enctype="multipart/form-data">
                                <div class="row">
                                    <!-- Columna para la imagen de perfil -->
                                    <div class="col-md-4 text-center d-flex flex-column align-items-center">
                                        <img id="profileImagePreview" src="https://placehold.co/150x150/EFEFEF/3A3A3A?text=Perfil" class="img-circle elevation-2 mb-3" alt="User Image" style="width: 150px; height: 150px; object-fit: cover; border: 3px solid #adb5bd; padding: 3px;">
                                        <label for="profileImageInput" class="btn btn-primary"><i class="fas fa-upload mr-2"></i>Cambiar Foto</label>
                                        <input type="file" id="profileImageInput" name="photo" class="d-none" accept="image/png, image/jpeg, image/gif">
                                        <small class="text-muted mt-2">Sube una imagen (JPG, PNG, GIF)</small>
                                    </div>
                                    <!-- Columna para los datos de la cuenta -->
                                    <div class="col-md-8">
                                        <input type="hidden" id="userId" name="id_usuario">
                                        <div class="form-group">
                                            <label for="nombre_usuario">Nombre de Usuario</label>
                                            <input type="text" class="form-control" id="nombre_usuario" name="nombre_usuario" placeholder="Tu nombre de usuario" required>
                                        </div>
                                        <hr>
                                        <h5 class="mt-4 mb-3">Cambiar Contraseña (Opcional)</h5>
                                        <div class="form-group">
                                            <label for="contrasena_usuario">Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="contrasena_usuario" name="contrasena_usuario" placeholder="Deja en blanco para no cambiar">
                                        </div>
                                        <div class="form-group">
                                            <label for="password_confirmation">Confirmar Nueva Contraseña</label>
                                            <input type="password" class="form-control" id="password_confirmation" placeholder="Repite la nueva contraseña">
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-success"><i class="fas fa-save mr-2"></i>Guardar Cambios</button>
                                            <button type="button" id="logout-button" class="btn btn-danger"><i class="fas fa-sign-out-alt mr-2"></i>Cerrar Sesión</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        {{-- Pestaña 2: Información Personal (Solo Lectura) --}}
                        <div class="tab-pane" id="personal">
                            <form class="form-horizontal">
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nombre Completo</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="full_name_display">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Identificación</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="identification_display">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Fecha de Nacimiento</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="birth_date_display">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Género</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="gender_display">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Nacionalidad</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="nationality_display">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-2 col-form-label">Estado Civil</label>
                                    <div class="col-sm-10">
                                        <input type="text" readonly class="form-control-plaintext" id="civil_status_display">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('css')
 <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">
@stop
@push('js')
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const API_BASE_URL = 'http://localhost:3000/api'; 
    const profileForm = document.getElementById('profileForm');
    const profileImagePreview = document.getElementById('profileImagePreview');
    const profileImageInput = document.getElementById('profileImageInput');
    const userIdInput = document.getElementById('userId');
    const nameInput = document.getElementById('nombre_usuario');
    const passwordInput = document.getElementById('contrasena_usuario');
    const passwordConfirmationInput = document.getElementById('password_confirmation');
    const logoutButton = document.getElementById('logout-button');
    
    // Campos de la pestaña de Información Personal
    const fullNameDisplay = document.getElementById('full_name_display');
    const identificationDisplay = document.getElementById('identification_display');
    const birthDateDisplay = document.getElementById('birth_date_display');
    const genderDisplay = document.getElementById('gender_display');
    const nationalityDisplay = document.getElementById('nationality_display');
    const civilStatusDisplay = document.getElementById('civil_status_display');
    
    const authToken = localStorage.getItem('authToken');
    const initialUserData = JSON.parse(localStorage.getItem('userData'));

    if (!authToken || !initialUserData) {
        Swal.fire({
            icon: 'warning', title: 'Sesión no encontrada', text: 'Por favor, inicia sesión de nuevo para ver tu perfil.',
            confirmButtonText: 'Ir a Login', allowOutsideClick: false, allowEscapeKey: false
        }).then((result) => {
            if (result.isConfirmed) { window.location.href = "{{ route('login') }}"; }
        });
        return;
    }

    async function loadUserProfile() {
        const userId = initialUserData.id_usuario;
        try {
            const response = await fetch(`${API_BASE_URL}/usuarios/perfil/${userId}`, {
                headers: { 'Authorization': `Bearer ${authToken}` }
            });
            if (!response.ok) { throw new Error('No se pudo obtener la información del perfil.'); }
            
            const result = await response.json();
            const freshUserData = result.usuario;
            
// ======================================================================
// ==> INSERTA ESTE NUEVO BLOQUE DE CÓDIGO AQUÍ <==
// Este código crea el icono y lo añade a la barra de navegación
// ======================================================================
try {
    // 1. Buscamos la barra de navegación derecha
    const rightNavbar = document.querySelector('.navbar-nav.ml-auto');

    // 2. Verificamos que exista y que el usuario tenga una foto
    if (rightNavbar && freshUserData.ruta_foto_perfil) {
        
        // Evitamos añadir el icono múltiples veces si ya existe
        let existingIcon = document.getElementById('navbarProfileIcon');
        if (existingIcon) {
            // Si ya existe, solo actualizamos la foto
            existingIcon.src = `{{ url('/') }}/${freshUserData.ruta_foto_perfil}`;
        } else {
            // Si no existe, lo creamos desde cero
            const listItem = document.createElement('li');
            listItem.classList.add('nav-item');

            const img = document.createElement('img');
            img.id = 'navbarProfileIcon';
            img.src = `{{ url('/') }}/${freshUserData.ruta_foto_perfil}`;
            img.classList.add('img-circle');
            img.style.cssText = 'width: 28px; height: 28px; margin-top: 5px; margin-right: 15px; border: 1px solid #6c757d;';

            listItem.appendChild(img);
            rightNavbar.prepend(listItem); // .prepend lo añade al principio
        }
    }
} catch(e) {
    console.error("Error al crear el icono de perfil en la navbar:", e);
}
// ======================================================================
// FIN DEL NUEVO BLOQUE
// ==========================
            console.log("Datos frescos recibidos de la API:", freshUserData);
            localStorage.setItem('userData', JSON.stringify(freshUserData));

            // Pestaña 1: Cuenta y Seguridad
            userIdInput.value = freshUserData.id_usuario; 
            nameInput.value = freshUserData.nombre_usuario;
            if (freshUserData.ruta_foto_perfil && freshUserData.ruta_foto_perfil.trim() !== '') {
                profileImagePreview.src = `{{ url('/') }}/${freshUserData.ruta_foto_perfil}`;
              const navbarIcon = document.getElementById('navbarProfileIcon');
    if (navbarIcon) {
        navbarIcon.src = `{{ url('/') }}/${freshUserData.ruta_foto_perfil}`;
    }
            }

            // Pestaña 2: Información Personal
            const fullName = [freshUserData.primer_nombre, freshUserData.segundo_nombre, freshUserData.primer_apellido, freshUserData.segundo_apellido].filter(Boolean).join(' ');
            fullNameDisplay.value = fullName;
            identificationDisplay.value = `${freshUserData.tipo_identificacion}: ${freshUserData.numero_identificacion}`;
            // Formatear fecha para mostrar solo YYYY-MM-DD
            birthDateDisplay.value = freshUserData.fecha_nacimiento ? new Date(freshUserData.fecha_nacimiento).toLocaleDateString('es-HN') : 'No especificada';
            genderDisplay.value = freshUserData.genero;
            nationalityDisplay.value = freshUserData.nacionalidad;
            civilStatusDisplay.value = freshUserData.estado_civil;

        } catch (error) {
            console.error("Error al cargar perfil:", error);
            Swal.fire('Error', 'No se pudieron cargar los datos del perfil.', 'error');
        }
    }

    profileImageInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) { profileImagePreview.src = e.target.result; }
            reader.readAsDataURL(file);
        }
    });

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

    logoutButton.addEventListener('click', function(event) {
        event.preventDefault(); 
        Swal.fire({
            title: '¿Estás seguro?', text: "¿Quieres cerrar la sesión actual?", icon: 'warning',
            showCancelButton: true, confirmButtonColor: '#3085d6', cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, ¡cerrar sesión!', cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                localStorage.removeItem('authToken');
                localStorage.removeItem('userData');
                window.location.href = "{{ route('login') }}";
            }
        });
    });

    loadUserProfile();
});
</script>
@endpush
