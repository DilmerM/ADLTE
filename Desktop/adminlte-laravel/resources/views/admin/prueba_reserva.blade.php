@extends('adminlte::page')

@section('title', 'Nueva Reserva')

@section('content_header')
    <h1>Nueva Reserva</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <!-- Formulario de Reservas -->
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Crear Nueva Reserva</h3>
                </div>
                <div class="card-body">
                    <form id="reserva-form">
                        <div class="form-group">
                            <label>Usuario</label>
                            <input type="text" class="form-control" id="nombre_usuario" readonly>
                            <input type="hidden" id="id_persona" name="id_persona">
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
                        <button type="submit" class="btn btn-primary">Crear Reserva</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Mis Reservas -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Mis Reservas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="reservas-table">
                            <thead>
                                <tr>
                                    <th>Fecha de Servicio</th>
                                    <th>Ubicación</th>
                                    <th>Estado</th>
                                    <th>Notas</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.min.css">
@stop

@section('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.19/dist/sweetalert2.all.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const reservaForm = document.getElementById('reserva-form');
    const reservasTable = document.getElementById('reservas-table').getElementsByTagName('tbody')[0];
    
    // Obtener datos del usuario desde localStorage y verificar en la API
    let initialUserData = null;
    try {
        const userDataString = localStorage.getItem('userData');
        if (userDataString) {
            initialUserData = JSON.parse(userDataString);
            
            // Mostrar nombre completo del usuario desde localStorage
            if (initialUserData.nombre_completo) {
                document.getElementById('nombre_usuario').value = initialUserData.nombre_completo;
            } else if (initialUserData.nombre_usuario) {
                document.getElementById('nombre_usuario').value = initialUserData.nombre_usuario;
            }
            
            // Obtener datos completos del usuario
            fetch(`http://localhost:3000/api/geolocalizacion/perfil-completo/${initialUserData.id_usuario}`)
                .then(response => response.json())
                .then(result => {
                    if (!result || !result.usuario) {
                        throw new Error('No se pudo obtener la información del usuario');
                    }

                    // Mostrar nombre actualizado del usuario
                    document.getElementById('nombre_usuario').value = result.usuario.nombre_usuario || '';

                    // Buscar la persona asociada al usuario usando el procedimiento almacenado
                    fetch(`http://localhost:3000/api/reservas2/persona-por-usuario/${result.usuario.id_usuario}`)
                        .then(response => response.json())
                        .then(personaData => {
                            if (!personaData || !personaData.id_persona) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: 'No se encontró la información personal asociada a tu usuario. Por favor, contacta al administrador.'
                                });
                                return;
                            }
                            document.getElementById('id_persona').value = personaData.id_persona;
                        });

                    cargarReservas();
                })
                .catch(error => {
                    console.error("Error al obtener perfil:", error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo obtener la información del usuario'
                    });
                });
        } else {
            throw new Error("No hay datos de usuario en localStorage");
        }
    } catch (e) {
        console.error("Error al cargar datos de usuario:", e);
        Swal.fire({
            icon: 'error',
            title: 'Error al cargar datos',
            text: 'No se pudieron cargar los datos del usuario. Por favor, inicia sesión nuevamente.'
        }).then(() => {
            window.location.href = "{{ route('login') }}";
        });
        return;
    }

    // Función para cargar las reservas del usuario
    function cargarReservas() {
        const idPersona = document.getElementById('id_persona').value;
        fetch(`http://localhost:3000/api/reservas2?id_persona=${idPersona}`)
            .then(response => response.json())
            .then(result => {
                if (result.success && result.data) {
                    reservasTable.innerHTML = '';
                    result.data.forEach(reserva => {
                        const row = reservasTable.insertRow();
                        row.innerHTML = `
                            <td>${new Date(reserva.fecha_servicio).toLocaleString()}</td>
                            <td>${reserva.ubicacion}</td>
                            <td><span class="badge badge-${getEstadoClass(reserva.estado_reserva)}">${reserva.estado_reserva}</span></td>
                            <td>${reserva.notas || ''}</td>
                            <td>
                                ${reserva.estado_reserva === 'pendiente' ? `
                                    <button class="btn btn-sm btn-danger" onclick="cancelarReserva(${reserva.id_reserva})">Cancelar</button>
                                ` : ''}
                            </td>
                        `;
                    });
                }
            })
            .catch(error => {
                console.error('Error al cargar reservas:', error);
                Swal.fire('Error', 'No se pudieron cargar las reservas', 'error');
            });
    }

    function getEstadoClass(estado) {
        switch (estado) {
            case 'pendiente': return 'warning';
            case 'confirmada': return 'success';
            case 'cancelada': return 'danger';
            case 'completada': return 'info';
            default: return 'secondary';
        }
    }

    // Crear reserva
    reservaForm.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(reservaForm);
        const idPersona = formData.get('id_persona');
        if (!idPersona) {
            Swal.fire('Error', 'No se ha podido obtener el ID de persona. Por favor, recarga la página o inicia sesión nuevamente.', 'error');
            return;
        }
        const data = {
            id_usuario: initialUserData.id_usuario,
            fecha_reserva: new Date().toISOString().slice(0, 19).replace('T', ' '), // Fecha actual
            fecha_servicio: formData.get('fecha_servicio'),
            ubicacion: formData.get('ubicacion'),
            estado_reserva: 'pendiente', // Estado por defecto
            notas: formData.get('notas')
        };
        fetch('http://localhost:3000/api/reservas2', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(data)
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Error al crear la reserva');
                });
            }
            return response.json();
        })
        .then(result => {
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: 'Reserva creada correctamente'
                }).then(() => {
                    reservaForm.reset();
                    cargarReservas();
                });
            } else {
                throw new Error(result.message || 'Error al crear la reserva');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            Swal.fire({
                icon: 'error',
                title: 'Error al crear la reserva',
                text: error.message || 'No se pudo crear la reserva. Por favor, verifica que todos los datos sean correctos.'
            });
        });
    });

    // Función para cancelar una reserva
    window.cancelarReserva = function(idReserva) {
        Swal.fire({
            title: '¿Estás seguro?',
            text: "¿Deseas cancelar esta reserva?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, cancelar',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`http://localhost:3000/api/reservas2/${idReserva}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        estado_reserva: 'cancelada'
                    })
                })
                .then(response => response.json())
                .then(result => {
                    if (result.success) {
                        Swal.fire('¡Cancelada!', 'La reserva ha sido cancelada.', 'success');
                        cargarReservas();
                    } else {
                        throw new Error(result.message || 'Error al cancelar la reserva');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', error.message, 'error');
                });
            }
        });
    };

    // Cargar reservas al inicio
    cargarReservas();
});
</script>
@stop
