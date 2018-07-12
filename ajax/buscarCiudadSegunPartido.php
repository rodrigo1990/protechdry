<?php 
require_once("../clases/BaseDatos.php");

$partido=$_POST['partido'];

$bd=new BaseDatos();

	
$bd->buscarCiudadSegunPartido($partido);


 ?>