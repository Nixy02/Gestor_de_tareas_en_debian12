<?php
// Mostrar errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conexión a la base de datos
require 'config.php';

$error = '';

// Solo procesar si viene vía POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Recoger los datos del formulario
    $nombre      = trim($_POST['nombre']);
    $correo      = trim($_POST['correo']);
    $contrasena  = $_POST['contrasena'];
    $contrasena2 = $_POST['contrasena2'];

    // 1) Validaciones básicas
    if ($contrasena !== $contrasena2) {
        $error = '⚠️ Las contraseñas no coinciden.';
    } elseif (strlen($contrasena) < 6) {
        $error = '⚠️ La contraseña debe tener al menos 6 caracteres.';
    } else {
        // 2) Comprobar si el correo ya existe
        $stmt = $conn->prepare("SELECT id FROM usuarios WHERE correo = ?");
        $stmt->bind_param("s", $correo);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = '⚠️ Ese correo ya está en uso.';
            $stmt->close();
        } else {
            $stmt->close();
            // 3) Insertar nuevo usuario
            $hash = password_hash($contrasena, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $nombre, $correo, $hash);

            if ($stmt->execute()) {
                // Registro exitoso: redirigir con mensaje
                header("Location: inicio.php?registrado=1");
                exit();
            } else {
                $error = '⚠️E Error al registrar usuario. Por favor, inténtalo de nuevo.';
            }
            $stmt->close();
        }
    }
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - Gestor de Tareas</title>
    <link rel="stylesheet" href="css/inicio_registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedor">
        <div class="lado-izquierdo">
            <img src="img/icono_editar.png" alt="Icono checklist" class="icono">
            <h1>Crea tu<br><span>Cuenta</span></h1>
            <p>Organiza tus tareas desde un solo lugar.</p>
        </div>
        <div class="lado-derecho">
            <h2>Registro</h2>
            <form action="" method="POST">
                <input type="text" name="nombre" placeholder="Nombre completo" required>
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <input type="password" name="contrasena2" placeholder="Confirmar contraseña" required>
                <input type="submit" value="Registrarme">
            </form>

            <?php if ($error): ?>
                <p class="mensaje-error"><?= htmlspecialchars($error) ?></p>
            <?php endif; ?>

            <p class="registro-link">¿Ya tienes cuenta? <a href="inicio.php">Inicia sesión aquí</a></p>
        </div>
    </div>
</body>
</html>
