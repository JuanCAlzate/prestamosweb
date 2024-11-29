<?php
require_once '../config/conexion.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['idUsuarioActualizar'];
    $nombre = $_POST['nombre'];
    $direccion = $_POST['direccion'];
    $telefono = $_POST['telefono'];
    $login = $_POST['login'];
    $clave = $_POST['clave'];
    $estado = $_POST['estadoActualizar'];
    $rol = $_POST['rolActualizar'];

    $sql = "UPDATE usuarios SET nombre = ?, direccion = ?, telefono = ?, login = ?, clave = ?, estado = ?, rol = ? WHERE idusuario = ?";
    $stmt = $conexion->prepare($sql);

    if ($stmt->execute([$nombre, $direccion, $telefono, $login, $clave, $estado, $rol, $id])) {
        // Redirigir a la página de usuarios después de la actualización exitosa
        header('Location: ../vistas/usuarios.php');
        exit();
    } else {
        echo "Error al actualizar el usuario";
    }
} else {
    echo "Método no permitido";
}
?>
