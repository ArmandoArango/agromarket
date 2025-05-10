<?php
session_start();
require 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['usuario_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];

    // Validar imagen
    if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] !== 0) {
        header("Location: ../vistas/agregar_producto.php?error=imagen");
        exit();
    }

    $imagen = $_FILES['imagen'];
    $nombreArchivo = time() . '_' . basename($imagen['name']);
    $rutaDestino = '../uploads/' . $nombreArchivo;

    if (move_uploaded_file($imagen['tmp_name'], $rutaDestino)) {
        $sql = "INSERT INTO productos (user_id, nombre, descripcion, precio, imagen) VALUES (?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$user_id, $nombre, $descripcion, $precio, $nombreArchivo]);

        header("Location: ../vistas/dashboard.php");
        exit();
    } else {
        header("Location: ../vistas/agregar_producto.php?error=imagen");
        exit();
    }
}
?>
