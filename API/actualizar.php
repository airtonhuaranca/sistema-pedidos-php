<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_pedido = $_POST["id_pedido"];
    $cliente = trim($_POST["cliente"]);
    $producto = trim($_POST["producto"]);
    $precio = $_POST["precio"];
    $cantidad = $_POST["cantidad"];
    $estado = $_POST["estado"];

    if ($id_pedido > 0 && $cliente !== "" && $producto !== "" && $precio >= 0 && $cantidad > 0) {
        $sql = "UPDATE pedidos SET cliente = ?, producto = ?, precio = ?, cantidad = ?, estado = ? WHERE id_pedido = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$cliente, $producto, $precio, $cantidad, $estado, $id_pedido]);

        header("Location: index.php?mensaje=Pedido actualizado correctamente");
        exit;
    }
}

header("Location: index.php?mensaje=No se pudo actualizar el pedido");
exit;
?>
