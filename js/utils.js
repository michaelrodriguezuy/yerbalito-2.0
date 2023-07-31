

    const contadorNinos = document.getElementById("cantidad-finalizadas");    
    
   // contadorNinos.innerHTML = contadorJugadores();


    /* ---------------------------------- texto --------------------------------- */
    function validarTexto(texto) {

    }

    function normalizarTexto(texto) {

    }

    /* ---------------------------------- email --------------------------------- */
    function validarEmail(email) {

    }

    function normalizarEmail(email) {

    }

    /* -------------------------------- password -------------------------------- */
    function validarContrasenia(contrasenia) {

    }

    function compararContrasenias(contrasenia_1, contrasenia_2) {

    }

    function contadorJugadores() {
        
        
    }     

    function cerrarSesion() {
        // Enviar una solicitud AJAX al archivo logout.php para cerrar la sesión
        fetch('logout.php')
            .then(response => {
                // Redireccionar a la página de inicio de sesión una vez que se haya cerrado la sesión
                window.location.href = 'index.php';
            })
            .catch(error => {
                console.error('Error al cerrar sesión:', error);
            });
    }

