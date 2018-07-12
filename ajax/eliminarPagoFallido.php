<?php 
session_start();
require_once("../clases/BaseDatos.php");

$BaseDatos=new BaseDatos();

$BaseDatos->eliminarPagoFallido($_POST['referencia']);
 

 ?>