<?php

session_start();
if (!isset($_SESSION['bienvenida_usuario_mostrada'])) {
    $_SESSION['bienvenida_usuario_mostrada'] = true;
    $mostrar_bienvenida_usuario = true;
} else {
    $mostrar_bienvenida_usuario = false;
}


require_once '../config/conexion.php';

$sql = "SELECT * FROM cliente";
$stmt = $conexion->prepare($sql);
$stmt->execute();
$num_clientes = $stmt->rowCount();

if ($num_clientes > 0) {
    $clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    echo "No se encontraron clientes.";
    exit();
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Clientes</title>
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
    .header-usuario {
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
  <a href="usuario_cliente.php"><i class="bi bi-people"></i> Clientes</a>
  <a href="usuario_pagos.php"><i class="bi bi-credit-card"></i> Pagos</a>
  <a href="cerrar_sesion.php"><i class="bi bi-door-closed"></i> Cerrar Sesión</a>
  <img src="/prestamos/vistas/logo.jpg" alt="Logo" style="position: fixed; bottom: 10px; right: 10px; width: 100px; height: auto;">
</div>
</div>


<div class="content">
<?php if ($mostrar_bienvenida_usuario): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    ¡Bienvenido usuario!
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php endif; ?>

  <h2 class="header-usuario">Clientes</h2>
  
  <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#agregarClienteModal"> Nuevo Cliente</button>
  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Estado</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      foreach ($clientes as $cliente) {
          echo "<tr>";
          echo "<td>{$cliente['idcliente']}</td>";
          echo "<td>{$cliente['nombre']}</td>";
          echo "<td>{$cliente['direccion']}</td>";
          echo "<td>{$cliente['telefono']}</td>";
          echo "<td>{$cliente['estado']}</td>";
          echo "<td>";
          echo "<a href='../ajax/eliminar_cliente.php?id={$cliente['idcliente']}' class='btn btn-danger'><i class='bi bi-trash'></i></a>";
          echo "<a href='#' class='btn btn-primary' onclick='abrirModalActualizar({$cliente['idcliente']})'><i class='bi bi-pencil'></i></a>";
          echo "</td>";
          echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="agregarClienteModal" tabindex="-1" aria-labelledby="agregarClienteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarClienteModalLabel">Agregar cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">

        <form action="../ajax/agregar_cliente.php" method="POST">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
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

<div class="modal fade" id="actualizarClienteModal" tabindex="-1" aria-labelledby="actualizarClienteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarClienteModalLabel">Actualizar Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formActualizarCliente" action="../ajax/actualizar_cliente.php" method="POST">
          <input type="hidden" id="idClienteActualizar" name="idClienteActualizar">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreActualizar" name="nombreActualizar" required>
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección</label>
            <input type="text" class="form-control" id="direccionActualizar" name="direccionActualizar" required>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono</label>
            <input type="text" class="form-control" id="telefonoActualizar" name="telefonoActualizar" required>
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
  function abrirModalActualizar(idCliente) {
    $.ajax({
      url: '../ajax/cargar_clientes.php',
      method: 'POST',
      data: { id: idCliente },
      dataType: 'json',
      success: function(data) {
        $('#idClienteActualizar').val(data.idcliente);
        $('#nombreActualizar').val(data.nombre);
        $('#direccionActualizar').val(data.direccion);
        $('#telefonoActualizar').val(data.telefono);
        $('#estadoActualizar').val(data.estado);
        $('#actualizarClienteModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }
</script>
</body>
</html>
