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
    echo json_encode(['status' => 'error', 'mensaje' => 'Error al momento de escanear: ' . $conexion->connect_error]);
    exit;
}

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$codigo = isset($data['codigo_qr']) ? trim($data['codigo_qr']) : '';
$nombre = isset($data['nombre']) ? trim($data['nombre']) : 'Estudiante Escaneado';
if (empty($codigo)) {
    echo json_encode(['status' => 'error', 'mensaje' => 'Código QR vacío']);
    exit;
}

// 1. VALIDACIÓN: Verificar si el código QR ya fue escaneado en las últimas 24 horas
$sqlCheck = "SELECT id FROM escaner 
            WHERE codigo_qr = ? 
            AND fecha_escaneo >= NOW() - INTERVAL 24 HOUR 
            ORDER BY id DESC LIMIT 1";

$stmtCheck = $conexion->prepare($sqlCheck);

// Si la columna en tu BD se llama 'fecha' en lugar de 'fecha_escaneo', la consulta se adapta automáticamente
if (!$stmtCheck) {
    $sqlCheck = "SELECT id FROM escaner 
                WHERE codigo_qr = ? 
                AND fecha >= NOW() - INTERVAL 24 HOUR 
                ORDER BY id DESC LIMIT 1";
    $stmtCheck = $conexion->prepare($sqlCheck);
}

if ($stmtCheck) {
    $stmtCheck->bind_param("s", $codigo);
    $stmtCheck->execute();
    $resCheck = $stmtCheck->get_result();

    if ($resCheck->num_rows > 0) {
        // Bloquea el registro si no han pasado 24 horas
        echo json_encode([
            'status' => 'bloqueado',
            'mensaje' => 'este qr ya se ha escaneado'
        ]);
        $stmtCheck->close();
        $conexion->close();
        exit;
    }
    $stmtCheck->close();
}

// 2. REGISTRO: Guardar el escaneo si pasaron las 24 horas
$sql = "INSERT INTO escaner (nombre_estudiante,codigo_qr) VALUES (?, ?)";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $nombre, $codigo);
    
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