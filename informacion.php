<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Información</title>
    <!-- Vinculación directa al CSS -->
    <link rel="stylesheet" href="./public/informacion.css?v=1.1">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
</head>
<body>
        
    <!-- 1. MENÚ SUPERIOR (CERRADO Y AISLADO) -->
    <nav class="menu-superior">
        <div class="contenedor-menu">
            <div class="logo-proyecto">
                Fila Pro
            </div>
            <div class="navegacion-enlaces">
                <a href="pagina estudiante.php" class="enlace-navegacion">Inicio</a>
                <a href="iniciosesion.php" class="enlace-navegacion">Cerrar sesión</a>
            </div>
        </div>
    </nav>

    <!-- 2. CONTENIDO PRINCIPAL (ÚNICAMENTE EL CUERPO DE LA PÁGINA) -->
    <main class="foto">
        <div class="banner" style="text-align: center; margin: 20px 0;">
            <img src="filapro.png" alt="Logo Fila Pro" style="width: 150px; height: auto; display: block; margin: 0 auto; object-fit: contain;">
        </div>

        <div class="estado" style="text-align: center;">
            <p>Acá podrás ver si tu cupo se ha suspendido o todavía sigue vigente.</p>
        </div>

        <div class="estado" id="contenedor-estado-dinamico" style="text-align: center;">
            <p>Cargando estado...</p>
        </div>

        <div class="caja bienvenida" style="text-align: center;">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>
    </main>

    <!-- 3. PIE DE PÁGINA (COMPLETAMENTE INDEPENDIENTE Y FUERA DEL MAIN) -->
    <footer class="footer-global">
        <div class="contenido-footer">
            <div class="info-footer">
                <h3>Dirección</h3>
                <p>Carrera 81 #43 sur 38</p>
                <p>San Antonio De Prado, Colombia</p>
            </div>
            <div class="info-footer">
                <h3>Contacto</h3>
                <p>3127127266</p>
                <p>mjb@iemanueljbetancur.edu.co</p>
            </div>
        </div>

        <div class="linea-divisora"></div>

        <div class="mini-footer">
            Copyright © 2025-2026 - Todos los derechos reservados (Fila pro). 
        </div>
    </footer>

    <!-- SCRIPTS -->
    <script>
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

        function verificarEstadoEstudiante() {
            const contenedor = document.getElementById("contenedor-estado-dinamico");
            const estadoSimulado = "vigente"; 

            if (estadoSimulado === "vigente") {
                contenedor.innerHTML = `
                    <div class="estado-box estado-vigente">
                        CUPO VIGENTE / ACTIVO 
                        <p style="font-size: 0.9rem; font-weight: normal; margin-top: 5px; color: #155724;">Tu cupo se encuentra al día. Recuerda registrar tu asistencia.</p>
                    </div>
                `;
            } 
            else if (estadoSimulado === "suspendido") {
                contenedor.innerHTML = `
                    <div class="estado-box estado-suspendido">
                        CUPO SUSPENDIDO TEMPORALMENTE 
                        <p style="font-size: 0.9rem; font-weight: normal; margin-top: 5px; color: #856404;">Acumulaste fallas sin justificación. Acércate a coordinación para reactivarlo.</p>
                    </div>
                `;
            } 
            else if (estadoSimulado === "no-agregado") {
                contenedor.innerHTML = `
                    <div class="estado-box estado-no-agregado">
                        NO AGREGADO A LA LISTA 
                        <p style="font-size: 0.9rem; font-weight: normal; margin-top: 5px; color: #721c24;">No estás en la lista oficial. Dirígete con el encargado para tu inscripción.</p>
                    </div>
                `;
            }
        }

        verificarEstadoEstudiante();
    </script>
</body>
</html>