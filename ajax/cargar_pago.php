<?php
require_once '../config/conexion.php';

$idPago = $_GET['id']; 
$sqlCargarPago = "SELECT * FROM pagos WHERE idpago = :idPago";
$stmtCargarPago = $conexion->prepare($sqlCargarPago);
$stmtCargarPago->bindParam(':idPago', $idPago);
$stmtCargarPago->execute();
$pago = $stmtCargarPago->fetch(PDO::FETCH_ASSOC);

echo json_encode($pago);
?>
