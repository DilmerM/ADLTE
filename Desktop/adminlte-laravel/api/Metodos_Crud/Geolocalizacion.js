// Dilmer Eli Nuñez Moreira   N° 20221020048
// Equipo #2
const mysql = require('mysql');
const express = require('express');
const router = express.Router();
// Middleware para verificar el body (agrégalo al inicio del archivo)
router.use(express.json());
router.use(express.urlencoded({ extended: true }));

//conectando a la base de datos (mysql)   este si tiene esto ya que es direfente a la funcion
// la funcion de personas recibe directamente la conexion desde el index y esta la obtiene desde aqui.
// ojo si se elimina esta conexion no funcionara 
const pool = mysql.createPool({
    connectionLimit: 10, // Límite de conexiones para este módulo
    host: '142.44.161.115',
    user: '25-1700P4PAC2E2',
    password: '25-1700P4PAC2E2#e67',
    database: '25-1700P4PAC2E2',
    multipleStatements: true
});


// Obtener detalle de direccion por ID  SELECT - GET
// antes  : app.get   
// despues: router.get   obligatorio
router.get('/direcciones/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarDireccionDetallePorID(?)";
    pool.query(sql, [id], (err, rows, fields) => {
        if (!err) {
            res.json(rows[0]);
        } else {
            console.log(err);
            res.status(500).send('Error al obtener el detalle de la dirección');
        }
    });
});

// Insertar una nueva direccion   INSERT POST
router.post('/direcciones', (req, res) => {
    const {
        id_persona,
        ciudad,
        estado,
        cod_postal,  
        pais,
        id_direccion_geo
    } = req.body;

    const sql = "CALL SP_InsertarDireccion(?, ?, ?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_direccion;";
    pool.query(
        sql,
        [
            id_persona,
            ciudad,
            estado,
            cod_postal,  
            pais,
            id_direccion_geo
        ],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Dirección insertada correctamente",
                    id_direccion: results[1][0].id_direccion
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar la dirección');
            }
        }
    );
});


// Actualizar una dirección   UPDATE PUT
router.put('/direcciones/:id', (req, res) => {
    const id = req.params.id;
    const {
        ciudad,
        estado,
        cod_postal,
        pais,
        id_direccion_geo
    } = req.body;

    const sql = "CALL SP_ActualizarDireccion(?, ?, ?, ?, ?, ?)";
    pool.query(
        sql,
        [
            parseInt(id), // id_direccion
            id_direccion_geo,
            ciudad,
            estado,
            cod_postal,
            pais
        ],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Dirección actualizada correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar la dirección');
            }
        }
    );
});


// Eliminar una dirección por ID desde la API
router.delete('/direcciones/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarDireccion(?)";

    pool.query(sql, [id], (err, results) => {
        if (!err) {
            res.json({ mensaje: "Dirección eliminada correctamente" });
        } else {
            console.error("Error al eliminar la dirección:", err);
            res.status(500).send('Error al eliminar la dirección');
        }
    });
});

// INICIO DIRECCION GEOGRAFICA


// Obtener detalle de direccion geografica por ID // SELECT GET
router.get('/direcciones_geograficas/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarDireccionGeograficaDetallePorID(?)";
    pool.query(sql, [id], (err, rows, fields) => {
        if (!err) {
            res.json(rows[0]);
        } else {
            console.log(err);
            res.status(500).send('Error al obtener la dirección geográfica');
        }
    });
});



// Insertar una nueva dirección geografica   INSERT - POST
router.post('/direcciones_geograficas', (req, res) => {
    const {
        id_puntogeografico,
        calle_numero,
        colonia_barrio,
        ciudad,
        departamento_territorial, 
        municipio,
        estado_provincia,
        codigo_postal,
        pais,
        referencia
    } = req.body;

    const sql = "CALL SP_InsertarDireccionGeografica(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_direccion_geo;";
    pool.query(
        sql,
        [
            id_puntogeografico,
            calle_numero,
            colonia_barrio,
            ciudad,
            departamento_territorial,  
            municipio,
            estado_provincia,
            codigo_postal,
            pais,
            referencia
        ],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Dirección geográfica insertada correctamente",
                    id_direccion_geo: results[1][0].id_direccion_geo
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar la dirección geográfica');
            }
        }
    );
});
// Actualizar una direccion geografica UPDATE - PUT

router.put('/direcciones_geograficas/:id', (req, res) => {
    const id = req.params.id;
    const {
        id_puntogeografico,
        calle_numero,
        colonia_barrio,
        ciudad,
        departamento_territorial,  
        municipio,
        estado_provincia,
        codigo_postal,
        pais,
        referencia
    } = req.body;

    const sql = "CALL SP_ActualizarDireccionGeografica(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    pool.query(
        sql,
        [
            parseInt(id), // id_direccion_geo como entero
            id_puntogeografico,
            calle_numero,
            colonia_barrio,
            ciudad,
            departamento_territorial,
            municipio,
            estado_provincia,
            codigo_postal,
            pais,
            referencia
        ],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Dirección geográfica actualizada correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar la dirección geográfica');
            }
        }
    );
});

// Eliminar una dirección geográfica por ID desde la API
router.delete('/direcciones_geograficas/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarDireccionGeografica(?)";

    pool.query(sql, [id], (err, results) => {
        if (!err) {
            res.json({ mensaje: "Dirección geográfica eliminada correctamente" });
        } else {
            console.error("Error al eliminar la dirección geográfica:", err);
            res.status(500).send('Error al eliminar la dirección geográfica');
        }
    });
});

// FIN DIRECCION GEOGRAFICA;


//INICIO DE LOS METODOS DE LA TABLA PUNTOS GEOGRAFICOS

// Obtener un punto geografico por ID   SELECT - GET   http://localhost:3000/Geolocalizacion/puntos_geograficos/5
router.get('/puntos_geograficos/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarPuntoGeograficoPorID(?)";
    pool.query(sql, [id], (err, rows, fields) => {
        if (!err) {
            // El resultado viene como un array de arrays por el call
            res.json(rows[0]);
        } else {
            console.log(err);
            res.status(500).send('Error al obtener el punto geográfico');
        }
    });
});


// Insertar un nuevo punto geografico   INSERT - POST    http://localhost:3000/Geolocalizacion/puntos_geograficos
router.post('/puntos_geograficos', (req, res) => {
    const { latitud, longitud, nombre_punto, descripcion } = req.body;
    const sql = "CALL SP_InsertarPuntoGeografico(?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_punto_geografico;";
    pool.query(
        sql,
        [latitud, longitud, nombre_punto, descripcion],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Punto geográfico insertado correctamente",
                    id_punto_geografico: results[1][0].id_punto_geografico
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar el punto geográfico');
            }
        }
    );
});


// Actualizar un punto geografico   UPDATE - PUT   http://localhost:3000/Geolocalizacion/puntos_geograficos/6
router.put('/puntos_geograficos/:id', (req, res) => {
    const id = req.params.id;
    const { latitud, longitud, nombre_punto, descripcion } = req.body;
    const sql = "CALL SP_ActualizarPuntoGeografico(?, ?, ?, ?, ?)";
    pool.query(
        sql,
        [id, latitud, longitud, nombre_punto, descripcion],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Punto geográfico actualizado correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar el punto geográfico');
            }
        }
    );
});

// Eliminar un punto geográfico por ID desde la API       http://localhost:3000/Geolocalizacion/puntos_geograficos/10
router.delete('/puntos_geograficos/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarPuntoGeografico(?)";

    pool.query(sql, [id], (err, results) => {
        if (!err) {
            res.json({ mensaje: "Punto geográfico eliminado correctamente" });
        } else {
            console.error("Error al eliminar el punto geográfico:", err);
            res.status(500).send('Error al eliminar el punto geográfico');
        }
    });
});


// FIN PUNTO GEOGRAFICO;
// OBTENER TODOS LOS PUNTOS GEOGRAFICOS   SELECT - GET   http://localhost:3000/Geolocalizacion/puntos_geograficos
router.get('/puntos_geograficos', (req, res) => {
    // Asegúrate de tener un procedimiento almacenado como este en tu base de datos:
    // CREATE PROCEDURE SP_SeleccionarTodosPuntosGeograficos()
    // BEGIN
    //     SELECT * FROM Puntos_geograficos;
    // END
    const sql = "CALL SP_SeleccionarTodosPuntosGeograficos()";
    pool.query(sql, (err, rows, fields) => {
        if (!err) {
            // El resultado viene como un array de
            //  arrays por el CALL
            res.json(rows);
        } else {
            console.log(err);
            res.status(500).send('Error al obtener la lista de puntos geográficos');
        }
    });
});


router.get('/perfil-completo/:id', (req, res) => {
    const idUsuario = req.params.id;

    const sql = "CALL SP_ObtenerPerfilCompletoUsuario(?)";

    pool.query(sql, [idUsuario], (err, rows, fields) => {
        if (!err) {
            if (rows && rows[0] && rows[0][0]) {
                res.json({ usuario: rows[0][0] });
            } else {
                res.status(404).json({ message: "Usuario no encontrado en la base de datos." });
            }
        } else {
            console.error("Error al ejecutar SP_ObtenerPerfilCompletoUsuario:", err);
            res.status(500).send('Error al obtener los datos del perfil desde la base de datos.');
        }
    });
});


// 1. Endpoint para actualizar información personal (Versión corregida)
router.post('/actualizar-info-personal', (req, res) => {
    try {
        // Verificación de body
        if (!req.body) {
            return res.status(400).json({
                success: false,
                error: 'Cuerpo de la solicitud vacío',
                codigo_error: 'API-001'
            });
        }

        // Extraer campos con valores por defecto
        const body = req.body;
        const id_persona = body.id_persona || body.id_usuario; // Acepta ambos campos
        
        if (!id_persona) {
            return res.status(400).json({
                success: false,
                error: 'Se requiere id_persona o id_usuario',
                codigo_error: 'API-002'
            });
        }

        // Ejecutar procedimiento
        const sql = "CALL SP_ActualizarInformacionPersonal(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        
        pool.query(sql, [
            id_persona,
            body.primer_nombre || '',
            body.segundo_nombre || null,
            body.primer_apellido || '',
            body.segundo_apellido || null,
            body.tipo_identificacion || 'DNI',
            body.numero_identificacion || '',
            body.fecha_nacimiento || null,
            body.genero || 'Masculino',
            body.nacionalidad || '',
            body.estado_civil || 'Soltero/a'
        ], (err, results) => {
            if (err) {
                console.error("Error en BD:", err);
                return res.status(500).json({ 
                    success: false,
                    error: 'Error en la base de datos',
                    detalle: err.message
                });
            }
            
            res.json({ 
                success: true,
                message: "Información actualizada"
            });
        });

    } catch (error) {
        console.error("Error inesperado:", error);
        res.status(500).json({
            success: false,
            error: 'Error interno del servidor'
        });
    }
});

// 2. Endpoint para actualizar/crear dirección (Versión mejorada)
router.post('/actualizar-direccion', (req, res) => {
    try {
        // Verificación de body
        if (!req.body || Object.keys(req.body).length === 0) {
            return res.status(400).json({
                success: false,
                error: 'El cuerpo de la solicitud no puede estar vacío',
                codigo_error: 'API-001'
            });
        }

        // Destructuración con valores por defecto
        const {
            id_persona,
            id_direccion = null,
            ciudad = '',
            estado = '',
            cod_postal = '',
            pais = '',
            id_direccion_geo = null
        } = req.body;

        // Validación de campos obligatorios
        const camposObligatorios = [
            { campo: id_persona, nombre: 'id_persona' },
            { campo: ciudad, nombre: 'ciudad' },
            { campo: pais, nombre: 'pais' }
        ];

        const camposFaltantes = camposObligatorios.filter(item => !item.campo);

        if (camposFaltantes.length > 0) {
            return res.status(400).json({
                success: false,
                error: 'Campos obligatorios faltantes',
                campos_faltantes: camposFaltantes.map(item => item.nombre),
                codigo_error: 'API-002'
            });
        }

        // Configuración de la consulta según sea actualización o inserción
        let sql, params;

        if (id_direccion) {
            sql = "CALL SP_ActualizarDireccionUsuario(?, ?, ?, ?, ?, ?, ?)";
            params = [
                id_direccion,
                id_persona,
                ciudad,
                estado,
                cod_postal,
                pais,
                id_direccion_geo
            ];
        } else {
            sql = "CALL SP_InsertarDireccionUsuario(?, ?, ?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_direccion;";
            params = [
                id_persona,
                ciudad,
                estado,
                cod_postal,
                pais,
                id_direccion_geo
            ];
        }

        // Ejecución de la consulta
        pool.query(sql, params, (err, results) => {
            if (err) {
                console.error("Error en base de datos:", err);
                return res.status(500).json({
                    success: false,
                    error: 'Error al procesar la solicitud',
                    detalle: err.sqlMessage || err.message,
                    codigo_error: 'DB-001'
                });
            }

            // Preparar respuesta
            const response = {
                success: true,
                message: id_direccion 
                    ? "Dirección actualizada correctamente" 
                    : "Dirección creada correctamente"
            };

            // Si fue una inserción, agregar el nuevo ID
            if (!id_direccion && results[1]?.[0]?.id_direccion) {
                response.id_direccion = results[1][0].id_direccion;
            }

            res.json(response);
        });

    } catch (error) {
        console.error("Error inesperado:", error);
        res.status(500).json({
            success: false,
            error: 'Error interno del servidor',
            codigo_error: 'SERVER-001'
        });
    }
});

module.exports = router;//obligatorio