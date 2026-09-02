<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $usuario = trim($_POST['usuario'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $rol = trim($_POST['rol'] ?? '');

    if (empty($usuario) || empty($password) || empty($rol)) {
        echo "<script>
            alert('Por favor completa todos los campos.');
            window.location.href = 'registro.php';
        </script>";
        exit();
    }

    $passwordHash = password_hash($password, PASSWORD_BCRYPT);

    $checkSql = "SELECT nombre_usuario FROM usuarios WHERE nombre_usuario = ?";
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
    $checkStmt->close();

    $sql = "INSERT INTO usuarios (nombre_usuario, contraseña, rol) VALUES (?, ?, ?)";
    $stmt = $conexion->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("sss", $usuario, $passwordHash, $rol);

        if ($stmt->execute()) {
            if ($rol === "estudiante") {
                $destino = "perfil_estudiante.php";
            } else {
                $destino = "iniciosesion.php";
            }

            echo "<script>
                alert('¡Registro exitoso! Ya puedes iniciar sesión.');
                window.location.href = '$destino';
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