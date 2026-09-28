<?php
header('Content-Type: application/json; charset=utf-8');
ini_set('display_errors', 0);
error_reporting(E_ALL);

require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Recibir datos con las claves exactas enviadas por FormData en JS
    $usuario    = trim($_POST['usuario'] ?? '');
    $contrasena = trim($_POST['contraseña'] ?? $_POST['contrasena'] ?? '');
    $rol        = 'estudiante'; // Rol asignado por defecto

    // 2. Validar que no lleguen vacíos
    if (empty($usuario) || empty($contrasena)) {
        echo json_encode(['success' => false, 'message' => 'Por favor completa todos los campos (Nombre y Contraseña).']);
        exit();
    }

    // 2.1 VALIDACIÓN DE SEGURIDAD DE CONTRASEÑA EN EL SERVIDOR (PHP)
    // Expresión Regular: Mínimo 8 caracteres, 1 mayúscula, 1 minúscula, 1 número y 1 carácter especial
    $regexPassword = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/';

    if (!preg_match($regexPassword, $contrasena)) {
        echo json_encode([
            'success' => false, 
            'message' => 'La contraseña debe incluir mínimo 8 caracteres, una mayúscula, una minúscula, un número y un carácter especial.'
        ]);
        exit();
    }

    // 3. Verificar si el usuario ya existe (usando Nombre_usuario)
    $checkSql = "SELECT Nombre_usuario FROM usuarios WHERE Nombre_usuario = ?";
    $checkStmt = $conexion->prepare($checkSql);
    
    if (!$checkStmt) {
        echo json_encode(['success' => false, 'message' => 'Error SQL en validación: ' . $conexion->error]);
        exit();
    }

    $checkStmt->bind_param("s", $usuario);
    $checkStmt->execute();
    $res = $checkStmt->get_result();

    if ($res->num_rows > 0) {
        echo json_encode(['success' => false, 'message' => "El usuario '$usuario' ya está registrado."]);
        $checkStmt->close();
        $conexion->close();
        exit();
    }
    $checkStmt->close();

    // 4. Encriptar contraseña para seguridad con BCRYPT
    $passwordHash = password_hash($contrasena, PASSWORD_BCRYPT);

    // 5. Insertar datos usando los nombres exactos de columnas de MySQL
    $sql = "INSERT INTO usuarios (Nombre_usuario, Contraseña, ROL) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $usuario, $passwordHash, $rol);

        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => '¡Registro guardado con éxito en la base de datos!'
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error al insertar registro: ' . $stmt->error]);
        }
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta SQL: ' . $conexion->error]);
    }

    $conexion->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido.']);
}
?>