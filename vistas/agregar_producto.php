<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

require '../consultas/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Recibir los datos del formulario
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = $_POST['precio'];
    $cantidad = $_POST['cantidad'];
    $imagen = $_FILES['imagen'];

    // Validación de campos (puedes agregar más validaciones si es necesario)
    if (empty($nombre) || empty($descripcion) || empty($precio) || empty($cantidad) || empty($imagen['name'])) {
        echo "<p>Por favor, complete todos los campos.</p>";
    } else {
        // Subir imagen
        $imagen_nombre = time() . "_" . $imagen['name'];
        move_uploaded_file($imagen['tmp_name'], "../uploads/" . $imagen_nombre);

        // Insertar el producto en la base de datos
        $sql = "INSERT INTO productos (user_id, nombre, descripcion, precio, cantidad, imagen) 
                VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['usuario_id'], $nombre, $descripcion, $precio, $cantidad, $imagen_nombre]);

        echo "<p>Producto agregado exitosamente.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto - AgroMarket</title>
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
            <h1>Agregar Producto</h1>
            <form action="agregar_producto.php" method="post" enctype="multipart/form-data">
                <label for="nombre">Nombre del producto:</label>
                <input type="text" name="nombre" id="nombre" required>

                <label for="descripcion">Descripción:</label>
                <textarea name="descripcion" id="descripcion" required></textarea>

                <label for="precio">Precio:</label>
                <input type="number" name="precio" id="precio" required step="0.01">

                <label for="cantidad">Cantidad disponible:</label>
                <input type="number" name="cantidad" id="cantidad" required min="1">

                <label for="imagen">Imagen del producto:</label>
                <input type="file" name="imagen" id="imagen" accept="image/*" required>

                <button type="submit">Agregar Producto</button>
            </form>
        </main>
    </div>
</body>
</html>
