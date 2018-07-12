<?php 
session_start();
require_once("../clases/BaseDatos.php");

$baseDatos=new BaseDatos();

$mensaje=$baseDatos->verificarTipoUsuario($_POST['email']);


if($mensaje==FALSE){
echo "FALSE";
}else{
echo "TRUE";
}




 ?>