<?php
ini_set('display_errors', 0);
header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$pass = '';

$connFilaPro = new mysqli($host, $user, $pass, 'fila pro');
$connSuspencion = new mysqli($host, $user, $pass, 'suspencion');

$input = json_decode(file_get_contents('php://input'), true);
$usuarioId = trim($input['id'] ?? $input['usuario'] ?? $input['Nombre_usuario'] ?? '');

if (empty($usuarioId)) {
    echo json_encode(['exito' => false, 'mensaje' => 'ID no proporcionado.']);
    exit();
}

// Limpiar suspensión
$stmt1 = $connSuspencion->prepare("DELETE FROM suspencion WHERE usuario_id = ?");
$stmt1->bind_param("s", $usuarioId);
$stmt1->execute();

// Eliminar usuario
$stmt2 = $connFilaPro->prepare("DELETE FROM usuarios WHERE Nombre_usuario = ?");
$stmt2->bind_param("s", $usuarioId);

if ($stmt2->execute()) {
    echo json_encode(['exito' => true, 'mensaje' => 'Usuario eliminado correctamente.']);
} else {
    echo json_encode(['exito' => false, 'mensaje' => 'Error: ' . $connFilaPro->error]);
}
?>