<?php
$host = "localhost";
$usuario = "root"; // o el usuario que hayas creado
$contrasena = "debian12";  // pon aquí tu contraseña si tu usuario tiene una
$basedatos = "gestor_tareas";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
