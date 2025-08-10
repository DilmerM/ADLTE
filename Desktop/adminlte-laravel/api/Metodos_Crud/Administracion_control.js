
// ALUMNO: DANIEL ARMANDO RIVERA BUSTILLO
// CUENTA: 20201004200
// GRUPO: 2
//constante para el paquete de mysql


const mysql = require('mysql');
const express = require('express');
const bp = require('body-parser');
const router = express.Router();
// obligatorio tener esto!!



//conectando a la base de datos (mysql)   este si tiene esto ya que es direfente a la funcion
// la funcion de personas recibe directamente la conexion desde el index y esta la obtiene desde aqui.
// ojo si se elimina esta conexion no funcionara 
// Importamos el módulo 'mysql' para poder conectarnos a la base de datos

// Creamos un pool de conexiones para manejar múltiples consultas simultáneamente
// Esto mejora el rendimiento y evita abrir/cerrar conexiones repetidamente
const pool = mysql.createPool({
    connectionLimit: 10, // Límite máximo de conexiones activas al mismo tiempo
    host: '142.44.161.115', // Dirección del servidor de la base de datos
    user: '25-1700P4PAC2E2', // Usuario con permisos para acceder a la base de datos
    password: '25-1700P4PAC2E2#e67', // Contraseña del usuario
    database: '25-1700P4PAC2E2', // Nombre de la base de datos a la que nos conectaremos
    multipleStatements: true // Permite ejecutar múltiples sentencias SQL en una sola consulta
});

// Exportamos el pool para poder usarlo en otros módulos de nuestra aplicación
module.exports = pool;


/////////USUARIO_ROLES/////////////////////

//GET USUARIO_ROLES
//Obtiene el detalle completo de la asignación de rol a un usuario por medio del ID de esa relación. Es útil para ver qué rol tiene asignado un usuario en específico.
router.get('/Usuario_roles/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarUsuarioRolDetallePorID(?)";
    pool.query(sql, [id], (err, rows, fields) => {
        if (!err) {
            res.json(rows[0]);
        } else {
            console.log(err);
            res.status(500).send('Error al obtener el rol');
        }
    });
});


router.get('/Usuario_roles', (req, res) => {
  const sql = "CALL SP_SeleccionarTodosUsuarioRoles()";
  pool.query(sql, (err, rows) => {
    if (!err) {
      res.json(rows[0]);  // Envío sólo el primer elemento que contiene los datos
    } else {
      console.error(err);
      res.status(500).send('Error al obtener la lista de Usuario_roles');
    }
  });
});






//INSERTAR USUARIO_ROLES
//Asocia un rol existente a un usuario específico. Crea una nueva fila en la tabla Usuario_roles.
router.post('/Usuario_roles', (req, res) => {
    const { id_usuario, id_rol } = req.body;
    const sql = "CALL SP_InsertarUsuarioRol(?, ?, @nuevo_id); SELECT @nuevo_id AS id_usuario_rol;";
    pool.query(
        sql,
        [id_usuario, id_rol],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Rol insertado correctamente",
                    id_usuario_rol: results[1][0].id_usuario_rol
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar el Rol');
            }
        }
    );
});



// ACTUALIZAR USUARIO_ROLES
//Actualiza la relación existente entre un usuario y un rol. Sirve para cambiar el rol asignado a un usuario específico.
router.put('/Usuario_roles/:id', (req, res) => {
    const id_usuario_rol = req.params.id;
    const { id_usuario, id_rol } = req.body;

    const sql = "CALL SP_ActualizarUsuarioRol(?, ?, ?)";

    pool.query(
        sql,
        [id_usuario_rol, id_usuario, id_rol],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Usuario_rol actualizado correctamente" });
            } else {
                console.error(err);
                res.status(500).send('Error al actualizar Usuario_rol');
            }
        }
    );
});

//DELETE USUARIO ROLES

router.delete('/Usuario_roles/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarUsuarioRol(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al eliminar el Rol del usuario');
        }
    });
});



/////////ROLES/////////////////////

//GET ROLES
//Obtiene la información detallada de un rol específico por su ID.

router.get('/roles/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarRolPorID(?)";
    pool.query(sql, [id], (err, rows, fields) => {
        if (!err) {
            res.json(rows[0]);
        } else {
            console.log(err);
            res.status(500).send('Error al obtener el rol');
        }
    });
});


router.get('/roles', (req, res) => {
  const sql = "CALL SP_SeleccionarTodosRoles()";
  pool.query(sql, (err, rows) => {
    if (!err) {
      res.json(rows[0]);  // Envío sólo el primer elemento que contiene los datos
    } else {
      console.error(err);
      res.status(500).send('Error al obtener la lista de Usuario_roles');
    }
  });
});

//INSERTAR ROLES
//Crea un nuevo rol en el sistema.


router.post('/roles', (req, res) => {
    const { nombre_rol, descripcion } = req.body;
    const sql = "CALL SP_InsertarRol(?, ?, @nuevo_id); SELECT @nuevo_id AS id_rol;";
    pool.query(
        sql,
        [nombre_rol, descripcion],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Rol insertado correctamente",
                    id_rol: results[1][0].id_rol
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar el Rol');
            }
        }
    );
});



//ACTUZALIZAR ROLES
//Actualiza los datos de un rol existente (nombre o descripción).

router.put('/roles/:id', (req, res) => {
    const id = req.params.id;
    const { nombre_rol, descripcion } = req.body;
    const sql = "CALL SP_ActualizarRol(?, ?, ?)";
    pool.query(
        sql,
        [id, nombre_rol, descripcion],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Rol actualizado correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar el Rol');
            }
        }
    );
});


//DELETE ROLES

router.delete('/Roles/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarRol(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al eliminar el Rol');
        }
    });
});

/////////BACKUPS/////////////////////

//GET BACKUPS
//Obtiene la información detallada de un backup por su ID, incluyendo quién lo realizó, el tamaño, tipo, etc.

router.get('/Backups/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarBackupDetallePorID(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al obtener el Backup');
        }
    });
});


router.get('/Backups', (req, res) => {
  const sql = "CALL SP_SeleccionarTodosBackups()";
  pool.query(sql, (err, rows) => {
    if (!err) {
      res.json(rows[0]);  // Envío sólo el primer elemento que contiene los datos
    } else {
      console.error(err);
      res.status(500).send('Error al obtener');
    }
  });
});



//INSERTAR BACKUPS
//Crea un nuevo registro de backup. Requiere que el ID de persona exista en la tabla Usuarios (clave foránea).

router.post('/Backups', (req, res) => {
    const { nombre_archivo, ruta_almacenamiento, tipo_backup, tamano_mb, id_persona } = req.body;
    const sql = "CALL SP_InsertarBackup(?, ?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_backup;";
    pool.query(
        sql,
        [nombre_archivo, ruta_almacenamiento, tipo_backup, tamano_mb, id_persona],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Backup insertado correctamente",
                    id_backup: results[1][0].id_backup
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar el Backup');
            }
        }
    );
});



//ACTUZALIZAR BACKUPS
//Actualiza un backup ya existente por su ID. También valida la relación con Usuarios.


router.put('/Backups/:id', (req, res) => {
    const id_backup = req.params.id;
    const { nombre_archivo, ruta_almacenamiento, tipo_backup, tamano_mb, id_persona} = req.body;
    const sql = "CALL SP_ActualizarBackup(?, ?, ?, ?, ?, ?)";
    pool.query(
        sql,
        [id_backup, nombre_archivo, ruta_almacenamiento, tipo_backup, tamano_mb, id_persona],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Backup actualizado correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar el Backups');
            }
        }
    );
});



//DELETE BACKUPS

router.delete('/Backups/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarBackup(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al eliminar el Backup');
        }
    });
});



/////////PANTALLA/////////////////////

//GET PANTALLA
//Obtiene los datos de una pantalla o vista del sistema, por su ID.


router.get('/Pantallas/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarPantallaDetallePorID(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al obtener la pantalla');
        }
    });
});


router.get('/Pantallas', (req, res) => {
  const sql = "CALL SP_SeleccionarTodosPantallas()";
  pool.query(sql, (err, rows) => {
    if (!err) {
      res.json(rows[0]);  // Envío sólo el primer elemento que contiene los datos
    } else {
      console.error(err);
      res.status(500).send('Error al obtener');
    }
  });
});

//INSERTAR PANTALLA
//Crea una nueva pantalla en el sistema.


router.post('/Pantallas', (req, res) => {
    const { nombre_pantalla, titulo_visible, ruta_url, activo } = req.body;
    const sql = "CALL SP_InsertarPantalla(?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_pantalla;";
    pool.query(
        sql,
        [nombre_pantalla, titulo_visible, ruta_url, activo],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Pantalla insertado correctamente",
                    id_pantalla: results[1][0].id_pantalla
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar el Pantalla');
            }
        }
    );
});


//ACTUZALIZAR PANTALLA
//Actualiza una pantalla ya existente por su ID.


router.put('/Pantallas/:id', (req, res) => {
    const id_pantalla = req.params.id;
    const { nombre_pantalla, titulo_visible, ruta_url, activo} = req.body;
    const sql = "CALL SP_ActualizarPantalla(?, ?, ?, ?,?)";
    pool.query(
        sql,
        [id_pantalla, nombre_pantalla, titulo_visible, ruta_url, activo],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Pantalla actualizado correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar la pantalla');
            }
        }
    );
});

//DELETE Pantalla

router.delete('/Pantallas/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarPantalla(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al eliminar la pantalla');
        }
    });
});

/////////PERMISOS/////////////////////

//GET PERMISO
//Obtiene los datos de una pantalla o vista del sistema, por su ID.


router.get('/Permisos/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_SeleccionarPermisoDetallePorID(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al obtener el permiso');
        }
    });
});


router.get('/Permisos', (req, res) => {
  const sql = "CALL SP_SeleccionarTodosPermisos()";
  pool.query(sql, (err, rows) => {
    if (!err) {
      res.json(rows[0]);  // Envío sólo el primer elemento que contiene los datos
    } else {
      console.error(err);
      res.status(500).send('Error al obtener');
    }
  });
});

//INSERTAR PERMISO
//Crea una nueva pantalla en el sistema.


router.post('/Permisos', (req, res) => {
    const { id_rol, id_pantalla, ver, crear, editar, eliminar } = req.body;
    const sql = "CALL SP_InsertarPermiso(?, ?, ?, ?, ?, ?, @nuevo_id); SELECT @nuevo_id AS id_permiso;";
    pool.query(
        sql,
        [id_rol, id_pantalla, ver, crear, editar, eliminar],
        (err, results) => {
            if (!err) {
                res.json({
                    mensaje: "Permiso insertado correctamente",
                    id_permiso: results[1][0].id_permiso
                });
            } else {
                console.log(err);
                res.status(500).send('Error al insertar el Permiso');
            }
        }
    );
});


//ACTUZALIZAR PERMISOS
//Actualiza una pantalla ya existente por su ID.


router.put('/Permisos/:id', (req, res) => {
    const id_permiso = req.params.id;
    const { id_rol, id_pantalla, ver, crear, editar, eliminar } = req.body;
    const sql = "CALL SP_ActualizarPermiso(?, ?, ?, ?, ?, ?,?)";
    pool.query(
        sql,
        [id_permiso, id_rol, id_pantalla, ver, crear, editar, eliminar ],
        (err, results) => {
            if (!err) {
                res.json({ mensaje: "Permiso actualizado correctamente" });
            } else {
                console.log(err);
                res.status(500).send('Error al actualizar Permiso');
            }
        }
    );
});


//DELETE PERMISOS

router.delete('/Permisos/:id', (req, res) => {
    const id = req.params.id;
    const sql = "CALL SP_EliminarPermiso(?)";
    pool.query(sql, [id], (err, rows) => {
        if (!err) {
            res.json(rows[0][0]); 
        } else {
            console.log(err);
            res.status(500).send('Error al eliminar el permiso');
        }
    });
});



module.exports = router;//obligatorio