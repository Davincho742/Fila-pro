<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro</title>
    <link rel="stylesheet" href="asistencia.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
</head>
<body>

<nav class="menu-superior">
  <div class="contenedor-menu">   
       
    <div class="logo-proyecto">
      <span class="material-icons-round"></span>
      Fila Pro
    </div>
    
    <div class="navegacion-enlaces">
    <a href="pagina estudiante.html" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        Inicio
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

    <main class="foto" style="margin-top: 80px;"> <div class="banner">
            <img src="Fila pro.jpg" alt="Logo Fila Pro">
        </div>
        <div class="caja bienvenida" style="text-align: center;">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>
         
        <div class="contenedor-calendario">
            <div class="cabecera-calendario" style="text-align: center; display: flex; justify-content: space-between; align-items: center; padding: 0 15px;">
                <button id="btn-anterior" style="cursor: pointer; padding: 5px 10px; border-radius: 5px; border: 1px solid #ccc;">&#8592; Anterior</button>
                <h2 id="nombre-mes-dinamico" style="margin: 0;">Cargando mes...</h2>
                <button id="btn-siguiente" style="cursor: pointer; padding: 5px 10px; border-radius: 5px; border: 1px solid #ccc;">Siguiente &#8594;</button>
            </div>
            
            <div class="dias-semana-grid">
                <div>Do</div><div>Lu</div><div>Ma</div><div>Mi</div><div>Ju</div><div>Vi</div><div>Sá</div>
            </div>
            
            <div class="dias-grid" id="grid-dias-dinamico">
                </div>
        </div>
        <br>
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

        <footer class="mini-footer" style="text-align: center;">
            Copyright © 2025-2026 - Todos los derechos reservados (Fila pro). 
        </footer>
    </main>

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
    </script>

    <script>
        const estudianteSesionID = "1033261277-2026"; 

        const festivosColombia2026 = [
            "2026-01-01", "2026-01-12", "2026-03-23", "2026-04-02", 
            "2026-04-03", "2026-05-01", "2026-05-18", "2026-06-08", 
            "2026-06-15", "2026-06-29", "2026-07-20", "2026-08-07", 
            "2026-08-17", "2026-10-12", "2026-11-02", "2026-11-16", 
            "2026-12-08", "2026-12-25"  
        ];

        let fechaNavegacion = new Date();
        let añoActual = fechaNavegacion.getFullYear();
        let mesActual = fechaNavegacion.getMonth();

        function inicializarCalendarioAsistencia() {
            const gridContenedor = document.getElementById("grid-dias-dinamico");
            const tituloMesHTML = document.getElementById("nombre-mes-dinamico");
            
            const fechaHoy = new Date();
            const añoReal = fechaHoy.getFullYear();
            const mesReal = fechaHoy.getMonth();
            const diaDelMesHoy = fechaHoy.getDate();

            const nombresMeses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
            tituloMesHTML.innerText = `${nombresMeses[mesActual]} ${añoActual}`;

            const historialAsistencias = JSON.parse(localStorage.getItem(`asistencia_${estudianteSesionID}`)) || [];

            const primerDiaIndex = new Date(añoActual, mesActual, 1).getDay();
            const diasTotalesMes = new Date(añoActual, mesActual + 1, 0).getDate();

            gridContenedor.innerHTML = "";

            for (let i = 0; i < primerDiaIndex; i++) {
                const celdaVacia = document.createElement("div");
                celdaVacia.classList.add("celda-vacia");
                gridContenedor.appendChild(celdaVacia);
            }

            for (let dia = 1; dia <= diasTotalesMes; dia++) {
                const celdaDia = document.createElement("div");
                celdaDia.classList.add("celda-dia");
                celdaDia.innerText = dia;

                const fechaEvaluada = new Date(añoActual, mesActual, dia);
                const diaDeLaSemana = fechaEvaluada.getDay();

                const mesFormateado = String(mesActual + 1).padStart(2, '0');
                const diaFormateado = String(dia).padStart(2, '0');
                
                // Formato exacto con ceros
                const claveFechaCompleta = `${añoActual}-${mesFormateado}-${diaFormateado}`;
                // Formato alternativo sin ceros (por si el escáner lo guarda así)
                const claveFechaSinCeros = `${añoActual}-${mesActual + 1}-${dia}`; 

                if (dia === diaDelMesHoy && mesActual === mesReal && añoActual === añoReal) {
                    celdaDia.classList.add("hoy");
                }

                const esFinDeSemana = (diaDeLaSemana === 0 || diaDeLaSemana === 6);
                const esFestivo = festivosColombia2026.includes(claveFechaCompleta);

                if (esFinDeSemana) {
                    celdaDia.classList.add("fin-semana");
                } else if (esFestivo) {
                    celdaDia.classList.add("festivo");
                } else {
                    // Validamos ambos formatos para que no marque fallas por error de ceros
                    if (historialAsistencias.includes(claveFechaCompleta) || historialAsistencias.includes(claveFechaSinCeros)) {
                        celdaDia.classList.add("asistio");
                        // AQUÍ ESTÁ EL PUNTICO VERDE QUE PEDISTE
                        celdaDia.innerHTML = `${dia} <div style="color: #28a745; font-size: 18px; line-height: 0.5; margin-top: 5px;">●</div>`;
                    
                    } else if (fechaEvaluada < new Date(añoReal, mesReal, diaDelMesHoy)) {
                        celdaDia.classList.add("falta");
                        // OPCIONAL: Si también quieres que la falta sea un puntico rojo en vez de pintar todo el cuadro, borra las dos barras '//' de la línea de abajo:
                        // celdaDia.innerHTML = `${dia} <div style="color: #dc3545; font-size: 18px; line-height: 0.5; margin-top: 5px;">●</div>`;
                    }
                }

                gridContenedor.appendChild(celdaDia);
            }
        }

        document.getElementById("btn-anterior").addEventListener("click", () => {
            mesActual--;
            if (mesActual < 0) {
                mesActual = 11;
                añoActual--;
            }
            inicializarCalendarioAsistencia();
        });

        document.getElementById("btn-siguiente").addEventListener("click", () => {
            mesActual++;
            if (mesActual > 11) {
                mesActual = 0;
                añoActual++;
            }
            inicializarCalendarioAsistencia();
        });

        inicializarCalendarioAsistencia();
    </script>

</body>
</html>