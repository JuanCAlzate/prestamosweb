<?php
require_once '../config/conexion.php';

$id = $_GET['id'];
$sql = "DELETE FROM usuarios WHERE idusuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->execute([$id]);

header("Location: ../vistas/usuarios.php");
exit();
?>
