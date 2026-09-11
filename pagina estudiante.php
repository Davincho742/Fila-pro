<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Estudiante</title>
    <link rel="stylesheet" href="./public/pagina_estudiantes.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
        
    <nav class="menu-superior">
        <div class="contenedor-menu">
            <div class="logo-proyecto">Fila Pro</div>
            <div class="navegacion-enlaces">
                <a href="informacion.php" class="enlace-navegacion">Información</a>
                <a href="iniciosesion.php" class="enlace-navegacion">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    
    <main class="foto">
        <!-- BANNER LOGO -->
        <div class="banner" style="text-align: center; margin: 20px 0;">
            <img src="Fila pro.jpg" alt="Logo Fila Pro" style="width: 150px !important; max-width: 150px !important; height: auto !important; display: block !important; margin: 0 auto !important; object-fit: contain !important;">
        </div>

        <div class="caja bienvenida" style="text-align: center;">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>

        <!-- TARJETA PRINCIPAL -->
        <div id="tarjeta-validacion" style="margin: 40px auto; max-width: 750px; background-color: #0D0D0D; padding: 30px; border-radius: 20px; border: 1px solid #2aff7a; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            
            <div style="text-align: center; width: 100%;">
                <p id="subtitulo-estado" style="margin-bottom: 25px; color: #2aff7a; font-size: 1.1rem; font-weight: bold;">CÓDIGO QR ACTIVO (SIN LÍMITE DE ESCANEO)</p>
                
                <div style="background: white; padding: 15px; width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                    <div id="contenedor-qr"></div>
                </div>
            </div>

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

        <footer class="mini-footer" style="text-align: center; margin-top: 30px;">
            Copyright © 2025-2026 - Todos los derechos reservados (Fila pro). 
        </footer>
    </main>

    <script>
        // ID o texto estático del estudiante para el QR
        const idEstudiante = "ESTUDIANTE-PRUEBA-123";

        window.onload = function() {
            // Elimina cualquier bloqueo almacenado en el navegador
            localStorage.clear();
            
            // Genera el QR con el ID ilimitado
            document.getElementById("contenedor-qr").innerHTML = "";
            new QRCode(document.getElementById("contenedor-qr"), {
                text: idEstudiante,
                width: 150,
                height: 150,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        };
    </script>
</body>
</html>