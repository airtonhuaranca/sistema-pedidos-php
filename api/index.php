<?php
require_once "conexion.php";

$sentencia = $conexion->query("SELECT * FROM pedidos ORDER BY id_pedido DESC");
$pedidos = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$totalPedidos = count($pedidos);
$totalIngresos = 0;
$pedidosPendientes = 0;

foreach ($pedidos as $p) {
    $totalIngresos += $p["precio"] * $p["cantidad"];
    if ($p["estado"] == "Pendiente") {
        $pedidosPendientes++;
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Pedidos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
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
            overflow-x: hidden;
        }

        .main-container {
            padding: 35px;
        }

        .header-box {
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.18);
            backdrop-filter: blur(12px);
            border-radius: 25px;
            padding: 30px;
            margin-bottom: 25px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.25);
        }

        .header-title {
            font-size: 32px;
            font-weight: 800;
            margin: 0;
        }

        .header-subtitle {
            color: #d1d5db;
            margin-top: 8px;
        }

        .stat-card {
            background: rgba(255, 255, 255, 0.13);
            border-radius: 22px;
            padding: 22px;
            border: 1px solid rgba(255, 255, 255, 0.18);
            box-shadow: 0 12px 25px rgba(0,0,0,0.18);
        }

        .stat-card h3 {
            font-size: 28px;
            font-weight: 800;
            margin: 0;
        }

        .stat-card p {
            margin: 0;
            color: #d1d5db;
        }

        .form-card,
        .table-card {
            background: #ffffff;
            color: #111827;
            border-radius: 25px;
            padding: 25px;
            box-shadow: 0 20px 35px rgba(0,0,0,0.25);
        }

        .form-title {
            font-weight: 800;
            margin-bottom: 20px;
            color: #0f172a;
        }

        .form-control,
        .form-select {
            border-radius: 14px;
            padding: 11px;
        }

        .btn-main {
            background: linear-gradient(135deg, #0f766e, #14b8a6);
            color: white;
            border: none;
            border-radius: 16px;
            padding: 12px;
            font-weight: bold;
            width: 100%;
        }

        .btn-main:hover {
            background: linear-gradient(135deg, #115e59, #0d9488);
            color: white;
        }

        .table {
            vertical-align: middle;
        }

        .table thead {
            background: #0f172a;
            color: white;
        }

        .table thead th {
            padding: 14px;
            white-space: nowrap;
        }

        .table tbody td {
            padding: 12px;
        }

        .btn-update {
            background: #2563eb;
            color: white;
            border-radius: 12px;
            border: none;
            padding: 8px 12px;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            border-radius: 12px;
            border: none;
            padding: 8px 12px;
        }

        .btn-update:hover,
        .btn-delete:hover {
            opacity: 0.85;
            color: white;
        }

        .small-input {
            min-width: 100px;
        }

        .price-box {
            font-weight: 700;
            color: #0f766e;
            white-space: nowrap;
        }

        .empty-row {
            padding: 25px !important;
        }

        /* TABLET */
        @media (max-width: 992px) {
            .main-container {
                padding: 22px;
            }

            .header-title {
                font-size: 28px;
            }

            .table-card {
                overflow-x: auto;
            }
        }

        /* CELULAR: la tabla se convierte en tarjetas */
        @media (max-width: 768px) {
            body {
                background: linear-gradient(160deg, #111827, #164e63, #0f766e);
            }

            .main-container {
                padding: 12px;
            }

            .header-box {
                padding: 22px;
                border-radius: 20px;
                text-align: center;
            }

            .header-title {
                font-size: 24px;
                line-height: 1.2;
            }

            .header-subtitle {
                font-size: 14px;
            }

            .stat-card {
                text-align: center;
                padding: 18px;
                border-radius: 18px;
            }

            .stat-card h3 {
                font-size: 25px;
            }

            .form-card,
            .table-card {
                padding: 18px;
                border-radius: 20px;
            }

            .form-title {
                text-align: center;
                font-size: 20px;
            }

            .table-responsive {
                overflow-x: visible;
            }

            table,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            tbody tr {
                background: #ffffff;
                margin-bottom: 18px;
                border-radius: 20px;
                padding: 15px;
                box-shadow: 0 8px 22px rgba(0,0,0,0.14);
                border: 1px solid #e5e7eb;
            }

            tbody td {
                display: flex;
                justify-content: space-between;
                align-items: center;
                gap: 12px;
                border: none;
                padding: 10px 0 !important;
            }

            tbody td::before {
                content: attr(data-label);
                font-weight: 800;
                color: #0f172a;
                min-width: 95px;
            }

            tbody td input,
            tbody td select {
                width: 65%;
                font-size: 14px;
            }

            .price-box {
                font-size: 16px;
                font-weight: 800;
            }

            .acciones {
                display: block !important;
                padding-top: 15px !important;
            }

            .acciones::before {
                display: none;
            }

            .acciones .btn-update,
            .acciones .btn-delete {
                width: 100%;
                margin-top: 8px;
                padding: 11px;
            }

            .acciones form {
                width: 100%;
            }

            .empty-row {
                text-align: center;
            }
        }

        /* CELULAR PEQUEÑO */
        @media (max-width: 420px) {
            .header-title {
                font-size: 21px;
            }

            .header-subtitle {
                font-size: 13px;
            }

            .form-card,
            .table-card {
                padding: 14px;
            }

            tbody td {
                display: block;
            }

            tbody td::before {
                display: block;
                margin-bottom: 6px;
            }

            tbody td input,
            tbody td select {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container-fluid main-container">

    <div class="header-box">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="header-title">Sistema de Gestión de Pedidos</h1>
                <p class="header-subtitle">
                    Registra, controla, actualiza y elimina pedidos desde una interfaz moderna.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-light text-dark p-3 rounded-pill">
                    Panel Administrativo
                </span>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-md-4">
            <div class="stat-card">
                <h3><?php echo $totalPedidos; ?></h3>
                <p>Total de pedidos</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <h3>S/ <?php echo number_format($totalIngresos, 2); ?></h3>
                <p>Ingresos registrados</p>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <h3><?php echo $pedidosPendientes; ?></h3>
                <p>Pedidos pendientes</p>
            </div>
        </div>
    </div>

    <div class="row g-4">

        <!-- FORMULARIO -->
        <div class="col-lg-4">
            <div class="form-card">
                <h4 class="form-title">Crear nuevo pedido</h4>

                <form action="guardar.php" method="POST">

                    <div class="mb-3">
                        <label class="form-label">Cliente</label>
                        <input type="text" name="cliente" class="form-control" placeholder="Nombre del cliente" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Producto</label>
                        <input type="text" name="producto" class="form-control" placeholder="Producto solicitado" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Precio</label>
                        <input type="number" name="precio" class="form-control" step="0.01" placeholder="0.00" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Cantidad</label>
                        <input type="number" name="cantidad" class="form-control" min="1" placeholder="Cantidad" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select name="estado" class="form-select" required>
                            <option value="Pendiente">Pendiente</option>
                            <option value="En proceso">En proceso</option>
                            <option value="Entregado">Entregado</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-main">
                        Registrar pedido
                    </button>

                </form>
            </div>
        </div>

        <!-- TABLA -->
        <div class="col-lg-8">
            <div class="table-card">
                <h4 class="form-title">Listado de pedidos</h4>

                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Producto</th>
                                <th>Precio</th>
                                <th>Cant.</th>
                                <th>Estado</th>
                                <th>Total</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php if (count($pedidos) > 0): ?>
                            <?php foreach ($pedidos as $pedido): ?>
                                <?php $formId = "form-update-" . $pedido["id_pedido"]; ?>
                                <tr>
                                    <td data-label="ID">
                                        <?php echo $pedido["id_pedido"]; ?>
                                        <input form="<?php echo $formId; ?>" type="hidden" name="id_pedido" value="<?php echo $pedido["id_pedido"]; ?>">
                                    </td>

                                    <td data-label="Cliente">
                                        <input form="<?php echo $formId; ?>" type="text" name="cliente" class="form-control small-input"
                                               value="<?php echo htmlspecialchars($pedido["cliente"]); ?>" required>
                                    </td>

                                    <td data-label="Producto">
                                        <input form="<?php echo $formId; ?>" type="text" name="producto" class="form-control small-input"
                                               value="<?php echo htmlspecialchars($pedido["producto"]); ?>" required>
                                    </td>

                                    <td data-label="Precio">
                                        <input form="<?php echo $formId; ?>" type="number" name="precio" step="0.01" class="form-control small-input"
                                               value="<?php echo $pedido["precio"]; ?>" required>
                                    </td>

                                    <td data-label="Cantidad">
                                        <input form="<?php echo $formId; ?>" type="number" name="cantidad" class="form-control small-input"
                                               value="<?php echo $pedido["cantidad"]; ?>" min="1" required>
                                    </td>

                                    <td data-label="Estado">
                                        <select form="<?php echo $formId; ?>" name="estado" class="form-select small-input" required>
                                            <option value="Pendiente" <?php if($pedido["estado"]=="Pendiente") echo "selected"; ?>>Pendiente</option>
                                            <option value="En proceso" <?php if($pedido["estado"]=="En proceso") echo "selected"; ?>>En proceso</option>
                                            <option value="Entregado" <?php if($pedido["estado"]=="Entregado") echo "selected"; ?>>Entregado</option>
                                            <option value="Cancelado" <?php if($pedido["estado"]=="Cancelado") echo "selected"; ?>>Cancelado</option>
                                        </select>
                                    </td>

                                    <td data-label="Total" class="price-box">
                                        S/ <?php echo number_format($pedido["precio"] * $pedido["cantidad"], 2); ?>
                                    </td>

                                    <td class="acciones">
                                        <form id="<?php echo $formId; ?>" action="actualizar.php" method="POST"></form>

                                        <button type="submit" form="<?php echo $formId; ?>" class="btn btn-update">
                                            Actualizar
                                        </button>

                                        <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este pedido?');">
                                            <input type="hidden" name="id_pedido" value="<?php echo $pedido["id_pedido"]; ?>">
                                            <button type="submit" class="btn btn-delete">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted empty-row">
                                    No hay pedidos registrados todavía.
                                </td>
                            </tr>
                        <?php endif; ?>
                        </tbody>

                    </table>
                </div>

            </div>
        </div>

    </div>

</div>

</body>
</html>
