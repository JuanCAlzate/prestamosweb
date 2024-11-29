<?php
require_once '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $idCliente = $_POST['idClienteActualizar'];
    $nombre = $_POST['nombreActualizar'];
    $direccion = $_POST['direccionActualizar'];
    $telefono = $_POST['telefonoActualizar'];
    $estado = $_POST['estadoActualizar'];

    
    $sql = "UPDATE cliente SET nombre = :nombre, direccion = :direccion, telefono = :telefono, estado = :estado WHERE idcliente = :id";

    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bindParam(":id", $idCliente);
        $stmt->bindParam(":nombre", $nombre);
        $stmt->bindParam(":direccion", $direccion);
        $stmt->bindParam(":telefono", $telefono);
        $stmt->bindParam(":estado", $estado);
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
