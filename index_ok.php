<?php 

require_once('Connections/yerbalito.php');
//require_once('D://Virtuales//Docker//server//docker-lamp-main//www//yerbalito//Connections//yerbalito.php');

//include('session.php'); //esto lo uso para dar la bienvenida y para cerrar sesion

//include('seguridad.php');  	  
//      include('funciones.php');	
include('funciones2.php');

//	  include 'funciones.php?banderaDeudores=1';


//HABILITAR
//actualizaDeudores(); //los que estan al dia y deberian pasar a deudores


	// actualizaDeudores2(); // los que estan deudores y deberian pasar a habilitados
 



?>


<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Yerbalito </title>

    <!-- ----------------------------- estilos CSS ----------------------------- -->
    <link rel="stylesheet" href="./css/tasksStyles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- CSS 
    <link rel="stylesheet" href="./css/loginSignupStyles.css"> ESTE ES EL CSS DE LOGIN Y SIGNUP

    
    ESTE ES EL CSS VIEJO
    
    <link rel="stylesheet" href="css/style1.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" />
    <link rel="stylesheet" href="css/styled-elements.css" type="text/css" media="screen" />



    <link rel="stylesheet" type="text/css" href="css/style54.css" />
    <link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" /> -->

    <!-- css bootstrap nuevo (alertas)
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">      
  -->



    <!-- GOOGLE FONTS 
    <link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>

     SKIN 
    <link rel="stylesheet" href="skins/plastic/style.css" type="text/css" media="screen" />

    css del calendario 4.8.2
    <link href='fullCalendar/core/main.css' rel='stylesheet'>
    <link href='fullCalendar/daygrid/main.css' rel='stylesheet'>
-->

    <!-- css bootstrap viejo (modal)-->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"> -->

    <script src="js/jquery.min.js"></script>
    <script src="js/moment.min.js"></script>

    <!-- fullCalendar 3.8.2-->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
    <!--fullCalendar 3.8.3 -->
    <script src="js/fullcalendar.min.js"></script>
    <script src="js/es.js"></script>


    <!--js de bootstrap nuevo
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
  -->

    <!-- js bootstrap viejo-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"> </script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"></script>

    <script content-type="application/json;"> </script>


    <script src="js/imagenEnModal.js"></script>
    <script src="js/utils.js"></script>

    <!-- js de facebook -->
    <script async defer crossorigin="anonymous"
        src="https://connect.facebook.net/es_ES/sdk.js#xfbml=1&version=v16.0&appId=549567693989826&autoLogAppEvents=1"
        nonce="RECHjLVP"></script>
    <!--
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" ></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" ></script>
-->

    <!--calendario 4.8.3
  <script src="fullCalendar/core/main.js"></script>
  <script src="fullCalendar/daygrid/main.js"></script>
  <script src="fullCalendar/interaction/main.js"></script>
-->



    <!-- ------------------------------ librerias ------------------------------ -->
    <!-- Sweet Alert -->
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- Animate on scroll -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


    <!-- ------------------- libreria de iconos Fontawesome -------------------- 
    ES MAS NUEVA PERO NO ENCONTRE LOS ICONOS PARA LAS REDES SOCIALES
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
-->


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

            <div class="logo">

            </div>


            <ul class="menu-list">
                <li><a href="index.php">Inicio</a></li>
                <li><a href="plantel.php">Planteles</a></li>
                <li><a href="contacto.php">Contacto</a></li>
                <li><a href="login.php">Iniciar Sesion</a></li>
            </ul>


        </nav>

    </header>

    <!-- MAIN -->
    <main class="container">



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

        <section id="facebook">

            <div id="fb-root">

                <div class="fb-page" data-href="https://www.facebook.com/Clubyerbalitodebabyfutbol" data-tabs="timeline"
                    data-width="" data-height="" data-small-header="true" data-adapt-container-width="true"
                    data-hide-cover="false" data-show-facepile="true">
                    <blockquote cite="https://www.facebook.com/Clubyerbalitodebabyfutbol" class="fb-xfbml-parse-ignore">
                        <a href="https://www.facebook.com/Clubyerbalitodebabyfutbol">Club Yerbalito Baby Futbol</a>
                    </blockquote>
                </div>

            </div>
        </section>



    </main>

    <footer>

        <?php
        $query = "SELECT * FROM jugador WHERE idcategoria<>10 AND idcategoria<>9 AND idcategoria<>11";
        $result = mysqli_query($db, $query);
        $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $cantJugadores = count($rows);
    ?>

        <div class="footer-content">
            <div class="ingresarA">
                <h2>Cantidad de niñas y niños: <span id="cantidad-finalizadas">
                        <?php echo $cantJugadores ?>
                    </span></h2>
                <!-- contenedor vacío para las que pasen a terminadas -->
                <ul class="tareas-terminadas"></ul>
            </div>

            <ul class="socials">
                <li>
                    <a href="https://www.facebook.com/Clubyerbalitodebabyfutbol" target="_blank"> <i
                            class="fa fa-facebook"></i></a>
                </li>
                <!-- hola@yerbalito.uy -->
                <li>
                    <a href="https://www.instagram.com/clubyerbalitobabyfutbol/" target="_blank"> <i
                            class="fa fa-instagram"></i></a>
                </li>
                <li>
                    <a href="https://api.whatsapp.com/send?phone=59899163200&text=Hola%20Yerbalito" target="_blank"> <i
                            class="fa fa-whatsapp"></i></a>
                </li>

                <li>
                    <a href="mailto:hola@yerbalito.uy?subject=enviado%20desde%20la%20web" target="_blank"> <i
                            class="fa fa-envelope"></i></a>
                </li>

            </ul>
        </div>

        <div class="footer-bottom">
            <p> Este sitio esta diseñado por <a target="_blank" href="http://olimarteam.uy"> <span> olimarteam.uy
                    </span> </p>
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

        <!-- con estoy muestro la hora actual
  <script>
      let d = new Date();
      document.body.innerHTML += "<h1>Time right now is:  " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds()
      "</h1>"
</script>
                -->

</body>

</html>