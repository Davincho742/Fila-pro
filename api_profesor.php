<?php
// Habilitar visualización de errores para diagnóstico
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);

try {
    if (!file_exists('conexion2.php')) {
        throw new Exception("El archivo conexion2.php no existe.");
    }
    require_once 'conexion2.php';

    $accion = $_GET['accion'] ?? '';

    if ($accion === 'buscar') {
        $q = trim($_GET['q'] ?? '');

        if (empty($q)) {
            echo json_encode(['exito' => false, 'mensaje' => 'Ingresa un parámetro de búsqueda.']);
            exit();
        }

        $paramBusqueda = "%" . $q . "%";

        // Consulta adaptada: Busca en la tabla 'usuarios' donde el ROL sea estudiante
        $sql = "SELECT * FROM usuarios WHERE (Nombre_usuario LIKE ? OR Contraseña = ?) AND LOWER(ROL) = 'estudiante' LIMIT 1";
        
        $stmt = $conexion->prepare($sql);
        if (!$stmt) {
            // Si falla prepare, intentamos una búsqueda más directa por si 'ROL' o 'Contraseña' cambian de nombre
            $sqlFailsafe = "SELECT * FROM usuarios WHERE Nombre_usuario LIKE ? LIMIT 1";
            $stmt = $conexion->prepare($sqlFailsafe);
            if (!$stmt) {
                throw new Exception("Error en la consulta SQL: " . $conexion->error);
            }
            $stmt->bind_param("s", $paramBusqueda);
        } else {
            $stmt->bind_param("ss", $paramBusqueda, $q);
        }

        $stmt->execute();
        $res = $stmt->get_result();

        if ($row = $res->fetch_assoc()) {
            // Normalizar nombres de llaves para JavaScript
            $estudiante = [
                'id' => $row['id'] ?? $row['ID'] ?? 0,
                'usuario' => $row['Nombre_usuario'] ?? $row['usuario'] ?? $row['nombre'] ?? 'Sin Nombre',
                'grado' => $row['grado'] ?? $row['Grado'] ?? 'N/A',
                'estado' => $row['estado'] ?? 'activo',
                'diasReclamados' => []
            ];

            echo json_encode(['exito' => true, 'estudiante' => $estudiante]);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'No se encontró ningún estudiante registrado con esa información.']);
        }
        exit();
    }

    if ($accion === 'cambiar_estado') {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? '';
        $nuevoEstado = $input['nuevo_estado'] ?? 'activo';

        $sql = "UPDATE usuarios SET estado = ? WHERE id = ? OR Nombre_usuario = ?";
        $stmt = $conexion->prepare($sql);
        
        if ($stmt) {
            $stmt->bind_param("sss", $nuevoEstado, $id, $id);
            $stmt->execute();
            echo json_encode(['exito' => true, 'nuevo_estado' => $nuevoEstado]);
        } else {
            echo json_encode(['exito' => false, 'mensaje' => 'No se pudo actualizar la tabla usuarios.']);
        }
        exit();
    }

    echo json_encode(['exito' => false, 'mensaje' => 'Acción no válida']);

} catch (Throwable $e) {
    // Retorna el error exacto en formato JSON para no romper el JS
    http_response_code(200); 
    echo json_encode([
        'exito' => false, 
        'mensaje' => 'Error interno en el servidor: ' . $e->getMessage()
    ]);
}
?>