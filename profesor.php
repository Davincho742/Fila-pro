<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Panel Profesor</title>
    <link rel="stylesheet" href="./public/profesor.css">
    <link rel="icon" type="image/x-icon" href="Fila pro.jpg">
</head>
<body>
        
    <nav class="menu-superior">
        <div class="contenedor-menu">
            <div class="logo-proyecto">Fila Pro</div>
            <div class="navegacion-enlaces">
                <a href="iniciosesion.php" class="enlace-navegacion">Cerrar sesión</a>
            </div>
        </div>
    </nav>
    
    <main class="foto">
        <!-- BANNER LOGO -->
        <div class="banner">
            <img src="Fila pro.jpg" alt="Logo Fila Pro">
        </div>

        <div class="caja bienvenida">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>

        <!-- MÓDULO BÚSQUEDA DEL PROFESOR -->
        <div class="panel-profesor">
            <h3 style="color: #fff; margin-bottom: 5px;">Buscar Estudiante</h3>
            <p style="color: #aaa; font-size: 0.9rem;">Ingresa el nombre de usuario o el número de documento/contraseña:</p>
            <div class="caja-busqueda">
                <input type="text" id="searchInput" class="campo-input" placeholder="Ejemplo: 10029384 o juan.perez" onkeypress="if(event.key === 'Enter') buscarEstudiante()">
                <button class="btn-accion btn-buscar" onclick="buscarEstudiante()">Buscar 🔍</button>
            </div>
        </div>

        <!-- DATOS Y CONTROL DEL ESTUDIANTE -->
        <div class="panel-profesor">
            <div class="encabezado-estudiante">
                <div>
                    <h3 id="studentName" style="color: #fff; margin: 0 0 5px 0;">Realiza una búsqueda</h3>
                    <p id="studentInfo" style="color: #aaa; margin: 0 0 15px 0; font-size: 0.9rem;">Ingresa el documento o nombre para ver los datos</p>
                    
                    <!-- BOTONES DE ACCIÓN PARA EL PROFESOR -->
                    <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                        <button id="btnEstado" class="btn-accion btn-suspender" onclick="toggleCupo()">Suspender Cupo</button>
                        
                        <!-- BOTÓN DE ELIMINAR CUENTA -->
                        <button id="btnEliminar" class="btn-accion" onclick="eliminarEstudiante()" style="background-color: #d9534f; color: white; border: none; padding: 10px 18px; border-radius: 8px; cursor: pointer; display: none; font-weight: bold;">
                            Eliminar Cuenta 🗑️
                        </button>
                    </div>
                </div>
            </div>

            <hr style="border-color: #333; margin: 15px 0;">

            <div>
                <h4 style="color: var(--amarillo-pro, #ffca28); margin-bottom: 10px;">Días Reclamados por el Estudiante:</h4>
                <div class="lista-dias" id="historyList">
                    <!-- Cargados dinámicamente -->
                </div>
            </div>
        </div>

        <!-- FOOTER -->
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

        <footer class="mini-footer">
            Copyright © 2025-2026 - Todos los derechos reservados (Fila pro). 
        </footer>
    </main>

    <!-- SCRIPT DE FUNCIONALIDAD -->
    <script>
        let estudianteActual = null;

        // Estado inicial de la interfaz al cargar la página
        window.onload = function() {
            const btn = document.getElementById("btnEstado");
            const btnEliminar = document.getElementById("btnEliminar");
            if (btn) btn.style.display = "none"; 
            if (btnEliminar) btnEliminar.style.display = "none";
            document.getElementById("historyList").innerHTML = "<p style='color:#888;'>Ingresa datos para consultar.</p>";
        };

        // 1. BUSCAR ESTUDIANTE POR NOMBRE O CONTRASEÑA/DOCUMENTO
        async function buscarEstudiante() {
            const query = document.getElementById("searchInput").value.trim();
            if (!query) return alert("Por favor ingresa un número de identidad o nombre de usuario.");

            try {
                const respuesta = await fetch(`api_profesor.php?accion=buscar&q=${encodeURIComponent(query)}`);

                if (!respuesta.ok) {
                    const textoError = await respuesta.text();
                    console.error("Detalle del error del servidor:", textoError);
                    return alert(`Error en el servidor (${respuesta.status}). Revisa que api_profesor.php exista.`);
                }

                const data = await respuesta.json();

                if (data.exito) {
                    estudianteActual = data.estudiante;
                    renderizar();
                } else {
                    alert(data.mensaje || "No se encontró ningún estudiante con esa información.");
                }
            } catch (error) {
                console.error("Error al conectar con la base de datos:", error);
                alert("Error de conexión: No se pudo comunicar con api_profesor.php o la base de datos.");
            }
        }

        // 2. RENDERIZAR DATOS DEL ESTUDIANTE Y SUS DÍAS RECLAMADOS
        function renderizar() {
            if (!estudianteActual) return;

            const elemNombre = document.getElementById("studentName");
            const elemInfo = document.getElementById("studentInfo");
            const btn = document.getElementById("btnEstado");
            const btnEliminar = document.getElementById("btnEliminar");

            if (elemNombre) elemNombre.textContent = `Estudiante: ${estudianteActual.usuario || estudianteActual.nombre || 'Sin Nombre'}`;
            if (elemInfo) elemInfo.textContent = `ID: ${estudianteActual.id || 'N/A'} | Grado: ${estudianteActual.grado || 'N/A'}`;

            // Mostrar el botón de eliminar
            if (btnEliminar) btnEliminar.style.display = "inline-block";

            if (btn) {
                btn.style.display = "inline-block";

                const estaActivo = estudianteActual.estado === 'activo' || estudianteActual.estado === 1 || estudianteActual.estado === '1' || estudianteActual.activo === true;

                if (estaActivo) {
                    btn.textContent = "Suspender Cupo";
                    btn.className = "btn-accion btn-suspender";
                } else {
                    btn.textContent = "Reactivar Cupo";
                    btn.className = "btn-accion btn-reactivar";
                }
            }

            // Renderizado del historial de asistencia/días reclamados
            const historyList = document.getElementById("historyList");
            historyList.innerHTML = "";

            const dias = estudianteActual.diasReclamados || [];
            if (dias.length > 0) {
                dias.forEach(dia => {
                    const badge = document.createElement("div");
                    badge.className = "badge-dia";
                    badge.textContent = `✓ ${dia}`;
                    historyList.appendChild(badge);
                });
            } else {
                historyList.innerHTML = "<p style='color:#888;'>No registra días reclamados.</p>";
            }
        }

        // 3. CAMBIAR ESTADO DEL CUPO CON CONFIRMACIÓN PREVIA
        async function toggleCupo() {
            if (!estudianteActual) return;

            const estaActivo = estudianteActual.estado === 'activo' || estudianteActual.estado === 1 || estudianteActual.estado === '1' || estudianteActual.activo === true;
            const nuevoEstado = estaActivo ? 'suspendido' : 'activo';
            const accionTexto = estaActivo ? 'SUSPENDER' : 'REACTIVAR';

            const confirmacion = confirm(`¿Estás seguro de que deseas ${accionTexto} el cupo del estudiante "${estudianteActual.usuario}"?`);
            if (!confirmacion) return;

            try {
                const respuesta = await fetch('api_profesor.php?accion=cambiar_estado', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: estudianteActual.id,
                        nuevo_estado: nuevoEstado
                    })
                });

                const data = await respuesta.json();

                if (data.exito) {
                    estudianteActual.estado = data.nuevo_estado;
                    estudianteActual.activo = (data.nuevo_estado === 'activo');
                    renderizar();
                    alert(`✅ Cupo ${data.nuevo_estado.toUpperCase()} con éxito.`);
                } else {
                    alert("No se pudo actualizar el estado en la base de datos.");
                }
            } catch (error) {
                console.error("Error al modificar estado:", error);
                alert("Error al conectar con la base de datos.");
            }
        }

        // 4. ELIMINAR LA CUENTA DEL ESTUDIANTE PERMANENTEMENTE
        async function eliminarEstudiante() {
            if (!estudianteActual) return;

            const nombreUsuario = estudianteActual.usuario || estudianteActual.nombre || "este estudiante";
            const confirmacion = confirm(`⚠️ ¿Estás seguro de que deseas ELIMINAR PERMANENTEMENTE la cuenta de "${nombreUsuario}"?\n\nEsta acción eliminará al estudiante de la base de datos de Fila Pro.`);

            if (!confirmacion) return;

            try {
                const respuesta = await fetch('eliminar_usuario.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: estudianteActual.id || estudianteActual.usuario
                    })
                });

                const data = await respuesta.json();

                if (data.exito) {
                    alert("✅ " + data.mensaje);

                    // Limpiar el panel del profesor tras eliminar
                    estudianteActual = null;
                    document.getElementById("studentName").textContent = "Realiza una búsqueda";
                    document.getElementById("studentInfo").textContent = "Ingresa el documento o nombre para ver los datos";
                    document.getElementById("btnEstado").style.display = "none";
                    document.getElementById("btnEliminar").style.display = "none";
                    document.getElementById("historyList").innerHTML = "<p style='color:#888;'>Ingresa datos para consultar.</p>";
                    document.getElementById("searchInput").value = "";
                } else {
                    alert("❌ Error: " + data.mensaje);
                }
            } catch (error) {
                console.error("Error al eliminar cuenta:", error);
                alert("Ocurrió un error al procesar la eliminación en eliminar_usuario.php.");
            }
        }
    </script>
</body>
</html>