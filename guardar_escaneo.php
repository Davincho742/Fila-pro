<?php
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json; charset=utf-8');

if (!file_exists('conexion1.php')) {
    echo json_encode(['status' => 'error', 'mensaje' => 'El archivo conexion1.php no existe']);
    exit;
}

require_once 'conexion1.php';

if ($conexion->connect_error) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error de BD: ' . $conexion->connect_error]);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$codigo = isset($data['codigo_qr']) ? trim($data['codigo_qr']) : '';
$nombre = isset($data['nombre']) ? trim($data['nombre']) : 'Estudiante Escaneado';
$grado = isset($data['grado']) ? trim($data['grado']) : '11-A';

if (empty($codigo)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Código QR vacío']);
    exit;
}

$sql = "INSERT INTO escaner (nombre_estudiante, grado, codigo_qr) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("sss", $nombre, $grado, $codigo);
    
    if ($stmt->execute()) {
        echo json_encode([
            'status' => 'success', 
            'mensaje' => 'Escaneo guardado correctamente'
        ]);
    } else {
        echo json_encode(['status' => 'error', 'mensaje' => 'Error al insertar: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'mensaje' => 'Error SQL: ' . $conexion->error]);
}

$conexion->close();
?>