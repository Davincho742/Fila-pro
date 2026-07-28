<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro</title>
    <link rel="stylesheet" href="pagina estudinates.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/qrcodejs/1.0.0/qrcode.min.js"></script>
</head>
<body>
        
   <nav class="menu-superior">
  <div class="contenedor-menu">

    <div class="logo-proyecto">
      <span class="material-icons-round"></span>
      Fila Pro
    </div>

    <div class="navegacion-enlaces">
      <a href="asistencia.html" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        Asistencia
      </a>
      <a href="informacion.html" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        Información
      </a>
      <a href="iniciosesion.html" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        cerrar sesión
      </a>
    </div>
  </div>
</nav>
    

    <main class="foto">
        <div class="banner">
            <img src="Fila pro.jpg" alt="Logo Fila Pro">
        </div>

        <div class="caja bienvenida" style="text-align: center;">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>

        <div id="tarjeta-validacion" style="margin: 40px auto; max-width: 750px; background-color: #0D0D0D; padding: 30px; border-radius: 20px; border: 1px solid #2aff7a; display: flex; flex-wrap: wrap; gap: 30px; justify-content: center; align-items: center;">
        
                <p id="subtitulo-estado" style="margin-bottom: 25px; color: #aaa; font-size: 0.95rem;">Presenta este código QR para reclamar tu almuerzo</p>
                
                <div style="background: white; padding: 15px; width: 180px; height: 180px; margin: 0 auto; border-radius: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.5);">
                    <div id="contenedor-qr"></div>
                </div>
            </div>

            <div id="bloque-bloqueado" style="flex: 1; min-width: 250px; text-align: center; display: none; border-left: 1px solid #333; padding-left: 20px;">
                <span style="font-size: 45px;">❌</span>
                <h2 style="color: #ff4a4a; margin-top: 5px; margin-bottom: 10px;">¡Ya reclamaste!</h2>
                <p style="color: #aaa; font-size: 0.9rem; margin-bottom: 20px;">Tu código se encuentra inactivo. Podrás volver a reclamar en:</p>
                
                <div id="contador-reloj" style="font-family: monospace; font-size: 2rem; font-weight: bold; color: #ff4a4a; background: #1a1a1a; padding: 15px; border-radius: 10px; border: 1px solid #ff4a4a; display: inline-block; letter-spacing: 2px;">
                    24:00:00
                </div>
                
                <p style="color: #666; font-size: 0.8rem; margin-top: 15px;">El QR se reactivará automáticamente cuando el reloj llegue a cero.</p>
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
        // Datos base del estudiante
        const idEstudiante = "1033261277-2026"; 
        const nombreEstudiante = "Davidt sánchez ortiz";
        
        // Enlace que va encriptado dentro del código QR
        const urlValidacion = "https://filapro.com/validar?token=XYZ12345&id=" + idEstudiante;
        
        let intervaloTimer; // Variable global para controlar el conteo del reloj segundo a segundo

        // Evento que se dispara automáticamente en cuanto carga la página en el navegador
        window.onload = function() {
            verificarEstadoQR();
        };

        // [FUNCIÓN PRINCIPAL]: Evalúa si el QR debe estar bloqueado o activo al cargar la página
        function verificarEstadoQR() {
            const horaBloqueo = localStorage.getItem("tiempo_bloqueo_" + idEstudiante);
            
            if (horaBloqueo) {
                const tiempoTranscurrido = Date.now() - parseInt(horaBloqueo);
                const veinticuatroHoras = 24 * 60 * 60 * 1000; // Equivalente de 24h en milisegundos

                // Si el tiempo transcurrido es menor a 24 horas, sigue bloqueado
                if (tiempoTranscurrido < veinticuatroHoras) {
                    mostrarPantallaBloqueo();
                    arrancarContador(parseInt(horaBloqueo) + veinticuatroHoras);
                } else {
                    // Si ya pasaron las 24 horas, borramos el bloqueo de la memoria y lo activamos
                    localStorage.removeItem("tiempo_bloqueo_" + idEstudiante);
                    mostrarPantallaActiva();
                }
            } else {
                // Si no hay registros de bloqueos previos en memoria, se activa el QR de una vez
                mostrarPantallaActiva();
            }
        }

        // [FUNCIÓN PANTALLA ACTIVA]: Dibuja el código QR original y oculta el reloj
        function mostrarPantallaActiva() {
            document.getElementById("bloque-bloqueado").style.display = "none";
            document.getElementById("btn-simular").style.display = "flex";
            document.getElementById("subtitulo-estado").innerText = "Presenta este código QR para reclamar tu beneficio";
            document.getElementById("subtitulo-estado").style.color = "#aaa";
            document.getElementById("tarjeta-validacion").style.borderColor = "#2aff7a";
            
            // Inyectamos los textos del estudiante en las etiquetas HTML
            document.getElementById("nombre-alumno").innerText = nombreEstudiante;
            document.getElementById("matricula-alumno").innerText = "ID: " + idEstudiante;

            // Limpiamos el contenedor y creamos el QR con la librería
            document.getElementById("contenedor-qr").innerHTML = "";
            new QRCode(document.getElementById("contenedor-qr"), {
                text: urlValidacion,
                width: 150,
                height: 150,
                colorDark : "#000000",
                colorLight : "#ffffff",
                correctLevel : QRCode.CorrectLevel.H
            });
        }

        // [FUNCIÓN PANTALLA BLOQUEO]: Oculta el QR válido y muestra el panel del contador
        function mostrarPantallaBloqueo() {
            document.getElementById("bloque-bloqueado").style.display = "block";
            document.getElementById("btn-simular").style.display = "none";
            document.getElementById("subtitulo-estado").innerText = "CÓDIGO QR INACTIVO / EXPIRADO";
            document.getElementById("subtitulo-estado").style.color = "#ff4a4a";
            document.getElementById("tarjeta-validacion").style.borderColor = "#ff4a4a";
            
            // Reemplazamos el QR por un texto estático para que no pueda ser escaneado de nuevo
            document.getElementById("contenedor-qr").innerHTML = "<div style='color:black; font-weight:bold; font-size:14px; text-align:center;'>RECLAMADO</div>";
            document.getElementById("nombre-alumno").innerText = nombreEstudiante;
            document.getElementById("matricula-alumno").innerText = "ID: " + idEstudiante;
        }

        // [FUNCIÓN CRONÓMETRO]: Calcula el tiempo restante y refresca el reloj segundo a segundo
        function arrancarContador(tiempoDestino) {
            clearInterval(intervaloTimer); // Limpieza de seguridad para evitar que se dupliquen relojes

            intervaloTimer = setInterval(function() {
                const ahora = Date.now();
                const diferencia = tiempoDestino - ahora;

                // Si la cuenta regresiva llega a cero
                if (diferencia <= 0) {
                    clearInterval(intervaloTimer); // Apagamos el reloj
                    localStorage.removeItem("tiempo_bloqueo_" + idEstudiante); // Limpiamos la memoria
                    mostrarPantallaActiva(); // Activamos el QR de nuevo
                    alert("¡Las 24 horas han terminado! Tu código QR se encuentra activo de nuevo.");
                } else {
                    // Operaciones matemáticas para desglosar la diferencia de tiempo
                    const horas = Math.floor((diferencia % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((diferencia % (1000 * 60 * 60)) / (1000 * 60));
                    const segundos = Math.floor((diferencia % (1000 * 60)) / 1000);

                    // Formato estético: Agrega un '0' a la izquierda si el número es menor a 10 (ej: 09 en lugar de 9)
                    const hrsFormateadas = horas < 10 ? "0" + horas : horas;
                    const minsFormateados = minutes < 10 ? "0" + minutes : minutes;
                    const segsFormateados = segundos < 10 ? "0" + segundos : segundos;

                    // Pintamos el tiempo actualizado en el reloj digital del HTML
                    document.getElementById("contador-reloj").innerText = `${hrsFormateadas}:${minsFormateados}:${segsFormateados}`;
                }
            }, 1000); // 1000 milisegundos = Ejecución continua cada 1 segundo
        }

        // [FUNCIÓN SIMULADORA]: Guarda la marca de tiempo de hoy y arranca el ciclo de bloqueo
        function simularEscaneo() {
            alert("¡QR Escaneado con éxito! Almuerzo ya reclamado...");
            // Registramos el momento exacto actual en milisegundos en el almacenamiento local
            localStorage.setItem("tiempo_bloqueo_" + idEstudiante, Date.now().toString())
            // Activamos la evaluación para que bloquee el código e inicie el cronómetro
            verificarEstadoQR();
        }
        
    </script>
    </body>
</html>