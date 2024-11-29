<?php
require_once '../config/conexion.php';
$idcliente = $_POST['idcliente'];
$usuario = $_POST['usuario'];
$fecha = $_POST['fecha'];
$cuota = $_POST['cuota'];

$sqlAgregarPago = "INSERT INTO pagos (idcliente, usuario, fecha, cuota) VALUES (:idcliente, :usuario, :fecha, :cuota)";
$stmtAgregarPago = $conexion->prepare($sqlAgregarPago);
$stmtAgregarPago->bindParam(':idcliente', $idcliente);
$stmtAgregarPago->bindParam(':usuario', $usuario);
$stmtAgregarPago->bindParam(':fecha', $fecha);
$stmtAgregarPago->bindParam(':cuota', $cuota);

if ($stmtAgregarPago->execute()) {
    echo json_encode(array('status' => 'success', 'message' => 'Pago agregado correctamente.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error al agregar el pago.'));
}

header("location: ../vistas/pagos.php");
exit();
?>
