<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: inicio.php");
    exit();
}

require 'config.php';

// Obtener el ID del usuario
$correo = $_SESSION['correo'];
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($usuario_id);
$stmt->fetch();
$stmt->close();

$mensaje = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_inicio = $_POST['fecha_inicio'];
    $fecha_fin = $_POST['fecha_fin'];
    $estado = trim(strtolower($_POST['estado'])); // ← captura real del select

    // Validación de estado válido (opcional pero recomendable)
    $estados_validos = ['pendiente', 'en curso', 'completada'];
    if (!in_array($estado, $estados_validos)) {
      $mensaje = "⚠️ Estado no válido.";
    } elseif (empty($titulo)) {
        $mensaje = "⚠️ El título no puede estar vacío.";
    } elseif (strtotime($fecha_fin) < strtotime($fecha_inicio)) {
        $mensaje = "⚠️ La fecha de fin no puede ser anterior a la de inicio.";
    } else {
        $stmt = $conn->prepare("INSERT INTO tareas (id_usuario, titulo, descripcion, estado, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $usuario_id, $titulo, $descripcion, $estado, $fecha_inicio, $fecha_fin);

        if ($stmt->execute()) {
    // Redirigir a tareas.php con mensaje
        header("Location: tareas.php?creado=1");
        exit();
        } else {
        $mensaje = "❌ Error al crear la tarea.";
      }
        $stmt->close();
      }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Tarea</title>
    <link rel="stylesheet" href="css/crear_tareas.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
       <div class="contenedor">
        <h2>Nueva tarea</h2>

        <?php if ($mensaje): ?>
            <p class="mensaje-ok"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

         <form method="POST" action="crear_tarea.php" style="margin-top: 20px; display: flex; flex-direction: column; gap: 10px;">
            <input type="text" name="titulo" placeholder="Título de la tarea" required>

            <textarea name="descripcion" placeholder="Descripción (opcional)" rows="4"></textarea>

            <label for="fecha_inicio">Fecha de inicio:</label>
            <input type="date" name="fecha_inicio" required>

            <label for="fecha_fin">Fecha de fin:</label>
            <input type="date" name="fecha_fin" required>

            <label for="estado">Estado:</label>
            <select name="estado" required>
                <option value="pendiente">Pendiente</option>
                <option value="en curso">En curso</option>
                <option value="completada">Completada</option>
            </select>
             <input type="submit" value="Guardar tarea" class="boton-principal" style="margin-top: 15px;">
         </form>
         <div class="acciones">
        <a href="bienvenida.php" class="boton-secundario">Volver</a>
      </div>
    </div>
</body>
</html>
