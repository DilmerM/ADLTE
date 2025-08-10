const mysql = require('mysql');
const express = require('express');
const router = express.Router();

const mysqlConnection = mysql.createPool({
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true,
    connectionLimit: 10,
    waitForConnections: true
});

// Middleware de autenticación
const authenticate = (req, res, next) => {
    const token = req.headers['auth-token'];
    
    if (!token) {
        return res.status(401).json({ success: false, message: 'Token de autenticación requerido' });
    }
    
    const tokenParts = token.split('-');
    if (tokenParts.length < 5 || tokenParts[0] !== 'simple' || tokenParts[1] !== 'token' || tokenParts[2] !== 'for' || tokenParts[3] !== 'user') {
        return res.status(401).json({ success: false, message: 'Token inválido' });
    }
    
    const userId = parseInt(tokenParts[4]);
    if (isNaN(userId)) {
        return res.status(401).json({ success: false, message: 'Token inválido - ID de usuario no numérico' });
    }
    
    mysqlConnection.query(
        'SELECT id_persona FROM Usuarios WHERE id_usuario = ?',
        [userId],
        (err, results) => {
            if (err) {
                console.error('Error al verificar usuario:', err);
                return res.status(500).json({ 
                    success: false, 
                    message: 'Error al verificar usuario en la base de datos' 
                });
            }
            
            if (!results || results.length === 0) {
                return res.status(404).json({ 
                    success: false, 
                    message: 'Usuario no encontrado en la base de datos' 
                });
            }
            
            req.userId = userId;
            req.personaId = results[0].id_persona;
            next();
        }
    );
};

// POST crear reserva
router.post('/', authenticate, (req, res) => {
    const {
        id_servicio,
        id_ubicacion_reserva,
        id_evento,
        id_actividad,
        fecha_hora_inicio,
        fecha_hora_fin,
        estado_reserva,
        costo_total
    } = req.body;

    // Validación de campos requeridos
    if (!id_servicio || !fecha_hora_inicio || !id_ubicacion_reserva) {
        return res.status(400).json({ 
            success: false, 
            message: 'ID de servicio, ubicación y fecha/hora de inicio son requeridos' 
        });
    }

    // Validar el estado de la reserva
    const estados_validos = ['pendiente', 'confirmada', 'completada', 'cancelada'];
    if (estado_reserva && !estados_validos.includes(estado_reserva.toLowerCase())) {
        return res.status(400).json({
            success: false,
            message: 'Estado de reserva inválido. Estados permitidos: ' + estados_validos.join(', ')
        });
    }

    // Validar fechas
    const inicio = new Date(fecha_hora_inicio);
    const fin = fecha_hora_fin ? new Date(fecha_hora_fin) : null;
    
    if (isNaN(inicio.getTime())) {
        return res.status(400).json({
            success: false,
            message: 'Fecha de inicio inválida'
        });
    }

    if (fin && (isNaN(fin.getTime()) || fin <= inicio)) {
        return res.status(400).json({
            success: false,
            message: 'Fecha de fin debe ser posterior a la fecha de inicio'
        });
    }

    // Validar que el servicio existe
    mysqlConnection.query('SELECT id_servicio FROM Servicios WHERE id_servicio = ?', 
        [id_servicio], 
        (err, serviceResults) => {
            if (err || serviceResults.length === 0) {
                return res.status(400).json({
                    success: false,
                    message: 'El servicio especificado no existe'
                });
            }

            // Validar que la ubicación existe
            mysqlConnection.query('SELECT id_ubicacion FROM Ubicaciones WHERE id_ubicacion = ?', 
                [id_ubicacion_reserva], 
                (err, locationResults) => {
                    if (err || locationResults.length === 0) {
                        return res.status(400).json({
                            success: false,
                            message: 'La ubicación especificada no existe'
                        });
                    }

                    // Validar evento si se proporciona
                    if (id_evento) {
                        mysqlConnection.query('SELECT id_evento FROM Eventos WHERE id_evento = ?', 
                            [id_evento], 
                            (err, eventResults) => {
                                if (err || eventResults.length === 0) {
                                    return res.status(400).json({
                                        success: false,
                                        message: 'El evento especificado no existe'
                                    });
                                }
                                realizarInsert();
                            }
                        );
                    } else {
                        realizarInsert();
                    }
                }
            );
        }
    );

    // Función para realizar el insert
    const realizarInsert = () => {
        const now = new Date().toISOString().slice(0, 19).replace('T', ' ');
        
        mysqlConnection.query(
            `INSERT INTO Reservas (
                id_servicio,
                id_persona_reserva,
                id_ubicacion_reserva,
                id_evento,
                id_actividad,
                fecha_hora_inicio,
                fecha_hora_fin,
                estado_reserva,
                costo_total,
                fecha_creacion,
                ultima_actualizacion
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)`,
            [
                parseInt(id_servicio),
                req.personaId,
                parseInt(id_ubicacion_reserva),
                id_evento ? parseInt(id_evento) : null,
                id_actividad ? parseInt(id_actividad) : null,
                fecha_hora_inicio,
                fecha_hora_fin || null,
                estado_reserva || 'pendiente',
                costo_total ? parseFloat(costo_total) : null,
                now,
                now
            ],
            (err, results) => {
                if (err) {
                    console.error('Error en la base de datos:', err);
                    return res.status(500).json({ 
                        success: false, 
                        message: 'Error en la base de datos',
                        error: err.message 
                    });
                }

                if (!results || !results.insertId) {
                    return res.status(500).json({
                        success: false,
                        message: 'No se pudo crear la reserva'
                    });
                }

                res.status(201).json({
                    success: true,
                    id_reserva: results.insertId,
                    message: 'Reserva creada exitosamente'
                });
            }
        );
    };
});

module.exports = router;
