const mysql = require('mysql');
const express = require('express');
const router = express.Router();

// Middleware para procesar JSON y datos de formulario
router.use(express.json());
router.use(express.urlencoded({ extended: true }));

const pool = mysql.createPool({
    connectionLimit: 10,
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
});

// GET - Obtener todas las reservas
router.get('/', (req, res) => {
    pool.query('CALL SP_ObtenerReservasConDetalles()', (err, results) => {
        if (err) {
            console.error('Error al obtener reservas:', err);
            return res.status(500).json({
                success: false,
                message: 'Error al obtener las reservas',
                error: err.message
            });
        }
        // El resultado de un CALL es un array de arrays, tomamos el primero
        res.json({
            success: true,
            data: results[0]
        });
    });
});

// GET - Obtener una reserva específica
router.get('/:id', (req, res) => {
    pool.query(
        `SELECT 
            r.id_reserva,
            r.id_usuario,
            u.nombre_usuario,
            r.fecha_reserva,
            r.fecha_servicio,
            r.ubicacion,
            r.estado_reserva,
            r.notas,
            r.created_at,
            r.updated_at
        FROM reservas2 r
        LEFT JOIN Usuarios u ON r.id_usuario = u.id_usuario
        WHERE r.id_reserva = ?`,
        [req.params.id],
        (err, results) => {
            if (err) {
                console.error('Error al obtener la reserva:', err);
                return res.status(500).json({
                    success: false,
                    message: 'Error al obtener la reserva',
                    error: err.message
                });
            }

            if (results.length === 0) {
                return res.status(404).json({
                    success: false,
                    message: 'Reserva no encontrada'
                });
            }

            res.json({
                success: true,
                data: results[0]
            });
        }
    );
});

// POST - Crear nueva reserva
router.post('/', (req, res) => {
    const {
        id_usuario,
        fecha_reserva,
        fecha_servicio,
        ubicacion,
        estado_reserva,
        notas,
        nombre_persona,
    nombre_servicio,
    tipo_servicio,
    descripcion_servicio,
    costo_base,
    duracion_promedio_minutos
    } = req.body;

    pool.query(
        'CALL SP_CrearReservaConUsuario(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)',
        [
            id_usuario,
            fecha_reserva,
            fecha_servicio,
            ubicacion,
            estado_reserva,
            notas,
            nombre_persona,
            nombre_servicio,
            tipo_servicio,
            descripcion_servicio,
            costo_base,
            duracion_promedio_minutos
        ],
        (err, results) => {
            if (err) {
                console.error('Error al crear la reserva:', err);
                return res.status(500).json({
                    success: false,
                    message: 'Error al crear la reserva',
                    error: err.message
                });
            }
            res.json({
                success: true,
                message: 'Reserva creada correctamente',
                data: results[0]
            });
        }
    );
});

// PUT - Actualizar reserva
router.put('/:id', (req, res) => {
    const { fecha_servicio, ubicacion, estado_reserva, notas } = req.body;
    const updates = [];
    const values = [];

    // Solo actualizamos el estado_reserva
    if (estado_reserva) {
        updates.push('estado_reserva = ?');
        values.push(estado_reserva);
    }

    if (updates.length === 0) {
        return res.status(400).json({
            success: false,
            message: 'No se proporcionaron campos para actualizar'
        });
    }

    values.push(req.params.id);

    pool.query(
        `UPDATE reservas2 SET ${updates.join(', ')} WHERE id_reserva = ?`,
        values,
        (err, results) => {
            if (err) {
                console.error('Error al actualizar la reserva:', err);
                return res.status(500).json({
                    success: false,
                    message: 'Error al actualizar la reserva',
                    error: err.message
                });
            }

            if (results.affectedRows === 0) {
                return res.status(404).json({
                    success: false,
                    message: 'Reserva no encontrada'
                });
            }

            res.json({
                success: true,
                message: 'Reserva actualizada exitosamente'
            });
        }
    );
});

// DELETE - Eliminar reserva
router.delete('/:id', (req, res) => {
    pool.query(
        'DELETE FROM reservas2 WHERE id_reserva = ?',
        [req.params.id],
        (err, results) => {
            if (err) {
                console.error('Error al eliminar la reserva:', err);
                return res.status(500).json({
                    success: false,
                    message: 'Error al eliminar la reserva',
                    error: err.message
                });
            }

            if (results.affectedRows === 0) {
                return res.status(404).json({
                    success: false,
                    message: 'Reserva no encontrada'
                });
            }

            res.json({
                success: true,
                message: 'Reserva eliminada exitosamente'
            });
        }
    );
});

// GET - Obtener id_persona por id_usuario usando procedimiento almacenado
router.get('/persona-por-usuario/:id_usuario', (req, res) => {
    const id_usuario = req.params.id_usuario;
    pool.query('CALL SP_ObtenerIdPersonaPorUsuario(?)', [id_usuario], (err, results) => {
        if (err) {
            console.error('Error al obtener id_persona:', err);
            return res.status(500).json({
                success: false,
                message: 'Error al obtener el id_persona',
                error: err.message
            });
        }
        // El resultado estará en results[0][0]
        if (results[0] && results[0][0] && results[0][0].id_persona) {
            res.json({
                success: true,
                id_persona: results[0][0].id_persona
            });
        } else {
            res.status(404).json({
                success: false,
                message: 'No se encontró id_persona para el usuario proporcionado'
            });
        }
    });
});

module.exports = router;
