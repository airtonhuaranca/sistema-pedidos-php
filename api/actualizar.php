<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_pedido = isset($_POST["id_pedido"]) ? (int) $_POST["id_pedido"] : 0;
    $cliente = isset($_POST["cliente"]) ? trim($_POST["cliente"]) : "";
    $producto = isset($_POST["producto"]) ? trim($_POST["producto"]) : "";
    $precio = isset($_POST["precio"]) ? (float) $_POST["precio"] : -1;
    $cantidad = isset($_POST["cantidad"]) ? (int) $_POST["cantidad"] : 0;
    $estado = isset($_POST["estado"]) ? $_POST["estado"] : "Pendiente";

    if ($id_pedido > 0 && $cliente !== "" && $producto !== "" && $precio >= 0 && $cantidad > 0) {
        $sql = "UPDATE pedidos 
                SET cliente = ?, producto = ?, precio = ?, cantidad = ?, estado = ? 
                WHERE id_pedido = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$cliente, $producto, $precio, $cantidad, $estado, $id_pedido]);

        header("Location: index.php?mensaje=Pedido actualizado correctamente");
        exit;
    }
}

header("Location: index.php?mensaje=No se pudo actualizar el pedido");
exit;
?>
