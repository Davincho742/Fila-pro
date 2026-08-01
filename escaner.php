<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro</title>
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <link rel="stylesheet" href="escaner.css">
    <!-- Librería HTML5-QRCode -->
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>
<body>


    <a href="punto validacion.html" class="enlace-navegacion">
        <span class="material-icons-round"></span>
       inicio
      </a>
      <a href="iniciosesion.html" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        cerrar sesión
      </a>

    <div class="tarjeta-alerta">
        <h1>Escáner Fila Pro</h1>
        
        <!-- Contenedor de la cámara -->
        <div id="reader"></div>

        <!-- Estado / Resultado del proceso -->
        <div class="icono-exito" id="icono-estado">✓</div>
        <p id="mensaje-estado">Apunta la cámara al código QR para registrar el almuerzo.</p>
    </div>

    <script>
        // Función principal para procesar e ingresar la asistencia
        function procesarAsistencia(idEstudiante) {
            if (!idEstudiante) {
                mostrarResultado("❌", "ERROR: Código QR no válido.", "#ff4d4d");
                return;
            }

            // Formato de fecha actual (AAAA-MM-DD)
            const fechaHoy = new Date();
            const año = fechaHoy.getFullYear();
            const mes = String(fechaHoy.getMonth() + 1).padStart(2, '0');
            const dia = String(fechaHoy.getDate()).padStart(2, '0');
            const claveFechaHoy = `${año}-${mes}-${dia}`;

            // Historial desde LocalStorage
            let historial = JSON.parse(localStorage.getItem(`asistencia_${idEstudiante}`)) || [];

            // Validación de duplicados
            if (historial.includes(claveFechaHoy)) {
                mostrarResultado("⚠️", `El almuerzo ya fue reclamado hoy por el ID: ${idEstudiante}`, "#ffaa00");
            } else {
                historial.push(claveFechaHoy);
                localStorage.setItem(`asistencia_${idEstudiante}`, JSON.stringify(historial));
                mostrarResultado("✓", `Almuerzo registrado con éxito para: ${idEstudiante}`, "#2aff7a");
            }
        }

        // Modifica la interfaz según el estado
        function mostrarResultado(icono, mensaje, color) {
            const iconoElemento = document.getElementById('icono-estado');
            const mensajeElemento = document.getElementById('mensaje-estado');
            
            iconoElemento.innerText = icono;
            iconoElemento.style.color = color;
            mensajeElemento.innerText = mensaje;
        }

        // Callback cuando el escáner lee un código
        function onScanSuccess(decodedText) {
            let idEstudiante = decodedText;

            // Extraer el id en caso de que el QR sea una URL con query param (?id=)
            try {
                if (decodedText.startsWith('http://') || decodedText.startsWith('https://')) {
                    const url = new URL(decodedText);
                    idEstudiante = url.searchParams.get('id') || decodedText;
                }
            } catch (e) {
                console.warn("No se pudo parsear como URL, se usará el texto tal cual.");
            }

            // Procesar el ID leído
            procesarAsistencia(idEstudiante);
        }

        // Iniciar el lector de QR
        const html5QrcodeScanner = new Html5QrcodeScanner(
            "reader", 
            { fps: 10, qrbox: { width: 220, height: 220 } },
            /* verbose= */ false
        );

        html5QrcodeScanner.render(onScanSuccess);

        // Lógica complementaria para verificar asistencia en calendario
        function verificarAsistenciaDia(claveFechaCompleta, celdaDia, idEstudiante) {
            const historial = JSON.parse(localStorage.getItem(`asistencia_${idEstudiante}`)) || [];
            if (historial.includes(claveFechaCompleta)) {
                celdaDia.classList.add("asistio");
            }
        }
    </script>
</body>
</html>