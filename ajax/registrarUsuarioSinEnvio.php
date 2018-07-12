<?php 
session_start();
require_once("../clases/Producto.php");
require_once("../clases/BaseDatos.php");
$destinatario = $_POST["email"];

$BaseDatos=new BaseDatos();

$BaseDatos->buscarUsuarioEInsertarloEnTablaSinEnvio($_POST['dni'],$_POST['tipo_dni'],ucwords(strtolower($_POST['nombre'])),ucwords(strtolower($_POST['apellido'])),$_POST['cod_area'],$_POST['telefono'],$_POST['email'],1);

	
//Si la validacion del lado del servidor es erronea envia un 1 
$BaseDatos->insertarVenta(0,$_POST['referencia'],$_POST['email'],date("d-m-y"),0,$_POST['medio_pago']);




 ?>