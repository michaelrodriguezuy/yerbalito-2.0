window.addEventListener('load', function () {

    const urlJason = "http://127.0.0.1/yerbalito/cumples.php"; // URL del archivo JSON

    const calendario = document.getElementById("calendario"); // Selecciono el elemento calendario
    const fotoJugador = document.getElementById("fotoJugador"); // Selecciono el elemento fotoJugador

    calendario.addEventListener("click", function () {
        mostrarPics(document.getElementById("idEvento").value);
    });

    const mostrarPics = async (evento) => {
        const request = await fetch(urlJason + "?idEvento=" + evento);
        const data = await request.json();
        fotoJugador.innerHTML = ""; // Vaciar el contenido antes de agregar la nueva imagen

        for (let index = 0; index < data.length; index++) {
            if (data[index].id == evento) {
                const jugadorImg = document.createElement("img");
                jugadorImg.src = data[index].image;
                fotoJugador.appendChild(jugadorImg);
            }
        }

        // Puedes eliminar el setInterval para evitar que la página se refresque cada 3 segundos
    };
});
