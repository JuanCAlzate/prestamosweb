<?php
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $idPrestamo = $_POST['id'];

    $sql = "SELECT * FROM prestamos WHERE idprestamo = :idprestamo";
    $stmt = $conexion->prepare($sql);
    $stmt->bindParam(':idprestamo', $idPrestamo);
    $stmt->execute();

    $prestamo = $stmt->fetch(PDO::FETCH_ASSOC);
    echo json_encode($prestamo);
}
?>
