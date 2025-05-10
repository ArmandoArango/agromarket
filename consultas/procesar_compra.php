<?php
session_start();
require 'conexion.php';

if (!isset($_SESSION['usuario_id'])) {
    header("Location: ../vistas/login.php");
    exit();
}

$comprador_id = $_SESSION['usuario_id'];
$producto_id = $_POST['producto_id'];
$cantidad_deseada = (int) $_POST['cantidad'];

// Verificar stock
$stmt = $pdo->prepare("SELECT cantidad FROM productos WHERE id = ?");
$stmt->execute([$producto_id]);
$producto = $stmt->fetch();

if (!$producto || $producto['cantidad'] < $cantidad_deseada) {
    echo "<script>alert('No hay suficiente inventario disponible'); window.location.href = '../vistas/comprar.php';</script>";
    exit();
}

// Descontar inventario
$nueva_cantidad = $producto['cantidad'] - $cantidad_deseada;
$update = $pdo->prepare("UPDATE productos SET cantidad = ? WHERE id = ?");
$update->execute([$nueva_cantidad, $producto_id]);

// Registrar compra
$insert = $pdo->prepare("INSERT INTO compras (comprador_id, producto_id, cantidad) VALUES (?, ?, ?)");
$insert->execute([$comprador_id, $producto_id, $cantidad_deseada]);

header("Location: ../vistas/historial.php");
exit();
?>
