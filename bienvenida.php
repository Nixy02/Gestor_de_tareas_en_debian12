<?php
session_start();
if (!isset($_SESSION['correo'])) {
    header("Location: inicio.php");
    exit();
}
$nombre = htmlspecialchars($_SESSION['nombre']);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bienvenida - Gestor de Tareas</title>

    <!-- Fuente Quicksand -->
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Estilos generales reutilizados -->
    <link rel="stylesheet" href="css/inicio_registro.css">

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            height: 100vh;
            background: linear-gradient(135deg, #26a69a, #48c9b0, #d1f0f0);
            background-size: 400% 400%;
            animation: fondoAnimado 10s ease infinite;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        @keyframes fondoAnimado {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bienvenida-box {
            width: 90%;
            max-width: 600px;
            background: #fff;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
            padding: 40px 30px;
            text-align: center;
        }

        .logo-superior {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 25px;
        }

        .logo-superior img {
            width: 60px;
            height: auto;
            opacity: 0.95;
            margin-bottom: 10px;
        }

        .titulo-bienvenida {
            font-size: 24px;
            font-weight: 600;
            color: #26a69a;
        }

        .mensaje-bienvenida {
            font-size: 20px;
            color: #26a69a;
            margin: 20px 0;
        }

        .acciones {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        .acciones a {
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background 0.3s;
        }

        .boton-principal {
            background: #26a69a;
            color: white;
        }

        .boton-principal:hover {
            background: #1e8e86;
        }

        .boton-secundario {
            background: #f2f2f2;
            color: #333;
        }

        .boton-secundario:hover {
            background: #ddd;
        }
    </style>
</head>
<body>
    <div class="bienvenida-box">
        <div class="logo-superior">
            <img src="img/icono_editar.png" alt="Logo del proyecto">
            <h1 class="titulo-bienvenida">Gestor de Tareas</h1>
        </div>

        <p class="mensaje-bienvenida">¡Hola, <?= $nombre ?>!</p>

        <div class="acciones" style="flex-direction: column; gap: 12px;">
         <a href="crear_tarea.php" class="boton-principal">➕ Crear nueva tarea</a>
         <a href="tareas.php" class="boton-principal">📋 Mis tareas</a>
         <a href="logout.php" class="boton-secundario">Cerrar sesión</a>
        </div>
    </div>
</body>
</html>
