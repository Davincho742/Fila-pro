<?php
// Desactivar impresión de errores de texto para no romper la respuesta JSON
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

$host = 'localhost';
$user = 'root';
$pass = '';

// Conexiones a las bases de datos
$connFilaPro = new mysqli($host, $user, $pass, 'fila pro');
$connSuspencion = new mysqli($host, $user, $pass, 'suspencion');

if ($connFilaPro->connect_error || $connSuspencion->connect_error) {
    echo json_encode(['exito' => false, 'mensaje' => 'Error de conexión a la base de datos.']);
    exit();
}

$accion = $_GET['accion'] ?? '';

// 1. BUSCAR ESTUDIANTE
if ($accion === 'buscar') {
    $q = trim($_GET['q'] ?? '');

    if (empty($q)) {
        echo json_encode(['exito' => false, 'mensaje' => 'Ingresa el usuario a buscar.']);
        exit();
    }

    $sql = "SELECT Nombre_usuario FROM usuarios WHERE Nombre_usuario = ? LIMIT 1";
    $stmt = $connFilaPro->prepare($sql);
    $stmt->bind_param("s", $q);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $usuarioEstudiante = $row['Nombre_usuario'];

        $sqlSusp = "SELECT estado FROM suspencion WHERE usuario_id = ? AND estado = 'suspendido' LIMIT 1";
        $stmtSusp = $connSuspencion->prepare($sqlSusp);
        $stmtSusp->bind_param("s", $usuarioEstudiante);
        $stmtSusp->execute();
        $resSusp = $stmtSusp->get_result();

        $estadoActual = ($resSusp->num_rows > 0) ? 'suspendido' : 'activo';

        echo json_encode([
            'exito' => true,
            'estudiante' => [
                'id' => $usuarioEstudiante,
                'usuario' => $usuarioEstudiante,
                'nombre' => $usuarioEstudiante,
                'estado' => $estadoActual
            ]
        ]);
        $stmtSusp->close();
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Estudiante no encontrado.']);
    }
    $stmt->close();
    exit();
}

// 2. CAMBIAR ESTADO DE SUSPENSIÓN
if ($accion === 'cambiar_estado') {
    $input = json_decode(file_get_contents('php://input'), true);
    $usuarioId = trim($input['usuario'] ?? $input['id'] ?? '');
    $nuevoEstado = trim($input['nuevo_estado'] ?? 'suspendido');

    if ($nuevoEstado === 'suspendido') {
        $stmtDel = $connSuspencion->prepare("DELETE FROM suspencion WHERE usuario_id = ?");
        $stmtDel->bind_param("s", $usuarioId);
        $stmtDel->execute();
        $stmtDel->close();

        $stmtIns = $connSuspencion->prepare("INSERT INTO suspencion (usuario_id, estado, motivo, fecha) VALUES (?, 'suspendido', 'Suspendido por profesor', NOW())");
        $stmtIns->bind_param("s", $usuarioId);
        $stmtIns->execute();
        $stmtIns->close();

        echo json_encode(['exito' => true, 'nuevo_estado' => 'suspendido']);
    } else {
        $stmtDel = $connSuspencion->prepare("DELETE FROM suspencion WHERE usuario_id = ?");
        $stmtDel->bind_param("s", $usuarioId);
        $stmtDel->execute();
        $stmtDel->close();

        echo json_encode(['exito' => true, 'nuevo_estado' => 'activo']);
    }
    exit();
}

// 3. ELIMINAR CUENTA (CAPTURA TODAS LAS VARIANTES DE ACCIONES)
if ($accion === 'eliminar' || $accion === 'eliminar_cuenta' || $accion === 'eliminar_usuario') {
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Captura el identificador del usuario sin importar qué nombre le dé el JS
    $usuarioId = trim($input['id'] ?? $input['usuario'] ?? $input['Nombre_usuario'] ?? '');

    if (empty($usuarioId)) {
        echo json_encode(['exito' => false, 'mensaje' => 'Usuario no proporcionado.']);
        exit();
    }

    // Paso A: Eliminar de la base de datos 'suspencion'
    $stmt1 = $connSuspencion->prepare("DELETE FROM suspencion WHERE usuario_id = ?");
    $stmt1->bind_param("s", $usuarioId);
    $stmt1->execute();
    $stmt1->close();

    // Paso B: Eliminar de la base de datos 'fila pro'
    $stmt2 = $connFilaPro->prepare("DELETE FROM usuarios WHERE Nombre_usuario = ?");
    $stmt2->bind_param("s", $usuarioId);

    if ($stmt2->execute()) {
        echo json_encode(['exito' => true, 'mensaje' => 'Estudiante eliminado con éxito.']);
    } else {
        echo json_encode(['exito' => false, 'mensaje' => 'Error SQL al eliminar: ' . $connFilaPro->error]);
    }
    $stmt2->close();
    exit();
}

$connFilaPro->close();
$connSuspencion->close();
?>