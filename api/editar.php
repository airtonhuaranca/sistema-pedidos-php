<?php
require_once "conexion.php";

$id_pedido = isset($_GET["id"]) ? (int) $_GET["id"] : 0;

if ($id_pedido <= 0) {
    header("Location: index.php?mensaje=Pedido no válido");
    exit;
}

$sql = "SELECT * FROM pedidos WHERE id_pedido = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id_pedido]);
$pedido = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$pedido) {
    header("Location: index.php?mensaje=Pedido no encontrado");
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar pedido</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #111827, #1e293b, #0f766e);
            font-family: 'Segoe UI', sans-serif;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .edit-card {
            width: 100%;
            max-width: 680px;
            background: #ffffff;
            color: #111827;
            border-radius: 26px;
            padding: 30px;
            box-shadow: 0 25px 45px rgba(0,0,0,0.28);
        }

        .edit-title {
            font-weight: 900;
            margin-bottom: 8px;
            color: #0f172a;
        }

        .edit-subtitle {
            color: #64748b;
            margin-bottom: 25px;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 12px;
        }

        .btn-save {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 13px;
            font-weight: 800;
            width: 100%;
        }

        .btn-save:hover {
            background: linear-gradient(135deg, #115e59, #0d9488);
            color: white;
        }

        .btn-back {
            background: #0f172a;
            color: white;
            border-radius: 16px;
            padding: 13px;
            font-weight: 800;
            width: 100%;
            text-decoration: none;
            text-align: center;
            display: block;
        }

        .btn-back:hover {
            background: #1e293b;
            color: white;
        }

        .pedido-id {
            background: #ecfeff;
            color: #0f766e;
            font-weight: 800;
            border-radius: 999px;
            display: inline-block;
            padding: 8px 14px;
            margin-bottom: 18px;
        }

        @media (max-width: 576px) {
            body {
                align-items: flex-start;
                padding: 12px;
            }

            .edit-card {
                padding: 20px;
                border-radius: 20px;
            }

            .edit-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="edit-card">
    <span class="pedido-id">Pedido #<?php echo $pedido["id_pedido"]; ?></span>

    <h1 class="edit-title">Editar pedido</h1>
    <p class="edit-subtitle">Corrige los datos del pedido y guarda los cambios.</p>

    <form action="actualizar.php" method="POST">
        <input type="hidden" name="id_pedido" value="<?php echo $pedido["id_pedido"]; ?>">

        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Cliente</label>
                <input type="text" name="cliente" class="form-control" value="<?php echo htmlspecialchars($pedido["cliente"]); ?>" required>
            </div>

            <div class="col-md-6">
                <label class="form-label">Producto</label>
                <input type="text" name="producto" class="form-control" value="<?php echo htmlspecialchars($pedido["producto"]); ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Precio</label>
                <input type="number" name="precio" class="form-control" step="0.01" min="0" value="<?php echo $pedido["precio"]; ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Cantidad</label>
                <input type="number" name="cantidad" class="form-control" min="1" value="<?php echo $pedido["cantidad"]; ?>" required>
            </div>

            <div class="col-md-4">
                <label class="form-label">Estado</label>
                <select name="estado" class="form-select" required>
                    <option value="Pendiente" <?php if($pedido["estado"] == "Pendiente") echo "selected"; ?>>Pendiente</option>
                    <option value="En proceso" <?php if($pedido["estado"] == "En proceso") echo "selected"; ?>>En proceso</option>
                    <option value="Entregado" <?php if($pedido["estado"] == "Entregado") echo "selected"; ?>>Entregado</option>
                    <option value="Cancelado" <?php if($pedido["estado"] == "Cancelado") echo "selected"; ?>>Cancelado</option>
                </select>
            </div>
        </div>

        <div class="row g-3 mt-4">
            <div class="col-md-6">
                <button type="submit" class="btn-save">Guardar cambios</button>
            </div>
            <div class="col-md-6">
                <a href="index.php" class="btn-back">Volver al listado</a>
            </div>
        </div>
    </form>
</div>

</body>
</html>
