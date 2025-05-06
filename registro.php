<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro de usuario</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="formulario">
        <h2>Crear cuenta</h2>
        <form action="registro.php" method="POST">
            <label>Nombre completo:</label>
            <input type="text" name="nombre" required>

            <label>Correo electrónico:</label>
            <input type="email" name="correo" required>

            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>

            <input type="submit" name="registrar" value="Registrarse">
        </form>
        <div class="mensaje-extra">
        ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión aquí</a>
        </div>
        <?php
        if (isset($_POST['registrar'])) {
            require 'config.php';

            $nombre = $_POST['nombre'];
            $correo = $_POST['correo'];
            $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $nombre, $correo, $contrasena);

            if ($stmt->execute()) {
                echo "<p class='mensaje ok'>¡Usuario registrado con éxito!</p>";
            } else {
                echo "<p class='mensaje error'>Error: " . htmlspecialchars($stmt->error) . "</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>
    </div>
</body>
</html>
