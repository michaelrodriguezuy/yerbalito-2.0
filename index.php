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

    <!- ----------------------------- estilos CSS ----------------------------- -->
    <link rel="stylesheet" href="css/style.css">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"> -->
        
    <!- ----------------------------- JS ----------------------------- -->
    <script src="js/provisorio.js"></script>


    <!- ----------------------------- FONT AWESOME ----------------------------- -->
    <script src="https://kit.fontawesome.com/2c36e9b7b1.js" crossorigin="anonymous"></script>
    



    <!- ----------------------------- GOOGLE FONTS ----------------------------- -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Signika+Negative:wght@400;700&display=swap" rel="stylesheet">

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico">


    <style>
        
    </style>

   

</head>

<body>
    <header>
        <nav class="nav">

            <div class="logo">

            </div>
            

        </nav>      

    </header>

    <!-- MAIN -->
    <main class="main">

        <h1 class="main-h1" id="h1">

        </h1>

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
                    <a href="https://www.instagram.com/clubyerbalitobabyfutbol/" target="_blank"> <i
                            class="fa fa-instagram"></i></a>
                </li>
                <li>
                    <a href="https://api.whatsapp.com/send?phone=59899163200&text=Hola%20Yerbalito" target="_blank"> <i
                            class="fa fa-whatsapp"></i></a>
                </li>
                <li>
                    <a href="mailto:hola@yerbalito.uy?subject=enviado%20desde%20la%20web" target="_blank"> <i
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