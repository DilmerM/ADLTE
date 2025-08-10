const express = require('express');
const router = express.Router();
const mysql = require('mysql');
const multer = require('multer');
const path = require('path');

// Configurar multer para almacenar las imágenes
const storage = multer.diskStorage({
    destination: function (req, file, cb) {
        cb(null, path.join(__dirname, '../../public/images/imageServicios/'));
    },
    filename: function (req, file, cb) {
        // Generar un nombre único para el archivo
        const uniqueSuffix = Date.now() + '-' + Math.round(Math.random() * 1E9);
        cb(null, file.fieldname + '-' + uniqueSuffix + path.extname(file.originalname));
    }
});

// Filtrar solo imágenes
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
        fileSize: 5 * 1024 * 1024 // Límite de 5MB
    }
});

// Conexión a la base de datos
const pool = mysql.createPool({
    connectionLimit: 10,
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2'
});

// POST - Crear nuevo servicio con imagen
router.post('/', upload.single('imagen'), (req, res) => {
    try {
        const {
            nombre_servicio,
            descripcion,
            tipo_servicio,
            costo_base,
            duracion_promedio_minutos
        } = req.body;

        // Ruta de la imagen relativa para la base de datos
        const ruta_imagen = req.file ? `/images/imageServicios/${req.file.filename}` : null;

        pool.query(
            'CALL SP_CrearServicio(?, ?, ?, ?, ?, ?)',
            [nombre_servicio, descripcion, tipo_servicio, costo_base, duracion_promedio_minutos, ruta_imagen],
            (err, results) => {
                if (err) {
                    console.error('Error al crear el servicio:', err);
                    return res.status(500).json({
                        success: false,
                        message: 'Error al crear el servicio',
                        error: err.message
                    });
                }

                res.json({
                    success: true,
                    message: 'Servicio creado correctamente',
                    data: {
                        ...results[0],
                        ruta_imagen
                    }
                });
            }
        );
    } catch (error) {
        console.error('Error:', error);
        res.status(500).json({
            success: false,
            message: 'Error al procesar la solicitud',
            error: error.message
        });
    }
});

// GET - Obtener todos los servicios
router.get('/', (req, res) => {
    pool.query('SELECT * FROM servicios', (err, results) => {
        if (err) {
            return res.status(500).json({
                success: false,
                message: 'Error al obtener los servicios',
                error: err.message
            });
        }
        res.json(results);
    });
});

module.exports = router;
