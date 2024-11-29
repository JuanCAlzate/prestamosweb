<?php
if (isset($_GET['id'])) {
    
    require_once '../config/conexion.php';

    $id = $_GET['id'];
    $sql = "DELETE FROM prestamos WHERE idprestamo = :id";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    header("location: ../vistas/prestamos.php");
    exit();
} else {
    header("location: ../vistas/prestamos.php");
    exit();
}
?>

