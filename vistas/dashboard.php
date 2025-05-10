<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require '../consultas/conexion.php';

// Obtener productos del usuario
$sql = "SELECT * FROM productos WHERE user_id = ?";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['usuario_id']]);
$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
if ($productos === false) {
    $productos = [];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - AgroMarket</title>
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
                <li><a href="historial.php">Historial de Compras</a></li>
                <li><a href="../consultas/logout.php">Cerrar sesión</a></li>
            </ul>
        </aside>

        <main class="content">
            <h1>Bienvenido, <?php echo $_SESSION['usuario_nombre']; ?> 👋</h1>
            <h2>Mis Productos</h2>

            <?php if (count($productos) === 0): ?>
                <p class="no-registered">No has registrado productos aún.</p>
            <?php else: ?>
                <div class="product-list">
                    <?php
                    // Filtrar productos con cantidad > 0 para el vendedor
                    $productos_disponibles = array_filter($productos, function($producto) {
                        return isset($producto['cantidad']) && (int)$producto['cantidad'] > 0;
                    });

                    if (count($productos_disponibles) === 0): ?>
                        <p class="no-products">No hay productos registrados o todos están agotados.</p>
                    <?php else: ?>
                        <?php foreach ($productos_disponibles as $p): ?>
                            <div class="product-card">
                                <img src="../uploads/<?php echo htmlspecialchars($p['imagen']); ?>" alt="producto">
                                <h3><?php echo htmlspecialchars($p['nombre']); ?></h3>
                                <p><?php echo htmlspecialchars($p['descripcion']); ?></p>
                                <p><strong>Precio:</strong> $<?php echo number_format($p['precio'], 2); ?></p>
                                <p><strong>Cantidad disponible:</strong> <?php echo (int)$p['cantidad']; ?></p>
                                
                                <a href="editar_producto.php?id=<?php echo $p['id']; ?>" class="btn edit">Editar</a>
                                <a href="../consultas/eliminar_modificar_producto.php?eliminar=<?php echo $p['id']; ?>" class="btn delete" onclick="return confirm('¿Eliminar este producto?');">Eliminar</a>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </main>
    </div>
</body>
</html>

