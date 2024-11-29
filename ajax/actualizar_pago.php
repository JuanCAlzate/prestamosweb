<?php
require_once '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idPago = $_POST['idpago'];
    $idcliente = $_POST['idcliente'];
    $usuario = $_POST['usuario'];
    $fecha = $_POST['fecha'];
    $cuota = $_POST['cuota'];

    $sqlActualizarPago = "UPDATE pagos SET idcliente = :idcliente, usuario = :usuario, fecha = :fecha, cuota = :cuota WHERE idpago = :idpago";
    $stmtActualizarPago = $conexion->prepare($sqlActualizarPago);
    $stmtActualizarPago->bindParam(':idcliente', $idcliente);
    $stmtActualizarPago->bindParam(':usuario', $usuario);
    $stmtActualizarPago->bindParam(':fecha', $fecha);
    $stmtActualizarPago->bindParam(':cuota', $cuota);
    $stmtActualizarPago->bindParam(':idpago', $idPago);

    if ($stmtActualizarPago->execute()) {
        header("Location: ../vistas/pagos.php");
        exit();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Error al actualizar el pago.'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Método de solicitud incorrecto.'));
}
?>
