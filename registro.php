<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Registro</title>
    <link rel="stylesheet" href="public/registro.css?v=4">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>

    <main class="contenedor-principal">

        <!-- Formulario de Registro -->
        <form id="form-registro">
            <div class="login">
                <div class="banner">
                    <img src="Fila pro.jpg" alt="Logo Fila Pro">
                </div>

                <h2>Registro</h2>

                <!-- Campo Nombre Completo -->
                <div class="campo">
                    <input 
                        type="text" 
                        id="usuario" 
                        name="usuario" 
                        placeholder="Nombre completo" 
                        required
                    >
                </div>

                <!-- Campo Contraseña -->
                <div class="campo">
                    <input 
                        type="password" 
                        id="contraseña" 
                        name="contraseña" 
                        placeholder="Contraseña (Tarjeta de Identidad)" 
                        required
                    >
                </div>

                <!-- Selector de Rol -->
                <div class="campo">
                    <select id="rol" name="rol" required>
                        <option value="estudiante" selected>Estudiante</option>
                    </select>
                </div>

                <div class="campo">
                    <button type="submit" class="boton-ingresar" id="btn-login">Ingresar</button>
                </div>

                <div class="campo redireccion">
                    <a href="iniciosesion.php" id="btn-registro-redirect">
                        ¿Ya tienes cuenta? Inicia sesión aquí
                    </a>
                </div>
            </div>
        </form>

        <!-- SECCIÓN INFORMATIVA REDISEÑADA (MODERNA Y SIN EMOJIS) -->
        <section class="seccion-info-filapro">
            <div class="tarjeta-info">
                
                <header class="encabezado-info">
                    <span class="badge-tag">RESTAURANTE ESCOLAR</span>
                    <h3>¿Qué es Fila Pro?</h3>
                    <p class="descripcion-proyecto">
                        Un sistema inteligente diseñado para optimizar, agilizar y transformar la entrega de almuerzos en nuestra institución.
                    </p>
                </header>

                <div class="grid-beneficios">
                    
                    <div class="item-beneficio">
                        <div class="indicador-glow"></div>
                        <div class="contenido-beneficio">
                            <span class="num-beneficio">01</span>
                            <div>
                                <h5>Acceso Rápido</h5>
                                <p>Tu código QR personal sustituye las planillas manuales de forma instantánea.</p>
                            </div>
                        </div>
                    </div>

                    <div class="item-beneficio">
                        <div class="indicador-glow"></div>
                        <div class="contenido-beneficio">
                            <span class="num-beneficio">02</span>
                            <div>
                                <h5>Ahorro de Tiempo</h5>
                                <p>Filas fluidas y continuas para que aproveches al máximo tu descanso.</p>
                            </div>
                        </div>
                    </div>

                    <div class="item-beneficio">
                        <div class="indicador-glow"></div>
                        <div class="contenido-beneficio">
                            <span class="num-beneficio">03</span>
                            <div>
                                <h5>Mayor Control</h5>
                                <p>Registro individual, preciso y completamente seguro de cada ración.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </section>

    </main>

    <script>
        document.getElementById('form-registro').addEventListener('submit', async function(e) {
            e.preventDefault();

            const btn = document.getElementById('btn-login');
            btn.disabled = true;
            btn.textContent = 'Guardando...';

            const formData = new FormData(this);

            try {
                const resInserta = await fetch('insertar.php', {
                    method: 'POST',
                    body: formData
                });

                const textoRespuesta = await resInserta.text();
                let dataInserta;

                try {
                    dataInserta = JSON.parse(textoRespuesta);
                } catch (errJson) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error de Servidor',
                        text: 'Respuesta no válida del servidor.'
                    });
                    btn.disabled = false;
                    btn.textContent = 'Ingresar';
                    return;
                }

                if (dataInserta.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Registro exitoso!',
                        text: 'Tu cuenta ha sido creada. Iniciando sesión...',
                        timer: 1800,
                        showConfirmButton: false
                    });

                    // Iniciar sesión automáticamente
                    const resLogin = await fetch('login_process.php', {
                        method: 'POST',
                        body: formData
                    });

                    const textoLogin = await resLogin.text();
                    let dataLogin = JSON.parse(textoLogin);

                    if (dataLogin.success) {
                        setTimeout(() => {
                            window.location.href = dataLogin.redirect || 'pagina estudiante.php';
                        }, 1800);
                    } else {
                        window.location.href = 'iniciosesion.php';
                    }
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Atención',
                        text: dataInserta.message || 'El usuario ya existe o falta información.'
                    });
                    btn.disabled = false;
                    btn.textContent = 'Ingresar';
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error de Conexión',
                    text: 'No se pudo conectar con el servidor.'
                });
                btn.disabled = false;
                btn.textContent = 'Ingresar';
            }
        });
    </script>
</body>
</html>