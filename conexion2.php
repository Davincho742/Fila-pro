<?php
$host = "localhost";
$usuario_db = "root";
$password_db = ""; // Tu contraseña de MySQL si aplica
$database = "fila pro"; // Nombre exacto de tu base de datos

$conexion = new mysqli($host, $usuario_db, $password_db, $database);

if ($conexion->connect_error) {
    die(json_encode([
        'exito' => false, 
        'mensaje' => 'Error de conexión a la BD: ' . $conexion->connect_error
    ]));
}

$conexion->set_charset("utf8");
?>