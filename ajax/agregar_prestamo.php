<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once '../config/conexion.php';

    $idcliente = $_POST['idcliente'];
    $usuario = $_POST['usuario'];
    $fechaprestamo = $_POST['fechaprestamo'];
    $monto = $_POST['monto'];
    $interes = $_POST['interes'];
    $formapago = $_POST['formapago'];
    $fechapago = $_POST['fechapago'];
    $plazo = $_POST['plazo'];
    $estado = $_POST['estado'];

    $saldo = $monto + ($monto * ($interes / 100));

    $sql = "INSERT INTO prestamos (idcliente, usuario, fechaprestamo, monto, interes, saldo, formapago, fechapago, plazo, estado) 
            VALUES (:idcliente, :usuario, :fechaprestamo, :monto, :interes, :saldo, :formapago, :fechapago, :plazo, :estado)";

    $stmt = $conexion->prepare($sql);

    $stmt->bindParam(":idcliente", $idcliente);
    $stmt->bindParam(":usuario", $usuario);
    $stmt->bindParam(":fechaprestamo", $fechaprestamo);
    $stmt->bindParam(":monto", $monto);
    $stmt->bindParam(":interes", $interes);
    $stmt->bindParam(":saldo", $saldo);
    $stmt->bindParam(":formapago", $formapago);
    $stmt->bindParam(":fechapago", $fechapago);
    $stmt->bindParam(":plazo", $plazo);
    $stmt->bindParam(":estado", $estado);

    if ($stmt->execute()) {
        header("location: ../vistas/prestamos.php?mensaje=success");
        exit();
    } else {
        header("location: ../vistas/prestamos.php?mensaje=error");
        exit();
    }
} else {
    header("location: ../vistas/prestamos.php");
    exit();
}
?>
