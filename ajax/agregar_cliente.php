<?php
require_once '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $estado = $_POST['estado'];

    $sql = "INSERT INTO cliente (nombre, direccion, telefono, estado) VALUES (:nombre, :direccion, :telefono, :estado)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
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
