<?php
$host = 'localhost';
$db   = 'agromarket';
$user = 'root';
$pass = ''; // Cambiar si tu MySQL tiene contraseña
$charset = 'utf8mb4';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=$charset", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Conexión exitosa";
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>
