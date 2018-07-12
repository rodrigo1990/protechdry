<?php 
session_start();
require_once("../clases/BaseDatos.php");

$baseDatos=new BaseDatos();

$mensaje=$baseDatos->validarUsuario($_POST['email'],md5($_POST['contrasenia']));

$_SESSION['pass']=md5($_POST['contrasenia']);

if($mensaje==TRUE){
echo "TRUE";
}else{
echo "FALSE";
}




 ?>