<?php
// CONFIGURACIÓN LOCAL PARA XAMPP
$host = "127.0.0.1";
$puerto = "3307";
$bd = "sistema_pedidos";
$usuario = "root";
$password = "123123"; // tu contraseña de MySQL

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>