<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro</title>
    <link rel="stylesheet" href="./public/iniciosesion.css">
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

        <form id="form-login">
            <div class="ring">
                <i style="--clr:#006603;"></i>
                <i style="--clr:#9F00E0;"></i>
                <i style="--clr:#C0FF2B;"></i>

                <div class="login">
                    <h2>Iniciar Sesión</h2>

                    <div class="inputBx">
                        <select id="select-rol" onchange="cambiarPerfil(this.value)" required>
                            <option value="" disabled selected>Seleccione su perfil</option>
                            <option value="estudiante">Estudiante</option>
                            <option value="validacion">Punto de Validación</option>
                        </select>
                    </div>

                    <div class="inputBx" id="campo-usuario">
                        <input type="text" id="usuario" placeholder="Usuario" required>
                    </div>

                    <div class="inputBx" id="campo-contraseña">
                        <input type="password" id="contraseña" placeholder="Contraseña" required>
                    </div>

                    <div class="inputBx">
                        <button type="submit" class="boton-ingresar" id="btn-enviar">Ingresar</button>
                    </div>
                </div>
            </div>
        </form>

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
        // Muestra u oculta usuario/contraseña según el perfil elegido
        function cambiarPerfil(perfil) {
            const campoUsuario = document.getElementById('campo-usuario');
            const campoContraseña = document.getElementById('campo-contraseña');
            const inputUsuario = document.getElementById('usuario');
            const inputContraseña = document.getElementById('contraseña');
            const btnEnviar = document.getElementById('btn-enviar');

            if (perfil === 'validacion') {
                campoUsuario.style.display = 'none';
                campoContraseña.style.display = 'none';
                inputUsuario.required = false;
                inputContraseña.required = false;
                btnEnviar.innerText = 'Acceder a Terminal';
            } else {
                campoUsuario.style.display = 'block';
                campoContraseña.style.display = 'block';
                inputUsuario.required = true;
                inputContraseña.required = true;
                btnEnviar.innerText = 'Ingresar';
            }
        }

        document.getElementById('form-login').addEventListener('submit', function (e) {
            e.preventDefault();

            const rol = document.getElementById('select-rol').value;

            if (!rol) {
                alert('Por favor selecciona un perfil antes de continuar.');
                return;
            }

            // Punto de Validación: acceso directo, sin usuario/contraseña ni consulta a la BD
            if (rol === 'validacion') {
                window.location.href = 'punto validacion.php';
                return;
            }

            // Estudiante: valida contra la base de datos
            const usuario = document.getElementById('usuario').value.trim();
            const contraseña = document.getElementById('contraseña').value.trim();

            const datos = new FormData();
            datos.append('usuario', usuario);
            datos.append('contraseña', contraseña);
            datos.append('rol', rol);

            fetch('login_process.php', {
                method: 'POST',
                body: datos
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    window.location.href = data.redirect;
                } else {
                    alert(data.message);
                }
            })
            .catch(err => {
                console.error(err);
                alert('Ocurrió un error al conectar con el servidor.');
            });
        });

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