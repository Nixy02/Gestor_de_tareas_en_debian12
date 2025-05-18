<?php
session_start();
if (isset($_SESSION['correo'])) {
    header("Location: bienvenida.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión - Gestor de Tareas</title>
    <link rel="stylesheet" href="css/inicio_registro.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="contenedor">
        <div class="lado-izquierdo">
            <img src="img/icono_editar.png" alt="Logo checklist" class="icono">
            <h1>Gestor de<br><span>Tareas</span></h1>
            <p>Tu espacio para organizar,<br>priorizar y avanzar.</p>
        </div>
        <div class="lado-derecho">
            <h2>Inicia sesión</h2>
<?php if (isset($_GET['registrado']) && $_GET['registrado'] == 1): ?>
    <p class="mensaje-ok">¡Registro exitoso! Ahora puedes iniciar sesión.</p>
<?php endif; ?>
            <form action="login.php" method="POST">
                <input type="email" name="correo" placeholder="Correo electrónico" required>
                <input type="password" name="contrasena" placeholder="Contraseña" required>
                <input type="submit" name="iniciar" value="Entrar">
            </form>

            <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
                <p class="mensaje-error">Correo o contraseña incorrectos.</p>
            <?php endif; ?>

            <p class="registro-link">¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
        </div>
    </div>
</body>
</html>
