@extends('admin.app')
@section('title', 'persona')
@section('page-title', 'persona')


@section('content')

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro Completo</title>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
 <link rel="icon" href="{{ asset('images/artichoke.png') }}" type="image/png">

 <style>
 body { font-family: 'Inter', sans-serif; }
.register-box { width: 100%; max-width: 800px; }
.card-body { max-height: 85vh; overflow-y: auto; }
</style>
</head>
<body class="hold-transition register-page bg-body-secondary">

<div class="register-box">
 <div class="card card-outline card-primary shadow-lg">
  <div class="card-header text-center">
 <a href="{{ url('/') }}" class="h1"><b>Registro</b> Completo</a>
</div>
<div class="card-body p-4">
 <p class="login-box-msg">Registrar un nuevo miembro</p>

<div id="error-message" class="alert alert-danger d-none" role="alert"></div>
<div id="success-message" class="alert alert-success d-none" role="alert"></div>

<form id="register-form">
 <h5 class="mb-3">Datos Personales</h5>
 <div class="row">
 <div class="col-md-6 mb-3">
 <input type="text" name="primer_nombre" class="form-control" placeholder="Primer Nombre" required>
 </div>
 <div class="col-md-6 mb-3">
 <input type="text" name="segundo_nombre" class="form-control" placeholder="Segundo Nombre">
 </div>
 <div class="col-md-6 mb-3">
 <input type="text" name="primer_apellido" class="form-control" placeholder="Primer Apellido" required>
  </div>
  <div class="col-md-6 mb-3">
  <input type="text" name="segundo_apellido" class="form-control" placeholder="Segundo Apellido">
 </div>
  <div class="col-md-6 mb-3">
  <input type="date" name="fecha_nacimiento" class="form-control" placeholder="Fecha de Nacimiento" required>
  </div>
 <div class="col-md-6 mb-3">
  <select name="genero" class="form-select" required>
  <option value="" disabled selected>Seleccione Género...</option>
  <option value="Masculino">Masculino</option>
  <option value="Femenino">Femenino</option>
  <option value="Otro">Otro</option>
  </select>
  </div>
  <div class="col-md-6 mb-3">
  <input type="text" name="nacionalidad" class="form-control" placeholder="Nacionalidad" required>
  </div>
  <div class="col-md-6 mb-3">
  <select name="estado_civil" class="form-select" required>
  <option value="" disabled selected>Seleccione Estado Civil...</option>
  <option value="Soltero/a">Soltero/a</option>
  <option value="Casado/a">Casado/a</option>
 <option value="Divorciado/a">Divorciado/a</option>
 <option value="Viudo/a">Viudo/a</option>
<option value="Unión Libre">Unión Libre</option>
 </select>
</div>
 </div>
 <div class="input-group mb-4">
 <select name="tipo_identificacion" class="form-select" required>
 <option value="" disabled selected>Tipo de Identificación...</option>
 <option value="DNI">DNI</option>
 <option value="Pasaporte">Pasaporte</option>
 </select>
 <input type="text" name="numero_identificacion" class="form-control" placeholder="Número de Identificación" required>
</div>

 <div class="row align-items-center mt-4">
 <div class="col-md-8 col-12">
 <div class="form-check">
 <input class="form-check-input" type="checkbox" id="agreeTerms" name="terms" value="agree" required>
 <label class="form-check-label" for="agreeTerms">Acepto los <a href="#">términos y condiciones</a></label>
 </div>
 </div>
 <div class="col-md-4 col-12 mt-3 mt-md-0">
 <button type="submit" class="btn btn-primary w-100">Registrar</button>
 </div>
 </div>
 </form>

 <p class="mt-3 mb-0 text-center">
<a href="{{ url('/dashboard') }}">Regresar</a>
 </p>
 </div>
 </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
const registerForm = document.getElementById('register-form');
 const errorMessageDiv = document.getElementById('error-message');
const successMessageDiv = document.getElementById('success-message');

 registerForm.addEventListener('submit', function (event) {
 event.preventDefault();
 const submitButton = registerForm.querySelector('button[type="submit"]');
 const formData = new FormData(registerForm);
 const data = Object.fromEntries(formData.entries());

errorMessageDiv.classList.add('d-none');
 successMessageDiv.classList.add('d-none');

 submitButton.disabled = true;
 submitButton.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Registrando...';

 // ==================================================================
 // CAMBIO: La URL ahora apunta a tu "API persona"
 // ==================================================================
 fetch("http://localhost:3000/api/persona", {
 method: 'POST',
 headers: { 'Content-Type': 'application/json', 'Accept': 'application/json' },
 body: JSON.stringify(data)
 })
 .then(response => {
 if (!response.ok) {
 return response.json().then(err => { throw new Error(err.message || 'Error en el servidor.') });
 }
 return response.json();
 })
 .then(result => {
 if (result.success) {
successMessageDiv.textContent = result.message + ' Redirigiendo al login...';
successMessageDiv.classList.remove('d-none');
 setTimeout(() => { window.location.href = "{{ url('dashboard') }}"; }, 2500);
 } else {
throw new Error(result.message);
 }
 })
 .catch(error => {
 errorMessageDiv.textContent = error.message;
 errorMessageDiv.classList.remove('d-none');
 submitButton.disabled = false;
 submitButton.innerHTML = 'Registrar';
 });
 });
});
</script>
</body>
</html>