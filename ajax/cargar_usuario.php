<?php
require_once '../config/conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['id'])) {
        $idUsuario = $_POST['id'];

        $sql = "SELECT * FROM usuarios WHERE idusuario = :id";
        $stmt = $conexion->prepare($sql);
        $stmt->bindParam(':id', $idUsuario);
        $stmt->execute();

        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($usuario) {
            echo json_encode($usuario);
        } else {
            echo json_encode(array('error' => 'No se encontró ningún usuario con ese ID.'));
        }
    } else {
        echo json_encode(array('error' => 'No se proporcionó el ID del usuario.'));
    }
} else {
    echo json_encode(array('error' => 'Método de solicitud no permitido.'));
}
?>
