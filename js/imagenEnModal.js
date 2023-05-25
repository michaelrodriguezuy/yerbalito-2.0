window.addEventListener('load', function () {

    const urlJason = "http://127.0.0.1/yerbalito/cumples.php"; //url del archivo json

    const calendario = document.getElementById("calendario"); //selecciono el elemento calendario
    const divImagen = document.getElementById("imagen2"); //selecciono el elemento divImagen
    

    //const idJugador= document.getElementById("idJug").value;

    calendario.addEventListener("click", function () { //cuando se hace click en el boton de la imagen se ejecuta la funcion        

        //llamo a la funcion mostrarPics y le paso el id del evento
        //sino refresco la pagina y no cambia el id      

        mostrarPics(document.getElementById("idEvento").value);
    });

    const mostrarPics = async (evento) => {

        //me trae correctamente el numero de evento
        console.log(evento);        

        const request = await fetch(urlJason);
        const data = await request.json();
        const photo = "user.jpg"; //imagen por defecto
        //const categoria = 0;


        //entra
        for (let index = 0; index < data.length; index++) {
            if (data[index].id == evento) {

                /*
                console.log("largo json: "+data.length);
                console.log("ID del evento "+ index +" json: "+data[index].id);
                console.log("ID del evento cliqueado: "+evento);
                //ESTO ANDA PERFECTO
                */
                const myIMG = this.document.createElement("img");
                myIMG.src = data[index].image;
                divImagen.appendChild(myIMG);

            }
        }

        //  divImagen.innerHTML = `<img src="images/gurises/${categoria}/${photo}"> </img>`;

        //buscar la forma de resfrescar el calendario refresca la pagina        
        //BUSCAR CORREGIR ESTO, no es la mejor forma de solucionarlo
        setInterval("location.reload()", 3000);
    };
});