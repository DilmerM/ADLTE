@extends('admin.app')
@section('title', 'Administración y Control')
@section('page-title', 'Administración y Control')


@section('content')
<div class="container mt-4 text-center">
    <h2 class="mb-4 text-primary"><i class="fas fa-cogs"></i> Administración y Control</h2>

    <!-- Iconos modulos -->
    <div class="row justify-content-center mb-4">
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-primary shadow cursor-pointer" style="cursor:pointer;" data-modulo="roles">
                <div class="card-body py-4">
                    <i class="fas fa-user-tag fa-3x mb-2"></i>
                    <h5 class="card-title">Roles</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-success shadow cursor-pointer" data-modulo="usuarios_roles">
                <div class="card-body py-4">
                    <i class="fas fa-users-cog fa-3x mb-2"></i>
                    <h5 class="card-title">Usuarios Roles</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-warning shadow cursor-pointer" data-modulo="permisos">
                <div class="card-body py-4">
                    <i class="fas fa-key fa-3x mb-2"></i>
                    <h5 class="card-title">Permisos</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-danger shadow cursor-pointer" data-modulo="backups">
                <div class="card-body py-4">
                    <i class="fas fa-cloud-upload-alt fa-3x mb-2"></i>
                    <h5 class="card-title">Backups</h5>
                </div>
            </div>
        </div>
        <div class="col-6 col-md-3 mb-3">
            <div class="card text-white bg-info shadow cursor-pointer" data-modulo="pantallas">
                <div class="card-body py-4">
                    <i class="fas fa-desktop fa-3x mb-2"></i>
                    <h5 class="card-title">Pantallas</h5>
                </div>
            </div>
        </div>
    </div>

    <!-- Buscador -->
    <div class="mb-4 text-center">
        <div class="input-group input-group-lg justify-content-center" style="max-width: 400px; margin: 0 auto;">
            <span class="input-group-text bg-primary text-white"><i class="fas fa-search fa-lg"></i></span>
            <input type="text" id="buscador" class="form-control" placeholder="Buscar...">
        </div>
    </div>

    <!-- Titulo y boton agregar -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 id="tituloModulo" class="text-primary"></h4>
        <button type="button" class="btn btn-success" id="btnAgregarNuevo" style="display:none;">
            <i class="fas fa-plus"></i> Agregar Nuevo
        </button>
    </div>

    <!-- Tabla datos -->
    <div class="table-responsive">
        <table class="table table-hover table-bordered align-middle" id="dataTable">
            <thead class="table-dark text-center" id="tableHead">
                <tr><th colspan="100%">Selecciona un módulo para ver los datos</th></tr>
            </thead>
            <tbody id="tableBody" class="text-center"></tbody>
        </table>
    </div>

    <div id="status" class="mt-2"></div>
</div>

<!-- Modal General -->
<div class="modal fade" id="modalGeneral" tabindex="-1" aria-labelledby="modalGeneralLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <form id="formModal" class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="modalGeneralLabel">Título Modal</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="modalBodyContent">
        <!-- Contenido dinámico -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" id="btnCancelar" data-bs-dismiss="modal">
            <i class="fas fa-times"></i> Cancelar
        </button>
        <button type="submit" class="btn btn-primary" id="btnGuardar">
            <i class="fas fa-save"></i> Guardar
        </button>
      </div>
    </form>
  </div>
</div>

<!-- Toast para notificaciones -->
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080;">
  <div id="liveToast" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="d-flex">
      <div class="toast-body" id="toastMessage">Mensaje</div>
      <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Cerrar"></button>
    </div>
  </div>
</div>
@endsection

@push('js')
<script>
(() => {
    const apiBaseUrl = 'http://localhost:3000/Administracion_control';

    // Configuración por módulo
    const modulos = {
        roles: {
            url: `${apiBaseUrl}/roles`,
            idField: 'id_rol',
            columns: [
                {key:'id_rol', label:'ID Rol'},
                {key:'nombre_rol', label:'Nombre Rol'},
                {key:'descripcion', label:'Descripción'}
            ],
            modalFields: [
                {name:'id_rol', type:'hidden'},
                {name:'nombre_rol', label:'Nombre Rol', type:'text', placeholder:'Ej: Administrador', required:true},
                {name:'descripcion', label:'Descripción', type:'textarea', placeholder:'Descripción del rol', required:false}
            ]
        },
        usuarios_roles: {
            url: `${apiBaseUrl}/Usuario_roles`,
            idField: 'id_usuario_rol',
            columns: [
                {key:'id_usuario_rol', label:'ID Usuario Rol'},
                {key:'fecha_asignacion', label:'Fecha Asignación', isDate:true},
                {key:'id_usuario', label:'ID Usuario'},
                {key:'id_rol', label:'ID Rol'}
            ],
            modalFields: [
                {name:'id_usuario_rol', type:'hidden'},
                {name:'id_usuario', label:'ID Usuario', type:'number', placeholder:'Ej: 5', required:true},
                {name:'id_rol', label:'ID Rol', type:'number', placeholder:'Ej: 2', required:true}
            ]
        },
        permisos: {
            url: `${apiBaseUrl}/Permisos`,
            idField: 'id_permiso',
            columns: [
                {key:'id_permiso', label:'ID Permiso'},
                {key:'id_rol', label:'ID Rol'},
                {key:'id_pantalla', label:'ID Pantalla'},
                {key:'ver', label:'Ver', type:'boolean'},
                {key:'crear', label:'Crear', type:'boolean'},
                {key:'editar', label:'Editar', type:'boolean'},
                {key:'eliminar', label:'Eliminar', type:'boolean'}
            ],
            modalFields: [
                {name:'id_permiso', type:'hidden'},
                {name:'id_rol', label:'ID Rol', type:'number', placeholder:'Ej: 1', required:true},
                {name:'id_pantalla', label:'ID Pantalla', type:'number', placeholder:'Ej: 1', required:true},
                {name:'ver', label:'Ver', type:'checkbox'},
                {name:'crear', label:'Crear', type:'checkbox'},
                {name:'editar', label:'Editar', type:'checkbox'},
                {name:'eliminar', label:'Eliminar', type:'checkbox'}
            ]
        },
        backups: {
            url: `${apiBaseUrl}/Backups`,
            idField: 'id_backup',
            columns: [
                {key:'id_backup', label:'ID Backup'},
                {key:'nombre_archivo', label:'Nombre Archivo'},
                {key:'ruta_almacenamiento', label:'Ruta Almacenamiento'},
                {key:'fecha_hora_backup', label:'Fecha Backup', isDate:true},
                {key:'tipo_backup', label:'Tipo Backup'},
                {key:'tamano_mb', label:'Tamaño (MB)'},
                {key:'id_persona', label:'ID Persona'}
            ],
            modalFields: [
                {name:'id_backup', type:'hidden'},
                {name:'nombre_archivo', label:'Nombre Archivo', type:'text', placeholder:'Ej: backup_2025_08_10.sql', required:true},
                {name:'ruta_almacenamiento', label:'Ruta Almacenamiento', type:'text', placeholder:'Ej: /backups/backup.sql', required:true},
                {name:'fecha_hora_backup', label:'Fecha Backup', type:'date', required:true},
                {name:'tipo_backup', label:'Tipo Backup', type:'text', placeholder:'Ej: Completo', required:true},
                {name:'tamano_mb', label:'Tamaño (MB)', type:'number', placeholder:'Ej: 1.1', step:'0.1', required:true},
                {name:'id_persona', label:'ID Persona', type:'number', placeholder:'Ej: 5', required:true}
            ]
        },
        pantallas: {
            url: `${apiBaseUrl}/Pantallas`,
            idField: 'id_pantalla',
            columns: [
                {key:'id_pantalla', label:'ID Pantalla'},
                {key:'nombre_pantalla', label:'Nombre Pantalla'},
                {key:'titulo_visible', label:'Título Visible'},
                {key:'ruta_url', label:'Ruta URL'},
                {key:'activo', label:'Activo', type:'boolean'}
            ],
            modalFields: [
                {name:'id_pantalla', type:'hidden'},
                {name:'nombre_pantalla', label:'Nombre Pantalla', type:'text', placeholder:'Ej: Dashboard', required:true},
                {name:'titulo_visible', label:'Título Visible', type:'text', placeholder:'Ej: Panel Principal', required:true},
                {name:'ruta_url', label:'Ruta URL', type:'text', placeholder:'Ej: /dashboard', required:true},
                {name:'activo', label:'Activo', type:'checkbox'}
            ]
        }
    };

    let currentModulo = null;
    let dataActual = [];

    // Elementos DOM
    const cardsModulo = document.querySelectorAll('.card.cursor-pointer');
    const tituloModulo = document.getElementById('tituloModulo');
    const btnAgregarNuevo = document.getElementById('btnAgregarNuevo');
    const tableHead = document.getElementById('tableHead');
    const tableBody = document.getElementById('tableBody');
    const statusDiv = document.getElementById('status');
    const buscador = document.getElementById('buscador');
    const modalGeneral = new bootstrap.Modal(document.getElementById('modalGeneral'));
    const modalEl = document.getElementById('modalGeneral');
    const formModal = document.getElementById('formModal');
    const toastEl = document.getElementById('liveToast');
    const toastBootstrap = new bootstrap.Toast(toastEl);

    // Función para mostrar notificación toast
    function mostrarToast(mensaje, tipo='success') {
        toastEl.className = `toast align-items-center text-bg-${tipo} border-0`;
        document.getElementById('toastMessage').innerText = mensaje;
        toastBootstrap.show();
    }

    // Función para limpiar tabla
    function limpiarTabla() {
        tableHead.innerHTML = `<tr><th colspan="100%">Selecciona un módulo para ver los datos</th></tr>`;
        tableBody.innerHTML = '';
    }

    // Función para crear encabezado tabla
    function crearEncabezado(columns) {
        let html = '<tr>';
        columns.forEach(c => {
            html += `<th>${c.label}</th>`;
        });
        html += '<th>Acciones</th></tr>';
        tableHead.innerHTML = html;
    }

    // Función para renderizar tabla con datos
    function renderizarTabla(datos, modulo) {
        crearEncabezado(modulos[modulo].columns);
        if (datos.length === 0) {
            tableBody.innerHTML = `<tr><td colspan="${modulos[modulo].columns.length + 1}">No hay datos para mostrar.</td></tr>`;
            return;
        }

        let html = '';
        datos.forEach(row => {
            html += '<tr>';
            modulos[modulo].columns.forEach(col => {
                let val = row[col.key];
                if (col.isDate && val) val = new Date(val).toLocaleDateString();
                if (col.type === 'boolean') val = val ? '<i class="fas fa-check text-success"></i>' : '<i class="fas fa-times text-danger"></i>';
                html += `<td>${val !== null && val !== undefined ? val : ''}</td>`;
            });
            html += `
                <td>
                    <button class="btn btn-warning btn-sm me-1 btnEditar" data-id="${row[modulos[modulo].idField]}" title="Editar">
                        <i class="fas fa-edit"></i>
                    </button>
                    <button class="btn btn-danger btn-sm btnEliminar" data-id="${row[modulos[modulo].idField]}" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </td>`;
            html += '</tr>';
        });
        tableBody.innerHTML = html;
    }

    // Función para cargar datos del módulo seleccionado
    async function cargarDatosModulo(modulo) {
        limpiarTabla();
        tituloModulo.textContent = `Módulo: ${modulo.charAt(0).toUpperCase() + modulo.slice(1).replace('_',' ')}`;
        btnAgregarNuevo.style.display = 'inline-block';
        currentModulo = modulo;
        statusDiv.innerHTML = `<div class="alert alert-info">Cargando datos...</div>`;

        try {
            const res = await fetch(modulos[modulo].url);
            if (!res.ok) throw new Error(`Error al cargar datos: ${res.statusText}`);
            const datos = await res.json();
            dataActual = datos;
            renderizarTabla(datos, modulo);
            statusDiv.innerHTML = '';
        } catch (error) {
            statusDiv.innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
        }
    }

    // Función para limpiar formulario modal
    function limpiarFormulario() {
        formModal.reset();
        // Limpiar inputs hidden o checkbox (por si acaso)
        formModal.querySelectorAll('input[type=hidden]').forEach(i => i.value = '');
        formModal.querySelectorAll('input[type=checkbox]').forEach(i => i.checked = false);
        document.getElementById('modalGeneralLabel').innerText = '';
        document.getElementById('modalBodyContent').innerHTML = '';
    }

    // Función para crear inputs del modal según configuración
    function crearCamposModal(modalFields) {
        let html = '';
        modalFields.forEach(field => {
            if (field.type === 'hidden') {
                html += `<input type="hidden" name="${field.name}" id="${field.name}">`;
            } else if (field.type === 'textarea') {
                html += `
                <div class="mb-3 text-start">
                    <label for="${field.name}" class="form-label">${field.label}</label>
                    <textarea class="form-control" id="${field.name}" name="${field.name}" placeholder="${field.placeholder || ''}" ${field.required ? 'required' : ''}></textarea>
                </div>`;
            } else if (field.type === 'checkbox') {
                html += `
                <div class="form-check text-start mb-3">
                    <input class="form-check-input" type="checkbox" id="${field.name}" name="${field.name}">
                    <label class="form-check-label" for="${field.name}">${field.label}</label>
                </div>`;
            } else {
                html += `
                <div class="mb-3 text-start">
                    <label for="${field.name}" class="form-label">${field.label}</label>
                    <input
                        type="${field.type}"
                        class="form-control"
                        id="${field.name}"
                        name="${field.name}"
                        placeholder="${field.placeholder || ''}"
                        ${field.step ? `step="${field.step}"` : ''}
                        ${field.required ? 'required' : ''}
                    >
                </div>`;
            }
        });
        return html;
    }

    // Abrir modal para nuevo o editar
    function abrirModal(modulo, isEdit=false, datos=null) {
        limpiarFormulario();
        const modalLabel = document.getElementById('modalGeneralLabel');
        const modalBody = document.getElementById('modalBodyContent');

        modalLabel.innerHTML = `${isEdit ? '<i class="fas fa-edit"></i> Editar Registro' : '<i class="fas fa-plus"></i> Agregar Nuevo Registro'}`;
        modalBody.innerHTML = crearCamposModal(modulos[modulo].modalFields);

        // Si es editar, llenar campos
        if (isEdit && datos) {
            modulos[modulo].modalFields.forEach(field => {
                const input = document.getElementById(field.name);
                if (!input) return;
                if (field.type === 'checkbox') {
                    input.checked = !!datos[field.name];
                } else {
                    input.value = datos[field.name] !== null && datos[field.name] !== undefined ? datos[field.name] : '';
                }
            });
        }

        modalGeneral.show();
    }

    // Función para obtener registro por id
    function obtenerRegistroPorId(id) {
        return dataActual.find(item => item[modulos[currentModulo].idField] == id);
    }

    // Función para filtrar tabla según búsqueda
    function filtrarTabla(texto) {
        if (!currentModulo) return;
        const columnas = modulos[currentModulo].columns;
        const textoLower = texto.toLowerCase();

        const filtrados = dataActual.filter(row => {
            return columnas.some(col => {
                let valor = row[col.key];
                if (valor === null || valor === undefined) return false;
                return String(valor).toLowerCase().includes(textoLower);
            });
        });
        renderizarTabla(filtrados, currentModulo);
    }

    // Eventos

    // Click en tarjetas para cargar módulo
    cardsModulo.forEach(card => {
        card.addEventListener('click', () => {
            cargarDatosModulo(card.dataset.modulo);
            buscador.value = '';
        });
    });

    // Click botón agregar nuevo
    btnAgregarNuevo.addEventListener('click', () => {
        if (!currentModulo) return;
        abrirModal(currentModulo, false);
    });

    // Click editar desde tabla
    tableBody.addEventListener('click', e => {
        if (e.target.closest('.btnEditar')) {
            const id = e.target.closest('.btnEditar').dataset.id;
            const registro = obtenerRegistroPorId(id);
            if (!registro) {
                mostrarToast('Registro no encontrado', 'danger');
                return;
            }
            abrirModal(currentModulo, true, registro);
        }
    });

    // Click eliminar desde tabla
    tableBody.addEventListener('click', async e => {
        if (e.target.closest('.btnEliminar')) {
            const id = e.target.closest('.btnEliminar').dataset.id;
            if (!confirm('¿Estás seguro de eliminar este registro?')) return;
            try {
                const res = await fetch(`${modulos[currentModulo].url}/${id}`, { method: 'DELETE' });
                if (!res.ok) throw new Error('Error eliminando el registro');
                mostrarToast('Registro eliminado correctamente');
                cargarDatosModulo(currentModulo);
            } catch (error) {
                mostrarToast(error.message, 'danger');
            }
        }
    });

    // Envío formulario modal (Agregar o Editar)
    formModal.addEventListener('submit', async e => {
        e.preventDefault();
        if (!currentModulo) return;

        const config = modulos[currentModulo];
        const formData = new FormData(formModal);
        const objeto = {};
        config.modalFields.forEach(field => {
            if (field.type === 'checkbox') {
                objeto[field.name] = formData.get(field.name) === 'on' ? true : false;
            } else {
                objeto[field.name] = formData.get(field.name);
            }
        });

        const id = objeto[config.idField];
        const metodo = id ? 'PUT' : 'POST';
        const url = id ? `${config.url}/${id}` : config.url;

        try {
            const res = await fetch(url, {
                method: metodo,
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(objeto)
            });
            if (!res.ok) throw new Error(`Error en la operación: ${res.statusText}`);
            mostrarToast(id ? 'Registro actualizado' : 'Registro agregado');
            modalGeneral.hide();
            cargarDatosModulo(currentModulo);
        } catch (error) {
            mostrarToast(error.message, 'danger');
        }
    });

    // Buscador filtrar
    buscador.addEventListener('input', e => {
        filtrarTabla(e.target.value.trim());
    });

})();
</script>
@endpush
