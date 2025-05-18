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
    $estado = 'pendiente';

    if (!empty($titulo)) {
        $stmt = $conn->prepare("INSERT INTO tareas (id_usuario, titulo, descripcion, estado, fecha_inicio, fecha_fin) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isssss", $usuario_id,  $titulo, $descripcion, $estado, $fecha_inicio, $fecha_fin);
        
        if ($stmt->execute()) {
            $mensaje = "✅ Tarea creada correctamente.";
        } else {
            $mensaje = "❌ Error al crear la tarea.";
        }
        $stmt->close();
    } else {
        $mensaje = "⚠️ El campo no puede estar vacío.";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Tarea</title>
    <link rel="stylesheet" href="css/inicio_registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
  <style>
    /* Contenedor de botones de acciones */
    .acciones {
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 15px;
      margin-top: 30px;
    }
     
    /* Botón primario (Guardar tarea) */
    .boton-principal {
      background: #26a69a;
      color: #fff;
      padding: 14px 60px;       /* ajuste de tamaño aquí */
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      border: none;
      transition: background 0.3s ease;
      width: auto;
      min-width: 200px;
    }
    .boton-principal:hover {
      background: #1e8e86;
    }

    /* Botón secundario (Volver) */
    .boton-secundario {
      background: #f2f2f2;
      color: #333;
      padding: 12px 50px;
      border-radius: 8px;
      font-weight: bold;
      text-decoration: none;
      display: inline-block;
      text-align: center;
      border: none;
      transition: background 0.3s ease;
    }

    .boton-secundario:hover {
      background: #ddd;
    }
    /*Estilo de descripcion*/
    textarea,
     select {
     width: 100%;
     padding: 12px;
     margin-bottom: 15px;
     border: 2px solid #d1f0f0;
     border-radius: 8px;
     font-size: 15px;
     font-family: 'Quicksand', sans-serif;
     transition: border-color 0.3s;
     outline: none;
     background-color: white;
     color: #333;
     }

     textarea:focus,
     select:focus {
     border-color: #26a69a;
     }

  </style>
</head>
<body>
    <div class="contenedor">
      <div class="lado-derecho">
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
            <select name="estado" required style="padding: 10px; border-radius: 8px; border: 2px solid #d1f0f0;">
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
    </div>
</body>
</html>
