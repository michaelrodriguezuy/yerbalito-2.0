<?php 

session_start();

// Verificar si existe una sesión activa
if (!isset($_SESSION["autentica"])) {
    header("Location: login.php"); // Redireccionar a la página de inicio de sesión si no hay sesión
    exit();
}

mysql_select_db($database_yerbalito, $yerbalito);


$query_DatosLibreta = "SELECT libretas.idlibreta, libretas.numeracion, libretas.fin, libretas.observacionesLibreta FROM libretas";

$DatosLibreta = mysql_query($query_DatosLibreta, $yerbalito) or die(mysql_error());
$row_DatosLibreta = mysql_fetch_assoc($DatosLibreta);
$totalRows_DatosLibreta = mysql_num_rows($DatosLibreta);
?>

<!DOCTYPE  html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Gestion Yerbalito</title>
		
		<!-- CSS -->
		<link rel="stylesheet" href="css/style1.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/social-icons.css" type="text/css" media="screen" />
		<!--[if IE 8]>
			<link rel="stylesheet" type="text/css" media="screen" href="/css/ie8-hacks.css" />
		<![endif]-->
		<!-- ENDS CSS -->	
				
		<!-- GOOGLE FONTS -->
		<link href='http://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'>
		
		<!-- JS -->
		<script type="text/javascript" src="js/jquery-1.5.1.min.js"></script>
		<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
		<script type="text/javascript" src="js/easing.js"></script>
		<script type="text/javascript" src="js/jquery.scrollTo-1.4.2-min.js"></script>
		<script type="text/javascript" src="js/quicksand.js"></script>
		<script type="text/javascript" src="js/jquery.cycle.all.js"></script>
		<script type="text/javascript" src="js/custom.js"></script>
		<!--[if IE]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
		<!--[if IE 6]>
			<script type="text/javascript" src="js/DD_belatedPNG.js"></script>
			<script>
	      		/* EXAMPLE */
	      		//DD_belatedPNG.fix('*');
	    	</script>
		<![endif]-->
		<!-- ENDS JS -->
		
		
		<!-- Nivo slider -->
		<link rel="stylesheet" href="css/nivo-slider.css" type="text/css" media="screen" />
		<script src="js/nivo-slider/jquery.nivo.slider.js" type="text/javascript"></script>
		<!-- ENDS Nivo slider -->
		
		<!-- tabs -->
		<link rel="stylesheet" href="css/tabs.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/tabs.js"></script>
  		<!-- ENDS tabs -->
  		
  		<!-- prettyPhoto -->
		<script type="text/javascript" src="js/prettyPhoto/js/jquery.prettyPhoto.js"></script>
		<link rel="stylesheet" href="js/prettyPhoto/css/prettyPhoto.css" type="text/css" media="screen" />
		<!-- ENDS prettyPhoto -->
		
		<!-- superfish -->
		<link rel="stylesheet" media="screen" href="css/superfish.css" /> 
		<link rel="stylesheet" media="screen" href="css/superfish-left.css" /> 
		<script type="text/javascript" src="js/superfish-1.4.8/js/hoverIntent.js"></script>
		<script type="text/javascript" src="js/superfish-1.4.8/js/superfish.js"></script>
		<script type="text/javascript" src="js/superfish-1.4.8/js/supersubs.js"></script>
		<!-- ENDS superfish -->
		
		<!-- poshytip -->
		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-twitter/tip-twitter.css" type="text/css" />
		<link rel="stylesheet" href="js/poshytip-1.0/src/tip-yellowsimple/tip-yellowsimple.css" type="text/css" />
		<script type="text/javascript" src="js/poshytip-1.0/src/jquery.poshytip.min.js"></script>
		<!-- ENDS poshytip -->
		
		<!-- Tweet -->
		<link rel="stylesheet" href="css/jquery.tweet.css" media="all"  type="text/css"/> 
		<script src="js/tweet/jquery.tweet.js" type="text/javascript"></script> 
		<!-- ENDS Tweet -->
		
		<!-- Fancybox -->
		<link rel="stylesheet" href="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/jquery.fancybox-1.3.4/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
		<!-- ENDS Fancybox -->
		
		<!-- SKIN -->
		<link rel="stylesheet" href="skins/plastic/style.css" type="text/css" media="screen" />

 <!-- favicon-->
		<link rel="shortcut icon" href="favicon.ico" >

	</head>
	
	<body class="">
	
	
	<!-- WRAPPER -->
	<div id="wrapper">
		
		<!-- HEADER -->
		<div id="header"><!-- Social -->
			<div align="center">
		  <img src="images/logo3.png" alt="yerbalito" class="header" longdesc="images/logo.png" hspace="0" vspace="0" border="0" >        
        </div>
			<!-- ENDS Social -->
			
			<!-- Navigation --><!-- Navigation -->	
			
			<!-- search --><!-- ENDS search -->
			
			<!-- Breadcrumb--><!-- ENDS Breadcrumb-->	

		</div>
		<!-- ENDS HEADER -->
		

    
    	<!-- MAIN -->
	  <div id="main">   

      
	    <div align="center">
	      <h1> 
          
		  <?php if($_SESSION["admin"] != 2) {
		?>
          <a href="insertar_libreta.php" ><img src="img/knobs-icons/Knob Add.png" width="32" height="32" longdesc="img/knobs-icons/Knob Add.png" title="Insertar libreta"></a> 
          <?php ;} ?>
          
          Listado de libretas: </h1>       
         
	           

<table width="100%" border="0"cellpadding="2" cellspacing="2">
	        <tr class="blue-box">
			    <td>ID libreta</td>
			    <td>Numeración</td>			           
			    <td>Finalizada</td>
   			    <td>Observaciones</td>
            	<td>Acciones</td>      
			 </tr>
  
  <?php do { ?>
    <tr>
      <td><?php echo $row_DatosLibreta['idlibreta']; ?></td>       
         
      <td><?php echo $row_DatosLibreta['numeracion']; ?></td>    
    
                      
      <td> 
      
       <?php if ($row_DatosLibreta['fin'] == 0) {?> 
       			NO <?php }  
			 else {?> SI <?php ;}?>     
      
      
       </td>                  
      <td><?php echo $row_DatosLibreta['observacionesLibreta']; ?></td>

      <td>
      
       <?php if($_SESSION["admin"] != 2) {
		?>
	     <a href="modificar_libreta.php?recordID=<?php echo $row_DatosLibreta['idlibreta']; ?>"><img src="img/knobs-icons/Knob Smart.png" width="32" height="32" border="0" title="Modificar libreta"></a>  
         <?php ;}?>
      
      </td>      
    </tr>
    <?php } while ($row_DatosLibreta = mysql_fetch_assoc($DatosLibreta)); ?>
          </table>

	      
		</div>	   
        
	  </div>
		<!-- ENDS MAIN -->

  	  <!-- FOOTER -->
	<div id="footer">
    <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" border="0" title="Cerrar sesion" ></a> <a href="panel.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" border="0" title="Volver al Panel de control"></a>				
				<!-- footer-cols -->				<!-- ENDS footer-cols -->				
				<!-- Bottom -->
				<div id="bottom">
				<a href="http://olimarteam.uy/yerbalito/" >Gestión Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.uy">olimarteam.uy</a></div>
				<!-- ENDS Bottom -->
	  </div>
		<!-- ENDS FOOTER -->
	
	</div>
	<!-- ENDS WRAPPER -->
	Usuario: <?php echo $_SESSION["nombre"]; ?>
	</body>
	
</html>
<?php
mysql_free_result($DatosLibreta);

?>
