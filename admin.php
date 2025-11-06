<?php
session_start();
if(!isset($_SESSION['usuario']) || $_SESSION['usuario'] != 'dueña') {
    header("Location: sesion.php"); // si no es la dueña, vuelve al login
    exit;
}
?>

