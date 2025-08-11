// archivo: reporte.js
const cors = require('cors');
const mysql = require ('mysql');
const express = require('express');
const router = express.Router();
const bodyparser = require('body-parser');   

// 📌 Conexión a MySQL
const pool = mysql.createPool({
    connectionLimit: 10,
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
});

// Ruta para obtener TODOS los reportes (GET)
// Endpoint: GET http://localhost:3000/reporte/
router.get('/', (req, res) => {
    const sql = "SELECT * FROM reporte_de_reserva";
    pool.query(sql, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.status(200).json(results);
    });
});

// Ruta para obtener TODOS los reportes de eventos (GET)
// Endpoint: GET http://localhost:3000/reporte/eventos
router.get('/eventos', (req, res) => {
    const sql = "SELECT * FROM reporte_de_reserva";
    pool.query(sql, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.status(200).json(results);
    });
});

// Ruta para obtener TODOS los reportes de reservas (GET)  
// Endpoint: GET http://localhost:3000/reporte/reservas
router.get('/reservas', (req, res) => {
    const sql = "SELECT * FROM reporte_de_reserva";
    pool.query(sql, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        res.status(200).json(results);
    });
});

// =======================================================
// RUTAS PARA REPORTE DE EVENTOS
// =======================================================

// Ruta para OBTENER un reporte de evento por ID (GET)
// Endpoint: GET http://localhost:3000/reporte/reporte-evento/:id
router.get('/reporte-evento/:id', (req, res) => {
    const id = req.params.id;

    // Consulta SQL directa para obtener el reporte
    const sql = `
        SELECT * FROM reporte_de_reserva 
        WHERE id_reporte = ?
    `;
    
    pool.query(sql, [id], (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        if (results.length === 0) {
            return res.status(404).json({ message: 'Reporte de evento no encontrado' });
        }
        res.status(200).json(results[0]);
    });
});

// Ruta para INSERTAR un nuevo reporte de evento (POST)
// Endpoint: POST http://localhost:3000/reporte-evento
router.post('/reporte-evento', (req, res) => {
    // Ejemplo de body para Postman:
    /*
    {
        "id_reporte_evento": 123,
        "id_evento": 456,
        "nombre_evento": "Conferencia Anual",
        "descripcion": "Descripción del evento.",
        "fecha_inicio": "2024-06-01 09:00:00",
        "fecha_fin": "2024-06-01 17:00:00",
        "id_ubicacion_evento": 1
    }
    */
    // Validación: si no hay cuerpo de solicitud, devuelve un error
    if (!req.body) {
        return res.status(400).json({ error: 'Faltan datos en el cuerpo de la solicitud.' });
    }

    const {
        id_reporte_evento, // Nuevo campo
        id_evento,
        nombre_evento,
        descripcion,
        fecha_inicio,
        fecha_fin,
        id_ubicacion_evento
    } = req.body;

    // Llama al procedimiento almacenado para insertar
    const sql = 'CALL sp_insert_reporte_evento(?, ?, ?, ?, ?, ?, ?)';
    const values = [id_reporte_evento, id_evento, nombre_evento, descripcion, fecha_inicio, fecha_fin, id_ubicacion_evento];

    pool.query(sql, values, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        // Verificar si se insertó al menos una fila
        if (results.affectedRows > 0) {
            res.status(201).json({ message: 'Reporte de evento insertado exitosamente' });
        } else {
            res.status(500).json({ message: 'No se pudo insertar el reporte de evento.' });
        }
    });
});

// Ruta para ACTUALIZAR un reporte de evento por ID (PUT)
// Endpoint: PUT http://localhost:3000/reporte-evento/:id
router.put('/reporte-evento/:id', (req, res) => {
    const id = req.params.id;
    // Validación: si no hay cuerpo de solicitud, devuelve un error
    if (!req.body) {
        return res.status(400).json({ error: 'Faltan datos en el cuerpo de la solicitud.' });
    }

    const {
        id_reporte_evento, // Nuevo campo
        id_evento,
        nombre_evento,
        descripcion,
        fecha_inicio,
        fecha_fin,
        id_ubicacion_evento
    } = req.body;

    // Llama al procedimiento almacenado para actualizar
    const sql = 'CALL sp_update_reporte_evento(?, ?, ?, ?, ?, ?, ?, ?)';
    const values = [id, id_reporte_evento, id_evento, nombre_evento, descripcion, fecha_inicio, fecha_fin, id_ubicacion_evento];

    pool.query(sql, values, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        if (results.affectedRows === 0) {
            return res.status(404).json({ message: 'Reporte de evento no encontrado' });
        }
        res.status(200).json({ message: 'Reporte de evento actualizado exitosamente' });
    });
});

// =======================================================
// RUTAS PARA REPORTE DE RESERVA
// =======================================================

// Ruta para OBTENER un reporte de reserva por ID (GET)
// Endpoint: GET http://localhost:3000/reporte-reserva/:id
router.get('/reporte-reserva/:id', (req, res) => {
    const id = req.params.id;

    // Llama al procedimiento almacenado para seleccionar
    pool.query('CALL sp_select_reporte_reserva(?)', [id], (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        if (results[0].length === 0) {
            return res.status(404).json({ message: 'Reporte de reserva no encontrado' });
        }
        res.status(200).json(results[0][0]);
    });
});

// Ruta para INSERTAR un nuevo reporte de reserva (POST)
// Endpoint: POST http://localhost:3000/reporte-reserva
router.post('/reporte-reserva', (req, res) => {
    // Ejemplo de body para Postman:
    /*
    {
        "id_reporte": 1,
        "id_reserva": 101,
        "id_usuario": 201,
        "nombre_persona": "Ejemplo Nombre",
        "nombre_servicio": "Servicio de Ejemplo",
        "tipo_servicio": "Consulta",
        "descripcion_servicio": "Descripción detallada del servicio.",
        "fecha_reserva": "2024-05-20 10:00:00",
        "fecha_servicio": "2024-05-21 15:30:00",
        "ubicacion": "Ubicación de Ejemplo",
        "estado_reserva": "Pendiente"
    }
    */
    // Validación: si no hay cuerpo de solicitud, devuelve un error
    if (!req.body) {
        return res.status(400).json({ error: 'Faltan datos en el cuerpo de la solicitud.' });
    }

    // Se incluyó id_reporte en la desestructuración, tal como lo pediste
    const {
        id_reporte,
        id_reserva,
        id_usuario,
        nombre_persona,
        nombre_servicio,
        tipo_servicio,
        descripcion_servicio,
        fecha_reserva,
        fecha_servicio,
        ubicacion,
        estado_reserva
    } = req.body;

    // Llama al procedimiento almacenado para insertar
    // Se agregó id_reporte a la llamada del SP
    const sql = 'CALL sp_insert_reporte_reserva(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)';
    const values = [
        id_reporte,
        id_reserva,
        id_usuario,
        nombre_persona,
        nombre_servicio,
        tipo_servicio,
        descripcion_servicio,
        fecha_reserva,
        fecha_servicio,
        ubicacion,
        estado_reserva
    ];

    pool.query(sql, values, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        // Verificar si se insertó al menos una fila
        if (results.affectedRows > 0) {
            res.status(201).json({ message: 'Reporte de reserva insertado exitosamente' });
        } else {
            res.status(500).json({ message: 'No se pudo insertar el reporte de reserva.' });
        }
    });
});

// Ruta para ACTUALIZAR un reporte de reserva por ID (PUT)
// Endpoint: PUT http://localhost:3000/reporte-reserva/:id
router.put('/reporte-reserva/:id', (req, res) => {
    const id = req.params.id;
    // Validación: si no hay cuerpo de solicitud, devuelve un error
    if (!req.body) {
        return res.status(400).json({ error: 'Faltan datos en el cuerpo de la solicitud.' });
    }

    const {
        id_reserva,
        id_usuario,
        nombre_persona,
        nombre_servicio,
        tipo_servicio,
        descripcion_servicio,
        fecha_reserva,
        fecha_servicio,
        ubicacion,
        estado_reserva
    } = req.body;

    // Consulta SQL directa para actualizar
    const sql = `
        UPDATE reporte_de_reserva 
        SET id_reserva = ?, id_usuario = ?, nombre_persona = ?, nombre_servicio = ?, 
            tipo_servicio = ?, descripcion_servicio = ?, fecha_reserva = ?, 
            fecha_servicio = ?, ubicacion = ?, estado_reserva = ?
        WHERE id_reporte = ?
    `;
    const values = [
        id_reserva,
        id_usuario,
        nombre_persona,
        nombre_servicio,
        tipo_servicio,
        descripcion_servicio,
        fecha_reserva,
        fecha_servicio,
        ubicacion,
        estado_reserva,
        id  // El ID va al final para el WHERE
    ];

    pool.query(sql, values, (err, results) => {
        if (err) {
            return res.status(500).json({ error: err.message });
        }
        if (results.affectedRows === 0) {
            return res.status(404).json({ message: 'Reporte de reserva no encontrado' });
        }
        res.status(200).json({ message: 'Reporte de reserva actualizado exitosamente' });
    });
});

// Exportar el router
module.exports = router;
