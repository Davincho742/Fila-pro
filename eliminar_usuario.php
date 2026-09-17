<?php
header('Content-Type: application/json; charset=utf-8');
require_once 'conexion2.php';

$input = json_decode(file_get_contents('php://input'), true);
$id = $input['id'] ?? '';

if (empty($id)) {
    echo json_encode(['exito' => false, 'mensaje' => 'ID de usuario no proporcionado.']);
    exit();
}

// Eliminar el usuario por ID o por Nombre_usuario
$sql = "DELETE FROM usuarios WHERE id = ? OR Nombre_usuario = ?";
$stmt = $conexion->prepare($sql);

if ($stmt) {
    $stmt->bind_param("ss", $id, $id);
    if ($stmt->execute()) {
        echo json_encode(['exito' => true, 'mensaje' => 'Estudiante eliminado con éxito de la base de datos.']);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Error SQL: ' . $stmt->error]);
    }
    $stmt->close();
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Error al preparar la eliminación.']);
}

$conexion->close();
?>