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

function badgeEstado($estado) {
    switch ($estado) {
        case "Pendiente":
            return "badge-pendiente";
        case "En proceso":
            return "badge-proceso";
        case "Entregado":
            return "badge-entregado";
        case "Cancelado":
            return "badge-cancelado";
        default:
            return "badge-secondary";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Pedidos</title>
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

        .btn-refresh {
            background: #0f172a;
            color: white;
            border-radius: 14px;
            padding: 10px 14px;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
        }

        .btn-refresh:hover {
            background: #1e293b;
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

        .badge-estado {
            color: white;
            padding: 8px 12px;
            border-radius: 999px;
            font-size: 13px;
            font-weight: 700;
            display: inline-block;
        }

        .badge-pendiente {
            background: #f59e0b;
        }

        .badge-proceso {
            background: #2563eb;
        }

        .badge-entregado {
            background: #16a34a;
        }

        .badge-cancelado {
            background: #dc2626;
        }

        .btn-edit {
            background: #2563eb;
            color: white;
            border-radius: 12px;
            border: none;
            padding: 8px 12px;
            text-decoration: none;
            display: inline-block;
            font-weight: 700;
        }

        .btn-delete {
            background: #dc2626;
            color: white;
            border-radius: 12px;
            border: none;
            padding: 8px 12px;
            font-weight: 700;
        }

        .btn-edit:hover,
        .btn-delete:hover {
            opacity: 0.85;
            color: white;
        }

        .price-box {
            font-weight: 800;
            color: #0f766e;
            white-space: nowrap;
        }

        .empty-row {
            padding: 25px !important;
        }

        .acciones {
            white-space: nowrap;
        }

        .acciones form {
            display: inline-block;
        }

        .mensaje-alerta {
            border-radius: 18px;
            border: none;
        }

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

            .table-toolbar {
                text-align: center;
            }

            .btn-refresh {
                width: 100%;
                margin-bottom: 12px;
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

            .acciones {
                display: block !important;
                padding-top: 15px !important;
                white-space: normal;
            }

            .acciones::before {
                display: none;
            }

            .acciones .btn-edit,
            .acciones .btn-delete {
                width: 100%;
                margin-top: 8px;
                padding: 11px;
                text-align: center;
            }

            .acciones form {
                display: block;
                width: 100%;
            }

            .empty-row {
                text-align: center;
            }
        }

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
                    Registra pedidos, actualiza la lista, edita datos en otra ventana y elimina pedidos específicos.
                </p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <span class="badge bg-light text-dark p-3 rounded-pill">
                    Panel Administrativo
                </span>
            </div>
        </div>
    </div>

    <?php if (isset($_GET["mensaje"])): ?>
        <div class="alert alert-success mensaje-alerta mb-4">
            <?php echo htmlspecialchars($_GET["mensaje"]); ?>
        </div>
    <?php endif; ?>

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

        <div class="col-lg-8">
            <div class="table-card">
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2 table-toolbar">
                    <h4 class="form-title mb-0">Listado de pedidos</h4>
                    <a href="index.php" class="btn-refresh">Actualizar lista</a>
                </div>

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
                                <tr>
                                    <td data-label="ID">
                                        <?php echo $pedido["id_pedido"]; ?>
                                    </td>

                                    <td data-label="Cliente">
                                        <?php echo htmlspecialchars($pedido["cliente"]); ?>
                                    </td>

                                    <td data-label="Producto">
                                        <?php echo htmlspecialchars($pedido["producto"]); ?>
                                    </td>

                                    <td data-label="Precio">
                                        S/ <?php echo number_format($pedido["precio"], 2); ?>
                                    </td>

                                    <td data-label="Cantidad">
                                        <?php echo $pedido["cantidad"]; ?>
                                    </td>

                                    <td data-label="Estado">
                                        <span class="badge-estado <?php echo badgeEstado($pedido["estado"]); ?>">
                                            <?php echo htmlspecialchars($pedido["estado"]); ?>
                                        </span>
                                    </td>

                                    <td data-label="Total" class="price-box">
                                        S/ <?php echo number_format($pedido["precio"] * $pedido["cantidad"], 2); ?>
                                    </td>

                                    <td class="acciones">
                                        <a href="editar.php?id=<?php echo $pedido["id_pedido"]; ?>" target="_blank" rel="noopener" class="btn-edit">
                                            Editar
                                        </a>

                                        <form action="eliminar.php" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este pedido?');">
                                            <input type="hidden" name="id_pedido" value="<?php echo $pedido["id_pedido"]; ?>">
                                            <button type="submit" class="btn-delete">
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
