<?php
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuarios (nombre, correo, contrasena) VALUES (?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    try {
        $stmt->execute([$nombre, $correo, $contrasena]);
        header("Location: ../vistas/login.php?registro=exitoso");
        exit();
    } catch (PDOException $e) {
        header("Location: ../vistas/registro.php?error=correo_usado");
        exit();
    }
}
?>
