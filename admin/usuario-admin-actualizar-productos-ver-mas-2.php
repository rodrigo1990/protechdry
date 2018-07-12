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
	<!-- SCRIPT -->
	<script type="text/javascript" src="js/script.js"></script>

</head>

<body>
	<!-- Menu -->
<?php include("include/menu-admin.php");?>
	
	<div class="row">
		<div class="container">
			<form id='admin-actualizacion-producto' name="admin-actualizacion-producto" method='POST' enctype="multipart/form-data" action="usuario-admin-actualizar-productos-process-2.php">

		<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
			
				
				<input type="hidden" value="<?php echo $_GET['id']; ?>" name="id-admin-input" id="id-admin-input">
				<input placeholder="Ingrese modelo" class='form-admin-input' type="text" name='modelo-admin-input' id='modelo-admin-input' value="<?php $baseDatos->buscarModeloEstablecido($_GET['id']); ?>">
				<br>
				<select class='form-admin-input' name="marca-admin-select" id="marca-admin-select" value="">
				<?php $baseDatos->listarMarcaEstablecida($_GET['id']); ?>	
				</select><br>


				<select class='form-admin-input' name="ancho-admin-select" id="ancho-admin-select">
				<option value="0" selected='selected'>Seleccione ancho</option>	
				<?php $baseDatos->listarAnchoEstablecido($_GET['id']); ?>
				</select><br>

			
		</div>

			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
			
			

				<select class='form-admin-input' name="alto-admin-select" id="alto-admin-select">
				<option value="0" selected='selected'>Seleccione alto</option>	
				<?php $baseDatos->listarAltoEstablecido($_GET['id']); ?>
				</select><br>

				<select class='form-admin-input' name="velocidad-admin-select" id="velocidad-admin-select" >
				<option value="0" selected='selected'>Seleccione velocidad</option>	
				<?php $baseDatos->listarVelocidadEstablecida($_GET['id']); ?>
				</select><br>

				<select class='form-admin-input' name="carga-admin-select" id="carga-admin-select">
				<option value="0" selected='selected'>Seleccione carga</option>	
				<?php $baseDatos->listarCargaEstablecida($_GET['id']); ?>

				</select><br>

			
		</div>


			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
			
			

				<select class='form-admin-input' name="origen-admin-select" id="origen-admin-select">
				<option value="0" selected='selected'>Seleccione origen</option>
				<?php $baseDatos->listarOrigenEstablecido($_GET['id']); ?>	
				</select><br>
				
				<select class='form-admin-input' name="rodado-admin-select" id="rodado-admin-select">
				<option value="0" selected='selected'>Seleccione rodado</option>
				<?php $baseDatos->listarRodadoEstablecido($_GET['id']); ?>	
				</select><br>

				<select class='form-admin-input' name="vehiculo-admin-select" id="vehiculo-admin-select">
				<option value="0" selected='selected'>Seleccione vehiculo</option>
				<?php $baseDatos->listarTipoVehiculoEstablecido($_GET['id']); ?>	
				</select><br>
				
				<!-- LISTA RADIO BUTTONS ESTABLECIDOS EN LA BD -->
				<?php $baseDatos->listarCategoriaEstablecida($_GET['id']) ?>
			
		</div>
</div>
</div>
	<div class="row">
		<div class="container">
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
					
					<label class='label-admin' class='form-admin-input' for="precio-admin-input">Ingrese precio</label><br>
					<input class='form-admin-input' type="text" name='precio-admin-input' id='precio-admin-input' placeholder='Ej:5000.75' value="<?php $baseDatos->buscarPrecioEstablecido($_GET['id']); ?>">

					<label class='label-admin' class='form-admin-input' for="precio-descuento-admin-input">Ingrese precio en oferta</label><br>
					<input class='form-admin-input' type="text" name='precio-descuento-admin-input' placeholder="Ej:250.70" id='precio-descuento-admin-input'value="<?php $baseDatos->buscarPrecioDescuentoEstablecido($_GET['id']); ?>">

				
			</div>
				<div class='col-xs-8 col-sm-8 col-md-8 col-lg-8'>

				<label class='label-admin' for="destacado-admin-checkbox">¿Es destacado?</label><br>
				<?php $baseDatos->listarDestacadoEstablecido($_GET['id']);?><br>
				
				<label class='label-admin' for="destacado-admin-checkbox">¿Tiene stock?</label><br>
				<?php $baseDatos->listarStockEstablecido($_GET['id']);?>

				
			</div>
		</div>
	</div>

	<div class="row">
		<div class="container">
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
					
					 <label class='label-admin' class='form-admin-input' for="titulo-1-admin-input">Ingrese titulo 1</label><br>
					<input type="text" class='form-admin-input'  name='titulo-1-admin-input' id='titulo-1-admin-input' value="<?php $baseDatos->buscarTitulo1Establecido($_GET['id']); ?>"><br> 

					<label class='label-admin' class='form-admin-input' for="imagen-1-admin-input">Ingrese imagen 1</label><br>
					<input type="file" class='form-admin-input'  name='imagen-1-admin-input' id='imagen-1-admin-input'><br>

					<p class='texto-admin-aclaracion-subida'> ¡Ingrese nombres sin espacios! </p>
					<p class='texto-admin-aclaracion-subida'> 408 x 216 px aprox </p>
					<p class='texto-admin-aclaracion-subida'>JPG, PNG, GIF - 2000KB</p>

					 <label class='label-admin' class='form-admin-input' for="descripcion-1-admin-input">Ingrese descripcion 1</label><br>
					<textarea class='form-admin-input'  name='descripcion-1-admin-input' id='descripcion-1-admin-input' value=""><?php $baseDatos->buscarDescripcion1Establecida($_GET['id']); ?></textarea>
					 
			</div>

				<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
				 	
						<label class='label-admin' class='form-admin-input' for="titulo-2-admin-input">Ingrese titulo 2</label><br>
					<input type="text" class='form-admin-input'  name='titulo-2-admin-input' id='titulo-2-admin-input'value="<?php $baseDatos->buscarTitulo2Establecido($_GET['id']); ?>">

						
					<label class='label-admin' class='form-admin-input' for="imagen-2-admin-input">Ingrese imagen 2</label><br>
					<input type="file" class='form-admin-input'  name='imagen-2-admin-input' id='imagen-2-admin-input'><br>

					<p class='texto-admin-aclaracion-subida'> ¡Ingrese nombres sin espacios! </p>
					<p class='texto-admin-aclaracion-subida'> 408 x 216 px aprox </p>
					<p class='texto-admin-aclaracion-subida'>JPG, PNG, GIF - 2000KB</p>

				 <label class='label-admin' class='form-admin-input' for="descripcion-2-admin-input">Ingrese descripcion 2</label><br>
					<textarea class='form-admin-input'  name='descripcion-2-admin-input' id='descripcion-2-admin-input' value=""><?php $baseDatos->buscarDescripcion2Establecida($_GET['id']); ?></textarea>
				 
				
			</div>

				<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
					
						<label class='label-admin' class='form-admin-input' for="titulo-3-admin-input">Ingrese titulo 3</label><br>
					<input type="text" class='form-admin-input'  name='titulo-3-admin-input' id='titulo-3-admin-input' value="<?php $baseDatos->buscarTitulo3Establecido($_GET['id']); ?>">
				 
						<label class='label-admin' class='form-admin-input' for="imagen-3-admin-input">Ingrese imagen 3</label><br>
					<input type="file" class='form-admin-input'  name='imagen-3-admin-input' id='imagen-3-admin-input'><br>
				
					<p class='texto-admin-aclaracion-subida'> ¡Ingrese nombres sin espacios! </p>
					<p class='texto-admin-aclaracion-subida'> 408 x 216 px aprox </p>
					<p class='texto-admin-aclaracion-subida'>JPG, PNG, GIF - 2000KB</p>

					<label class='label-admin' class='form-admin-input' for="descripcion-3-admin-input">Ingrese descripcion 3</label><br>
					<textarea class='form-admin-input'  name='descripcion-3-admin-input' id='descripcion-3-admin-input'value=""><?php $baseDatos->buscarDescripcion3Establecida($_GET['id']); ?></textarea>
 				
				
			</div>
			
		</div>
	</div>

	<div class="row">
		<div class="container">
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
					
						<label class='label-admin' class='form-admin-input' for="imagen-home-admin-input">Ingrese imagen home </label><br>
					
					<input type="file" class='form-admin-input'  name='imagen-home-admin-input' id='imagen-home-admin-input'><br>
					<p class='texto-admin-aclaracion-subida'> ¡Ingrese nombres sin espacios! </p>
					<p class='texto-admin-aclaracion-subida'> 208 x 208 px aprox </p>
					<p class='texto-admin-aclaracion-subida'>JPG, PNG, GIF - 2000KB</p>


				
			</div>
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
					
					
					
						<label class='label-admin' class='form-admin-input' for="imagen-media-admin-input">Ingrese imagen mediana</label><br>
					
					<input type="file" class='form-admin-input'  name='imagen-media-admin-input' id='imagen-media-admin-input'><br>
					<p class='texto-admin-aclaracion-subida'> ¡Ingrese nombres sin espacios! </p>
					<p class='texto-admin-aclaracion-subida'> 311 x 500 px aprox </p>
					<p class='texto-admin-aclaracion-subida'>JPG, PNG, GIF - 2000KB</p>
						

				
			</div>
			<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>

						<label class='label-admin' class='form-admin-input' for="imagen-grande-admin-input">Ingrese imagen grande</label><br>
					
					<input type="file" class='form-admin-input'  name='imagen-grande-admin-input' id='imagen-grande-admin-input'><br>
					<p class='texto-admin-aclaracion-subida'> ¡Ingrese nombres sin espacios! </p>
					<p class='texto-admin-aclaracion-subida'> 505 x 805 px aprox </p>
					<p class='texto-admin-aclaracion-subida'>JPG, PNG, GIF - 2000KB</p>
				
			</div>
		</div>
	</div>

	
		<div class="row">
		<div class="container">
			<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					
					<a id='submit-admin-form' onClick='submitFormActualizarProducto();' class='carrito-checkout-btn'>¡Actualizar producto!</a>

				
			</div>
		</div>
	</div>


	</form>
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