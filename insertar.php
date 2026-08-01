<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['contraseña'] ?? '');
    $rol = $_POST['rol'] ?? '';

    if (empty($usuario) || empty($password) || empty($rol)) {
        echo "<script>
                alert('Por favor completa todos los campos.');
                window.location.href = 'registro.php';
              </script>";
        exit();
    }

    // 1. Verificamos usando el nombre exacto de la columna en tu BD (ejemplo: usuario)
    $checkSql = "SELECT usuario FROM usuarios WHERE usuario = ?";
    $checkStmt = $conexion->prepare($checkSql);
    $checkStmt->bind_param("s", $usuario);
    $checkStmt->execute();
    $res = $checkStmt->get_result();

    if ($res->num_rows > 0) {
        echo "<script>
                alert('El nombre de usuario \"$usuario\" ya está registrado. Intenta con otro.');
                window.location.href = 'registro.php';
              </script>";
        exit();
    }

    // 2. Insertamos asegurándote de que los nombres de las columnas coincidan con HeidiSQL
    $sql = "INSERT INTO usuarios (usuario, contraseña, rol) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $usuario, $password, $rol);

        if ($stmt->execute()) {
            echo "<script>
                    alert('¡Registro exitoso! Ya puedes iniciar sesión.');
                    window.location.href = 'iniciesesion.php';
                  </script>";
        } else {
            echo "Error al guardar en la base de datos: " . $conexion->error;
        }
        $stmt->close();
    } else {
        echo "Error en la consulta SQL: " . $conexion->error;
    }

    $conexion->close();
}
?>