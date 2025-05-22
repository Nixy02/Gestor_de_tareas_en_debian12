<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: inicio.php");
    exit();
}

require 'config.php';

// Obtener ID del usuario logueado
$correo = $_SESSION['correo'];
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
$stmt->bind_param("s", $correo);
$stmt->execute();
$stmt->bind_result($usuario_id);
$stmt->fetch();
$stmt->close();

// Obtener tareas del usuario
$stmt = $conn->prepare("SELECT titulo, descripcion, estado, fecha_inicio, fecha_fin FROM tareas WHERE id_usuario = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$resultado = $stmt->get_result();
$tareas = $resultado->fetch_all(MYSQLI_ASSOC);
$stmt->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Mis Tareas</title>
  <meta http-equiv='refresh' content='5;url=tareas.php'>
  <link rel="stylesheet" href="css/tareas.css">
  <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
  <div class="contenedor">
    <h2>Mis tareas</h2>
     <?php if (isset($_GET['creado']) && $_GET['creado'] == 1): ?>
     <p class="mensaje-ok">✅ Tarea creada correctamente.</p>
     <?php endif; ?>
    <?php if (empty($tareas)): ?>
      <div class="sin-tareas">
    <img src="img/icono_editar.png" alt="Sin tareas" class="logo-tareas-vacio">
    <p class="mensaje-vacio">No tienes tareas registradas.</p>
      </div>
    <?php else: ?>
      <table>
        <thead>
          <tr>
            <th>Título</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Inicio</th>
            <th>Fin</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($tareas as $tarea): ?>
            <tr>
              <tr class="estado-<?= str_replace(' ', '-', strtolower($tarea['estado'])) ?>">
              <td><?= htmlspecialchars($tarea['titulo']) ?></td>
              <td><?= nl2br(htmlspecialchars($tarea['descripcion'])) ?></td>
              <td><?= ucfirst($tarea['estado']) ?></td>
              <td><?= $tarea['fecha_inicio'] ?></td>
              <td><?= $tarea['fecha_fin'] ?></td>
           </tr>
         <?php endforeach; ?>
        </tbody>
      </table>
    <?php endif; ?>

    <div class="acciones">
      <a href="crear_tarea.php" class="boton-principal">Crear nueva tarea</a>
      <a href="bienvenida.php" class="boton-secundario">Volver</a>
    </div>
  </div>
</body>
</html>
