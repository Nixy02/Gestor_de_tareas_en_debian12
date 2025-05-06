<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="estilos.css">
</head>
<body>
    <div class="formulario">
        <h2>Iniciar sesión</h2>
        <form action="login.php" method="POST">
            <label>Correo electrónico:</label>
            <input type="email" name="correo" required>

            <label>Contraseña:</label>
            <input type="password" name="contrasena" required>

            <input type="submit" name="iniciar" value="Entrar">
        </form>

        <?php
        if (isset($_POST['iniciar'])) {
            require 'config.php';

            $correo = $_POST['correo'];
            $contrasena = $_POST['contrasena'];

            $sql = "SELECT * FROM usuarios WHERE correo = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();

            if ($resultado->num_rows === 1) {
                $usuario = $resultado->fetch_assoc();
                if (password_verify($contrasena, $usuario['contrasena'])) {
                    echo "<p class='mensaje ok'>Inicio de sesión exitoso</p>";
                    // Aquí podrías redirigir: header("Location: dashboard.php");
                } else {
                    echo "<p class='mensaje error'>Contraseña incorrecta</p>";
                }
            } else {
                echo "<p class='mensaje error'>El correo no está registrado</p>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <div class="mensaje-extra">
            ¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a>
        </div>
    </div>
</body>
</html>
