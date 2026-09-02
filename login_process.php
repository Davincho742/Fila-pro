<?php
include 'conexion.php';

error_reporting(0);
ini_set('display_errors', 0);

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['contraseña'] ?? '');
    $rol_seleccionado = trim($_POST['rol'] ?? '');

    if (empty($usuario) || empty($password) || empty($rol_seleccionado)) {
        echo json_encode([
            'success' => false,
            'message' => 'Por favor completa todos los campos del formulario.'
        ]);
        exit();
    }

    $sql = "SELECT contraseña, rol FROM usuarios WHERE nombre_usuario = ?";

    $stmt = $conexion->prepare($sql);

    if (!$stmt) {
        echo json_encode([
            'success' => false,
            'message' => 'Error en la estructura SQL: ' . $conexion->error
        ]);
        exit();
    }

    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $clave_db = $row['contraseña'];
        $rol_db = $row['rol'];

        if (password_verify($password, $clave_db) || $password === $clave_db) {

            if (mb_strtolower(trim($rol_db)) === mb_strtolower($rol_seleccionado)) {

                echo json_encode([
                    'success' => true,
                    'redirect' => "pagina estudiante.php"
                ]);
                exit();

            } else {
                echo json_encode([
                    'success' => false,
                    'message' => "El usuario '$usuario' existe, pero en la BD tiene el rol '$rol_db' y seleccionaste '$rol_seleccionado'."
                ]);
                exit();
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => "La contraseña ingresada para '$usuario' es incorrecta."
            ]);
            exit();
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => "El usuario '$usuario' no existe en la columna 'nombre_usuario' de HeidiSQL."
        ]);
        exit();
    }

    $stmt->close();
    $conexion->close();
}
?>