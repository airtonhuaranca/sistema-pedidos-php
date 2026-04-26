<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $cliente = trim($_POST["cliente"]);
    $producto = trim($_POST["producto"]);
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $estado = $_POST["estado"];

    if ($cliente !== "" && $producto !== "" && $precio >= 0 && $cantidad > 0) {
        $sql = "INSERT INTO pedidos (cliente, producto, precio, cantidad, estado) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$cliente, $producto, $precio, $cantidad, $estado]);

        header("Location: index.php?mensaje=Pedido registrado correctamente");
        exit;
    }
}

header("Location: index.php?mensaje=Datos inválidos");
exit;
?>
