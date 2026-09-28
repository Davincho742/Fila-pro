<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Escáner</title>
    <link rel="stylesheet" href="./public/escaner.css?v=1.1">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <!-- Librería HTML5-QRCode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>

    <!-- MENÚ SUPERIOR DE NAVEGACIÓN -->
    <nav class="menu-superior">
        <div class="contenedor-menu">
            <div class="logo-proyecto">
                <span class="material-icons-round"></span>
                Fila Pro
            </div>
            <div class="navegacion-enlaces">
                <a href="punto validacion.php" class="enlace-navegacion">
                    <span class="material-icons-round"></span>
                    Inicio
                </a>
            </div>
        </div>
    </nav>

    <!-- CONTENIDO PRINCIPAL -->
    <main class="foto">
        
        <!-- BANNER LOGO CENTRADO -->
        <div class="banner">
            <img src="filapro.png" alt="Logo Fila Pro">
        </div>

        <div class="caja bienvenida">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>

        <!-- TARJETA DEL ESCÁNER DE CÁMARA -->
        <div class="contenedor-escaner">
            <h3 class="titulo-escaner">Punto de Lectura QR</h3>
            
            <!-- Contenedor donde se dibuja la cámara -->
            <div id="reader"></div>

            <!-- Icono y mensaje de respuesta -->
            <div class="icono-exito" id="icono-estado"></div>
            <p id="mensaje-estado">Apunta la cámara al código QR para registrar el almuerzo.</p>
            <p id="contador-escaneos" class="contador-registros">Registros guardados en BD: 0</p>
        </div>
    </main>

    <!-- PIE DE PÁGINA UNIFICADO (FUERA DEL MAIN) -->
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

    <!-- SCRIPT DE LECTURA DE QR -->
    <script>
        let totalEscaneos = 0;
        let procesando = false;

        localStorage.clear();

        function procesarAsistencia(idEstudiante) {
            if (!idEstudiante) {
                mostrarResultado( "ERROR: Código QR no válido.", "#ff4d4d");
                return;
            }

            if (procesando) return;
            procesando = true;

            mostrarResultado("Guardando registro en la base de datos...", "#ffaa00");

            fetch('guardar_escaneo.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    codigo_qr: idEstudiante,
                    nombre: "Estudiante Escaneado",
                    grado: "11-A"
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    totalEscaneos++;
                    mostrarResultado("✓", `¡Registrado en BD! ID: ${idEstudiante}`, "#2aff7a");
                    document.getElementById('contador-escaneos').innerText = `Registros guardados en BD: ${totalEscaneos}`;
                } else {
                    mostrarResultado(`Error BD: ${data.mensaje}`, "#ff4d4d");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                mostrarResultado("Error de conexión con el servidor", "#ff4d4d");
            })
            .finally(() => {
                setTimeout(() => {
                    procesando = false;
                }, 1000);
            });
        }

        function mostrarResultado(icono, mensaje, color) {
            const iconoElemento = document.getElementById('icono-estado');
            const mensajeElemento = document.getElementById('mensaje-estado');
            
            iconoElemento.innerText = icono;
            iconoElemento.style.color = color;
            mensajeElemento.innerText = mensaje;
        }

        function onScanSuccess(decodedText) {
            let idEstudiante = decodedText;

            try {
                if (decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
                    const url = new URL(decodedText);
                    idEstudiante = url.searchParams.get('id') || decodedText;
                }
            } catch (e) {
                console.warn("No es una URL, se usará el texto directo.");
            }

            procesarAsistencia(idEstudiante);
        }

        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { fps: 15, qrbox: { width: 220, height: 220 } },
            false
        );

        html5QrcodeScanner.render(onScanSuccess);
    </script>
</body>
</html>