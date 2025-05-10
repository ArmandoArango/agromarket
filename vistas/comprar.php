<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require '../consultas/conexion.php';

$usuario_id = $_SESSION['usuario_id'];

// Traer productos de otros usuarios
$sql = "SELECT * FROM productos WHERE user_id != ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$usuario_id]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Filtrar productos con cantidad > 0
$productos_disponibles = array_filter($productos, function($producto) {
    return (int)$producto['cantidad'] > 0;
});
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprar Productos - AgroMarket</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
<div class="dashboard">
    <aside class="sidebar">
        <h2>AgroMarket</h2>
        <ul>
            <li><a href="dashboard.php">Mis Productos</a></li>
            <li><a href="agregar_producto.php">Agregar Producto</a></li>
            <li><a href="comprar.php" class="active">Comprar Productos</a></li>
            <li><a href="historial.php">Historial de Compras</a></li>
            <li><a href="../consultas/logout.php">Cerrar sesión</a></li>
        </ul>
    </aside>

    <main class="content">
        <h1>Productos disponibles para comprar</h1>

        <?php if (count($productos_disponibles) === 0): ?>
            <p>No hay productos disponibles en este momento.</p>
        <?php else: ?>
            <div class="product-list">
                <?php foreach ($productos_disponibles as $p): ?>
                    <div class="product-card">
                        <img src="../uploads/<?php echo htmlspecialchars($p['imagen']); ?>" alt="producto">
                        <h3><?php echo htmlspecialchars($p['nombre']); ?></h3>
                        <p><?php echo htmlspecialchars($p['descripcion']); ?></p>
                        <p><strong>Precio:</strong> $<?php echo number_format($p['precio'], 2); ?></p>
                        <p><strong>Disponible:</strong> <?php echo (int)$p['cantidad']; ?> unidades</p>

                        <form action="../consultas/procesar_compra.php" method="POST">
                            <input type="hidden" name="producto_id" value="<?php echo $p['id']; ?>">
                            <label for="cantidad_<?php echo $p['id']; ?>">Cantidad a comprar:</label>
                            <input type="number" name="cantidad" id="cantidad_<?php echo $p['id']; ?>" min="1" max="<?php echo (int)$p['cantidad']; ?>" required>
                            <button type="submit" class="btn buy">Comprar</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </main>
</div>
</body>
</html>
