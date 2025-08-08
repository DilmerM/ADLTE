<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Login</title>

  <!-- Estilos de AdminLTE, Bootstrap y Bootstrap Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background: linear-gradient(135deg, #f8fafc, #e2e8f0);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .login-box {
      width: 100%;
      max-width: 400px;
    }

    .card {
      border: none;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
    }

    .card-header {
      background-color: transparent;
      border-bottom: none;
    }

    .form-control:focus {
      box-shadow: 0 0 0 0.2rem rgba(13,110,253,.25);
    }

    .btn-primary {
      transition: all 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0b5ed7;
      box-shadow: 0 0 10px rgba(13,110,253,0.3);
    }

    .input-group-text {
      background-color: #f1f5f9;
      border: none;
    }
  </style>
</head>
<body class="hold-transition login-page">

<div class="login-box">
  <div class="card card-outline card-primary">
    <div class="card-header text-center">
      <a class="h1 text-primary"><b>Iniciar sesión</b></a>
    </div>
    <div class="card-body">
      <p class="login-box-msg text-muted">Inicia sesión para comenzar</p>

      <!-- Mensajes -->
      <div id="error-message" class="alert alert-danger d-none" role="alert"></div>
      <div id="success-message" class="alert alert-success d-none" role="alert"></div>

      <form id="login-form">
        <div class="mb-3">
          <div class="input-group">
            <input type="text" name="nombre_usuario" class="form-control" placeholder="Nombre de Usuario" required>
            <span class="input-group-text"><i class="bi bi-person"></i></span>
          </div>
        </div>
        <div class="mb-3">
          <div class="input-group">
            <input type="password" name="contrasena_usuario" class="form-control" placeholder="Contraseña" required>
            <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
          </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-3">
          <div class="form-check">
            <input class="form-check-input" type="checkbox" id="remember" name="remember">
            <label class="form-check-label" for="remember">Recordarme</label>
          </div>
          <button type="submit" class="btn btn-primary px-4">Ingresar</button>
        </div>
      </form>

      <div class="text-end mb-2">
        <a href="#">Olvidé mi contraseña</a>
      </div>

      <p class="mb-0 text-center">
        <a href="{{ route('register') }}" class="text-decoration-none">Registrar un nuevo miembro</a>
      </p>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

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

    fetch("http://localhost:3000/api/usuarios/login", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json',
      },
      body: JSON.stringify(data)
    })
    .then(response => {
      const contentType = response.headers.get("content-type");
      if (contentType && contentType.indexOf("application/json") !== -1) {
        return response.json().then(data => ({ ok: response.ok, data }));
      } else {
        throw new Error('Respuesta inesperada del servidor. Verifique la URL de la API.');
      }
    })
    .then(({ ok, data }) => {
      if (!ok) throw new Error(data.message || 'Error en la respuesta del servidor');

      if (data.success) {
        successMessageDiv.textContent = data.message;
        successMessageDiv.classList.remove('d-none');

        localStorage.setItem('authToken', data.token);
        localStorage.setItem('userData', JSON.stringify(data.usuario));

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



