<?php
require_once "conexion.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id_pedido = $_POST["id_pedido"];

    if ($id_pedido > 0) {
        $sql = "DELETE FROM pedidos WHERE id_pedido = ?";
        $stmt = $conexion->prepare($sql);
        $stmt->execute([$id_pedido]);

        header("Location: index.php?mensaje=Pedido eliminado correctamente");
        exit;
    }
}

header("Location: index.php?mensaje=No se pudo eliminar el pedido");
exit;
?>
