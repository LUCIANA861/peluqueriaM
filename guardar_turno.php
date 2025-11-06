<?php
// Conexión a la base de datos
$conexion = new mysqli("localhost", "root", "", "peluqueria");

// Verificar conexión
if ($conexion->connect_error) {
    die("Conexión fallida: " . $conexion->connect_error);
}

// Recibir datos del formulario
$nombre = $_POST['nombre'];
$telefono = $_POST['telefono'];
$servicio = $_POST['servicio'];
$fecha = $_POST['fecha'];
$horario = $_POST['horario'];

// Verificar si ya existe un turno reservado en esa fecha y hora (no solo servicio)
$sql_check = "SELECT * FROM reservas WHERE fecha = ? AND horario = ?";
$stmt = $conexion->prepare($sql_check);
$stmt->bind_param("ss", $fecha, $horario);
$stmt->execute();
$resultado = $stmt->get_result();


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"];

    if (!preg_match("/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$/", $nombre)) {
        echo "El nombre solo puede contener letras y espacios.";
    } else {
       
    }
}




if ($resultado->num_rows > 0) {
    // Ya existe un turno
    echo "
        <script>
            alert('Lo siento, ya hay un turno reservado para esa fecha y hora.');
            window.history.back();
        </script>
    ";
} else {
    // Insertar nuevo turno correctamente
    $sql_insert = "INSERT INTO reservas (nombre, telefono, servicio, fecha, horario) VALUES (?, ?, ?, ?, ?)";
    $stmt_insert = $conexion->prepare($sql_insert);
    $stmt_insert->bind_param("sssss", $nombre, $telefono, $servicio, $fecha, $horario);

    if ($stmt_insert->execute()) {
        echo "
            <script>
                alert('¡Turno reservado con éxito!');
                window.location.href = 'formulario.php';
            </script>
        ";
    } else {
        echo 'Error al guardar el turno: ' . $conexion->error;
    }
}

// Cerrar conexión
$conexion->close();
?>
