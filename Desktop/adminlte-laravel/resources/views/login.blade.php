<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login</title>

    <!-- Estilos de AdminLTE, Bootstrap y Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">
    
   <style>
        /* Estilos para centrar y dar una apariencia agradable */
        body {
            font-family: 'Inter', sans-serif;
        }
        .login-box {
            width: 100%;
            max-width: 400px;
        }
    </style>
</head>
<body class="hold-transition login-page bg-body-secondary">

<div class="login-box">
    <div class="card card-outline card-primary shadow-lg">
        <div class="card-header text-center">
            <a href="#" class="h1"><b>Mi</b>App</a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Inicia sesión para comenzar</p>

            <!-- Mensaje de error que se mostrará con JavaScript -->
            <div id="error-message" class="alert alert-danger d-none" role="alert"></div>
            <div id="success-message" class="alert alert-success d-none" role="alert"></div>

            <form id="login-form">
                <div class="input-group mb-3">
                    <input type="text" name="nombre_usuario" class="form-control" placeholder="Nombre de Usuario" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-person"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                   <input type="password" name="contrasena_usuario" class="form-control" placeholder="Contraseña" required>
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="bi bi-lock-fill"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-8">
                        <div class="icheck-primary">
                            <input type="checkbox" id="remember" name="remember">
                            <label for="remember">
                                Recordarme
                            </label>
                        </div>
                    </div>
                    <div class="col-4">
                        <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
                    </div>
                </div>
            </form>

            <div class="social-auth-links text-center mt-2 mb-3">
                <a href="#" class="btn btn-block btn-primary">
                    <i class="bi bi-facebook me-2"></i> Ingresar con Facebook
                </a>
                <a href="#" class="btn btn-block btn-danger">
                    <i class="bi bi-google me-2"></i> Ingresar con Google+
                </a>
            </div>

            <p class="mb-1">
                <a href="#">Olvidé mi contraseña</a>
            </p>
            
            <p class="mb-0 text-center">
                <a href="{{ route('register') }}" class="text-center">Registrar un nuevo miembro</a>
            </p>
        </div>
    </div>
</div>

<!-- Scripts de JQuery y Bootstrap -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script de AdminLTE -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- SCRIPT CORREGIDO Y FUNCIONAL -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        
        const loginForm = document.getElementById('login-form');
        const errorMessageDiv = document.getElementById('error-message');
        const successMessageDiv = document.getElementById('success-message');

        loginForm.addEventListener('submit', function (event) {
            
            event.preventDefault();

            const submitButton = loginForm.querySelector('button[type="submit"]');
            submitButton.disabled = true;
            submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Ingresando...';

            errorMessageDiv.classList.add('d-none');
            successMessageDiv.classList.add('d-none');

            const formData = new FormData(loginForm);
            const data = Object.fromEntries(formData.entries());

            // ==================================================================
            // CORRECCIÓN: La URL ahora apunta al endpoint correcto de tu API.
            // Antes tenías "/Usuario/login", ahora es "/api/usuarios/login".
            // ==================================================================
            fetch("http://localhost:3000/api/usuarios/login", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                // Primero verificamos si la respuesta es JSON antes de intentar parsearla
                const contentType = response.headers.get("content-type");
                if (contentType && contentType.indexOf("application/json") !== -1) {
                    return response.json().then(data => ({ ok: response.ok, data }));
                } else {
                    // Si no es JSON, es un error inesperado (como el HTML de un 404)
                    throw new Error('Respuesta inesperada del servidor. Verifique la URL de la API.');
                }
            })
            .then(({ ok, data }) => {
                if (!ok) {
                    throw new Error(data.message || 'Error en la respuesta del servidor');
                }

                if (data.success) {
                    successMessageDiv.textContent = data.message;
                    successMessageDiv.classList.remove('d-none');
                    
                    // Guardamos el token y los datos del usuario en el navegador.
                    // Esto es CRUCIAL para que la página de perfil funcione.
                    localStorage.setItem('authToken', data.token);
                    localStorage.setItem('userData', JSON.stringify(data.usuario));

                    // Redirigimos después de un momento.
                    setTimeout(() => {
                        window.location.href = "{{ route('admin.dashboard') }}";
                    }, 1500);

                } else {
                    throw new Error(data.message || 'Ocurrió un error desconocido.');
                }
            })
            .catch(error => {
                errorMessageDiv.textContent = error.message;
                errorMessageDiv.classList.remove('d-none');
                
                submitButton.disabled = false;
                submitButton.innerHTML = 'Ingresar';
            });
        });
    });
</script>

</body>
</html>
