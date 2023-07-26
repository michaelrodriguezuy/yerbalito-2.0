window.addEventListener('DOMContentLoaded', (event) => {


    
    function mostrarHora() {
        let d = new Date();
        let horaActual = d.getHours();
        let minutosActual = d.getMinutes();
        let segundosActual = d.getSeconds();

        let horaHTML = document.getElementById('h1');
        horaHTML.textContent = horaActual + ':' + minutosActual + ':' + segundosActual;
               
    }
  
    mostrarHora();   

    setInterval(mostrarHora, 1000);

    let horaHTML = document.getElementById('h1');
    document.querySelector('main').appendChild(horaHTML);

    



});



