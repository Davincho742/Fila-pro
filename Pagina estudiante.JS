
document.getElementById('miFormulario').addEventListener('submit', function(e) {
    // 1. Evitamos que la página se recargue sola
    e.preventDefault();

    // 2. Obtenemos los valores de las contraseñas
    const clave1 = document.getElementById('pass1').value;
    const clave2 = document.getElementById('pass2').value;

    // 3. Validamos
    if (clave1 !== clave2) {
        alert("Las contraseñas no coinciden.");
    } else {
        // 4. Redirección forzada
        console.log("Redirigiendo...");
        window.location.href = "pagina estudiante.html";
    }
});
