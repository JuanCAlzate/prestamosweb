<?php
require_once '../config/conexion.php';

if (isset($_GET['id'])) {
    $idCliente = $_GET['id'];

    $sql = "DELETE FROM cliente WHERE idcliente = :id";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bindParam(":id", $idCliente);
        if ($stmt->execute()) {
            header("Location: ../vistas/clientes.php");
            exit(); 
        } else {
            echo "Error al ejecutar la consulta: " . $stmt->errorInfo()[2];
        }
    } else {
        echo "Error al preparar la consulta: " . $conexion->errorInfo()[2];
    }
}
?>
