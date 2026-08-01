<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro</title>
    <link rel="stylesheet" href="inicioseccion.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">

</head>
<body>

    <main class="foto">
        <div class="banner">
            <img src="Fila pro.jpg" alt="Logo Fila Pro">
        </div>

        <div class="welcome-box">
            <p>Por favor inicia sesión con tu cuenta correspondiente 😊🍕</p>
        </div>

        <div class="contenedor-login">
            <h1 id="titulo-dinamico">Inicie Sesión</h1>

            <form id="form-login">
            
                <div id="campos-credenciales">
                    <div class="grupo-entrada">
                        <input type="text" id="user" name="usuario" placeholder="Nombre de usuario">
                        <i class="fa-solid fa-user"></i>
                    </div>

                    <div class="grupo-entrada">
                        <input type="password" id="pass" name="contraseña" placeholder="Contraseña">
                        <i class="fa-solid fa-lock"></i>
                    </div>
                </div>

                <!-- SECTOR DE PERFIL -->
                <div class="grupo-entrada">
                    <select name="rol" id="select-rol" onchange="cambiarPerfil(this.value)" required>
                        <option value="" disabled selected>Seleccione su perfil</option>
                        <option value="estudiante">Estudiante</option>
                        <option value="profesor">Profesor</option>
                        <option value="validacion">Punto de Validación</option>
                    </select>
                </div>

                <button type="submit" class="boton-ingresar" id="btn-enviar">Ingresar</button>
            </form>

              <p style="color: #fff; font-size: 14px;">
                ¿no tienes cuenta? <a href="registro.php" style="color: #4CAF50; text-decoration: none; font-weight: bold;">Registrate aqui</a>
        </div>

      
        <div class="footer">
            <div class="info-footer">
                <h3>🔎 Dirección</h3>
                <p>Carrera 81 #43 sur 38</p>
                <p>San Antonio De Prado, Colombia</p>
            </div>

            <div class="info-footer">
                <h3>📞 Contacto</h3>
                <p>3127127266</p>
                <p>mjb@iemanueljbetancur.edu.co</p>
            </div>
        </div>

        <footer class="mini-footer">
            Copyright © 2025-2026 - Todos los derechos reservados (Fila Pro).
        </footer>
    </main>

    <script>
        const USUARIO_VALIDO = 'prueba';
        const CLAVE_VALIDA   = '1234';

        let perfilActual = '';

        // Escucha los cambios del menú desplegable de ROL
        function cambiarPerfil(perfil) {
            perfilActual = perfil;

            const titulo = document.getElementById('titulo-dinamico');
            const contenedorCampos = document.getElementById('campos-credenciales');
            const inputUser = document.getElementById('user');
            const inputPass = document.getElementById('pass');
            const btnEnviar = document.getElementById('btn-enviar');

            if (perfil === 'estudiante') {
                titulo.innerText = "Estudiante";
                contenedorCampos.style.display = "block";
                inputUser.required = true;
                inputPass.required = true;
                inputPass.placeholder = "Contraseña (Número de TI)";
                btnEnviar.innerText = "Ingresar";
            }
            else if (perfil === 'profesor') {
                titulo.innerText = "Profesor";
                contenedorCampos.style.display = "block";
                inputUser.required = true;
                inputPass.required = true;
                inputPass.placeholder = "Contraseña (Cédula)";
                btnEnviar.innerText = "Ingresar";
            }
            else if (perfil === 'validacion') {
                titulo.innerText = "Punto de Validación";
                contenedorCampos.style.display = "none";
                inputUser.required = false;
                inputPass.required = false;
                btnEnviar.innerText = "Acceder a Terminal";
            }
        }

        // VALIDACIÓN Y REDIRECCIÓN
        document.getElementById('form-login').addEventListener('submit', function(e) {
            e.preventDefault();

            if (!perfilActual) {
                alert("Por favor selecciona un perfil antes de ingresar. ☹️");
                return;
            }

            const usuarioIngresado = document.getElementById('user').value;
            const claveIngresada = document.getElementById('pass').value;

            if (perfilActual === 'estudiante') {
                if (usuarioIngresado === USUARIO_VALIDO && claveIngresada === CLAVE_VALIDA) {
                    window.location.href = "pagina estudiante.html";
                } else {
                    alert("Usuario o contraseña de Estudiante incorrectos. ☹️");
                }
            }
            else if (perfilActual === 'profesor') {
                if (usuarioIngresado === USUARIO_VALIDO && claveIngresada === CLAVE_VALIDA) {
                    window.location.href = "pagina maestro.html";
                } else {
                    alert("Usuario o contraseña de Profesor incorrectos. ☹️");
                }
            }
            else if (perfilActual === 'validacion') {
                // Terminal de escaneo: no pide usuario/clave, pasa directo
                window.location.href = "punto validacion.html";
            }
        });

        // Animación de transición suave entre páginas
        document.querySelectorAll('a[href]').forEach(function(link) {
            link.addEventListener('click', function(e) {
                var href = this.getAttribute('href');
                if (!href || href.startsWith('#') || href.startsWith('http')) return;
                e.preventDefault();
                document.body.style.transition = 'opacity 0.25s ease, transform 0.25s ease';
                document.body.style.opacity    = '0';
                document.body.style.transform  = 'translateY(-14px)';
                setTimeout(function() { window.location.href = href; }, 260);
            });
        });
    </script>
</body>
</html>