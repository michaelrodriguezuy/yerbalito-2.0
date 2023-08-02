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
            <div class="column">
            <article class="articulo">
                <a href="listado_jugadores.php">                 <svg class="svg-panel" width="512" height="512"  viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M128 29.5c-6.557 0-12.898 3.62-18.146 10.924C104.604 47.728 101 58.51 101 70.596c0 12.085 3.605 22.866 8.854 30.17c5.248 7.303 11.59 10.923 18.146 10.923c6.557 0 12.898-3.62 18.146-10.924c5.25-7.304 8.854-18.085 8.854-30.17c0-12.086-3.605-22.868-8.854-30.172C140.898 33.12 134.556 29.5 128 29.5zm256 0c-6.557 0-12.898 3.62-18.146 10.924C360.604 47.728 357 58.51 357 70.596c0 12.085 3.605 22.866 8.854 30.17c5.248 7.303 11.59 10.923 18.146 10.923c6.557 0 12.898-3.62 18.146-10.924c5.25-7.304 8.854-18.085 8.854-30.17c0-12.086-3.605-22.868-8.854-30.172C396.898 33.12 390.556 29.5 384 29.5zm-235.736 93.912c-5.99 3.932-12.87 6.277-20.264 6.277c-7.25 0-13.996-2.26-19.902-6.053l-2.67 2.67c.905 4.4 3.467 9.56 7.77 15.298c3.93 5.24 9.223 10.835 14.802 16.532c5.58-5.697 10.87-11.292 14.8-16.532c4.402-5.868 6.963-11.122 7.81-15.584l-2.346-2.608zm215.472 0l-2.345 2.61c.846 4.46 3.408 9.715 7.81 15.583c3.93 5.24 9.22 10.835 14.8 16.532c5.58-5.697 10.87-11.292 14.8-16.532c4.305-5.74 6.867-10.9 7.772-15.298l-2.67-2.67c-5.906 3.792-12.653 6.052-19.902 6.052c-7.395 0-14.273-2.346-20.264-6.278zM88.998 134.826l-31.93 10.643c.077 28.387 1.13 55.42 13.496 82.132c43.338 13.938 71.534 13.938 114.872 0c12.367-26.712 13.42-53.745 13.496-82.133l-31.93-10.644c-2.11 6.28-5.692 12.1-9.803 17.58c-6.577 8.768-14.837 16.963-22.837 24.963L128 183.733l-6.363-6.365c-8-8-16.26-16.196-22.836-24.964c-4.11-5.48-7.693-11.3-9.802-17.58zm256 0l-31.93 10.643c.077 28.387 1.13 55.42 13.496 82.132c43.338 13.938 71.534 13.938 114.872 0c12.367-26.712 13.42-53.745 13.496-82.133l-31.93-10.644c-2.11 6.28-5.692 12.1-9.803 17.58c-6.577 8.768-14.837 16.963-22.837 24.963L384 183.733l-6.363-6.365c-8-8-16.26-16.196-22.836-24.964c-4.11-5.48-7.693-11.3-9.802-17.58zM18 146.5v36h22.44c-1.203-12.188-1.39-24.202-1.422-36H18zm198.982 0c-.03 11.798-.22 23.812-1.42 36h80.878c-1.203-12.188-1.39-24.202-1.422-36h-78.036zm256 0c-.03 11.798-.22 23.812-1.42 36H494v-36h-21.018zM73 247.24v63.45c5.94 4.56 14.298 7.316 23 7.316c8.627 0 17.07-2.6 23-7.086v-27.914h18v27.914c5.93 4.487 14.373 7.086 23 7.086c8.702 0 17.06-2.757 23-7.317v-63.45c-39.33 11.437-70.67 11.437-110 0zm256 0v63.45c5.94 4.56 14.298 7.316 23 7.316c8.627 0 17.07-2.6 23-7.086v-27.914h18v27.914c5.93 4.487 14.373 7.086 23 7.086c8.702 0 17.06-2.757 23-7.317v-63.45c-39.33 11.437-70.67 11.437-110 0zm-210 84.252c-7.228 3.056-15.142 4.514-23 4.514c-7.847 0-15.77-1.42-23-4.45v27.364c5.93 4.487 14.373 7.086 23 7.086s17.07-2.6 23-7.086v-27.428zm18 0v27.428c5.93 4.487 14.373 7.086 23 7.086s17.07-2.6 23-7.086v-27.363c-7.23 3.03-15.153 4.45-23 4.45c-7.858 0-15.772-1.46-23-4.515zm238 0c-7.228 3.056-15.142 4.514-23 4.514c-7.847 0-15.77-1.42-23-4.45v27.364c5.93 4.487 14.373 7.086 23 7.086s17.07-2.6 23-7.086v-27.428zm18 0v27.428c5.93 4.487 14.373 7.086 23 7.086s17.07-2.6 23-7.086v-27.363c-7.23 3.03-15.153 4.45-23 4.45c-7.858 0-15.772-1.46-23-4.515zm-274 48c-7.228 3.056-15.142 4.514-23 4.514c-6.4 0-12.813-1.076-18.898-3.068c1.1 3.693 2.132 7.308 3.437 11.222c2.93 8.792 6.073 17.492 7.564 25.846H119v-38.514zm18 0v24.373a64.622 64.622 0 0 1 18.723-20.02c-6.43-.438-12.806-1.85-18.723-4.353zm238 0c-7.228 3.056-15.142 4.514-23 4.514c-6.4 0-12.813-1.076-18.898-3.068c1.1 3.693 2.132 7.308 3.437 11.222c2.93 8.792 6.073 17.492 7.564 25.846H375v-38.514zm18 0v38.514h30.896c1.49-8.354 4.634-17.054 7.565-25.846c1.306-3.914 2.34-7.53 3.438-11.223c-6.085 1.993-12.497 3.07-18.898 3.07c-7.858 0-15.772-1.46-23-4.515zM192 390.5c-25.512 0-46 20.488-46 46s20.488 46 46 46s46-20.488 46-46s-20.488-46-46-46zM89 436.006v44h56.156C134.526 468.57 128 453.274 128 436.5c0-.166.01-.33.012-.494H89zm256 0v44h78v-44h-78z"/>
</svg> </a>
                <hr>



            </article>
            <?php if($_SESSION["admin"] != 3) { ?>
            <article class="articulo">
                <a href="listado_categorias.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M29 10h-5v2h5v6h-7v2h3v2.142a4 4 0 1 0 2 0V20h2a2.003 2.003 0 0 0 2-2v-6a2.002 2.002 0 0 0-2-2zm-1 16a2 2 0 1 1-2-2a2.003 2.003 0 0 1 2 2zM19 6h-5v2h5v6h-7v2h3v6.142a4 4 0 1 0 2 0V16h2a2.002 2.002 0 0 0 2-2V8a2.002 2.002 0 0 0-2-2zm-1 20a2 2 0 1 1-2-2a2.003 2.003 0 0 1 2 2zM9 2H3a2.002 2.002 0 0 0-2 2v6a2.002 2.002 0 0 0 2 2h2v10.142a4 4 0 1 0 2 0V12h2a2.002 2.002 0 0 0 2-2V4a2.002 2.002 0 0 0-2-2zM8 26a2 2 0 1 1-2-2a2.002 2.002 0 0 1 2 2zM3 10V4h6l.002 6z"/>
</svg></a>
                <hr>
                <?php }?>
            </article>
            <?php if($_SESSION["admin"] == 1) { ?>
            <article class="articulo">
                <a href="listado_libretas.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 14h8m-8-4h2m-2 8h4M10 3H6a2 2 0 0 0-2 2v15a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V5a2 2 0 0 0-2-2h-3.5M10 3V1m0 2v2"/>
</svg></a>
                <hr>
            </article>
            <?php }?>

            </div>

            <div class="column">
            <article class="articulo">
                <a href="listado_recibos.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M11.1 19h1.75v-1.25q1.25-.225 2.15-.975t.9-2.225q0-1.05-.6-1.925T12.9 11.1q-1.5-.5-2.075-.875T10.25 9.2q0-.65.463-1.025T12.05 7.8q.8 0 1.25.387t.65.963l1.6-.65q-.275-.875-1.012-1.525T12.9 6.25V5h-1.75v1.25q-1.25.275-1.95 1.1T8.5 9.2q0 1.175.688 1.9t2.162 1.25q1.575.575 2.188 1.025t.612 1.175q0 .825-.588 1.213t-1.412.387q-.825 0-1.463-.512T9.75 14.1l-1.65.65q.35 1.2 1.088 1.938T11.1 17.7V19Zm.9 3q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Zm0-2q3.35 0 5.675-2.325T20 12q0-3.35-2.325-5.675T12 4Q8.65 4 6.325 6.325T4 12q0 3.35 2.325 5.675T12 20Zm0-8Z"/>
</svg></a>
                <hr>
            </article>
            <article class="articulo">
                <a href="listado_fondo.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 26 26" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M12.875 2a1 1 0 0 0-.594.313L5.687 9H1c-.6 0-1 .4-1 1v2c0 .6.4 1 1 1h.094l2.718 9.313c.1.4.5.687 1 .687h16.5c.4 0 .8-.288 1-.688L25 13c.6 0 1-.4 1-1v-2c0-.6-.4-1-1-1h-4.594L13.72 2.281A1 1 0 0 0 12.875 2zM13 4.438L17.594 9H8.5L13 4.437zm4.563 7.343c.2 0 .38.069.53.219l.72.688c.3.3.3.824 0 1.124l-6 6c-.3.3-.825.3-1.126 0l-3.374-3.406c-.3-.3-.3-.793 0-1.093l.687-.72c.3-.3.794-.3 1.094 0l2.219 2.22L17 12a.798.798 0 0 1 .563-.219z"/>
</svg></a>
                <hr>
            </article>
            <article class="articulo">
                <!-- ver si es un administrador muestro la opcion sino no -->
                <?php if($_SESSION["admin"] == 1) {?>
                <a href="listado_usuarios.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 15 15" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M5.5 0a3.499 3.499 0 1 0 0 6.996A3.499 3.499 0 1 0 5.5 0Zm-2 8.994a3.5 3.5 0 0 0-3.5 3.5v2.497h11v-2.497a3.5 3.5 0 0 0-3.5-3.5h-4Zm9 1.006H12v5h3v-2.5a2.5 2.5 0 0 0-2.5-2.5Z"/>
    <path fill="currentColor" d="M11.5 4a2.5 2.5 0 1 0 0 5a2.5 2.5 0 0 0 0-5Z"/>
</svg></a>
                <hr>
                <?php ;}?>
            </article>
            <article class="articulo">
                <?php if(($_SESSION["admin"] == 0) or ($_SESSION["admin"] == 1)) {
                	?>
                <a href="reportes.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <path fill="currentColor" d="M17.45 15.18L22 7.31V21H2V3h2v12.54L9.5 6L16 9.78l4.24-7.33l1.73 1l-5.23 9.05l-6.51-3.75L4.31 19h2.26l4.39-7.56l6.49 3.74Z"/>
</svg></a>
                <hr>
                <?php ;} ?>
            </article>

            <article class="articulo">
                <a href="logout.php"><svg class="svg-panel" width="512" height="512" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
    <g fill="currentColor">
        <path d="M9.052 4.5C9 5.078 9 5.804 9 6.722v10.556c0 .918 0 1.644.052 2.222H8c-2.357 0-3.536 0-4.268-.732C3 18.035 3 16.857 3 14.5v-5c0-2.357 0-3.536.732-4.268C4.464 4.5 5.643 4.5 8 4.5h1.052Z" opacity=".5"/>
        <path fill-rule="evenodd" d="M9.707 2.409C9 3.036 9 4.183 9 6.476v11.048c0 2.293 0 3.44.707 4.067c.707.627 1.788.439 3.95.062l2.33-.406c2.394-.418 3.591-.627 4.302-1.505c.711-.879.711-2.149.711-4.69V8.948c0-2.54 0-3.81-.71-4.689c-.712-.878-1.91-1.087-4.304-1.504l-2.328-.407c-2.162-.377-3.243-.565-3.95.062Zm3.043 8.545c0-.434-.336-.785-.75-.785s-.75.351-.75.784v2.094c0 .433.336.784.75.784s.75-.351.75-.784v-2.094Z" clip-rule="evenodd"/>
    </g>
</svg></a>
            </article>
            </div>
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