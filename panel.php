<?php 

session_start();

// Verificar si existe una sesión activa
if (!isset($_SESSION["autentica"])) {
    header("Location: login.php"); // Redireccionar a la página de inicio de sesión si no hay sesión
    exit();
}
require_once('Connections/yerbalito.php');

include('funciones2.php');

//	  include 'funciones.php?banderaDeudores=1';

//HABILITAR
//actualizaDeudores(); //los que estan al dia y deberian pasar a deudores

	// actualizaDeudores2(); // los que estan deudores y deberian pasar a habilitados

    //este codigo es para mostrar la cantidad de jugadores actualmente
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
    <!--<script src="js/provisorio.js"></script>
    <script src="js/utils.js"></script>-->


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


</head>

<body>
    <header>
        <nav class="nav">

            <div class="logo">

            </div>
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
                               <!--<li class="li"><a class="a" href="login.php">Login</a></li>-->
                             </ul>

                             
            </nav>

            <div class="user-info">                
                                <p>Bienvenido <span class="span">  <?php echo $_SESSION["nombre"]; ?> </span></p>
                                <div class="user-image"></div>
                                <button id="closeApp" onclick="window.location.href='logout.php'"> <i class="fa-solid fa-right-from-bracket"></i> Cerrar sesión </button>
                            </div>
            
    </header>

    <!-- MAIN -->
    <main class="container">
        <section id="listaTareas">
            <article class="articulo">
                <a href="listado_jugadores.php"> <img src="img/mono-icons/user32.png" width="32" height="32"
                        title="Ver jugadores"></a>JUGADORES
                <hr>
            </article>
            <?php if($_SESSION["admin"] != 3) { ?>
            <article class="articulo">
                <a href="listado_categorias.php"><img src="img/knobs-icons/Knob Search.png" width="32" height="32"
                        title="Ver categorias"></a>CATEGORIAS
                <hr>
                <?php }?>
            </article>
            <?php if($_SESSION["admin"] == 1) { ?>
            <article class="articulo">
                <a href="listado_libretas.php"><img src="img/knobs-icons/Knob Search.png" width="32" height="32"
                        title="Ver libretas recibo"></a>LIBRETAS
                <hr>
            </article>
            <?php }?>
            <article class="articulo">
                <a href="listado_recibos.php"><img src="img/knobs-icons/Knob Search.png" width="32" height="32"
                        title="Ver cuotas"></a>CUOTAS CLUB
                <hr>
            </article>
            <article class="articulo">
                <a href="listado_fondo.php"><img src="img/knobs-icons/Knob Search.png" width="32" height="32"
                        title="Ver cuotas"></a>FONDO DE CAMPEONATO
                <hr>
            </article>
            <article class="articulo">
                <!-- ver si es un administrador muestro la opcion sino no -->
                <?php if($_SESSION["admin"] == 1) {?>
                <a href="listado_usuarios.php"><img src="img/knobs-icons/Knob Search.png" width="32" height="32"
                        title="Ver usuarios"></a>USUARIOS
                <hr>
                <?php ;}?>
            </article>
            <article class="articulo">
                <?php if(($_SESSION["admin"] == 0) or ($_SESSION["admin"] == 1)) {
                	?>
                <a href="reportes.php"><img src="img/knobs-icons/Knob Search.png" width="32" height="32"
                        title="Realizar reportes"></a>REPORTES
                <hr>
                <?php ;} ?>
            </article>

            <article class="articulo">
                <a href="logout.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32"
                        title="Cerrar sesion"></a>SALIR
            </article>
        </section>

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



    <!-- con esto muestro la hora actual
  <script>
      let d = new Date();
      document.body.innerHTML += "<h1>Time right now is:  " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds()
      "</h1>"
</script>
                -->

</body>

</html>