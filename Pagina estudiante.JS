
document.getElementById('miFormulario').addEventListener('submit', function(e) {
   
    e.preventDefault();

    
    const clave1 = document.getElementById('pass1').value;
    const clave2 = document.getElementById('pass2').value;

    // 3. Validamos
    if (clave1 !== clave2) {
        alert("Las contraseñas no coinciden.");
    } else {
       
        console.log("Redirigiendo...");
        window.location.href = "pagina estudiante.html";
    }
});

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
