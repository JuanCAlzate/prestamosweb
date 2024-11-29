<?php
require_once '../config/conexion.php';
$idPago = $_GET['id'];

$sqlEliminarPago = "DELETE FROM pagos WHERE idpago = :idPago";
$stmtEliminarPago = $conexion->prepare($sqlEliminarPago);
$stmtEliminarPago->bindParam(':idPago', $idPago);

if ($stmtEliminarPago->execute()) {
    echo json_encode(array('status' => 'success', 'message' => 'Pago eliminado correctamente.'));
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Error al eliminar el pago.'));
}

header("location: ../vistas/pagos.php");
exit();
?>
