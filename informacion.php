
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro</title>
    <link rel="stylesheet" href="./public/informacion.css">
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
         <a href="pagina estudiante.php" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        Inicio  
      <a href="iniciosesion.php" class="enlace-navegacion">
        <span class="material-icons-round"></span>
        cerrar sesión
      </a>
      
    </div>
</nav>
    

    <main class="foto">
        <div class="banner">
            <img src="Fila pro.jpg" alt="Logo Fila Pro">
        </div>
  <div class="estado" style="text-align: center;">
    <p>Aca podras ver si tu cupo se a suspendido o todavia sigue vigente.</p>
  </div>
        <div class="estado" id="contenedor-estado-dinamico" style="text-align: center;">
          <p>Cargando estado...</p>
        </div>

        <div class="caja bienvenida" style="text-align: center;">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
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
    function verificarEstadoEstudiante() {
        const contenedor = document.getElementById("contenedor-estado-dinamico");

        // Cambia la palabra a "vigente", "suspendido" o "no-agregado" para probar cómo se ve
        const estadoSimulado = "vigente"; 

        if (estadoSimulado === "vigente") {
            contenedor.innerHTML = `
                <div class="estado-box estado-vigente">
                    CUPO VIGENTE / ACTIVO ✅
                    <p style="font-size: 0.9rem; font-weight: normal; margin-top: 5px; color: #155724;">Tu cupo se encuentra al día. Recuerda registrar tu asistencia.</p>
                </div>
            `;
        } 
        else if (estadoSimulado === "suspendido") {
            contenedor.innerHTML = `
                <div class="estado-box estado-suspendido">
                    CUPO SUSPENDIDO TEMPORALMENTE ⚠️
                    <p style="font-size: 0.9rem; font-weight: normal; margin-top: 5px; color: #856404;">Acumulaste fallas sin justificación. Acércate a coordinación para reactivarlo.</p>
                </div>
            `;
        } 
        else if (estadoSimulado === "no-agregado") {
            contenedor.innerHTML = `
                <div class="estado-box estado-no-agregado">
                    NO AGREGADO A LA LISTA ❌
                    <p style="font-size: 0.9rem; font-weight: normal; margin-top: 5px; color: #721c24;">No estás en la lista oficial. Dirígete con el encargado para tu inscripción.</p>
                </div>
            `;
        }
    }

    verificarEstadoEstudiante();
</script>

</body>
</html>