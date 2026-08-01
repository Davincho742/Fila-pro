<?php
include 'conexion.php';

// Desactivamos errores en formato HTML para mantener la respuesta JSON limpia
error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = $_POST['usuario'] ?? '';
    $password = $_POST['contraseña'] ?? '';
    $rol_seleccionado = $_POST['rol'] ?? '';

    // Consultamos la contraseña Y el ROL de la base de datos
    $sql = "SELECT Contraseña, ROL FROM usuarios WHERE Nombre_usuario = ?";
    
    $stmt = $conexion->prepare($sql);
    
    if (!$stmt) {
        echo json_encode([
            'success' => false, 
            'message' => 'Error en la consulta a la base de datos.'
        ]);
        exit();
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // 1. Verificamos si existe el usuario en HeidiSQL
    if ($row = $result->fetch_assoc()) {
        $clave_db = $row['Contraseña'];
        $rol_db = $row['ROL']; // Obtiene "estudiante" o "profesor" de la tabla

        // 2. Verificamos la contraseña
        if (password_verify($password, $clave_db) || $password === $clave_db) {
            
            // 3. VALIDACIÓN DE ROL: Comparamos el ROL de la base de datos con el del formulario
            if (mb_strtolower($rol_db) === mb_strtolower($rol_seleccionado)) {
                
                // Si todo coincide, redirige a la página que corresponde
                $redirect = ($rol_seleccionado === 'estudiante') ? "pagina estudiante.php" : "pagina maestro.php";
                
                echo json_encode([
                    'success' => true,
                    'redirect' => $redirect
                ]);
                exit();
                
            } else {
                // Si la clave es correcta pero el rol no coincide
                echo json_encode([
                    'success' => false,
                    'message' => "El usuario '$usuario' no tiene permisos para ingresar como $rol_seleccionado. ☹️"
                ]);
                exit();
            }
        }
    }

    // Si el usuario no existe o la contraseña está mal
    $mensajeError = ($rol_seleccionado === 'estudiante') 
        ? "Usuario o contraseña de Estudiante incorrectos. ☹️" 
        : "Usuario o contraseña de Profesor incorrectos. ☹️";

    echo json_encode([
        'success' => false,
        'message' => $mensajeError
    ]);
    exit();
}
?>