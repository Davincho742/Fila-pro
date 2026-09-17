<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once 'conexion.php';

$accion = $_GET['accion'] ?? '';

if ($accion === 'buscar') {
    $q = trim($_GET['q'] ?? '');
    
    $sql = "SELECT id, Nombre_usuario AS usuario, grado, ROL, estado FROM usuarios WHERE Nombre_usuario = ? OR Contraseña = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ss", $q, $q);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($row = $res->fetch_assoc()) {
        // En caso de que no exista la columna estado en BD, se simula 'activo'
        $row['estado'] = $row['estado'] ?? 'activo'; 
        $row['diasReclamados'] = []; 
        echo json_encode(['exito' => true, 'estudiante' => $row]);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'No se encontró ningún estudiante registrado.']);
    }
    exit();
}

if ($accion === 'cambiar_estado') {
    $input = json_decode(file_get_contents('php://input'), true);
    $id = $input['id'] ?? '';
    $nuevoEstado = $input['nuevo_estado'] ?? 'activo';

    $sql = "UPDATE usuarios SET estado = ? WHERE id = ? OR Nombre_usuario = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("sss", $nuevoEstado, $id, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['exito' => true, 'nuevo_estado' => $nuevoEstado]);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Error al actualizar']);
    }
    exit();
}

echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida']);
?>