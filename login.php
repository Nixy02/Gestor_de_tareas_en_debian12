<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors',1);
require 'config.php';

if ($_SERVER['REQUEST_METHOD']==='POST' && isset($_POST['iniciar'])) {
    $correo    = trim($_POST['correo']);
    $contrasena= $_POST['contrasena'];

    $stmt = $conn->prepare("SELECT nombre, contrasena FROM usuarios WHERE correo = ?");
    $stmt->bind_param("s",$correo);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows===1) {
        $stmt->bind_result($nombreDb,$hash);
        $stmt->fetch();
        if (password_verify($contrasena,$hash)) {
            $_SESSION['correo']= $correo;
            $_SESSION['nombre']= $nombreDb;
            header("Location: bienvenida.php");
            exit();
        }
    }
    // Si llega aquí, error
    header("Location: inicio.php?error=1");
    exit();
} else {
    header("Location: inicio.php");
    exit();
}
