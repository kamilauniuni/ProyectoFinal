<?php
$host = 'localhost';
$database = 'supermercado';
$user = 'root';
$password = '';

try {
    $conexion = new PDO('mysql:host=' . $host . ';dbname=' . $database, $user, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error de conexión: " . $e->getMessage();
    exit();
}
?>
