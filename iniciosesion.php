<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Inicio de Sesión</title>
    <link rel="stylesheet" href="./PUBLIC/iniciosesion.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
</head>
<body>

    <main class="foto">

        <form id="form-login">
            <div class="login">
                <!-- Logo integrado dentro del bloque de inicio de sesión -->
                <div class="banner">
                    <img src="Fila pro.jpg" alt="Logo Fila Pro">
                </div>

                <h2>Inicio de sesión</h2>

                <div class="campo">
                    <select id="select-rol" required>
                        <option value="" disabled selected>Seleccione su perfil</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                        <option value="validacion">Punto de Validación</option>
                    </select>
                </div>

                <div class="campo" id="campo-usuario">
                    <input type="text" id="usuario" placeholder="Usuario" required>
                </div>

                <div class="campo" id="campo-contraseña">
                    <input type="password" id="contraseña" placeholder="Documento de Identidad" required>
                </div>

                <div class="campo">
                    <button type="submit" class="boton-ingresar" id="btn-enviar">Ingresar</button>
                </div>
                
                <div class="campo" style="margin-top: 15px; text-align: center;">
                    <a href="registro.php" class="enlace-animado" style="color: #fff; text-decoration: underline; font-size: 0.9em;">
                        ¿No tienes cuenta? Regístrate aquí
                    </a>
                </div>
            </div>
        </form>

    
    </main>

    <script>
      const selectRol = document.getElementById('select-rol');
      const inputUsuario = document.getElementById('usuario');
      const inputContrasena = document.getElementById('contraseña');
      const campoUsuario = document.getElementById('campo-usuario');
      const campoContrasena = document.getElementById('campo-contraseña');

      // Detectar cambio de perfil para quitar o requerir los campos de texto
      selectRol.addEventListener('change', function () {
          if (this.value === 'validacion') {
              // Ocultar campos y quitar obligatoriedad
              campoUsuario.style.display = 'none';
              campoContrasena.style.display = 'none';
              inputUsuario.removeAttribute('required');
              inputContrasena.removeAttribute('required');
          } else {
              // Mostrar campos y hacerlos obligatorios
              campoUsuario.style.display = 'block';
              campoContrasena.style.display = 'block';
              inputUsuario.setAttribute('required', 'required');
              inputContrasena.setAttribute('required', 'required');
          }
      });

      document.getElementById('form-login').addEventListener('submit', function (e) {
        e.preventDefault();

        const rol = selectRol.value;

        if (!rol) {
            alert('Por favor selecciona un perfil antes de continuar.');
            return;
        }

        // Si es Punto de Validación, entra directo sin pedir datos
        if (rol === 'validacion') {
            window.location.href = 'punto validacion.php';
            return;
        }

        // Si es Profesor, entra directo
        if (rol === 'profesor') {
            window.location.href = 'profesor.php';
            return;
        }

        const usuario = inputUsuario.value.trim();
        const contraseña = inputContrasena.value.trim();

        const datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('contraseña', contraseña);
        datos.append('rol', rol);

        fetch('login_process.php', {
            method: 'POST',
            body: datos
        })
        .then(async res => {
            const texto = await res.text();
            if (!texto.trim()) {
                throw new Error('El archivo login_process.php devolvió una respuesta totalmente vacía. Revisa que el archivo exista en la misma carpeta.');
            }
            try {
                return JSON.parse(texto);
            } catch (e) {
                throw new Error('Respuesta del servidor no válida: ' + texto.substring(0, 150));
            }
        })
        .then(data => {
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                alert(data.message);
            }
        })
        .catch(err => {
            alert(err.message);
        });
    });
    </script>
</body>
</html>