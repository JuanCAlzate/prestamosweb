<?php
if (isset($_POST['id'])) {

    require_once '../config/conexion.php';

    try {

        $idCliente = $_POST['id'];
        $sql = "SELECT * FROM cliente WHERE idcliente = :id";
        $stmt = $conexion->prepare($sql);

        $stmt->bindParam(":id", $idCliente);
        $stmt->execute();
        $cliente = $stmt->fetch(PDO::FETCH_ASSOC);
        echo json_encode($cliente);
    } catch (PDOException $e) {
        echo json_encode(array('error' => 'Error al cargar el cliente: ' . $e->getMessage()));
    }
} else {
    echo json_encode(array('error' => 'ID de cliente no proporcionado'));
}
?>
