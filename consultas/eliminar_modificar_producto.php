<?php
session_start();
require 'conexion.php';

// Eliminar producto
if (isset($_GET['eliminar'])) {
    $producto_id = $_GET['eliminar'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar que el producto sea del usuario
    $stmt = $pdo->prepare("SELECT imagen FROM productos WHERE id = ? AND user_id = ?");
    $stmt->execute([$producto_id, $usuario_id]);
    $producto = $stmt->fetch();

    if ($producto) {
        // Eliminar imagen
        $rutaImagen = '../uploads/' . $producto['imagen'];
        if (file_exists($rutaImagen)) {
            unlink($rutaImagen);
        }

        // Eliminar producto
        $stmt = $pdo->prepare("DELETE FROM productos WHERE id = ? AND user_id = ?");
        $stmt->execute([$producto_id, $usuario_id]);
    }

    header("Location: ../vistas/dashboard.php");
    exit();
}

// Modificar producto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $producto_id = $_POST['producto_id'];
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $usuario_id = $_SESSION['usuario_id'];

    $sql = "UPDATE productos SET nombre = ?, descripcion = ?, precio = ? WHERE id = ? AND user_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$nombre, $descripcion, $precio, $producto_id, $usuario_id]);

    header("Location: ../vistas/dashboard.php");
    exit();
}
?>
