<?php
require_once '../config/conexion.php';

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
  <title>Préstamos</title>
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
    .header-prestamos {
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
  <div class="text-center text-white mb-4">
  <h4 style="background-color: #0056b3; color: #ffc107; padding: 10px; border-radius: 5px;">Menú</h4>
  </div>
  <a href="inicio.php" class="text-white"><i class="bi bi-house"></i> Dashboard</a>
  <a href="clientes.php" class="text-white"><i class="bi bi-people"></i> Clientes</a>
  <a href="prestamos.php" class="text-white"><i class="bi bi-cash"></i> Préstamos</a>
  <a href="pagos.php" class="text-white"><i class="bi bi-credit-card"></i> Pagos</a>
  <a href="usuarios.php" class="text-white"><i class="bi bi-person"></i> Usuarios</a>
  <a href="cerrar_sesion.php" class="text-white"><i class="bi bi-door-closed"></i> Cerrar Sesión</a>
  <img src="/prestamos/vistas/logo.jpg" alt="Logo" style="position: fixed; bottom: 10px; right: 10px; width: 100px; height: auto;">
</div>

<div class="content">
  <h2 class="header-prestamos">Préstamos</h2>
  
  <div class="mb-3 d-flex justify-content-start align-items-center">
  <button type="button" class="btn btn-primary me-2" data-bs-toggle="modal" data-bs-target="#agregarPrestamoModal">
    <i class="bi bi-person-plus"></i> Nuevo Préstamo
  </button>
  <form action="../vistas/generar_pdf_prestamos.php" method="post" target="_blank" class="d-inline">
    <button type="submit" class="btn btn-pdf me-2" name="generar_pdf">
      <i class="bi bi-file-earmark-pdf"></i> PDF
    </button>
  </form>
  <form action="../vistas/generar_excel_prestamos.php" method="post" target="_blank" class="d-inline">
    <button type="submit" class="btn btn-success" name="generar_excel">
      <i class="bi bi-file-earmark-excel"></i> Excel
    </button>
  </form>
</div>

  <div class="table-responsive">
    <table class="table table-striped">
      <thead>
        <tr>
          <th>ID</th>
          <th>Cliente</th>
          <th>Prestamista</th>
          <th>Monto</th>
          <th>Interés</th>
          <th>Saldo</th>
          <th>Forma Pago</th>
          <th>Plazo</th>
          <th>Fecha Pago</th>
          <th>Fecha Préstamo</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $sqlPrestamos = "SELECT p.idprestamo, c.nombre AS cliente_nombre, p.usuario, p.monto, p.interes, (p.monto * (1 + (p.interes / 100))) AS saldo, p.formapago, p.plazo, p.fechapago, p.fechaprestamo, p.estado FROM prestamos p INNER JOIN cliente c ON p.idcliente = c.idcliente";
        $stmtPrestamos = $conexion->prepare($sqlPrestamos);
        $stmtPrestamos->execute();
        $prestamos = $stmtPrestamos->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($prestamos as $prestamo) {
            echo "<tr>";
            echo "<td>{$prestamo['idprestamo']}</td>";
            echo "<td>{$prestamo['cliente_nombre']}</td>";
            echo "<td>{$prestamo['usuario']}</td>";
            echo "<td>{$prestamo['monto']}</td>";
            echo "<td>{$prestamo['interes']}</td>";
            echo "<td>{$prestamo['saldo']}</td>";
            echo "<td>{$prestamo['formapago']}</td>";
            echo "<td>{$prestamo['plazo']}</td>";
            echo "<td>{$prestamo['fechapago']}</td>";
            echo "<td>{$prestamo['fechaprestamo']}</td>";
            echo "<td>{$prestamo['estado']}</td>";
            echo "<td>";
            echo "<a href='../ajax/eliminar_prestamo.php?id={$prestamo['idprestamo']}' class='btn btn-danger'><i class='bi bi-trash'></i></a>";
            echo "<a href='#' class='btn btn-primary' onclick='abrirModalActualizar({$prestamo['idprestamo']})'><i class='bi bi-pencil'></i></a>";
            echo "</td>";
            echo "</tr>";
        }
        ?>
      </tbody>
    </table>
  </div>
</div>

<div class="modal fade" id="agregarPrestamoModal" tabindex="-1" aria-labelledby="agregarPrestamoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarPrestamoModalLabel">Agregar Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="../ajax/agregar_prestamo.php" method="POST">
          <div class="mb-3">
            <label for="idcliente" class="form-label">Cliente</label>
            <select class="form-select" id="idcliente" name="idcliente" required>
              <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['idcliente']; ?>"><?php echo $cliente['nombre']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="usuario" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuario" name="usuario" required>
          </div>
          <div class="mb-3">
            <label for="monto" class="form-label">Monto</label>
            <input type="text" class="form-control" id="monto" name="monto" required>
          </div>
          <div class="mb-3">
            <label for="interes" class="form-label">Interés</label>
            <select class="form-select" id="interes" name="interes" required>
              <option value="20">20%</option>
              <option value="15">15%</option>
              <option value="10">10%</option>
              <option value="5">5%</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="formapago" class="form-label">Forma de Pago</label>
            <select class="form-select" id="formapago" name="formapago" required>
              <option value="Diario">Diario</option>
              <option value="Semanal">Semanal</option>
              <option value="Quincenal">Quincenal</option>
              <option value="Mensual">Mensual</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="plazo" class="form-label">Plazo</label>
            <select class="form-select" id="plazo" name="plazo" required>
              <option value="Dia">Día</option>
              <option value="Semana">Semana</option>
              <option value="Quincena">Quincena</option>
              <option value="Mes">Mes</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fechapago" class="form-label">Fecha de Pago</label>
            <input type="date" class="form-control" id="fechapago" name="fechapago" required>
          </div>
          <div class="mb-3">
            <label for="fechaprestamo" class="form-label">Fecha del Prestamo</label>
            <input type="date" class="form-control" id="fechaprestamo" name="fechaprestamo" required>
          </div>
          <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="actualizarPrestamoModal" tabindex="-1" aria-labelledby="actualizarPrestamoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarPrestamoModalLabel">Actualizar Préstamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
  
        <form id="formActualizarPrestamo" action="../ajax/actualizar_prestamo.php" method="POST">
          <input type="hidden" id="idPrestamoActualizar" name="idPrestamoActualizar">
          <div class="mb-3">
            <label for="idclienteActualizar" class="form-label">Cliente</label>
            <select class="form-select" id="idclienteActualizar" name="idclienteActualizar" required>
              <?php foreach ($clientes as $cliente): ?>
                <option value="<?php echo $cliente['idcliente']; ?>"><?php echo $cliente['nombre']; ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div class="mb-3">
            <label for="usuarioActualizar" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="usuarioActualizar" name="usuarioActualizar" required>
          </div>
          <div class="mb-3">
            <label for="montoActualizar" class="form-label">Monto</label>
            <input type="text" class="form-control" id="montoActualizar" name="montoActualizar" required>
          </div>
          <div class="mb-3">
            <label for="interesActualizar" class="form-label">Interés</label>
            <select class="form-select" id="interesActualizar" name="interesActualizar" required>
              <option value="20">20%</option>
              <option value="15">15%</option>
              <option value="10">10%</option>
              <option value="5">5%</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="formapagoActualizar" class="form-label">Forma de Pago</label>
            <select class="form-select" id="formapagoActualizar" name="formapagoActualizar" required>
              <option value="Diario">Diario</option>
              <option value="Semanal">Semanal</option>
              <option value="Quincenal">Quincenal</option>
              <option value="Mensual">Mensual</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="plazoActualizar" class="form-label">Plazo</label>
            <select class="form-select" id="plazoActualizar" name="plazoActualizar" required>
              <option value="Dia">Día</option>
              <option value="Semana">Semana</option>
              <option value="Quincena">Quincena</option>
              <option value="Mes">Mes</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fechapagoActualizar" class="form-label">Fecha de Pago</label>
            <input type="date" class="form-control" id="fechapagoActualizar" name="fechapagoActualizar" required>
          </div>
          <div class="mb-3">
            <label for="fechaprestamoActualizar" class="form-label">Fecha del Prestamo</label>
            <input type="date" class="form-control" id="fechaprestamoActualizar" name="fechaprestamoActualizar" required>
          </div>
          <div class="mb-3">
            <label for="estadoActualizar" class="form-label">Estado</label>
            <select class="form-select" id="estadoActualizar" name="estadoActualizar" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Actualizar</button>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>


<script>
  function abrirModalActualizar(idPrestamo) {
    $.ajax({
      url: '../ajax/cargar_prestamo.php',
      method: 'POST',
      data: { id: idPrestamo },
      dataType: 'json',
      success: function(data) {
        $('#idPrestamoActualizar').val(data.idprestamo);
        $('#idclienteActualizar').val(data.idcliente);
        $('#usuarioActualizar').val(data.usuario);
        $('#montoActualizar').val(data.monto);
        $('#interesActualizar').val(data.interes);
        $('#formapagoActualizar').val(data.formapago);
        $('#plazoActualizar').val(data.plazo);
        $('#fechapagoActualizar').val(data.fechapago);
        $('#fechaprestamoActualizar').val(data.fechaprestamo);
        $('#estadoActualizar').val(data.estado);
        $('#actualizarPrestamoModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }
</script>


</body>
</html>
