<?php
require_once '../config/conexion.php';

$sqlUsuarios = "SELECT idusuario, nombre FROM usuarios";
$stmtUsuarios = $conexion->prepare($sqlUsuarios);
$stmtUsuarios->execute();
$usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Usuarios</title>
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
    .header-usuarios {
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
    .action-btn {
      margin-right: 5px; 
    }
  </style>
</head>
<body>

<div class="sidebar">
<div class="text-center text-white mb-4">
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
  <h2 class="header-usuarios">Usarios</h2>
  
  <div class="mb-3 d-flex justify-content-start align-items-center">
    <button type="button" class="btn btn-primary me-2 mb-1" data-bs-toggle="modal" data-bs-target="#agregarUsuarioModal"><i class="bi bi-person-plus"></i> Nuevo Usuario</button>
    <form action="../vistas/generar_pdf_usuarios.php" method="post" target="_blank" class="d-inline">
      <button type="submit" class="btn btn-danger me-2 mb-1"><i class="bi bi-file-earmark-pdf"></i> PDF</button>
    </form>
    <form action="../vistas/generar_excel_usuarios.php" method="post" target="_blank" class="d-inline">
      <button type="submit" class="btn btn-success mb-1"><i class="bi bi-file-earmark-excel"></i> Excel</button>
    </form>
  </div>

  <table class="table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Dirección</th>
        <th>Teléfono</th>
        <th>Login</th>
        <th>Clave</th>
        <th>Estado</th>
        <th>Rol</th>
        <th>Acciones</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $sqlUsuarios = "SELECT * FROM usuarios";
      $stmtUsuarios = $conexion->prepare($sqlUsuarios);
      $stmtUsuarios->execute();
      $usuarios = $stmtUsuarios->fetchAll(PDO::FETCH_ASSOC);
      
      foreach ($usuarios as $usuario) {
          echo "<tr>";
          echo "<td>{$usuario['idusuario']}</td>";
          echo "<td>{$usuario['nombre']}</td>";
          echo "<td>{$usuario['direccion']}</td>";
          echo "<td>{$usuario['telefono']}</td>";
          echo "<td>{$usuario['login']}</td>";
          echo "<td class='clave-column' data-clave='{$usuario['clave']}'>•••••</td>"; 
          echo "<td>{$usuario['estado']}</td>";
          echo "<td>{$usuario['rol']}</td>";
          echo "<td>";
          echo "<a href='../ajax/eliminar_usuario.php?id={$usuario['idusuario']}' class='btn btn-danger action-btn'><i class='bi bi-trash'></i></a>";
          echo "<a href='#' class='btn btn-primary action-btn' onclick='abrirModalActualizar({$usuario['idusuario']})'><i class='bi bi-pencil'></i></a>";
          echo "<button class='btn btn-secondary action-btn ver-clave-btn'><i class='bi bi-eye'></i></button>";
          echo "</td>";
          echo "</tr>";
      }
      ?>
    </tbody>
  </table>
</div>

<div class="modal fade" id="agregarUsuarioModal" tabindex="-1" aria-labelledby="agregarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="agregarUsuarioModalLabel">Agregar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="../ajax/agregar_usuario.php" method="POST">
          <div class="mb-3">
            <label for="nombre" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombre" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="direccion" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccion" name="direccion" required>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefono" name="telefono" required>
          </div>
          <div class="mb-3">
            <label for="login" class="form-label">Login:</label>
            <input type="text" class="form-control" id="login" name="login" required>
          </div>
          <div class="mb-3">
            <label for="clave" class="form-label">Clave:</label>
            <input type="password" class="form-control" id="clave" name="clave" required>
          </div>
          <div class="mb-3">
            <label for="estado" class="form-label">Estado</label>
            <select class="form-select" id="estado" name="estado" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="rol" class="form-label">Rol</label> 
            <select class="form-select" id="rol" name="rol" required>
              <option value="Admin">Admin</option>
              <option value="Usuario">Usuario</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="actualizarUsuarioModal" tabindex="-1" aria-labelledby="actualizarUsuarioModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="actualizarUsuarioModalLabel">Actualizar Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formActualizarUsuario" action="../ajax/actualizar_usuario.php" method="POST">
          <input type="hidden" id="idUsuarioActualizar" name="idUsuarioActualizar">
          <div class="mb-3">
            <label for="nombreActualizar" class="form-label">Nombre:</label>
            <input type="text" class="form-control" id="nombreActualizar" name="nombre" required>
          </div>
          <div class="mb-3">
            <label for="direccionActualizar" class="form-label">Dirección:</label>
            <input type="text" class="form-control" id="direccionActualizar" name="direccion" required>
          </div>
          <div class="mb-3">
            <label for="telefonoActualizar" class="form-label">Teléfono:</label>
            <input type="text" class="form-control" id="telefonoActualizar" name="telefono" required>
          </div>
          <div class="mb-3">
            <label for="loginActualizar" class="form-label">Login:</label>
            <input type="text" class="form-control" id="loginActualizar" name="login" required>
          </div>
          <div class="mb-3">
            <label for="claveActualizar" class="form-label">Clave:</label>
            <input type="password" class="form-control" id="claveActualizar" name="clave" required>
          </div>
          <div class="mb-3">
            <label for="estadoActualizar" class="form-label">Estado</label>
            <select class="form-select" id="estadoActualizar" name="estadoActualizar" required>
              <option value="Activo">Activo</option>
              <option value="Inactivo">Inactivo</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="rolActualizar" class="form-label">Rol</label> 
            <select class="form-select" id="rolActualizar" name="rolActualizar" required>
              <option value="Admin">Admin</option>
              <option value="Usuario">Usuario</option>
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
  function abrirModalActualizar(idUsuario) {
    $.ajax({
      url: '../ajax/cargar_usuario.php',
      method: 'POST',
      data: { id: idUsuario },
      dataType: 'json',
      success: function(data) {
        $('#idUsuarioActualizar').val(data.idusuario);
        $('#nombreActualizar').val(data.nombre);
        $('#direccionActualizar').val(data.direccion);
        $('#telefonoActualizar').val(data.telefono);
        $('#loginActualizar').val(data.login);
        $('#claveActualizar').val(data.clave);
        $('#estadoActualizar').val(data.estado);
        $('#rolActualizar').val(data.rol); 
        $('#actualizarUsuarioModal').modal('show');
      },
      error: function(xhr, status, error) {
        console.error(xhr.responseText);
      }
    });
  }
</script>

<script>
$(document).ready(function() {
    $('.ver-clave-btn').click(function() {
        var claveElement = $(this).closest('tr').find('.clave-column');
        var clave = claveElement.data('clave');
        claveElement.text(clave); 
    });
});
</script>

</body>
</html>
