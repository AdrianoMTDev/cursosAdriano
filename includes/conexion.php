<?php
$host = "localhost";
$usuario = "root"; 
$password = "";    
$bd = "sistema_cursos";

$conexion = new mysqli($host, $usuario, $password, $bd);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8mb4");
?>

