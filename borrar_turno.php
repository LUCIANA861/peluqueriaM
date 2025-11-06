<?php
$conexion = new mysqli("localhost", "root", "", "peluqueria");
if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

if(isset($_POST['id'])){
    $id = $_POST['id'];

    $stmt = $conexion->prepare("DELETE FROM reservas WHERE id = ?");
    $stmt->bind_param("i", $id);
    if($stmt->execute()){
        echo "<script>alert('Turno eliminado correctamente'); window.location='sesion.php';</script>";
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }
    $stmt->close();
}
$conexion->close();
?>
