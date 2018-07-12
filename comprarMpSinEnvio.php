<?php 
require_once ("sdk-php-master-mp/lib/mercadopago.php");
require_once("clases/Producto.php");
require_once("clases/Usuario.php");
require_once("clases/Session.php");


/*if(!isset($_POST['referencia'])){
	header("Location:index.php");
}*/


session_start();
$session = new Session();
//$session->controlarTiempoDeSesion();

$usuario = new Usuario();

$_SESSION['nombre']=$_POST['nombre'];
$_SESSION['apellido']=$_POST['apellido'];
$_SESSION['tipo_dni']=$_POST['tipo_dni'];
$_SESSION['dni']=$_POST['dni'];
$_SESSION['email']=$_POST['email'];
$_SESSION['cod_area']=$_POST['cod_area'];
$_SESSION['telefono']=$_POST['telefono'];
$_SESSION['referencia']=$_POST['referencia'];

$mp = new MP("7685275542055403", "osPBYeqPRyUkKTazdErctjc1tmHEYeM4");

$preference_data = array(
    "items" => array(
        array(
            "title" => "Productos Protech Dry",
            "currency_id" => "ARG",
            "category_id" => "Category",
            "quantity" => 1,
            "unit_price" => (float)$usuario->mostrarTotal()
        )
    ),
	"payer" => array(
			"name" => $_POST['nombre'],
			"surname" => $_POST['apellido'],
			"email" => $_POST['email'],
			"date_created" => date("y-m-d"),
	"phone" => array(
			"area_code" => $_POST['cod_area'],
			"number" => $_POST['telefono']
	),
	),
	"identification" => array(
			"type" => $_POST['tipo_dni'],
			"number" => $_POST['dni']
	),
	"auto_return"=>"all",
	"back_urls" => array(
		"success" => "landingIframe.php",
		"failure" => "landingIframe.php",
		"pending" => "landingIframe.php",
	),
		"external_reference" => "".$_POST['referencia'].""

);

$preference = $mp->create_preference($preference_data);



?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Comprar</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="jquery/jquery-3.2.1.min.js"></script>
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" media="screen">
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<!-- ESTILOS PROPIOS -->
	<link rel="stylesheet" type="text/css" href="estilos_css/fuentes.css">
	<link rel="stylesheet" type="text/css" href="estilos_css/estilos.css">
		<link rel="stylesheet" type="text/css" href="estilos_css/estilos2.css">

	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
	<link rel="stylesheet" href="estilos_css/animate.css">

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '217958925677661');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=217958925677661&ev=PageView&noscript=1"
/></noscript>
</head>
<body>


	<!-- MENU -->
<?php 
	include("include/menu-checkout.php");
 ?>

 <!--<div class="slider-angosto">
 	<!--  <ul>
	 	<li><img src="banners/banner_angosto_1.png"   width="100%"></li>
	 	<li><img src="banners/banner_angosto_2.png"   width="100%"></li>
	 	<li><img src="banners/banner_angosto_1.png"   width="100%"></li>
	 	<li><img src="banners/banner_angosto_2.png"   width="100%"></li>
 	</ul>-->
 <!--</div>-->




		<div class="compra-row row">
		<div class="container">
			<div  class=" listar-cont hidden-xs hidden-sm col-md-8 col-lg-8">

				<ul class="lista-compraMp sinEnvio">
					<li class="titulo-lista-comprar-mp">Medio de pago</li>
					<li>Mercado Pago</li>
				</ul>

				<ul class="lista-compraMp sinEnvio">
					<li class="titulo-lista-comprar-mp">Datos personales</li>
					<li><?php echo $_POST['nombre'] ?> <?php echo $_POST['apellido'] ?></li>
					<li><?php echo $_POST['email'] ?></li>
					<li>54 <?php echo $_POST['cod_area']?> <?php echo $_POST['telefono'] ?></li>
				</ul>
			
			
			<div class="row">
				
				<div  class=" listar-cont articulos hidden-xs hidden-sm col-md-12 col-lg-12">

				<ul class="lista-compraMp articulos">
					<li class="titulo-lista-comprar-mp">Articulos</li>
					<?php $usuario->listarListaDeArticulosComprados(); ?>
				</ul>
				
				</div>

			</div>


			</div><!-- lista-cont -->
			<div  class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
						<div  class="boton-pago">
							<h3 class="tit-boton-pago"><i>Subtotal:<?php  $usuario->mostrarSubtotal();?>$</i></h3>
							<!--  <h3 class="tit-boton-pago"><i>Descuentos:<span style="color:rgb(255,106,0);text-decoration:underline;"><?php $usuario->mostrarDescuento();?>$</span></i></h3>-->
							<h3 class="tit-boton-pago"><i>Total:<?php echo $usuario->mostrarTotal();?>$</i></h3>

							<div class="boton-pago-row row">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				       <a id="pago-btn" href="<?php echo $preference["response"]["init_point"]; ?>"mp-mode="modal"  onClick="registrarUsuarioSinEnvio('<?php echo $_POST['nombre']?>','<?php echo $_POST['apellido']?>','<?php echo $_POST['tipo_dni']?>','<?php echo $_POST['dni']?>','<?php echo $_POST['email']?>','<?php echo $_POST['cod_area']?>','<?php echo $_POST['telefono']?>','<?php echo $_POST['referencia'] ?>',1);"  name="MP-Checkout"class="carrito-checkout-btn">Pagar</a>
								</div>
							</div>
						</div>
					
			</div>
		</div>
	</div>

	 <div class="logo-row row">
		<div class="container">
			<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<img id="logo-comprarMP" class="img-responsive" src="elementos_separados/logo.png" alt="">		
		
			</div>
		</div>
	</div> 
	

<!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>
<?php include("include/footer.php") ?>



<!-- FUNCIONES JS -->
<script type="text/javascript" src="js/script.js"></script>
<!-- <script type="text/javascript" src="js/validaciones.js"></script> -->
<script type="text/javascript" src="https://resources.mlstatic.com/mptools/render.js"></script> 
<script type="text/javascript">
(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
</script>

<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

</body>
</html>