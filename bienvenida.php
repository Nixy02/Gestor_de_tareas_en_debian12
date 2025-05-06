<?php
session_start();

// Si no hay sesión, redirige a login
if (!isset($_SESSION['correo'])) {
    header("Location: login.php");
    exit();
}

$usuario = $_SESSION['correo'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="formulario">
        <h2>¡Hola, bienvenida!</h2>
        <p class="mensaje">Has iniciado sesión como <strong><?php echo htmlspecialchars($usuario); ?></strong>.</p>

        <div class="acciones">
            <a href="gestor.php" class="boton">Ir al gestor de tareas</a>
            <a href="logout.php" class="boton boton-secundario">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
