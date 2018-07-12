<?php 
session_start();
require_once("../clases/Producto.php");
require_once("../clases/BaseDatos.php");
$destinatario = $_POST["email"];


$BaseDatos=new BaseDatos();

$BaseDatos->buscarUsuarioEInsertarloEnTabla($_POST['dni'],$_POST['tipo_dni'],ucwords(strtolower($_POST['nombre'])),ucwords(strtolower($_POST['apellido'])),$_POST['calle'],$_POST['altura'],$_POST['cod_area'],$_POST['telefono'],$_POST['email'],$_POST['cp'],$_POST['ciudad'],$_POST['provincia'],$_POST['piso'],$_POST['departamento']);

	
	//Si la validacion del lado del servidor es erronea envia un 1 

$estado_insercion=$BaseDatos->insertarVentaConEnvio(0,$_POST['referencia'],$_POST['email'],date("d-m-y"),0,$_POST['medio_pago']);
	echo $estado_insercion;



 ?>