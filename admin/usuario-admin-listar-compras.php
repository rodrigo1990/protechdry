<?php 
require_once("../clases/BaseDatos.php");
require_once("../clases/Usuario.php");
require_once("../clases/Administrador.php");
require_once("../clases/Session.php");


session_start();
$session = new Session();
$session->controlarTiempoDeSesion();

$baseDatos=new BaseDatos();


if($_SESSION['login']==FALSE){
	header("Location:index.php");
}

$admin=new Administrador();


 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="jquery/jquery-3.2.1.min.js"></script>
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" media="screen">
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<!-- ESTILOS PROPIOS -->
	<link rel="stylesheet" type="text/css" href="../estilos_css/fuentes.css">
	<link rel="stylesheet" type="text/css" href="../estilos_css/estilos.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
	<link rel="stylesheet" href="../estilos_css/animate.css">

	<!-- FUNCIONES JS -->
	<script type="text/javascript" src="js/script-admin.js"></script>
</head>

<body>
	<!-- Menu -->
<?php include("include/menu-admin.php");?>
	
	<div class="row">
		<div class="container">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				<h2 class='titulo-listar-usuarios'>Busca el usuario utilizando el buscador del navegador (ctrl+f)</h2>
			</div>
		</div>
	</div>



<div class="row">
<div class="container">	

<?php 
	$admin->listarComprobantes($_GET['email']);
 ?>
</div>
</div>
<!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>
<!-- Footer -->
<?php include("include/footer.php");?>


</body>
</html>