<?php
ini_set('display_errors', 0);
error_reporting(E_ALL);

header('Content-Type: application/json; charset=utf-8');

register_shutdown_function(function() {
    $error = error_get_last();
    if ($error !== NULL && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        echo json_encode([
            'success' => false,
            'message' => 'Error de PHP: ' . $error['message']
        ]);
    }
});

if (!file_exists('conexion.php')) {
    echo json_encode(['success' => false, 'message' => 'El archivo conexion.php no existe.']);
    exit();
}

require_once 'conexion.php';

if (!isset($conexion) || $conexion->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error al conectar a la Base de Datos.']);
    exit();
}

session_start();

$usuario  = trim($_POST['usuario'] ?? '');
$password = trim($_POST['contraseña'] ?? $_POST['contrasena'] ?? '');

if (empty($usuario) || empty($password)) {
    echo json_encode(['success' => false, 'message' => 'Por favor ingresa usuario y contraseña.']);
    exit();
}

// Consultar usuario en MySQL (Base de Datos: fila pro)
$sql = "SELECT Nombre_usuario, Contraseña, ROL FROM usuarios WHERE Nombre_usuario = ?";
$stmt = $conexion->prepare($sql);

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error SQL: ' . $conexion->error]);
    exit();
}

$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $clave_db = $row['Contraseña'];
    $rol_db = strtolower(trim($row['ROL'] ?? 'estudiante'));

    // Validar contraseña
    if (password_verify($password, $clave_db) || $password === $clave_db) {

        // ====================== VERIFICACIÓN DE SUSPENSIÓN ======================
        $conexion_suspencion = new mysqli("localhost", "root", "", "suspencion");

        if (!$conexion_suspencion->connect_error) {
            $sql_susp = "SELECT id FROM suspencion WHERE usuario_id = ? AND estado = 'suspendido' LIMIT 1";
            $stmt_susp = $conexion_suspencion->prepare($sql_susp);

            if ($stmt_susp) {
                $stmt_susp->bind_param("s", $row['Nombre_usuario']);
                $stmt_susp->execute();
                $res_susp = $stmt_susp->get_result();

                if ($res_susp->num_rows > 0) {
                    echo json_encode([
                        'success' => false,
                        'message' => '❌ Tu cuenta ha sido suspendida. No puedes ingresar al sistema.'
                    ]);
                    $stmt_susp->close();
                    $conexion_suspencion->close();
                    exit();
                }
                $stmt_susp->close();
            }
            $conexion_suspencion->close();
        }
        // =======================================================================

        // Guardar sesión
        $_SESSION['usuario']        = $row['Nombre_usuario'];
        $_SESSION['nombre_usuario'] = $row['Nombre_usuario'];
        $_SESSION['ROL']            = $rol_db;
        $_SESSION['rol']            = $rol_db;

        // Determinar destino según el rol
        $destino = 'pagina estudiante.php';

        if ($rol_db === 'profesor' || $rol_db === 'docente') {
            $destino = 'profesor.php';
        } elseif ($rol_db === 'admin' || $rol_db === 'validacion') {
            $destino = 'punto validacion.php';
        }

        echo json_encode([
            'success'  => true,
            'message'  => '¡Inicio de sesión exitoso!',
            'redirect' => $destino
        ]);
        exit();

    } else {
        echo json_encode(['success' => false, 'message' => 'La contraseña ingresada es incorrecta.']);
        exit();
    }
} else {
    echo json_encode(['success' => false, 'message' => "El usuario '$usuario' no existe en el sistema."]);
    exit();
}

$stmt->close();
$conexion->close();
?>