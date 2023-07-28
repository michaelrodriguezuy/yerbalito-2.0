<?php 

require_once('Connections/yerbalito.php');

    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <title>Yerbalito</title>

    <!- ----------------------------- estilos CSS ----------------------------- -->
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
    

        <!-- js bootstrap viejo-->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"> </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>
    

    <!- ----------------------------- JS ----------------------------- -->
    <script src="js/provisorio.js"></script>
    <script src="js/imagenEnModal.js"></script>
    <script src="js/utils.js"></script>

    <!- ----------------------------- FONT AWESOME ----------------------------- -->
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    

        <!-- ------------------------------ librerias ------------------------------ -->
    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate on scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


    <!- ----------------------------- GOOGLE FONTS ----------------------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico">

<script>
        $(document).ready(function () {
            $('#CalendarioWeb').fullCalendar({


                dayClick: function (date, jsEvent, view) {
                    $(this).css('background-color', 'grey');
                    $("#exampleModal").modal();
                },
                events: 'cumples.php',
                /*
                eventSources:[{
                  events:[
                  {
                    title: 'Pablo',
                    descripcion: "Pablo Menchaca - Cat 2012",
                    start: '2023-04-22',          
                    color:"#acefc8",
                    textColor:"#000000" // an option!      
                    //allDay:true
                  }],        
                  color:"black",
                  textColor:"yellow" // an option!
                }],
                */
                eventClick: function (calEvent, jsEvent, view) {
                    $('#idEvento').val(calEvent.id)
                    //          $('#idJug').val(calEvent.id_jugador);

                    $('#tituloEvento').html(calEvent.title);
                    $('#fecha').html(calEvent.start);
                    $('#descripcionEvento').html(calEvent.description);
                    $('#imagen2').val(calEvent.image);


                    //$('#idCat').val(calEvent.id_categoria);
                    $("#exampleModal").modal();


                },

                //cellHeight: 100,
                slotWidth: 200,

            });

        });
    </script>

</head>

<body>
<header>
    <nav class="nav">
      <div class="logo"></div>
    </nav>
    <nav class="nav-menu">
      <ul class="ul">
        <li class="li-inicio">
          <a class="a" href="index.php">Inicio</a>
          <ul class="ul-submenu">
            <li class="li"><a class="a" href="acerca.html">Nuestra institución</a></li>
            <li class="li"><a class="a" href="calendario.php">Cumpleaños</a></li>
          </ul>
        </li>
        <li class="li"><a class="a" href="planteles.html">Planteles</a></li>
        <li class="li"><a class="a" href="blog.php">Blog</a></li>
        <li class="li"><a class="a" href="contacto.html">Contacto</a></li>
        <li class="li"><a class="a" href="login.php">Login</a></li>
      </ul>
    </nav>
  </header>

    <!-- MAIN -->
    <main class="main">
   
        <section id="calendario">
            <div class="row">
                <article class="articulo2">
                    <div class="col"></div>
                    <div class="col-7">
                        <div id="CalendarioWeb"></div>
                    </div>
                    <div class="col"></div>
                </article>
        </section>


    </main>

    <footer class="footer">

        <div class="footer-content">
       

            <ul class="socials">
                <li>
                    <a href="https://www.facebook.com/Clubyerbalitodebabyfutbol" target="_blank"> <i
                            class="fa fa-facebook"></i></a>
                </li>

                <li>
                    <a href="https://www.instagram.com/clubyerbalitobabyfutbol/" title="yerbalito" target="_blank"> <i
                            class="fa fa-instagram"></i></a>
                </li>
                <li>
                    <a href="https://www.instagram.com/yerbalito.fem/" title="yerbalito femenino" target="_blank"> <i
                            class="fa fa-instagram"></i></a>
                </li>
                <li>
                    <a href="https://api.whatsapp.com/send?phone=59899163200&text=Hola%20Yerbalito" target="_blank"> <i
                            class="fa fa-whatsapp"></i></a>
                </li>
                <li>
                    <a href="mailto:info@yerbalito.uy?subject=enviado%20desde%20la%20web" target="_blank"> <i
                            class="fa fa-envelope" ></i></a>
                </li>
            </ul>
            
        </div>

        <div class="footer-bottom">
            <p> Este sitio esta diseñado por <a target="_blank" href="http://olimarteam.uy"> <span> olimarteam.uy
                    </span> </a> </p>
        </div>

    </footer>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tituloEvento"></h5>

                    <!-- este boton queda chico y no capta el evento click -->
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>
                <div class="modal-body">

                    <div id="descripcionEvento">

                    </div>
                    <!-- aca tengo el ID del jugador que cliqueo en el calendario -->
                    <div id="imagen2">
                        <input id="idEvento" type="hidden" value="idEvento" />

                    </div>

                </div>
            </div>
        </div>


</body>

</html>