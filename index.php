<?php 

require_once('Connections/yerbalito.php');
//include('session.php'); //esto lo uso para dar la bienvenida y para cerrar sesion

//include('seguridad.php');  	  
//      include('funciones.php');	
//include('funciones2.php');

$query = "SELECT * FROM jugador WHERE idcategoria<>10 AND idcategoria<>9 AND idcategoria<>11";
$result = mysqli_query($db, $query);
$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
$cantJugadores = count($rows);
    
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8">

    <title>Yerbalito</title>

    <!- ----------------------------- estilos CSS ----------------------------- ->
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
        
    <!- ----------------------------- JS ----------------------------- ->
    <script src="js/provisorio.js"></script>


    <!- ----------------------------- FONT AWESOME ----------------------------- ->
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    

    <!-- fullCalendar 3.8.2-->
    <link rel="stylesheet" href="css/fullcalendar.min.css">
  <!--fullCalendar 3.8.3 -->
  <script src="js/fullcalendar.min.js"></script>
  <script src="js/es.js"></script>

  

    <!- ----------------------------- GOOGLE FONTS ----------------------------- ->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet">    
    <link href="https://fonts.googleapis.com/css2?family=PT+Sans+Narrow&family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Indie+Flower&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico">


    <style>
        
    </style>

   

</head>

<body>
<header>
    <nav class="nav">
      <div class="logo"></div>
    </nav>
    <nav class="nav-menu">
      <ul class="ul">
        <li class="li-inicio">
          <a class="a" href="#">Inicio</a>
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

    <!-- muestro la hora
        <h1 class="main-h1" id="h1">
            
        </h1>
-->
        <p class="p">
            El Club Yerbalito de Baby Fútbol es una Institución que cuenta con más de 45 años de existencia situada en la ciudad de Treinta y Tres y que hace ocho años logró tramitar y obtener la personería jurídica; se dedica a la práctica de fútbol infantil, donde recibe semanalmente a más de 150 niños y niñas, pero hace un par de años viene desarrollando otras actividades conexas en beneficio del crecimiento físico y mental de los niños que en ésta participan, lo cual le permite realizar una tarea social considerada muy importante para la sociedad.
            </p>


           <seccion class="seccion-img-institucional">
            <div class="contenedor-img-institucional">
              <img src="assets/institucion/1.webp" alt="" class="img">
              <img src="assets/institucion/2.webp" alt="" class="img">
              <img src="assets/institucion/3.webp" alt="" class="img">
              <img src="assets/institucion/4.webp" alt="" class="img">
            </div>
           </seccion>

    </main>

    <footer class="footer">

        <div class="footer-content">
            <div class="ingresarA">
                <h2>Cantidad de niñas y niños: <span id="cantidad-finalizadas"><?php echo $cantJugadores ?></span></h2>
                <!-- contenedor vacío para las que pasen a terminadas -->
                <ul class="tareas-terminadas"></ul>
            </div>

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




</body>

</html>