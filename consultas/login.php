<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $correo = $_POST['correo'];
    $contrasena = $_POST['contrasena'];

    $sql = "SELECT * FROM usuarios WHERE correo = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$correo]);
    $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($usuario && password_verify($contrasena, $usuario['contrasena'])) {
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['usuario_nombre'] = $usuario['nombre'];
        header("Location: ../vistas/dashboard.php");
        exit();
    } else {
        header("Location: ../vistas/login.php?error=credenciales");
        exit();
    }
}
?>
