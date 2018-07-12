<?php 
require_once("clases/BaseDatos.php");
require_once("clases/Usuario.php");
require_once("clases/Administrador.php");
require_once("clases/Session.php");


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
	<link rel="stylesheet" type="text/css" href="estilos_css/fuentes.css">
	<link rel="stylesheet" type="text/css" href="estilos_css/estilos.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
	<link rel="stylesheet" href="estilos_css/animate.css">


</head>

<body>
	<!-- Menu -->
<?php include("include/menu-admin.php");?>
	
	<div class="row">
		<div class="container">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
				<form id='form-actualizar-ver-mas-admin' name='form-actualizar-ver-mas-admin' action="usuario-admin-actualizar-productos-process.php" method='POST'>

					<label class='label-admin' for="destacado-admin-checkbox">¿Es destacado?</label><br><br>

					<input type="radio"  name='destacado-admin-actualizar-checkbox' value="1"> Si<br>
  					<input type="radio"  name='destacado-admin-actualizar-checkbox' value="0"> No<br>

					<label class='label-admin' for="destacado-admin-checkbox">¿Tiene stock?</label><br><br>
					<input type="radio"  name='stock-admin-actualizar-checkbox' value="1"> Si<br>
  					<input type="radio"  name='stock-admin-actualizar-checkbox' value="0"> No<br><br>
					
					<label class='label-admin' for="precio-admin-actualizar-checkbox">Ingrese precio</label><br><br>
					<input type="text" class='input-text-actualizar' name='precio-admin-actualizar-checkbox' id="precio-admin-actualizar-checkbox"><br>
					
					<label class='label-admin' for="precio-admin-actualizar-checkbox">Ingrese precio con descuento</label><br><br>
					<input type="text" class='input-text-actualizar' name='precio-descuento-admin-actualizar-checkbox' id="precio-descuento-admin-actualizar-checkbox"><br><br>

					<?php echo "<input type='hidden' name='id' id='id' value='".$_GET['id']."'>" ?>

					<a id='submit-admin-form-actualizar' onClick='submitform();' class='carrito-checkout-btn'>Actualizar</a><br><br>
				</form>
			</div>
		</div>
	</div>



<div class="row">
<div class="container">

	<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>

		<?php echo "<a  href='usuario-admin-eliminar-producto.php?id=".$_GET['id']."'><h1 id='eliminar-producto'>ELIMINAR</h1></a>" ?>
		
	</div>

</div>
</div>
<!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>
<!-- Footer -->
<?php include("include/footer.php");?>

<script>
	function submitform(){
			 document.forms["form-actualizar-ver-mas-admin"].submit();
			}
</script>

	<!-- FUNCIONES JS -->
	<script type="text/javascript" src="js/script-admin.js"></script>

</body>
</html>