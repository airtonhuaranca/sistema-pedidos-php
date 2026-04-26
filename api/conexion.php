<?php
// CONEXIÓN PARA VERCEL + TiDB CLOUD

$host = getenv("DB_HOST");
$puerto = getenv("DB_PORT");
$bd = getenv("DB_NAME");
$usuario = getenv("DB_USER");
$password = getenv("DB_PASSWORD");

// Validar si faltan variables
if (!$host || !$puerto || !$bd || !$usuario || !$password) {
    die("Faltan variables de entorno en Vercel. Revisa DB_HOST, DB_PORT, DB_NAME, DB_USER y DB_PASSWORD.");
}

try {
    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4",
        $usuario,
        $password
    );

    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

} catch (PDOException $e) {
    die("Error de conexión con host: " . $host . " puerto: " . $puerto . " base: " . $bd . " - " . $e->getMessage());
}
?>