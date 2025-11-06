<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "peluqueria");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$servicio = $_POST['servicio'] ?? '';
$fecha = $_POST['fecha'] ?? '';
$horario = $_POST['horario'] ?? '';

// Traer todos los turnos
$sql = "SELECT id, nombre, telefono, servicio, fecha, horario FROM reservas ORDER BY fecha ASC, horario ASC";
$resultado = $conexion->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Reservar Turno</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <style>
    body { background: black; color: white; font-family: 'Roboto', sans-serif; margin:0; padding:0;}

    header { background: #111; padding: 15px 0; text-align:center; box-shadow:0 4px 10px rgba(0,0,0,0.8);}

    header h3 { margin:0; color:#ff4081; font-weight:bold;}

    .container-flex { 
      display:flex; 
      flex-wrap:wrap; 
      justify-content:center;
       align-items:flex-start; padding:40px 20px; 
       gap:40px;
      }
    .form-card, .turnos-card {
       background:#222; 
       padding:25px; 
       border-radius:20px;
        width:100%; max-width:500px;
         box-shadow:0 5px 20px rgba(0,0,0,0.9);
        }

        /* --- Tabla compacta con scroll --- */
.turnos-card {
  max-height: 600px;       /* altura fija para que no ocupe toda la pantalla */
  overflow-y: auto;        /* permite hacer scroll si hay muchos turnos */
  scrollbar-width: thin;   /* scrollbar más delgada (Firefox) */
}

.turnos-card::-webkit-scrollbar {
  width: 20px;              /* ancho de la barra */
}

.turnos-card::-webkit-scrollbar-thumb {
  background-color: #ff4081;  /* color rosado de la barra */
  border-radius: 20px;
}

.turnos-card::-webkit-scrollbar-track {
  background-color: #111;
}

/* Tabla más pequeña */
table.striped {
  font-size: 0.90rem;       /* texto más chico */
}

table.striped th, table.striped td {
  padding: 6px 8px;         /* menos espacio entre filas */
}

    h4 { text-align:center; color:#ff4081; margin-bottom:25px; font-weight:bold; }
    .btn-custom { background-color:#ff4081; border-radius:30px; padding:0 30px; font-weight:bold; box-shadow:0 4px 10px rgba(0,0,0,0.6);}
    .btn-custom:hover { background-color:#f50057; }
    .prefix { color:#ff4081; }
    table.striped tr:nth-child(even){background-color: rgba(255,64,129,0.2);}
    table.striped tr:nth-child(odd){background-color: rgba(255,255,255,0.05);}
    table th, table td { color:white; text-align:center; }
    input[type="text"], input[type="date"], select, input[type="time"] { color:white; }
    input[type="text"]:focus, input[type="date"]:focus, select:focus, input[type="time"]:focus { border-bottom:1px solid #ff4081 !important; box-shadow:0 1px 0 0 #ff4081 !important;}
    label { color:white !important; }
    footer { text-align:center; padding:20px; background:#111; color:white; margin-top:40px;}
    .btn-volver { display:inline-block; margin:20px auto 0 auto; text-align:center; background:#ff4081; color:white; padding:12px 25px; border-radius:30px; font-weight:bold; text-decoration:none; box-shadow:0 4px 10px rgba(0,0,0,0.6); transition: background 0.3s; }
    .btn-volver:hover { background:#f50057; }



    /* 📱 RESPONSIVE */
    @media (max-width: 992px) {
      .brand-logo {
        font-size: 1.8rem;
      }

      .hero {
        height: 60vh;
      }
      .hero h1 {
        font-size: 2.5rem;
      }
      .hero p {
        font-size: 1rem;
      }

      .carousel .carousel-item img {
        width: 90%;
        border-radius: 20px;
      }

      footer {
        font-size: 0.9rem;
        padding: 10px 0;
      }

      .section.white h2, .section.grey.lighten-3 h2 {
        font-size: 1.8rem;
      }
    }

    @media (max-width: 600px) {
      .hero {
        height: 50vh;
      }
      .hero h1 {
        font-size: 2rem;
      }
      .hero p {
        font-size: 0.9rem;
      }
      .collection-item {
        font-size: 1rem;
      }
    }
  </style>
</head>
<body>

<header>
  <h3>Peluquería M - Reservá tu turno</h3>
</header>

<div class="container-flex">
  <!-- FORMULARIO -->
  <div class="form-card z-depth-3">
    <h4>Reservá tu turno</h4>
    <form action="guardar_turno.php" method="POST">
      <div class="input-field">
        <i class="material-icons prefix">account_circle</i>
        <input type="text" name="nombre" id="nombre"  pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
         title="Solo se permiten letras y espacios"  required  >
        <label for="nombre">Nombre</label>
      </div>
      

      <div class="input-field">
        <i class="material-icons prefix">phone</i>
        <input type="text" name="telefono" id="telefono" pattern="[0-9]+" title="Solo se permiten números" required>
        <label for="telefono">Teléfono</label>
      </div>

      <div class="input-field">
        <i class="material-icons prefix">content_cut</i>
        <select name="servicio" id="servicio" required>
          <option value="" disabled selected>Elegí un servicio</option>
          <option value="Corte de cabello">Corte de cabello</option>
          <option value="Coloración">Coloración</option>
          <option value="Rulos">Rulos</option>
          <option value="Botox">Botox capilar</option>
          <option value="Baño de crema">Baño de crema</option>
          <option value="Teñido">Teñido</option>
          <option value="Nutrición">Nutrición de cabello</option>
        </select>
        <label for="servicio">Servicio</label>
      </div>

      <div class="input-field">
        <i class="material-icons prefix">event</i>
        <input type="date" name="fecha" id="fecha" required min="<?= date('Y-m-d') ?>">
        <label for="fecha">Fecha</label>
      </div>

      <div class="input-field">
        <i class="material-icons prefix">schedule</i>
        <input type="time" name="horario" id="horario" required step="60">
        <label for="horario">Hora</label>
      </div>

      <div class="center">
        <button class="btn btn-large btn-custom waves-effect waves-light" type="submit">
          Reservar <i class="material-icons right">send</i>
        </button>
      </div>
    </form>
    <div class="center">
      <a href="index.html" class="btn-volver">⬅ Volver</a>
    </div>
  </div>

  <!-- LISTADO DE TURNOS -->
  <div class="turnos-card z-depth-3">
    <h4>Turnos Reservados</h4>
    <table class="striped highlight responsive-table">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Teléfono</th>
          <th>Servicio</th>
          <th>Fecha</th>
          <th>Hora</th>
        </tr>
      </thead>
      <tbody>
        <?php 
        if ($resultado->num_rows > 0) {
          while ($row = $resultado->fetch_assoc()) { ?>
            <tr>
              <td><?= htmlspecialchars($row['nombre']); ?></td>
              <td><?= htmlspecialchars($row['telefono']); ?></td>
              <td><?= htmlspecialchars($row['servicio']); ?></td>
              <td><?= htmlspecialchars($row['fecha']); ?></td>
              <td><?= htmlspecialchars($row['horario']); ?></td>
            </tr>
        <?php } } else { ?>
            <tr><td colspan="5">No hay turnos reservados</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<footer>
  <p>© 2025 Peluquería M | Todos los derechos reservados</p>
</footer>

<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
  M.FormSelect.init(document.querySelectorAll('select'));

  const reservas = <?php
    $reservasArray = [];
    $resultado->data_seek(0);
    while($row = $resultado->fetch_assoc()) {
      $reservasArray[] = ['fecha'=>$row['fecha'], 'hora'=>$row['horario']];
    }
    echo json_encode($reservasArray);
  ?>;

  const inputFecha = document.getElementById('fecha');
  const inputHora = document.getElementById('horario');

  function checkReserva() {
    const fecha = inputFecha.value;
    const hora = inputHora.value;
    if(fecha && hora) {
      for(let r of reservas) {
        if(r.fecha === fecha && r.hora === hora) {
          alert("¡Ya hay un turno reservado para esta fecha y hora!");
          inputHora.value = "";
          return;
        }
      }
    }
  }

  inputFecha.addEventListener('change', () => {
    const hoy = new Date().toISOString().split('T')[0];
    if(inputFecha.value < hoy){
      alert("No se puede reservar días pasados");
      inputFecha.value = "";
    }
    checkReserva();
  });

  inputHora.addEventListener('change', checkReserva);
});
</script>

<form onsubmit="return validarNombre()" action="procesar.php" method="POST">
  <label for="nombre">Nombre:</label>
  <input type="text" id="nombre" name="nombre" required>
  <span id="errorNombre" style="color:red;"></span><br>
  <button type="submit">Enviar</button>
</form>

<script>
function validarNombre() {
  const nombre = document.getElementById("nombre").value;
  const regex = /^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/;

  if (!regex.test(nombre)) {
    document.getElementById("errorNombre").textContent = "Solo se permiten letras y espacios.";
    return false; // evita el envío
  }

  document.getElementById("errorNombre").textContent = "";
  return true; // permite el envío
}
</script>


<input type="text" id="telefono" placeholder="Ingrese su número">

<script>
document.getElementById("telefono").addEventListener("input", function() {
    this.value = this.value.replace(/[^0-9]/g, ''); 
});
</script>


</body>
</html>
<?php $conexion->close(); ?>
