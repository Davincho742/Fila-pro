<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fila Pro - Panel Profesor</title>
    <link rel="stylesheet" href="./public/profesor.css?v=1.2">
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
            <img src="filapro.png" alt="Logo Fila Pro">
        </div>

        <div class="caja bienvenida">
            <p>Bienvenido a la plataforma oficial de Fila Pro.</p>
        </div>
       <br>e
        <!-- MÓDULO BÚSQUEDA DEL PROFESOR -->
        <div class="panel-profesor">
            <h3 class="titulo-panel">Buscar Estudiante</h3>
            <p class="subtitulo-panel">Ingresa el nombre de usuario o el número de documento/contraseña:</p>
            <div class="caja-busqueda">
                <input type="text" id="searchInput" class="campo-input" placeholder="Ejemplo: 10029384 o juan.perez" onkeypress="if(event.key === 'Enter') buscarEstudiante()" oninput="if(this.value.trim() === '') resetearInterfaz()">
                <button class="btn-accion btn-buscar" onclick="buscarEstudiante()">Buscar </button>
            </div>
        </div>
       


        <!-- DATOS Y CONTROL DEL ESTUDIANTE -->
        <div class="panel-profesor">
            <div class="encabezado-estudiante">
                <div>
                    <h3 id="studentName" class="nombre-estudiante">Realiza una búsqueda</h3>
                    <p id="studentInfo" class="info-estudiante">Ingresa el documento o nombre para ver los datos</p>
                    
                    <!-- BOTONES DE ACCIÓN EN LÍNEA -->
                    <div class="contenedor-botones-accion">
                        <button id="btnEstado" class="btn-accion btn-suspender" onclick="procesarCambioCupo()">Suspender Cupo</button>
                        <button id="btnCancelarConfirmacion" class="btn-accion btn-cancelar-conf" onclick="cancelarConfirmacion()">Cancelar</button>
                        <button id="btnEliminar" class="btn-accion btn-eliminar-cuenta" onclick="confirmarEliminacion()">Eliminar Cuenta </button>
                    </div>
                </div>
            </div>

            <hr class="separador-panel">

            <div>
                <h4 class="titulo-dias">Días Reclamados por el Estudiante:</h4>
                <div class="lista-dias" id="historyList">
                    <!-- Cargados dinámicamente -->
                </div>
            </div>
        </div>
    </main>

    <!-- PIE DE PÁGINA UNIFICADO -->
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

    <div class="toast-container" id="toastContainer"></div>

    <!-- MODAL DE CONFIRMACIÓN -->
    <div class="modal-overlay" id="customModal">
        <div class="modal-box">
            <h4>Confirmar Eliminación</h4>
            <p id="modalMessage">¿Deseas eliminar permanentemente a este estudiante?</p>
            <div class="modal-acciones">
                <button class="btn-modal btn-modal-cancelar" onclick="cerrarModal()">Cancelar</button>
                <button class="btn-modal btn-modal-confirmar" onclick="ejecutarEliminacion()">Sí, Eliminar</button>
            </div>
        </div>
    </div>

    <script>
        let estudianteActual = null;
        let esperandoConfirmacionEstado = false;

        window.onload = function() {
            resetearInterfaz();

            // Evento para limpiar el panel si la barra de búsqueda se vacía
            document.getElementById("searchInput").addEventListener("input", function() {
                if (this.value.trim() === "") {
                    resetearInterfaz();
                }
            });
        };

        function mostrarToast(mensaje, tipo = 'info') {
            const container = document.getElementById('toastContainer');
            const toast = document.createElement('div');
            toast.className = `toast ${tipo}`;
            toast.innerHTML = mensaje;
            container.appendChild(toast);

            setTimeout(() => {
                toast.style.opacity = '0';
                toast.style.transition = 'opacity 0.3s ease';
                setTimeout(() => toast.remove(), 300);
            }, 3000);
        }

        function resetearInterfaz() {
            estudianteActual = null;
            esperandoConfirmacionEstado = false;
            document.getElementById("btnEstado").style.display = "none"; 
            document.getElementById("btnCancelarConfirmacion").style.display = "none";
            document.getElementById("btnEliminar").style.display = "none";
            document.getElementById("studentName").textContent = "Realiza una búsqueda";
            document.getElementById("studentInfo").textContent = "Ingresa el documento o nombre para ver los datos";
            document.getElementById("historyList").innerHTML = "<p class='mensaje-vacio'>Ingresa datos para consultar.</p>";
        }

        async function buscarEstudiante() {
            cancelarConfirmacion();
            const query = document.getElementById("searchInput").value.trim();
            if (!query) {
                mostrarToast("Ingresa un documento o usuario.", "warning");
                return;
            }

            try {
                const respuesta = await fetch(`api_profesor.php?accion=buscar&q=${encodeURIComponent(query)}`);
                if (!respuesta.ok) {
                    mostrarToast(`Error de servidor (${respuesta.status}).`, "error");
                    return;
                }

                const data = await respuesta.json();

                if (data.exito) {
                    estudianteActual = data.estudiante;
                    renderizar();
                    mostrarToast("Datos cargados correctamente.", "success");
                } else {
                    mostrarToast(data.mensaje || " Estudiante no encontrado.", "error");
                }
            } catch (error) {
                mostrarToast(" Error de conexión.", "error");
            }
        }

        function renderizar() {
            if (!estudianteActual) return;

            const elemNombre = document.getElementById("studentName");
            const elemInfo = document.getElementById("studentInfo");
            const btn = document.getElementById("btnEstado");
            const btnEliminar = document.getElementById("btnEliminar");

            elemNombre.textContent = `Estudiante: ${estudianteActual.usuario || estudianteActual.nombre || 'Sin Nombre'}`;
            elemInfo.textContent = `ID: ${estudianteActual.id || 'N/A'} | Grado: ${estudianteActual.grado || 'N/A'}`;

            btnEliminar.style.display = "inline-block";
            btn.style.display = "inline-block";

            const estaActivo = estudianteActual.estado === 'activo' || estudianteActual.estado === 1 || estudianteActual.estado === '1' || estudianteActual.activo === true;

            if (estaActivo) {
                btn.textContent = "Suspender Cupo";
                btn.className = "btn-accion btn-suspender";
            } else {
                btn.textContent = "Reactivar Cupo";
                btn.className = "btn-accion btn-reactivar";
            }

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
                historyList.innerHTML = "<p class='mensaje-vacio'>No registra días reclamados.</p>";
            }
        }

        function procesarCambioCupo() {
            if (!estudianteActual) return;

            const btn = document.getElementById("btnEstado");
            const btnCancelar = document.getElementById("btnCancelarConfirmacion");
            const estaActivo = estudianteActual.estado === 'activo' || estudianteActual.estado === 1 || estudianteActual.estado === '1' || estudianteActual.activo === true;
            const accionTexto = estaActivo ? 'Suspensión' : 'Reactivación';

            if (!esperandoConfirmacionEstado) {
                esperandoConfirmacionEstado = true;
                btn.textContent = `Confirmar ${accionTexto}`;
                btn.classList.add("btn-confirmar-accion");
                btnCancelar.style.display = "inline-block";
                return;
            }

            ejecutarCambioEstado(estaActivo ? 'suspendido' : 'activo');
        }

        function cancelarConfirmacion() {
            esperandoConfirmacionEstado = false;
            document.getElementById("btnCancelarConfirmacion").style.display = "none";
            if (estudianteActual) renderizar();
        }

        async function ejecutarCambioEstado(nuevoEstado) {
            try {
                const datosEnviar = {
                    id: estudianteActual.id,
                    id_estudiante: estudianteActual.id,
                    usuario: estudianteActual.usuario,
                    documento: estudianteActual.documento || estudianteActual.id,
                    nuevo_estado: nuevoEstado,
                    estado: nuevoEstado
                };

                const respuesta = await fetch('api_profesor.php?accion=cambiar_estado', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify(datosEnviar)
                });

                const data = await respuesta.json();

                if (data.exito) {
                    estudianteActual.estado = data.nuevo_estado || nuevoEstado;
                    estudianteActual.activo = (estudianteActual.estado === 'activo');
                    cancelarConfirmacion();
                    renderizar();
                    mostrarToast(` Estado actualizado a: ${nuevoEstado.toUpperCase()}`, "success");
                } else {
                    mostrarToast(data.mensaje || " No se pudo actualizar el estado.", "error");
                    cancelarConfirmacion();
                }
            } catch (error) {
                mostrarToast("Error al conectar con api_profesor.php", "error");
                cancelarConfirmacion();
            }
        }

        function confirmarEliminacion() {
            if (!estudianteActual) return;
            const nombreUsuario = estudianteActual.usuario || estudianteActual.nombre || "este estudiante";
            document.getElementById("modalMessage").textContent = `¿Deseas eliminar PERMANENTEMENTE a "${nombreUsuario}" de la base de datos?`;
            document.getElementById("customModal").style.display = "flex";
        }

        function cerrarModal() {
            document.getElementById("customModal").style.display = "none";
        }

        async function ejecutarEliminacion() {
            cerrarModal();
            if (!estudianteActual) return;

            try {
                const respuesta = await fetch('api_profesor.php?accion=eliminar', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        id: estudianteActual.id,
                        usuario: estudianteActual.usuario
                    })
                });

                const data = await respuesta.json();

                if (data.exito) {
                    mostrarToast(+ (data.mensaje || "Estudiante eliminado."), "success");
                    resetearInterfaz();
                    document.getElementById("searchInput").value = "";
                } else {
                    mostrarToast( + (data.mensaje || "No se pudo eliminar el estudiante."), "error");
                }
            } catch (error) {
                mostrarToast(" Error al procesar la eliminación.", "error");
            }
        }
    </script>
</body>
</html>             