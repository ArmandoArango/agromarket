<!-- vistas/registro.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registro - AgroMarket</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Registro de Usuario</h2>
        <form action="../consultas/registrar_usuario.php" method="POST">
            <label for="nombre">Nombre completo:</label>
            <input type="text" name="nombre" required>

            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Registrarse</button>
        </form>
        <p>¿Ya tienes cuenta? <a href="login.php">Inicia sesión aquí</a></p>
    </div>
</body>
</html>
