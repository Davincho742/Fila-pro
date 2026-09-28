<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Registro</title>
    <link rel="stylesheet" href="public/registro.css?v=4">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <!-- FontAwesome CDN para el icono del ojo (NUEVO) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Estilos añadidos para posicionar el icono del ojo (NUEVO) -->
    <style>
        .campo-password {
            position: relative;
            display: flex;
            align-items: center;
        }

        .campo-password input {
            width: 100%;
            padding-right: 45px;
        }

        .btn-toggle-password {
            position: absolute;
            right: 12px;
            background: transparent;
            border: none;
            color: #888888;
            cursor: pointer;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 5px;
            outline: none;
            transition: color 0.3s ease;
        }

        .btn-toggle-password:hover {
            color: #28a745;
        }
    </style>
</head>
<body>

    <main class="contenedor-principal">

        <!-- Formulario de Registro -->
        <form id="form-registro">
            <div class="login">
                <div class="banner">
                    <img src="filapro.png" alt="Logo filaPro">
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
                <div class="campo campo-password">
                    <input 
                        type="password" 
                        id="contraseña" 
                        name="contraseña" 
                        placeholder="Contraseña" 
                        required
                    >
                    <!-- Botón del ojo añadido (NUEVO) -->
                    <button type="button" id="togglePassword" class="btn-toggle-password" aria-label="Mostrar u ocultar contraseña">
                        <i class="fa-solid fa-eye" id="eyeIcon"></i>
                    </button>
                </div>

                <!-- Selector de Rol -->
                <div class="campo">
                    
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
    // 1. Lógica para alternar ver/ocultar contraseña con el botón del ojo
    const togglePassword = document.getElementById('togglePassword');
    const passwordInputEl = document.getElementById('contraseña');
    const eyeIcon = document.getElementById('eyeIcon');

    if (togglePassword && passwordInputEl && eyeIcon) {
        togglePassword.addEventListener('click', function () {
            const isPassword = passwordInputEl.getAttribute('type') === 'password';
            passwordInputEl.setAttribute('type', isPassword ? 'text' : 'password');
            eyeIcon.classList.toggle('fa-eye');
            eyeIcon.classList.toggle('fa-eye-slash');
        });
    }

    // 2. Lógica de registro y redirección directa
    document.getElementById('form-registro').addEventListener('submit', async function(e) {
        e.preventDefault();

        // Validación de contraseña
        const passwordInput = document.getElementById('contraseña').value;
        const regexPassword = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

        if (!regexPassword.test(passwordInput)) {
            Swal.fire({
                icon: 'warning',
                iconColor: '#28a745',
                title: 'Contraseña no segura',
                html: `La contraseña debe cumplir con los siguientes requisitos:
                       <ul style="text-align: left; font-size: 0.9rem; margin-top: 10px; color: #ffffff;">
                           <li>Al menos 8 caracteres</li>
                           <li>Al menos una letra mayúscula</li>
                           <li>Al menos una letra minúscula</li>
                           <li>Al menos un número</li>
                           <li>Al menos un carácter especial (!@#$%^&*, etc.)</li>
                       </ul>`,
                background: '#121212',
                color: '#ffffff',
                confirmButtonColor: '#28a745',
                customClass: {
                    popup: 'alerta-negra-verde'
                }
            });
            return;
        }

        const btn = document.getElementById('btn-login');
        btn.disabled = true;
        btn.textContent = 'Ingresando...';

        const formData = new FormData(this);

        try {
            // Petición de registro
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
                    iconColor: '#28a745',
                    title: 'Error de Servidor',
                    text: 'Respuesta no válida del servidor.',
                    background: '#121212',
                    color: '#ffffff',
                    confirmButtonColor: '#28a745'
                });
                btn.disabled = false;
                btn.textContent = 'Ingresar';
                return;
            }

            if (dataInserta.success) {
                // Iniciar sesión en segundo plano
                const resLogin = await fetch('login_process.php', {
                    method: 'POST',
                    body: formData
                });

                const textoLogin = await resLogin.text();
                let dataLogin = {};

                try {
                    dataLogin = JSON.parse(textoLogin);
                } catch (e) {}

                // Redirección directa (d1) a la página del estudiante
                window.location.href = dataLogin.redirect || dataInserta.redirect || 'pagina estudiante.php';

            } else {
                Swal.fire({
                    icon: 'warning',
                    iconColor: '#28a745',
                    title: 'Atención',
                    text: dataInserta.message || 'El usuario ya existe o falta información.',
                    background: '#121212',
                    color: '#ffffff',
                    confirmButtonColor: '#28a745'
                });
                btn.disabled = false;
                btn.textContent = 'Ingresar';
            }
        } catch (error) {
            Swal.fire({
                icon: 'error',
                iconColor: '#28a745',
                title: 'Error de Conexión',
                text: 'No se pudo conectar con el servidor.',
                background: '#121212',
                color: '#ffffff',
                confirmButtonColor: '#28a745'
            });
            btn.disabled = false;
            btn.textContent = 'Ingresar';
        }
    });
</script>
 
</body>
</html>