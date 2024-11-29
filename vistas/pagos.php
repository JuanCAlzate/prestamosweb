<?php
require_once '../config/conexion.php';

$filtro_cliente = isset($_GET['idcliente']) ? $_GET['idcliente'] : null;
$filtro_fecha_inicio = isset($_GET['fecha_inicio']) ? $_GET['fecha_inicio'] : null;
$filtro_fecha_fin = isset($_GET['fecha_fin']) ? $_GET['fecha_fin'] : null;

$sqlPagos = "SELECT p.idpago, c.nombre AS cliente_nombre, p.usuario, p.fecha, p.cuota 
             FROM pagos p 
             INNER JOIN cliente c ON p.idcliente = c.idcliente";

$condiciones = [];
$params = [];

if (!empty($filtro_cliente)) {
    $condiciones[] = "p.idcliente = :idcliente";
    $params[':idcliente'] = $filtro_cliente;
}

if (!empty($filtro_fecha_inicio)) {
    $condiciones[] = "p.fecha >= :fecha_inicio";
    $params[':fecha_inicio'] = $filtro_fecha_inicio;
}

if (!empty($filtro_fecha_fin)) {
    $condiciones[] = "p.fecha <= :fecha_fin";
    $params[':fecha_fin'] = $filtro_fecha_fin;
}

if (!empty($condiciones)) {
    $sqlPagos .= " WHERE " . implode(" AND ", $condiciones);
}

$stmtPagos = $conexion->prepare($sqlPagos);

foreach ($params as $param => $value) {
    $stmtPagos->bindValue($param, $value, PDO::PARAM_STR);
}

$stmtPagos->execute();

$pagos = $stmtPagos->fetchAll(PDO::FETCH_ASSOC);
$sqlClientes = "SELECT idcliente, nombre FROM cliente";
$stmtClientes = $conexion->prepare($sqlClientes);
$stmtClientes->execute();
$clientes = $stmtClientes->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pagos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="icon" href="/prestamos/vistas/logo.jpg" type="image/jpg">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f8f9fa;
    }
    .sidebar {
      height: 100%;
      width: 250px;
      position: fixed;
      top: 0;
      left: 0;
      background-color: #007bff;
      padding-top: 20px;
      border-right: 2px solid #0056b3;
      box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
    }
    .sidebar a {
      padding: 10px 15px;
      text-decoration: none;
      font-size: 18px;
      color: #fff;
      display: block;
      border-bottom: 1px solid #0056b3;
    }
    .sidebar a:hover {
      background-color: #0056b3;
      border-left: 5px solid #ffc107;
      padding-left: 10px;
    }
    .sidebar .text-center {
      color: #fff;
    }
    .content {
      margin-left: 250px;
      padding: 20px;
    }
    .btn-pdf {
      background-color: #dc3545; 
      color: #fff;
    }
    .header-pagos {
    background-color: #99FFCC; 
    padding: 15px; 
    margin-bottom: 20px; 
    border: 1px solid #ccc; 
    border-radius: 5px; 
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); 
    text-align: center; 
    font-size: 24px; 
  }
  .table {
      border-collapse: separate;
      border-spacing: 0;
      width: 100%;
      background-color: #fff;
    }
    .table thead th {
      background-color: #343a40;
      color: #fff;
      border-bottom: 2px solid #ddd;
    }
    .table th, .table td {
      border-right: 1px solid #ddd;
      padding: 10px;
    }
    .table th:last-child, .table td:last-child {
      border-right: 0;
    }
    .table-hover tbody tr:hover {
      background-color: #f1f1f1;
    }
    .table tbody tr {
      border-bottom: 1px solid #ddd;
    }
    .table tbody tr:last-child {
      border-bottom: 0;
    }
    
  </style>
</head>
<body>

<div class="sidebar">
  <div class="text-center mb-4">
  <h4 style="background-color: #0056b3; color: #ffc107; padding: 10px; border-radius: 5px;">Menú</h4>
  </div>
  <a href="inicio.php"><i class="bi bi-house"></i> Dashboard</a>
  <a href="clientes.php"><i class="bi bi-people"></i> Clientes</a>
  <a href="prestamos.php"><i class="bi bi-cash"></i> Préstamos</a>
  <a href="pagos.php"><i class="bi bi-credit-card"></i> Pagos</a>
  <a href="usuarios.php"><i class="bi bi-person"></i> Usuarios</a>
  <a href="cerrar_sesion.php"><i class="bi bi-door-closed"></i> Cerrar Sesión</a>
  <img src="/prestamos/vistas/logo.jpg" alt="Logo" style="position: fixed; bottom: 10px; right: 10px; width: 100px; height: auto;">
</div>

<div class="content">
  <h2 class="header-pagos">Pagos</h2>
  
  <div class="my-3">
    <form method="GET" action="pagos.php" class="row g-3">
      <div class="col-md-3">
        <label for="idcliente" class="form-label">Cliente:</label>
        <select id="idcliente" name="idcliente" class="form-select">
          <option value="">Todos los clientes</option>
          <?php foreach ($clientes as $cliente): ?>
            <option value="<?php echo htmlspecialchars($cliente['idcliente']); ?>" <?php echo $filtro_cliente == $cliente['idcliente'] ? 'selected' : ''; ?>>
              <?php echo htmlspecialchars($cliente['nombre']); ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-md-3">
        <label for="fecha_inicio" class="form-label">Fecha de inicio:</label>
        <input type="date" id="fecha_inicio" name="fecha_inicio" class="form-control" value="<?php echo htmlspecialchars($filtro_fecha_inicio); ?>">
      </div>
      <div class="col-md-3">
        <label for="fecha_fin" class="form-label">Fecha de fin:</label>
        <input type="date" id="fecha_fin" name="fecha_fin" class="form-control" value="<?php echo htmlspecialchars($filtro_fecha_fin); ?>">
      </div>
      <div class="col-md-3 align-self-end">
        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="pagos.php" class="btn btn-secondary">Limpiar</a>
      </div>
    </form>
  </div>

  <div class="mb-3 d-flex justify-content-start align-items-center">
  <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarPagoModal">
    <i class="bi bi-person-plus"></i> Nuevo Pago
  </button>
  <form action="../vistas/generar_pdf_pagos.php" method="post" target="_blank" class="d-inline">
    <button type="submit" class="btn btn-pdf me-2" name="generar_pdf">
      <i class="bi bi-file-earmark-pdf"></i> PDF
    </button>
  </form>
  <form action="../vistas/generar_excel_pagos.php" method="post" target="_blank" class="d-inline">
    <button type="submit" class="btn btn-success" name="generar_excel">
      <i class="bi bi-file-earmark-excel"></i> Excel
    </button>
  </form>
</div>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Cliente</th>
        <th>Prestamista</th>
        <th>Fecha de Pago</th>
        <th>Cuota</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($pagos as $pago): ?>
        <tr>
          <td><?php echo htmlspecialchars($pago['idpago']); ?></td>
          <td><?php echo htmlspecialchars($pago['cliente_nombre']); ?></td>
          <td><?php echo htmlspecialchars($pago['usuario']); ?></td>
          <td><?php echo htmlspecialchars($pago['fecha']); ?></td>
          <td><?php echo htmlspecialchars($pago['cuota']); ?></td>
          <td>
            <a href="../ajax/eliminar_pago.php?id=<?php echo htmlspecialchars($pago['idpago']); ?>" class="btn btn-danger"><i class="bi bi-trash"></i></a>
            <a href="#" class="btn btn-primary" onclick="abrirModalActualizar(<?php echo htmlspecialchars($pago['idpago']); ?>)"><i class="bi bi-pencil"></i></a>
          </td>
        </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="agregarPagoModal" tabindex="-1" aria-labelledby="agregarPagoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarPagoModalLabel">Agregar Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../ajax/agregar_pago.php" method="POST">
          <div class="mb-3">
            <label for="idcliente" class="form-label">Cliente</label>
            <select class="form-select" id="idcliente" name="idcliente" required>
              <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo htmlspecialchars($cliente['idcliente']); ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
          </div>
          <div class="mb-3">
            <label for="fecha" class="form-label">Fecha de Pago</label>
            <input type="date" class="form-control" id="fecha" name="fecha" required>
          </div>
          <div class="mb-3">
            <label for="cuota" class="form-label">Cuota</label>
            <input type="text" class="form-control" id="cuota" name="cuota" required>
          </div>
          <button type="submit" class="btn btn-primary">Agregar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="actualizarPagoModal" tabindex="-1" aria-labelledby="actualizarPagoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarPagoModalLabel">Actualizar Pago</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../ajax/actualizar_pago.php" method="POST" id="formActualizarPago">
          <input type="hidden" name="idpago" id="actualizarIdPago">
          <div class="mb-3">
            <label for="actualizarIdCliente" class="form-label">Cliente</label>
            <select class="form-select" id="actualizarIdCliente" name="idcliente" required>
              <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo htmlspecialchars($cliente['idcliente']); ?>"><?php echo htmlspecialchars($cliente['nombre']); ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="actualizarUsuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="actualizarUsuario" name="usuario" required>
          </div>
          <div class="mb-3">
            <label for="actualizarFecha" class="form-label">Fecha de Pago</label>
            <input type="date" class="form-control" id="actualizarFecha" name="fecha" required>
          </div>
          <div class="mb-3">
            <label for="actualizarCuota" class="form-label">Cuota</label>
            <input type="text" class="form-control" id="actualizarCuota" name="cuota" required>
          </div>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
  function abrirModalActualizar(idPago) {
    $.ajax({
      url: '../ajax/cargar_pago.php',
      method: 'GET',
      data: { id: idPago },
      dataType: 'json',
      success: function(data) {
        $('#actualizarIdPago').val(data.idpago);
        $('#actualizarIdCliente').val(data.idcliente);
        $('#actualizarUsuario').val(data.usuario);
        $('#actualizarFecha').val(data.fecha);
        $('#actualizarCuota').val(data.cuota);
        $('#actualizarPagoModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }

</script>
</body>
</html>
