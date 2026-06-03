
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
