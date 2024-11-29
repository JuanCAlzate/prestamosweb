<?php
$host = 'localhost'; 
$dbname = 'creditosdb';
$username = 'root'; 
$password = ''; 

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conexion->exec("SET NAMES utf8mb4");
} catch(PDOException $e) {
    die("Error de conexión: " . $e->getMessage());
}
?>
