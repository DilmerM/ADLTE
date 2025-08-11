@extends('admin.app')
@section('title', 'Reportes')
@section('page-title', 'Reportes')

@section('content')

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Reportes de Reserva</title>
    <!-- Tailwind CSS CDN for a nice-looking, responsive design -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Custom styles for smoother transitions */
        .fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .message-box {
            animation: slideIn 0.5s forwards;
        }
        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
</head>
<body class="bg-gray-100 font-sans p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl overflow-hidden p-8 space-y-8">
        <header class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-800">
                <i class="fas fa-file-invoice mr-4 text-indigo-500"></i>Gestión de Reportes de Reserva
            </h1>
            <p class="text-gray-500 mt-2">
                Interfaz para interactuar con la API de reportes de reserva y eventos.
            </p>
        </header>

        <!-- Main Action Buttons -->
        <div class="flex flex-col md:flex-row justify-center gap-4">
            <button id="showInsertFormBtn" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-plus mr-2"></i> Insertar Reporte
            </button>
            <button id="showUpdateFormBtn" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-edit mr-2"></i> Actualizar Reporte
            </button>
            <button id="showSearchFormBtn" class="bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-lg transition duration-300 transform hover:scale-105 shadow-lg">
                <i class="fas fa-search mr-2"></i> Buscar Reporte
            </button>
        </div>

        <!-- Message Box -->
        <div id="messageBox" class="hidden text-center py-4 px-6 rounded-lg font-semibold transition duration-500 message-box"></div>

        <!-- Forms Container -->
        <div class="space-y-6">
            <!-- Formulario de Inserción (POST) -->
            <div id="insertFormContainer" class="hidden fade-in bg-gray-50 p-6 rounded-xl shadow-inner">
                <h2 class="text-2xl font-bold text-indigo-600 mb-4">Formulario de Inserción</h2>
                <form id="insertForm" class="space-y-4">
                    <!-- Los campos del formulario coinciden con el cuerpo de tu API -->
                    <div>
                        <label for="insert_id_reporte" class="block text-sm font-medium text-gray-700">ID Reporte</label>
                        <input type="number" id="insert_id_reporte" name="id_reporte" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_id_reserva" class="block text-sm font-medium text-gray-700">ID Reserva</label>
                        <input type="number" id="insert_id_reserva" name="id_reserva" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_id_usuario" class="block text-sm font-medium text-gray-700">ID Usuario</label>
                        <input type="number" id="insert_id_usuario" name="id_usuario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_nombre_persona" class="block text-sm font-medium text-gray-700">Nombre Persona</label>
                        <input type="text" id="insert_nombre_persona" name="nombre_persona" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_nombre_servicio" class="block text-sm font-medium text-gray-700">Nombre Servicio</label>
                        <input type="text" id="insert_nombre_servicio" name="nombre_servicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_tipo_servicio" class="block text-sm font-medium text-gray-700">Tipo Servicio</label>
                        <input type="text" id="insert_tipo_servicio" name="tipo_servicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_descripcion_servicio" class="block text-sm font-medium text-gray-700">Descripción Servicio</label>
                        <textarea id="insert_descripcion_servicio" name="descripcion_servicio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required></textarea>
                    </div>
                    <div>
                        <label for="insert_fecha_reserva" class="block text-sm font-medium text-gray-700">Fecha Reserva</label>
                        <input type="text" id="insert_fecha_reserva" name="fecha_reserva" placeholder="YYYY-MM-DD HH:MM:SS" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_fecha_servicio" class="block text-sm font-medium text-gray-700">Fecha Servicio</label>
                        <input type="text" id="insert_fecha_servicio" name="fecha_servicio" placeholder="YYYY-MM-DD HH:MM:SS" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
                        <input type="text" id="insert_ubicacion" name="ubicacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="insert_estado_reserva" class="block text-sm font-medium text-gray-700">Estado Reserva</label>
                        <input type="text" id="insert_estado_reserva" name="estado_reserva" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
                    </div>
                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                        <i class="fas fa-paper-plane mr-2"></i> Enviar
                    </button>
                </form>
            </div>

            <!-- Formulario de Actualización (PUT) -->
            <div id="updateFormContainer" class="hidden fade-in bg-gray-50 p-6 rounded-xl shadow-inner">
                <h2 class="text-2xl font-bold text-yellow-600 mb-4">Formulario de Actualización</h2>
                <form id="updateForm" class="space-y-4">
                    <div>
                        <label for="update_id_reporte" class="block text-sm font-medium text-gray-700">ID Reporte a Actualizar</label>
                        <input type="number" id="update_id_reporte" name="id_reporte" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <!-- Campos del formulario para actualizar -->
                    <div>
                        <label for="update_id_reserva" class="block text-sm font-medium text-gray-700">ID Reserva</label>
                        <input type="number" id="update_id_reserva" name="id_reserva" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_id_usuario" class="block text-sm font-medium text-gray-700">ID Usuario</label>
                        <input type="number" id="update_id_usuario" name="id_usuario" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_nombre_persona" class="block text-sm font-medium text-gray-700">Nombre Persona</label>
                        <input type="text" id="update_nombre_persona" name="nombre_persona" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_nombre_servicio" class="block text-sm font-medium text-gray-700">Nombre Servicio</label>
                        <input type="text" id="update_nombre_servicio" name="nombre_servicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_tipo_servicio" class="block text-sm font-medium text-gray-700">Tipo Servicio</label>
                        <input type="text" id="update_tipo_servicio" name="tipo_servicio" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_descripcion_servicio" class="block text-sm font-medium text-gray-700">Descripción Servicio</label>
                        <textarea id="update_descripcion_servicio" name="descripcion_servicio" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required></textarea>
                    </div>
                    <div>
                        <label for="update_fecha_reserva" class="block text-sm font-medium text-gray-700">Fecha Reserva</label>
                        <input type="text" id="update_fecha_reserva" name="fecha_reserva" placeholder="YYYY-MM-DD HH:MM:SS" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_fecha_servicio" class="block text-sm font-medium text-gray-700">Fecha Servicio</label>
                        <input type="text" id="update_fecha_servicio" name="fecha_servicio" placeholder="YYYY-MM-DD HH:MM:SS" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_ubicacion" class="block text-sm font-medium text-gray-700">Ubicación</label>
                        <input type="text" id="update_ubicacion" name="ubicacion" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <div>
                        <label for="update_estado_reserva" class="block text-sm font-medium text-gray-700">Estado Reserva</label>
                        <input type="text" id="update_estado_reserva" name="estado_reserva" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-yellow-300 focus:ring focus:ring-yellow-200 focus:ring-opacity-50" required>
                    </div>
                    <button type="submit" class="w-full bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                        <i class="fas fa-sync-alt mr-2"></i> Actualizar
                    </button>
                </form>
            </div>

            <!-- Formulario de Búsqueda (GET) -->
            <div id="searchFormContainer" class="hidden fade-in bg-gray-50 p-6 rounded-xl shadow-inner">
                <h2 class="text-2xl font-bold text-green-600 mb-4">Búsqueda de Reporte</h2>
                <form id="searchForm" class="flex flex-col md:flex-row gap-4 items-center">
                    <div class="flex-grow w-full">
                        <label for="search_id" class="sr-only">ID de Reporte</label>
                        <input type="number" id="search_id" name="id" placeholder="ID del Reporte" class="w-full rounded-md border-gray-300 shadow-sm focus:border-green-300 focus:ring focus:ring-green-200 focus:ring-opacity-50" required>
                    </div>
                    <button type="submit" class="w-full md:w-auto bg-green-500 hover:bg-green-600 text-white font-bold py-2 px-4 rounded-md transition duration-300">
                        <i class="fas fa-search mr-2"></i> Buscar
                    </button>
                </form>
            </div>
        </div>

        <!-- Sección de resultados de la búsqueda -->
        <div id="resultsContainer" class="hidden mt-8 fade-in">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Resultados de la Búsqueda</h2>
            <div id="resultCard" class="bg-indigo-50 border-l-4 border-indigo-500 rounded-lg p-6 shadow-md">
                <!-- Data will be injected here -->
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const apiBaseUrl = 'http://localhost:3000';

            const messageBox = document.getElementById('messageBox');
            const insertFormContainer = document.getElementById('insertFormContainer');
            const updateFormContainer = document.getElementById('updateFormContainer');
            const searchFormContainer = document.getElementById('searchFormContainer');
            const resultsContainer = document.getElementById('resultsContainer');
            const resultCard = document.getElementById('resultCard');

            // --- UI Handlers ---
            const showMessage = (message, type) => {
                messageBox.textContent = message;
                messageBox.className = `message-box block text-center py-4 px-6 rounded-lg font-semibold transition duration-500 ${
                    type === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'
                }`;
                setTimeout(() => {
                    messageBox.classList.remove('block');
                    messageBox.classList.add('hidden');
                }, 5000); // Hide after 5 seconds
            };

            const clearForms = () => {
                insertFormContainer.classList.add('hidden');
                updateFormContainer.classList.add('hidden');
                searchFormContainer.classList.add('hidden');
                resultsContainer.classList.add('hidden');
            };

            document.getElementById('showInsertFormBtn').addEventListener('click', () => {
                clearForms();
                insertFormContainer.classList.remove('hidden');
            });

            document.getElementById('showUpdateFormBtn').addEventListener('click', () => {
                clearForms();
                updateFormContainer.classList.remove('hidden');
            });

            document.getElementById('showSearchFormBtn').addEventListener('click', () => {
                clearForms();
                searchFormContainer.classList.remove('hidden');
            });

            // --- API Call Functions ---

            // POST: Insertar Reporte
            document.getElementById('insertForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());

                try {
                    const response = await fetch(`${apiBaseUrl}/reporte/reporte-reserva`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    });

                    const result = await response.json();
                    if (response.ok) {
                        showMessage(result.message, 'success');
                        e.target.reset(); // Clear the form
                    } else {
                        showMessage(`Error: ${result.error || result.message}`, 'error');
                    }
                } catch (error) {
                    showMessage(`Error de red: ${error.message}`, 'error');
                }
            });

            // PUT: Actualizar Reporte
            document.getElementById('updateForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const formData = new FormData(e.target);
                const data = Object.fromEntries(formData.entries());
                const id = data.id_reporte;

                try {
                    const response = await fetch(`${apiBaseUrl}/reporte/reporte-reserva/${id}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify(data),
                    });

                    const result = await response.json();
                    if (response.ok) {
                        showMessage(result.message, 'success');
                        e.target.reset();
                    } else {
                        showMessage(`Error: ${result.error || result.message}`, 'error');
                    }
                } catch (error) {
                    showMessage(`Error de red: ${error.message}`, 'error');
                }
            });

            // GET: Buscar Reporte
            document.getElementById('searchForm').addEventListener('submit', async (e) => {
                e.preventDefault();
                const id = document.getElementById('search_id').value;

                if (!id) {
                    showMessage('Por favor, ingrese un ID de reporte.', 'error');
                    return;
                }

                try {
                    const response = await fetch(`${apiBaseUrl}/reporte/reporte-evento/${id}`);
                    const result = await response.json();

                    if (response.ok) {
                        // Display the results
                        resultsContainer.classList.remove('hidden');
                        let htmlContent = `<div class="font-bold text-lg mb-2">Detalles del Reporte ${id}</div>`;
                        for (const [key, value] of Object.entries(result)) {
                            htmlContent += `<p class="mb-1"><strong>${key.replace(/_/g, ' ').toUpperCase()}:</strong> ${value}</p>`;
                        }
                        resultCard.innerHTML = htmlContent;
                        showMessage('Reporte encontrado exitosamente.', 'success');
                    } else {
                        resultsContainer.classList.add('hidden');
                        showMessage(`Error: ${result.error || result.message}`, 'error');
                    }
                } catch (error) {
                    resultsContainer.classList.add('hidden');
                    showMessage(`Error de red: ${error.message}`, 'error');
                }
            });
        });
    </script>
</body>
</html>
@endsection