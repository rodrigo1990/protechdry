<?php 
require_once("../clases/Administrador.php");
require_once("../clases/Session.php");

session_start();
$session = new Session();
$session->controlarTiempoDeSesion();




if($_SESSION['login']==FALSE){
	header("Location:index.php");
}

$admin = new Administrador();

$admin->actualizarEstadoVenta($_GET['comprobante'],$_GET['estado']);

header("Location:usuario-admin-ventas.php");

 ?>