<?php 
session_start();
require_once("clases/Producto.php");
require_once("clases/BaseDatos.php");
require_once("clases/Mail.php");

if(isset($_GET['operationid'])){
	
	$BaseDatos=new BaseDatos();
	$mail = new Mail();


	$BaseDatos->actualizarIdTpEnVenta($_GET['operationid'],$_SESSION['referencia'],1,2);
		
	$mail->enviarComprobantePagoExitosoTodoPago();

	

session_destroy(); 
}else{
	header("location: index.php");
}
 ?>
 <!DOCTYPE html>
 <html lang="en">
 <head>
 	<meta charset="UTF-8">
		<title>PROTECH</title>

 		<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="jquery/jquery-3.2.1.min.js"></script>
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" media="screen">
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<!-- ESTILOS PROPIOS -->
	<link rel="stylesheet" type="text/css" href="estilos_css/fuentes.css">
	<link rel="stylesheet" type="text/css" href="estilos_css/estilos.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
	<link rel="stylesheet" href="estilos_css/animate.css">


	<!-- FUNCIONES JS -->
	<script type="text/javascript" src="js/script.js"></script>

 </head>
 <body>

<!-- MENU -->
<?php 
	include("include/menu-checkout.php");
 ?>







<div class="row">

	<div class="landing-cont col-xs-12 col-sm-12 col-md-12 col-lg-12">
	 	<h1><b>Te hemos enviado un mail con los detalles de la compra</b</h1>

	 	<h3><a href="index.php"><b>Sigue comprando y enterandote de nuestras ofertas</b></a></h3>
	 	<img src="elementos_separados/logo.png" alt="" class="img-reponsive">
	</div>


</div>


<!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>

 <!-- FOOTER -->
<?php 
include("include/footer.php");
 ?>


 </body>
 </html>