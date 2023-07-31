<?php 


session_start();

// Verificar si existe una sesión activa
if (!isset($_SESSION["autentica"])) {
    header("Location: login.php"); // Redireccionar a la página de inicio de sesión si no hay sesión
    exit();
}

?>
<!DOCTYPE  html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Yerbalito </title>

    <!-- ----------------------------- estilos CSS ----------------------------- -->
    <link rel="stylesheet" href="./css/tasksStyles.css">

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


    <!-- ------------------- libreria de iconos Fontawesome -------------------- -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css"
        integrity="sha512-KfkfwYDsLkIlwQp6LFnl8zNdLGxu9YAA1QvwINks4PhcElQSvqcyVLLD9aMhXd13uQjoXtEKNosOWaZqXgel0g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

        <!-- ------------------------- logica de la página ------------------------- -->
    <script src="./scripts/taks.js"></script>

    <!-- favicon -->
    <link rel="shortcut icon" href="favicon.ico">

		<!-- script en java para exportar a excel la tabla de jugadores-->
		<script src="js/tableToExcel.js"></script>
	</head>
	
	<body class="">
	
	
	<!-- WRAPPER -->
	<div id="wrapper">
		
		<!-- HEADER -->
		<div id="header"><!-- Social -->
			<div>
		  		<img src="images/logo3.png" alt="yerbalito" class="header" longdesc="images/logo3.png">        
        	</div>
			<!-- ENDS Social -->
			
			<!-- Navigation --><!-- Navigation -->	
			
			<!-- search --><!-- ENDS search -->
			
			<!-- Breadcrumb--><!-- ENDS Breadcrumb-->	

		</div>
		<!-- ENDS HEADER -->
		

    
    	<!-- MAIN -->
	  <div id="main">   

      
	    <div >
	      <h1>
          
          <form name="filtro" action="<?php echo $PHP_SELF;?>" method="POST">

<a href="panel.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" title="Volver al Panel de control"></a>
 
 <?php if($_SESSION["admin"] != 2) {
		?>
          <a href="insertar_jugador.php"><img src="img/knobs-icons/Knob Add.png" width="32" height="32" longdesc="img/knobs-icons/Knob Add.png" title="Insertar jugador"></a>
          <?php ;} ?>
   		
			<select name="estado" title="Estado">
        	                
					<option value="0">Elige un estado</option>
					<option value="1">Deshabilitado</option>
					<option value="2">Habilitado</option>
					<option value="3">Exonerado</option>
				
            </select>
        
            <select name="categoria" title="Categoria">
           	    
					<option value="0">Elige una categoría</option> 
					<option value="1">Abejitas</option>
					<option value="2">Grillitos</option>
					<option value="3">Chatitas</option>
	       			<option value="4">Churrinches</option>
	            	<option value="5">Gorriones</option>
	                <option value="6">Semillas</option>
    	            <option value="7">Cebollitas</option>
	                <option value="8">Babys</option>                
					<option value="12">Sub 11</option>
					<option value="13">Sub 13</option>
		
            
<!--                <option value="11">Sub-9</option>                -->
<!--                <option value="12">Sub-11</option> -->
              
			</select>
        
			<input type="submit" name="filtrar" value="Filtrar">
            
            
            Listado de jugadores: 
		</form>   
     </h1> 
	           

<table id="testTable" width="100%" cellpadding="2" cellspacing="2">
	        <tr class="blue-box">
			    <td>Nombre</td>
			    <td>Apellido</td>			                    
                <td>Categoria</td>                
			    <td>Estado</td>
			    <td>Ultimo pago</td>
             <!--   <td>Cant. pagos</td> -->
                <td>Ficha</td>
			 </tr>
  
  
  
  
  <?php
  
/*saco la fecha de hoy para buscar solo meses pagos de este año*/
$hoy=getdate();
$mysqli = new mysqli($hostname_yerbalito, $username_yerbalito, $password_yerbalito,$database_yerbalito) or
    die("No se pudo conectar: " . mysql_error());


  
//recibo los criterios y construyo la consulta


if($_POST['estado'])
{
	$estadoJugador = $_POST['estado'];
	$sql="select * from jugador where idestado=".$estadoJugador." AND idcategoria<>10 AND idcategoria<>9 AND idcategoria<>11 ORDER BY idcategoria, nombre";
	mysql_select_db($database_yerbalito, $yerbalito);
	$result=mysql_query($sql,$yerbalito);
}
elseif ($_POST['categoria'])
{
	$categoriaJugador = $_POST['categoria'];
		$sql="select * from jugador where idcategoria=".$categoriaJugador." ORDER BY nombre";
	mysql_select_db($database_yerbalito, $yerbalito);
	$result=mysql_query($sql,$yerbalito);
}

else
	$sql="select * from jugador where idcategoria<>10 AND idcategoria<>9 AND idcategoria<>11 ORDER BY idcategoria, nombre";
	mysql_select_db($database_yerbalito, $yerbalito);
	$result=mysql_query($sql,$yerbalito);
	
if($result && mysql_num_rows($result)>0)
{  
  	 do { ?>
    <tr>
    
    
    <?php
		while($row=mysql_fetch_array($result))
		{
			
		$sql2="select * from categoria WHERE idcategoria=".$row['idcategoria'];
		mysql_select_db($database_yerbalito, $yerbalito);
		$result2=mysql_query($sql2,$yerbalito);
		
		$sql3="select * from estado WHERE idestado=".$row['idestado'];
		mysql_select_db($database_yerbalito, $yerbalito);
		$result3=mysql_query($sql3,$yerbalito);	

		$sql4="select * from recibo WHERE idjugador=".$row['idjugador']." ORDER BY anio DESC,mes_pago DESC";
		mysql_select_db($database_yerbalito, $yerbalito);
		$result4=mysql_query($sql4,$yerbalito);	
		
		$sql5="select * from meses";
		mysql_select_db($database_yerbalito, $yerbalito);
		$result5=mysql_query($sql5,$yerbalito);	
			
		
		$result11 = $mysqli->query("SELECT * FROM recibo WHERE recibo.idjugador =".$row['idjugador']." AND recibo.anio = $hoy[year] AND monto>0");
		$row_cnt = $result11->num_rows;
		
		
		 		while($row2=mysql_fetch_array($result2))
				{
					
					
					?>
    
    
						<td>	<?php echo $row['nombre']; ?> </td>       
         
						<td> <?php echo $row['apellido']; ?></td>    
						
						<td><?php echo $row2['nombre_categoria']; ?></td>           
           
						<td> 
                        
					<?php 
					while($row3=mysql_fetch_array($result3))
						{
					
					if ($row['idestado']==1) { 
					
						
								
							?>
						<span style="background-color:#F00"> <?php echo $row3['tipo_estado']; ?>         </span>
					<?php 
					}
					elseif ($row['idestado']==2) { ?>
						<span style="background-color:#0F0"> <?php echo $row3['tipo_estado']; ?>        </span>
					<?php
					}
					else { ?>
						<span style="background-color:#FF9"> <?php echo $row3['tipo_estado']; ?> </span>
					<?php
					} }
					?>
					</td>  
                    
                    
                    
                    
                    
                    
                    
                    <td>
                    
                    <?php 
					$row4=mysql_fetch_array($result4);
						
							if ($row4['mes_pago']==1) {
								 echo 'SIN PAGOS 2020';
                    		}
							elseif ($row4['mes_pago']==2) {
								 echo FEBRERO;
                    		}
                    		elseif ($row4['mes_pago']==3) {
								 echo MARZO;
                    		}
							elseif ($row4['mes_pago']==4) {
								 echo ABRIL;
                    		}
							elseif ($row4['mes_pago']==5) {
								 echo MAYO;
                    		}
							elseif ($row4['mes_pago']==6) {
								 echo JUNIO;
                    		}
							elseif ($row4['mes_pago']==7) {
								 echo JULIO;
                    		}
							elseif ($row4['mes_pago']==8) {
								 echo AGOSTO;
                    		}
							elseif ($row4['mes_pago']==9) {
								 echo SETIEMBRE;
                    		}
							elseif ($row4['mes_pago']==10) {
								 echo OCTUBRE;
                    		}
							elseif ($row4['mes_pago']==11) {
								 echo ANUAL;
                    		}
							elseif ($row4['mes_pago']==12) {
								 echo ANUAL;
                    		}
                    
					
						
								
							?>
                    
                    </td>
                    
                    
                    
                   <!-- 
					   <td>
                    	<?php 
						/* POR AHORA NO MUESTRO LA CANTIDAD DE PAGOS
                    	echo $row_cnt;
						*/
						?>
                    </td>
						-->
                    
					<td>
						<a href="jugador.php?recordID=<?php echo $row['idjugador']; ?>"><img src="img/knobs-icons/Knob Search.png" width="32" height="32" title="Ver jugador"></a>
					</td>      
				</tr>	
	 <?php  } } } while ($row = mysql_fetch_assoc($result)); 
	 
	 
}
?>
				
          </table>

	      
		</div>	   
        
	  </div>
		<!-- ENDS MAIN -->

  	  <!-- FOOTER -->
	<div id="footer">
	    <a href="salir.php"><img src="img/knobs-icons/Knob Cancel.png" width="32" height="32" title="Cerrar sesion" ></a>       
    
    	<a href="panel.php"><img src="img/knobs-icons/Knob Left.png" width="32" height="32" title="Volver al Panel de control"></a>				
				<!-- footer-cols -->				<!-- ENDS footer-cols -->						
        		<!-- Bottom --> 
           
                <!--
        <a href="" onclick="javascript:tableToExcel('testTable', 'Pagos de jugadores')"><img src="img/knobs-icons/Knob Download.png" width="32" height="32" border="0" title="Exportar a Excel" ></a>
        -->
        
        <!-- esta opcion la ve solo guille y yo -->
         <?php if(($_SESSION["admin"] == 0) or ($_SESSION["admin"] == 1)) {
		?>
			<input type="image" src="img/social-icons/circular/livejournal_32.png" width="32" height="32" onclick="tableToExcel('testTable', 'Pagos de jugadores')" value="Exportar a Excel" title="Exportar a Excel">
          <?php ;} ?>


	  <div id="bottom">
		<a href="http://olimarteam.uy/yerbalito/" >Gestión Yerbalito</a> es un sitio de <a target="_blank" href="http://olimarteam.uy">olimarteam.uy</a>
      </div>
				<!-- ENDS Bottom -->
               
	  </div>
		<!-- ENDS FOOTER -->
	</div>
	<!-- ENDS WRAPPER -->
    
    
     
	
	Usuario: <?php echo $_SESSION["nombre"]; ?>
	</body>
	
</html>

