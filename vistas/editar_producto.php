<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require '../consultas/conexion.php';

$usuario_id = $_SESSION['usuario_id'];
$producto_id = $_GET['id'] ?? null;

$stmt = $pdo->prepare("SELECT * FROM productos WHERE id = ? AND user_id = ?");
$stmt->execute([$producto_id, $usuario_id]);
$producto = $stmt->fetch();

if (!$producto) {
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Producto - AgroMarket</title>
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
        <h1>Editar Producto</h1>
        <form action="../consultas/eliminar_modificar_producto.php" method="POST">
            <input type="hidden" name="producto_id" value="<?= $producto['id'] ?>">

            <label for="nombre">Nombre:</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($producto['nombre']) ?>" required>

            <label for="descripcion">Descripción:</label>
            <textarea name="descripcion" required><?= htmlspecialchars($producto['descripcion']) ?></textarea>

            <label for="precio">Precio:</label>
            <input type="number" step="0.01" name="precio" value="<?= $producto['precio'] ?>" required>

            <button type="submit">Guardar Cambios</button>
        </form>
    </main>
</div>
</body>
</html>
