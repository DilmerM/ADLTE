// ./Metodos_Crud/Usuario.js

const express = require('express');
const router = express.Router();
const mysql = require('mysql');
const multer = require('multer');
const path = require('path');
const fs = require('fs');

// --- CONFIGURACIÓN DE MULTER ---
const storage = multer.diskStorage({
    destination: (req, file, cb) => {
        const uploadPath = path.join(__dirname, '..', '..', 'public', 'uploads', 'profile-photos');
        fs.mkdirSync(uploadPath, { recursive: true });
        cb(null, uploadPath);
    },
    filename: (req, file, cb) => {
        const uniqueName = req.params.id_usuario + '-' + Date.now() + path.extname(file.originalname);
        cb(null, uniqueName);
    }
});

const upload = multer({
    storage: storage,
    fileFilter: (req, file, cb) => {
        const filetypes = /jpeg|jpg|png|gif/;
        const mimetype = filetypes.test(file.mimetype);
        const extname = filetypes.test(path.extname(file.originalname).toLowerCase());
        if (mimetype && extname) {
            return cb(null, true);
        }
        cb("Error: ¡Solo se permiten archivos de imagen!");
    }
});

// --- CONEXIÓN A LA BASE DE DATOS ---
const dbConfig = {
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
};

// --- ENDPOINTS ---

// Endpoint de Registro
router.post('/registro', (req, res) => {
    // ... (Tu código de registro se mantiene igual)
    console.log('Recibido en /registro. Body:', req.body);
    const { 
        primer_nombre, segundo_nombre, primer_apellido, segundo_apellido,
        fecha_nacimiento, genero, nacionalidad, tipo_identificacion,
        numero_identificacion, estado_civil,
        nombre_usuario, contrasena_usuario 
    } = req.body;
    if (!primer_nombre || !primer_apellido || !fecha_nacimiento || !genero || !nacionalidad || !estado_civil || !tipo_identificacion || !numero_identificacion || !nombre_usuario || !contrasena_usuario) {
        return res.status(400).json({ success: false, message: 'Por favor, complete todos los campos requeridos.' });
    }
    const mysqlConnection = mysql.createConnection(dbConfig);
    mysqlConnection.beginTransaction(err => {
        if (err) {
            console.error("Error al iniciar la transacción:", err);
            return res.status(500).json({ success: false, message: 'Error interno del servidor.' });
        }
        const personaQuery = 'CALL SP_InsertarPersona(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @p_id_persona_generada); SELECT @p_id_persona_generada AS id_persona;';
        const personaParams = [
            primer_nombre, segundo_nombre || null, primer_apellido, segundo_apellido || null,
            fecha_nacimiento, genero, nacionalidad, tipo_identificacion, numero_identificacion, estado_civil
        ];
        mysqlConnection.query(personaQuery, personaParams, (err, results) => {
            if (err) {
                return mysqlConnection.rollback(() => {
                    const message = err.code === 'ER_DUP_ENTRY' ? 'El número de identificación ya está registrado.' : 'Error al crear la persona.';
                    console.error("Error en Operación 1:", err);
                    res.status(409).json({ success: false, message });
                });
            }
            const nueva_persona_id = results[1][0].id_persona;
            const usuarioQuery = 'CALL SP_InsertarUsuario(?, ?, ?, @p_mensaje); SELECT @p_mensaje AS mensaje;';
            const usuarioParams = [nueva_persona_id, nombre_usuario, contrasena_usuario];
            mysqlConnection.query(usuarioQuery, usuarioParams, (err, results) => {
                if (err) {
                    return mysqlConnection.rollback(() => {
                        console.error("Error en Operación 2:", err);
                        res.status(500).json({ success: false, message: 'Error al crear el usuario.' });
                    });
                }
                const mensaje = results[1][0].mensaje;
                if (mensaje.includes('exitosamente')) {
                    mysqlConnection.commit(err => {
                        if (err) {
                            return mysqlConnection.rollback(() => {
                                console.error("Error al hacer commit:", err);
                                res.status(500).json({ success: false, message: 'Error al finalizar el registro.' });
                            });
                        }
                        res.status(201).json({ success: true, message: mensaje });
                    });
                } else {
                    mysqlConnection.rollback(() => {
                        res.status(409).json({ success: false, message: mensaje });
                    });
                }
            });
        });
    });
});

// Endpoint de Login
router.post('/login', (req, res) => {
    // ... (Tu código de login se mantiene igual)
    console.log('Recibido en /login. Body:', req.body);
    const { nombre_usuario, contrasena_usuario } = req.body;
    if (!nombre_usuario || !contrasena_usuario) {
        return res.status(400).json({ success: false, message: 'El nombre de usuario y la contraseña son requeridos.' });
    }
    const query = 'CALL SP_VerificarUsuarioLogin(?)';
    const mysqlConnection = mysql.createConnection(dbConfig);
    mysqlConnection.query(query, [nombre_usuario], (err, results) => {
        if (err) {
            console.error('Error en la consulta a la base de datos:', err);
            return res.status(500).json({ success: false, message: 'Error interno del servidor.' });
        }
        if (results[0].length === 0) {
            return res.status(401).json({ success: false, message: 'Las credenciales proporcionadas son incorrectas.' });
        }
        const usuario = results[0][0];
        if (contrasena_usuario === usuario.contrasena_usuario) {
            const updateQuery = 'CALL SP_ActualizarUltimoAcceso(?)';
            mysqlConnection.query(updateQuery, [usuario.id_usuario], (updErr, updRes) => {
                if(updErr) console.error("Error al actualizar fecha de acceso:", updErr);
            });
            const authToken = `simple-token-for-user-${usuario.id_usuario}-${Date.now()}`;
            return res.status(200).json({
                success: true,
                message: '¡Inicio de sesión exitoso!',
                token: authToken,
                usuario: usuario
            });
        } else {
            return res.status(401).json({ success: false, message: 'Las credenciales proporcionadas son incorrectas.' });
        }
    });
});

// Endpoint para obtener datos frescos del perfil (MODIFICADO)
router.get('/perfil/:id_usuario', (req, res) => {
    const { id_usuario } = req.params;
    const mysqlConnection = mysql.createConnection(dbConfig);
    
    // ==================================================================
    // ¡CONSULTA ACTUALIZADA!
    // Ahora usa un JOIN para traer los datos de la tabla Personas también.
    // ==================================================================
    const query = `
        SELECT 
            u.id_usuario, u.id_persona, u.nombre_usuario, u.fecha_ultimo_acceso, u.ruta_foto_perfil,
            p.primer_nombre, p.segundo_nombre, p.primer_apellido, p.segundo_apellido,
            p.fecha_nacimiento, p.genero, p.nacionalidad, p.tipo_identificacion,
            p.numero_identificacion, p.estado_civil
        FROM Usuarios u
        JOIN Personas p ON u.id_persona = p.id_persona
        WHERE u.id_usuario = ?`;
    
    mysqlConnection.query(query, [id_usuario], (err, results) => {
        if (err) {
            console.error('Error al obtener el perfil con JOIN:', err);
            return res.status(500).json({ success: false, message: 'Error al obtener datos del perfil.' });
        }
        if (results.length === 0) {
            return res.status(404).json({ success: false, message: 'Usuario no encontrado.' });
        }
        res.status(200).json({ success: true, usuario: results[0] });
    });
});

// Endpoint para Actualizar Perfil
router.patch('/perfil/actualizar/:id_usuario', upload.single('photo'), (req, res) => {
    // ... (Tu código de actualización se mantiene igual)
    const { id_usuario } = req.params;
    const { nombre_usuario, contrasena_usuario } = req.body;
    if (!nombre_usuario) {
        return res.status(400).json({ success: false, message: 'El nombre de usuario es requerido.' });
    }
    const mysqlConnection = mysql.createConnection(dbConfig);
    mysqlConnection.query("SELECT ruta_foto_perfil FROM Usuarios WHERE id_usuario = ?", [id_usuario], (err, results) => {
        if (err || results.length === 0) {
            return res.status(500).json({ success: false, message: 'No se pudo encontrar el usuario para actualizar.' });
        }
        const currentPhotoPath = results[0].ruta_foto_perfil;
        const ruta_para_db = req.file
            ? path.join('uploads', 'profile-photos', path.basename(req.file.path)).replace(/\\/g, '/')
            : currentPhotoPath;
        const query = 'CALL SP_ActualizarPerfilUsuario(?, ?, ?, ?)';
        const params = [id_usuario, nombre_usuario, ruta_para_db, contrasena_usuario || null];
        mysqlConnection.query(query, params, (err, sp_results) => {
            if (err) {
                console.error('Error al llamar a SP_ActualizarPerfilUsuario:', err);
                return res.status(500).json({ success: false, message: 'Error interno del servidor al actualizar el perfil.' });
            }
            res.status(200).json({
                success: true,
                message: '¡Perfil actualizado con éxito!',
                nuevaRutaFoto: ruta_para_db
            });
        });
    });
});

module.exports = router;
