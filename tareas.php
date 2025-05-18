<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: inicio.php");
    exit();
}

require 'config.php';

$correo = $_SESSION['correo'];
$usuario_id = null;

// Obtener el ID del usuario
$stmt = $conn->prepare("SELECT id, nombre FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($usuario_id, $nombre);
$stmt->fetch();
$stmt->close();

// Obtener tareas del usuario
$tareas = [];
if ($usuario_id) {
    $stmt = $conn->prepare("SELECT id, texto, completada FROM tareas WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $resultado = $stmt->get_result();
    while ($fila = $resultado->fetch_assoc()) {
        $tareas[] = $fila;
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Tareas</title>
    <link rel="stylesheet" href="css/inicio_registro.css">
</head>
<body>
    <div class="bienvenida-box">
        <h2 class="titulo-bienvenida">Hola, <?= htmlspecialchars($nombre) ?> 👋</h2>
        <h3 style="color:#26a69a; margin-top:20px;">Tus tareas</h3>

        <?php if (empty($tareas)): ?>
            <p>No tienes tareas aún.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($tareas as $tarea): ?>
                    <li>
                        <?= htmlspecialchars($tarea['texto']) ?>
                        <?= $tarea['completada'] ? '✅' : '' ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <div class="acciones" style="margin-top: 30px;">
            <a href="logout.php" class="boton-secundario">Cerrar sesión</a>
            <a href="bienvenida.php" class="boton-principal">Volver</a>
        </div>
    </div>
</body>
</html>
