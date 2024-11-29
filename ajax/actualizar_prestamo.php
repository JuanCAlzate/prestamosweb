<?php
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPrestamo = $_POST['idPrestamoActualizar'];
    $idCliente = $_POST['idclienteActualizar'];
    $usuario = $_POST['usuarioActualizar'];
    $monto = $_POST['montoActualizar'];
    $interes = $_POST['interesActualizar'];
    $formapago = $_POST['formapagoActualizar'];
    $plazo = $_POST['plazoActualizar'];
    $fechapago = $_POST['fechapagoActualizar'];
    $fechaprestamo = $_POST['fechaprestamoActualizar'];
    $estado = $_POST['estadoActualizar'];

    $sql = "UPDATE prestamos SET 
            idcliente = :idcliente, 
            usuario = :usuario, 
            monto = :monto, 
            interes = :interes, 
            formapago = :formapago, 
            plazo = :plazo, 
            fechapago = :fechapago, 
            fechaprestamo = :fechaprestamo, 
            estado = :estado 
            WHERE idprestamo = :idprestamo";

    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idcliente', $idCliente);
    $stmt->bindParam(':usuario', $usuario);
    $stmt->bindParam(':monto', $monto);
    $stmt->bindParam(':interes', $interes);
    $stmt->bindParam(':formapago', $formapago);
    $stmt->bindParam(':plazo', $plazo);
    $stmt->bindParam(':fechapago', $fechapago);
    $stmt->bindParam(':fechaprestamo', $fechaprestamo);
    $stmt->bindParam(':estado', $estado);
    $stmt->bindParam(':idprestamo', $idPrestamo);

    if ($stmt->execute()) {
        header('Location: ../vistas/prestamos.php');
    } else {
        echo "Error al actualizar el préstamo";
    }
}
?>

