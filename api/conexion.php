<?php
$host = getenv("DB_HOST");
$puerto = getenv("DB_PORT");
$bd = getenv("DB_NAME");
$usuario = getenv("DB_USER");
$password = getenv("DB_PASSWORD");

if (!$host || !$puerto || !$bd || !$usuario || !$password) {
    die("Faltan variables de entorno en Vercel. Revisa DB_HOST, DB_PORT, DB_NAME, DB_USER y DB_PASSWORD.");
}

// Buscar certificado CA disponible en Vercel/Linux
$caPaths = [
    "/etc/ssl/certs/ca-certificates.crt",
    "/etc/pki/tls/certs/ca-bundle.crt",
    "/etc/ssl/cert.pem"
];

$sslCa = null;

foreach ($caPaths as $path) {
    if (file_exists($path)) {
        $sslCa = $path;
        break;
    }
}

if (!$sslCa) {
    die("No se encontró un certificado CA válido en el servidor.");
}

try {
    $opciones = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 15,
        Pdo\Mysql::ATTR_SSL_CA => $sslCa,
        Pdo\Mysql::ATTR_SSL_VERIFY_SERVER_CERT => false
    ];

    $conexion = new PDO(
        "mysql:host=$host;port=$puerto;dbname=$bd;charset=utf8mb4",
        $usuario,
        $password,
        $opciones
    );

} catch (PDOException $e) {
    die("Error de conexión con host: " . $host . " puerto: " . $puerto . " base: " . $bd . " - " . $e->getMessage());
}
?>