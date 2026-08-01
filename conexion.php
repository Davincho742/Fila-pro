<?php
$host = "localhost";
$user = "root";
$password = ""; 


$database = "fila pro";

$conexion = new mysqli($host, $user, $password, $database);

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>