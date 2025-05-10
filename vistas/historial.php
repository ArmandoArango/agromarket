<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require '../consultas/conexion.php';

$usuario_id = $_SESSION['usuario_id'];

// Obtener compras del usuario
$sql = "SELECT c.*, p.nombre, p.descripcion, p.imagen, p.precio 
        FROM compras c
        JOIN productos p ON c.producto_id = p.id
        WHERE c.comprador_id = ?
        ORDER BY c.fecha DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$compras = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial de Compras - AgroMarket</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>AgroMarket</h2>
        <ul>
            <li><a href="dashboard.php">Mis Productos</a></li>
            <li><a href="agregar_producto.php">Agregar Producto</a></li>
            <li><a href="comprar.php">Comprar Productos</a></li>
            <li><a href="historial.php" class="active">Historial de Compras</a></li>
            <li><a href="../consultas/logout.php">Cerrar sesión</a></li>
        </ul>
    </aside>

    <main class="content">
        <h1>Historial de Compras</h1>

        <?php if (count($compras) > 0): ?>
            <?php foreach ($compras as $compra): ?>
                <div class="product-card">
                    <img src="../uploads/<?= htmlspecialchars($compra['imagen']) ?>" alt="Producto">
                    <h3><?= htmlspecialchars($compra['nombre']) ?></h3>
                    <p><?= htmlspecialchars($compra['descripcion']) ?></p>
                    <p>Precio unitario: $<?= number_format($compra['precio'], 2) ?></p>
                    <p>Cantidad comprada: <?= $compra['cantidad'] ?></p>
                    <p>Fecha: <?= date("d/m/Y H:i", strtotime($compra['fecha'])) ?></p>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No has realizado ninguna compra.</p>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
