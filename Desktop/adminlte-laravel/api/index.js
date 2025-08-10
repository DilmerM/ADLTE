// app.js o tu archivo principal de servidor

const express = require('express');
const mysql = require('mysql');
const cors = require('cors');
const path = require('path'); // <-- AÑADIDO: Necesario para servir archivos

// --- 1. INICIALIZACIÓN DE LA APP ---
const app = express();
const PORT = 3000;

// --- 2. CONFIGURACIÓN DE CORS (MODIFICADO) ---
// ==================================================================
// ¡CORRECCIÓN IMPORTANTE!
// Se simplifica la configuración de CORS para permitir todas las solicitudes
// de origen cruzado. Esto soluciona el error "Failed to fetch"
// al asegurar que las solicitudes 'preflight' (OPTIONS) se manejen correctamente.
// ==================================================================
app.use(cors());


// --- 3. MIDDLEWARES ESENCIALES ---
// Para entender peticiones con cuerpo en formato JSON
app.use(express.json());
// Para entender datos de formularios
app.use(express.urlencoded({ extended: true }));
// Para servir archivos estáticos (imágenes) desde la carpeta 'public'
app.use(express.static(path.join(__dirname, 'public')));


// --- 4. CONEXIÓN A LA BASE DE DATOS ---
var mysqlConnection = mysql.createConnection({
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
});

mysqlConnection.connect((err) => {
    if (!err) {
        console.log('Conexión a la base de datos exitosa');
    } else {
        console.log('Error al conectar a la base de datos ', err);
    }
});


// --- 5. DEFINICIÓN DE RUTAS ---
// Se cargan todos los módulos de rutas del equipo.

// Importar y usar las rutas de personas
const personasRoutes = require('./Metodos_Crud/Personas');
app.use('/api/personas', personasRoutes);

// Importar y usar las rutas de reservas2
const reservas2Routes = require('./Metodos_Crud/Reservas2');
app.use('/api/reservas2', reservas2Routes);

const usuariosRoutes = require('./Metodos_Crud/Usuario.js'); // Asegúrate que el nombre del archivo sea 'Usuario.js'
app.use('/api/usuarios', usuariosRoutes);


// --- OTRAS RUTAS DE TU EQUIPO (se mantienen igual) ---

// Módulo Personas (Osman)
app.use('/personas', require('./Metodos_Crud/Personas.js')(mysqlConnection));

// Módulo Geolocalización (Dilmer)
const geolocalizacionRoutes = require('./Metodos_Crud/Geolocalizacion.js');
app.use('/api/geolocalizacion', geolocalizacionRoutes);

// Módulo Reservas (Sarai)
const reservasRoutes = require('./Metodos_Crud/Reservas.js');
app.use('/reservas', reservasRoutes);

// Módulo Servicios (Sarai)
const servicioRoutes = require('./Metodos_Crud/Servicio.js');
app.use('/servicios', servicioRoutes);

// Módulo Reportes (Elizabeth)
const reporteGeneradosrouter = require ('./Metodos_Crud/reportes.js');
app.use('/reportes', reporteGeneradosrouter);

// Henrry Módulo Eventos
const eventosRoutes = require('./Metodos_Crud/Eventos.js');
app.use('/Eventos', eventosRoutes);

// Módulo Actividades (Henrry)
const actividadesRoutes = require('./Metodos_Crud/Actividades.js');
app.use('/Actividades', actividadesRoutes);

// Módulo Asistencias (Henrry)
const asistenciasRouter = require('./Metodos_Crud/Asistencias.js');
app.use('/Asistencias', asistenciasRouter);

// Módulo Administración y Control (Daniel Rivera)
const administracionControlRoutes = require('./Metodos_Crud/Administracion_control.js');
app.use('/Administracion_control', administracionControlRoutes);


// --- 6. INICIAR EL SERVIDOR ---
app.listen(PORT, () => console.log(`Servidor en puerto ${PORT}`));
