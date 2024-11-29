<?php
require_once '../config/conexion.php';

// Obtener valores del POST
$nombre = $_POST['nombre'];
$direccion = $_POST['direccion'];
$telefono = $_POST['telefono'];
$login = $_POST['login'];
$clave = $_POST['clave'];
$estado = $_POST['estado'];
$rol = $_POST['rol'];

// Verificar si las variables no están vacías y si existen
if (!empty($nombre) && !empty($direccion) && !empty($telefono) && !empty($login) && !empty($clave) && !empty($estado) && !empty($rol)) {
    // Preparar la consulta SQL
    $sql = "INSERT INTO usuarios (nombre, direccion, telefono, login, clave, estado, rol) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    
    // Ejecutar la consulta con los valores
    $stmt->execute([$nombre, $direccion, $telefono, $login, $clave, $estado, $rol]);
    
    // Redirigir a la página de usuarios
    header("Location: ../vistas/usuarios.php");
    exit();
} else {
    // Manejar el error en caso de variables vacías
    echo "Error: Todos los campos son obligatorios.";
}
?>
