<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Fila Pro</title>
    <link rel="stylesheet" href="inicioseccion.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
</head>
<body>

    <main class="foto">
        <div class="banner" style="margin-top: 15px;">
            <img src="Fila pro.jpg">
        </div>

        <div class="welcome-box">
            <p>Crea tu cuenta para acceder a Fila Pro 🍕</p>
        </div>
        <br>

        <div class="contenedor-login">
            <h1>Crear Cuenta</h1>

            <form action="insertar.php" method="POST">
            
                <div class="grupo-entrada">
                    <label style="display: block; text-align: left; margin-bottom: 8px; font-weight: bold; font-size: 14px; color: #fff;">NOMBRE DE USUARIO</label>
                    <input type="text" name="usuario" placeholder="Crea tu usuario" required>
                </div>

                <div class="grupo-entrada">
                    <label style="display: block; text-align: left; margin-bottom: 8px; font-weight: bold; font-size: 14px; color: #fff;">CONTRASEÑA</label>
                    <input type="password" name="contraseña" placeholder="Crea tu contraseña" required>
                </div>

                <div class="grupo-entrada">
                    <label style="display: block; text-align: left; margin-bottom: 8px; font-weight: bold; font-size: 14px; color: #fff;">ROL</label>
                    <select name="rol" required style="width: 100%; padding: 12px; background-color: #1e1e1e; color: white; border: 1px solid #333; border-radius: 6px; font-size: 16px; cursor: pointer;">
                        <option value="" disabled selected>Seleccione su perfil</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                    </select>
                </div>

                <button type="submit" class="boton-ingresar" style="margin-top: 15px;">Registrarse</button>
            </form>

            <br>
            <p style="color: #fff; font-size: 14px;">
                ¿Ya tienes cuenta? <a href="iniciosesion.php" style="color: #4CAF50; text-decoration: none; font-weight: bold;">Inicia sesión aquí</a>
            </p>
        </div>
    </main>

</body>
</html>