const mysql = require('mysql');
const express = require('express');
const router = express.Router();
const multer = require('multer');
const path = require('path');

// Configuración de multer para el manejo de imágenes
const storage = multer.diskStorage({
    destination: function (req, file, cb) {
        cb(null, path.join(__dirname, '../../public/images/imageServicios/'));
    },
    filename: function (req, file, cb) {
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, file.fieldname + '-' + uniqueSuffix + path.extname(file.originalname));
    }
});

const fileFilter = (req, file, cb) => {
    if (file.mimetype.startsWith('image/')) {
        cb(null, true);
    } else {
        cb(new Error('No es un archivo de imagen válido'), false);
    }
};

const upload = multer({ 
    storage: storage,
    fileFilter: fileFilter,
    limits: {
        fileSize: 10 * 1024 * 1024 // Límite de 10MB
    }
});

// Se crea un pool de conexiones en lugar de una única conexión
const pool = mysql.createPool({
    connectionLimit: 10,
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
});

// POST insertar un nuevo servicio
router.post('/', (req, res) => {
    upload.single('imagen')(req, res, function(err) {
        if (err instanceof multer.MulterError) {
            if (err.code === 'LIMIT_FILE_SIZE') {
                return res.status(400).json({
                    error: 'Archivo demasiado grande',
                    message: 'El tamaño máximo permitido es de 10MB'
                });
            }
            return res.status(400).json({
                error: 'Error al subir el archivo',
                message: err.message
            });
        } else if (err) {
            return res.status(500).json({
                error: 'Error al procesar la solicitud',
                message: err.message
            });
        }

        const {
            nombre_servicio,
            descripcion,
            tipo_servicio,
            costo_base,
            duracion_promedio_minutos
        } = req.body;
        
        // Obtener la ruta de la imagen si se subió una
        const ruta_imagen = req.file ? `/images/imageServicios/${req.file.filename}` : null;

        // Validación de parámetros requeridos
        if (!nombre_servicio || !descripcion || !tipo_servicio ||
            costo_base === undefined || duracion_promedio_minutos === undefined) {
            return res.status(400).json({
                error: 'Faltan parámetros requeridos',
                campos_requeridos: [
                    'nombre_servicio',
                    'descripcion',
                    'tipo_servicio',
                    'costo_base',
                    'duracion_promedio_minutos'
                ]
            });
        }

        const sql = `CALL SP_InsertarServicio(?, ?, ?, ?, ?, ?, @p_id_servicio); SELECT @p_id_servicio AS id_servicio;`;

        pool.query(sql, [
            nombre_servicio,
            descripcion,
            tipo_servicio,
            parseFloat(costo_base),
            parseInt(duracion_promedio_minutos),
            ruta_imagen
        ], (err, results) => {
            if (err) {
                console.error('Error al insertar servicio:', err);
                return res.status(500).json({
                    error: 'Error al insertar el servicio',
                    detalles: err.sqlMessage,
                    codigo_error: err.code
                });
            }

            const id_servicio = results[1][0].id_servicio;
            res.status(201).json({
                success: true,
                message: 'Servicio creado correctamente',
                id_servicio: id_servicio,
                ruta_imagen: ruta_imagen
            });
        });
    });
});

// PUT actualizar servicio por ID
router.put('/:id', upload.single('imagen'), (req, res) => {
    const {
        nombre_servicio,
        descripcion,
        tipo_servicio,
        costo_base,
        duracion_promedio_minutos
    } = req.body;

    const id_servicio = req.params.id;
    const ruta_imagen = req.file ? `/images/imageServicios/${req.file.filename}` : null;

    // Validación de parámetros requeridos
    if (!nombre_servicio || !descripcion || !tipo_servicio ||
        costo_base === undefined || duracion_promedio_minutos === undefined) {
        return res.status(400).json({
            error: 'Faltan parámetros requeridos',
            campos_requeridos: ['nombre_servicio', 'descripcion', 'tipo_servicio', 'costo_base', 'duracion_promedio_minutos']
        });
    }

    const sql = `CALL SP_ActualizarServicio(?, ?, ?, ?, ?, ?, ?)`;

    pool.query(sql, [
        id_servicio,
        nombre_servicio,
        descripcion,
        tipo_servicio,
        parseFloat(costo_base),
        parseInt(duracion_promedio_minutos),
        ruta_imagen
    ], (err, result) => {
        if (err) {
            console.error("Error al actualizar servicio:", err);
            return res.status(500).json({
                error: 'Error al actualizar el servicio',
                detalles: err.sqlMessage,
                codigo_error: err.code
            });
        }

        res.json({
            success: true,
            message: 'Servicio actualizado correctamente',
            id_servicio: id_servicio,
            ruta_imagen: ruta_imagen
        });
    });
});

// GET todos los servicios
router.get('/', (req, res) => {
    const sql = 'SELECT * FROM Servicio';
    
    pool.query(sql, (err, results) => {
        if (err) {
            console.error("Error al obtener servicios:", err);
            return res.status(500).json({
                error: 'Error al obtener los servicios',
                detalles: err.sqlMessage
            });
        }
        res.json(results);
    });
});

// GET servicio por ID
router.get('/:id', (req, res) => {
    const id = req.params.id;
    const sql = 'SELECT * FROM Servicio WHERE id_servicio = ?';
    
    pool.query(sql, [id], (err, results) => {
        if (err) {
            console.error("Error al obtener servicio:", err);
            return res.status(500).json({
                error: 'Error al obtener el servicio',
                detalles: err.sqlMessage
            });
        }
        
        if (results.length === 0) {
            return res.status(404).json({
                error: 'Servicio no encontrado'
            });
        }
        
        res.json(results[0]);
    });
});

// DELETE servicio por ID (borrado lógico)
router.delete('/:id', (req, res) => {
    const id = req.params.id;
    const sql = 'DELETE FROM Servicio WHERE id_servicio = ?';
    
    pool.query(sql, [id], (err, result) => {
        if (err) {
            console.error("Error al eliminar servicio:", err);
            return res.status(500).json({
                error: 'Error al eliminar el servicio',
                detalles: err.sqlMessage
            });
        }
        
        if (result.affectedRows === 0) {
            return res.status(404).json({
                error: 'Servicio no encontrado'
            });
        }
        
        res.json({
            success: true,
            message: 'Servicio eliminado correctamente'
        });
    });
});

module.exports = router;
