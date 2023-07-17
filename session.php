<?php
   include('control.php');
   session_start();
   
   $user_check = $_SESSION['login_user'];

   $ses_sql = $db-> query("select usuario from usuario where nombre ='". $user_check."'"); 
   //me trae el usuario de ese nombre

   $login_session = '';

   if($ses_sql->num_rows == 1) {
    $login_session = $ses_sql->fetch_object()->usuario;    
   }
   
   if(!isset($_SESSION['login_user'])){
      header("location:index.php");
      die();
   }
?>