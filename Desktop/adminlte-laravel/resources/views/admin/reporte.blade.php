<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Generación de Reportes</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f4f9f4;
    }
    .report-card {
      max-width: 600px;
      margin: 50px auto;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    .btn-custom {
      background-color: #2e7d32;
      color: white;
    }
    .btn-custom:hover {
      background-color: #1b5e20;
    }
    #resultado {
      margin-top: 20px;
      padding: 15px;
      border-radius: 10px;
      background-color: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
  </style>
</head>
<body>

  <div class="card report-card">
    <div class="card-body">
      <h4 class="card-title text-center mb-3">Generar Reporte</h4>
      <p class="text-center text-muted">Seleccione el tipo de reporte y el ID correspondiente.</p>

      <form id="formReporte">
        <div class="mb-3">
          <label for="tipoReporte" class="form-label">Tipo de Reporte</label>
          <select class="form-select" id="tipoReporte" required>
            <option value="">Seleccione una opción</option>
            <option value="reserva">Reservas</option>
            <option value="actividad">Actividades</option>
          </select>
        </div>

        <div class="mb-3" id="campoID" style="display: none;">
          <label id="labelID" class="form-label"></label>
          <input type="number" class="form-control" id="idRegistro" required>
        </div>

        <div class="d-grid">
          <button type="submit" class="btn btn-custom">Generar Reporte</button>
        </div>
      </form>

      <div id="resultado" style="display:none;"></div>
    </div>
  </div>

  <script>
    const tipoReporte = document.getElementById("tipoReporte");
    const campoID = document.getElementById("campoID");
    const labelID = document.getElementById("labelID");
    const resultado = document.getElementById("resultado");

    tipoReporte.addEventListener("change", () => {
      if (tipoReporte.value === "reserva") {
        labelID.textContent = "ID de Reserva";
        campoID.style.display = "block";
      } else if (tipoReporte.value === "actividad") {
        labelID.textContent = "ID de Actividad";
        campoID.style.display = "block";
      } else {
        campoID.style.display = "none";
      }
    });

    document.getElementById("formReporte").addEventListener("submit", async (e) => {
      e.preventDefault();

      const tipo = tipoReporte.value;
      const id = document.getElementById("idRegistro").value;

      let url = "";
      if (tipo === "reserva") {
        url = `http://localhost:3000/reporte_reserva/Reservas/${id}`;
      } else if (tipo === "actividad") {
        url = `http://localhost:3000/reporte/Reportes_Generados/${id}`;
      }

      try {
        const resp = await fetch(url);
        if (!resp.ok) throw new Error("Error en la conexión con el servidor");

        const data = await resp.json();

        if (data.length === 0) {
          resultado.style.display = "block";
          resultado.innerHTML = `<p class="text-danger">No se encontraron datos para ese ID.</p>`;
          return;
        }

        const item = data[0];
        resultado.style.display = "block";
        resultado.innerHTML = `
          <h5>Detalles del Reporte</h5>
          <p><strong>ID:</strong> ${item.id_reserva || item.id_evento}</p>
          <p><strong>Nombre:</strong> ${item.nombre_evento || item.nombre_reserva || "No disponible"}</p>
          <p><strong>Fecha Inicio:</strong> ${item.fecha_hora_inicio || item.fecha_inicio}</p>
          <p><strong>Fecha Fin:</strong> ${item.fecha_hora_fin || item.fecha_fin}</p>
          <p><strong>Estado:</strong> ${item.estado_reserva || item.estado}</p>
          <p><strong>Observaciones:</strong> ${item.observaciones || "Sin observaciones"}</p>
        `;
      } catch (err) {
        resultado.style.display = "block";
        resultado.innerHTML = `<p class="text-danger">${err.message}</p>`;
      }
    });
  </script>
</body>
</html>