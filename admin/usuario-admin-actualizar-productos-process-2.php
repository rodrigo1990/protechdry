<?php 
require_once("clases/Administrador.php");
require_once("clases/Session.php");


session_start();
$session = new Session();
$session->controlarTiempoDeSesion();



if($_SESSION['login']==FALSE){
	header("Location:index.php");
}

$admin=new Administrador();

$admin->actualizarProducto($_POST['id-admin-input'],$_POST['modelo-admin-input'],$_POST['marca-admin-select'],
	$_POST['ancho-admin-select'],$_POST['alto-admin-select'],$_POST['velocidad-admin-select'],
	$_POST['carga-admin-select'],$_POST['origen-admin-select'],$_POST['rodado-admin-select'],
	$_POST['vehiculo-admin-select'],$_POST['categoria-admin-radio'],$_POST['precio-admin-input'],
	$_POST['precio-descuento-admin-input'],$_POST['destacado-admin-radio'],$_POST['stock-admin-radio'],
	$_POST['titulo-1-admin-input'],$_POST['descripcion-1-admin-input'],$_POST['titulo-2-admin-input'],
	$_POST['descripcion-2-admin-input'],$_POST['titulo-3-admin-input'],$_POST['descripcion-3-admin-input'],
	$_FILES['imagen-1-admin-input']['name'],$_FILES['imagen-2-admin-input']['name'],$_FILES['imagen-3-admin-input']['name'],
	$_FILES['imagen-home-admin-input']['name'],$_FILES['imagen-media-admin-input']['name'],$_FILES['imagen-grande-admin-input']['name']);



	?>

	<!DOCTYPE html>
	<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title>Document</title>
	</head>
	<body>
		<a href="usuario-admin-actualizar-productos.php">Volver al panel de actualizaciones</a>;
	</body>
	</html>