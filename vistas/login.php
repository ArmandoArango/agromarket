<!-- vistas/login.php -->
<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - AgroMarket</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
    <div class="container">
        <h2>Iniciar Sesión</h2>

        <?php if (isset($_GET['registro']) && $_GET['registro'] == 'exitoso'): ?>
            <p class="success">Registro exitoso. Ahora puedes iniciar sesión.</p>
        <?php endif; ?>

        <?php if (isset($_GET['error']) && $_GET['error'] == 'credenciales'): ?>
            <p class="error">Correo o contraseña incorrectos.</p>
        <?php endif; ?>

        <form action="../consultas/login.php" method="POST">
            <label for="correo">Correo electrónico:</label>
            <input type="email" name="correo" required>

            <label for="contrasena">Contraseña:</label>
            <input type="password" name="contrasena" required>

            <button type="submit">Iniciar sesión</button>
        </form>

        <p>¿No tienes cuenta? <a href="registro.php">Regístrate aquí</a></p>
    </div>
</body>
</html>
