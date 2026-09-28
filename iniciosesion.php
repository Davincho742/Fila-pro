<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Inicio de Sesión</title>
    <link rel="stylesheet" href="./PUBLIC/iniciosesion.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <main class="foto">

        <form id="form-login">
            <div class="login">
                <!-- Banner / Logo -->
                <div class="banner">
                    <img src="filapro.png" alt="Logo Fila Pro">
                </div>

                <h2>Inicio de sesión</h2>

                <!-- Selector simplificado: Solo para alternar a Punto de Validación si es necesario -->
                <div class="campo">
                    <select id="select-modo">
                        <option value="usuario" selected>/ Docente / Estudiante</option>
                        <option value="validacion">Punto de Validación</option>
                    </select>
                </div>

                <!-- Campos normales de Ingreso -->
                <div class="campo" id="campo-usuario">
                    <input type="text" id="usuario" placeholder="Usuario" required>
                </div>

                <div class="campo" id="campo-contraseña">
                    <input type="password" id="contraseña" placeholder="Documento de Identidad" required>
                </div>

                <!-- Botón de Envío -->
                <div class="campo">
                    <button type="submit" class="boton-ingresar" id="btn-enviar">Ingresar</button>
                </div>
                
                <!-- Enlace de Registro -->
                <div class="campo" id="campo-registro" style="margin-top: 5px; text-align: center;">
                    <a href="registro.php" class="enlace-animado" style="color: #fff; text-decoration: underline; font-size: 0.9em;">
                        ¿No tienes cuenta? Regístrate aquí
                    </a>
                </div>
            </div>
        </form>

    </main>

    
<script>
      // Funcionalidad para ver/ocultar contraseña
      const togglePassword = document.getElementById('togglePassword');
      const eyeIcon = document.getElementById('eyeIcon');
      const inputContrasena = document.getElementById('contraseña');

      if (togglePassword && inputContrasena && eyeIcon) {
          togglePassword.addEventListener('click', function () {
              const isPassword = inputContrasena.getAttribute('type') === 'password';
              inputContrasena.setAttribute('type', isPassword ? 'text' : 'password');
              eyeIcon.classList.toggle('fa-eye');
              eyeIcon.classList.toggle('fa-eye-slash');
          });
      }

      const selectModo = document.getElementById('select-modo');
      const inputUsuario = document.getElementById('usuario');
      const campoUsuario = document.getElementById('campo-usuario');
      const campoContrasena = document.getElementById('campo-contraseña');
      const campoRegistro = document.getElementById('campo-registro');

      const SwalEstilo = Swal.mixin({
          background: '#121212',
          color: '#ffffff',
          confirmButtonColor: '#2aff7a',
          customClass: {
              popup: 'alerta-filapro',
              confirmButton: 'btn-alerta-confirmar'
          }
      });

      // Alternar vista si selecciona Punto de Validación
      selectModo.addEventListener('change', function () {
          if (this.value === 'validacion') {
              campoUsuario.style.display = 'none';
              campoContrasena.style.display = 'none';
              campoRegistro.style.display = 'none';
              inputUsuario.removeAttribute('required');
              inputContrasena.removeAttribute('required');
          } else {
              campoUsuario.style.display = 'block';
              campoContrasena.style.display = 'block';
              campoRegistro.style.display = 'block';
              inputUsuario.setAttribute('required', 'required');
              inputContrasena.setAttribute('required', 'required');
          }
      });

      document.getElementById('form-login').addEventListener('submit', function (e) {
        e.preventDefault();

        // Si es Punto de Validación, entra directamente
        if (selectModo.value === 'validacion') {
            window.location.href = 'punto validacion.php';
            return;
        }

        const usuario = inputUsuario.value.trim();
        const contraseña = inputContrasena.value.trim();

        const datos = new FormData();
        datos.append('usuario', usuario);
        datos.append('contraseña', contraseña);

        fetch('login_process.php', {
            method: 'POST',
            body: datos
        })
        .then(async res => {
            const texto = await res.text();
            if (!texto.trim()) {
                throw new Error('El servidor devolvió una respuesta vacía.');
            }
            try {
                return JSON.parse(texto);
            } catch (e) {
                throw new Error('Respuesta del servidor no válida.');
            }
        })
        .then(data => {
            if (data.success) {
                SwalEstilo.fire({
                    icon: 'success',
                    title: '¡Bienvenido!',
                    text: 'Inicio de sesión exitoso. Redirigiendo...',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    // La base de datos determina a dónde redirigir (profesor o estudiante)
                    window.location.href = data.redirect;
                });
            } else {
                SwalEstilo.fire({
                    icon: 'error',
                    title: 'Acceso Denegado',
                    text: data.message || 'Usuario o contraseña incorrectos.'
                });
            }
        })
        .catch(err => {
            SwalEstilo.fire({
                icon: 'error',
                title: 'Error de Conexión',
                text: err.message
            });
        });
    });
</script>       
   
</body>
</html>