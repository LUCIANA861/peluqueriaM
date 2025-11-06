<?php 
session_start();
if(!isset($_SESSION['usuario'])) {
    header("Location: login.php");
    exit;
}

$conexion = new mysqli("localhost", "root", "", "peluqueria");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}


$sql = "SELECT id, nombre, telefono, servicio, fecha, horario FROM reservas ORDER BY fecha ASC, horario ASC";
$resultado = $conexion->query($sql); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Panel de Administración</title>
     <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- MaterializeCSS -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      margin: 0;
      padding: 0;
      background: #000000ff;
    }

     /* Navbar */
    nav {
    background: linear-gradient(90deg, #000000, #4c4c4d);
    
    }
    

    .brand-logo {
      font-family: 'Great Vibes', cursive;
      font-size: 2rem;
      margin-left: 10px;
      
    }


    .header {
      text-align: center;
      padding: 30px 0;
    }
    .header h1 {
      color: #ff4081;
      font-weight: bold;
      margin: 0;
      letter-spacing: 2px;
    }
    .header p {
      margin: 5px 0 20px;
      color: #ccc;
    }

    .container {
      display: flex;
      justify-content: center;
      padding: 30px;
    }

    .turnos-card {
      background: rgba(20, 20, 20, 0.95);
      padding: 25px;
      border-radius: 20px;
      width: 100%;
      max-width: 900px;
      box-shadow: 0 8px 25px rgba(0, 0, 0, 0.7);
      overflow-y: auto;
      max-height: 75vh;
    }

    h4 {
      text-align: center;
      color: #ff4081;
      margin-bottom: 20px;
      font-weight: bold;
    }

    table.striped {
      color: white;
    }
    table.striped tbody tr:nth-child(even) {
      background-color: rgba(255, 64, 129, 0.08);
    }

    table.striped th {
      color: #ff4081;
      font-weight: bold;
      text-transform: uppercase;
    }

    .btn-modern {
      background: linear-gradient(135deg, #ff4081, #7b1fa2);
      border: none;
      border-radius: 50px;
      padding: 10px 20px;
      font-weight: bold;
      letter-spacing: 1px;
      color: white;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.4);
      transition: all 0.3s ease;
    }
    .btn-modern:hover {
      transform: translateY(-3px);
      box-shadow: 0 6px 16px rgba(0, 0, 0, 0.6);
    }

    .btn-delete {
      background: linear-gradient(135deg, #ff1744, #d50000);
    }
    .btn-delete:hover {
      background: linear-gradient(135deg, #ff5252, #ff1744);
    }

    .volver-btn {
      margin: 10px;
    }

    ::-webkit-scrollbar {
      width: 8px;
    }
    ::-webkit-scrollbar-thumb {
      background: #ff4081;
      border-radius: 10px;
    }
    ::-webkit-scrollbar-track {
      background: #222;
    }

   </style>
</head>
<body>


  <div class="header">
    <h1>Panel de Administración</h1>
    <p>Gestioná tus turnos fácilmente</p>
    <a href="logout.php" class="btn-modern volver-btn">Cerrar Sesión</a>
    <a href="index.html" class="btn-modern volver-btn">Volver</a>
  </div>

  <div class="container">
    <div class="turnos-card z-depth-3">
      <h4>Turnos Reservados</h4>
      <table class="striped highlight responsive-table">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Servicio</th> 
            <th>Fecha</th>
            <th>Horario</th> <!-- 🔹 Nueva columna -->
            <th>Acción</th>
          </tr>
        </thead>
        <tbody>
        <?php while($row = $resultado->fetch_assoc()) { ?>
          <tr>
            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
            <td><?php echo htmlspecialchars($row['telefono']); ?></td>
            <td><?php echo htmlspecialchars($row['servicio']); ?></td>
            <td><?php echo htmlspecialchars($row['fecha']); ?></td>
            <td><?php echo htmlspecialchars($row['horario']); ?></td> <!-- 🔹 Mostramos el horario -->
            <td>
              <form action="borrar_turno.php" method="POST" style="margin:0;">
                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                <button type="submit" class="btn-modern btn-delete">Borrar</button>
              </form>
            </td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
</body>
</html>
