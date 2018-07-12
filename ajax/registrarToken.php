<?php 
require_once("../clases/BaseDatos.php");
require_once("../clases/Mail.php");

$baseDatos=new BaseDatos();
$mail= new Mail();

$token=md5($_POST["email"]);

$mensaje=$baseDatos->actualizarToken($_POST['email'],$token);

$mail->enviarToken($_POST['email'])


 ?>