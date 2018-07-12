<?php 
require_once ("sdk-php-master-mp/lib/mercadopago.php");
require_once("clases/Producto.php");
require_once("clases/Usuario.php");
require_once("clases/Session.php");

if(!isset($_POST['referencia'])){
	header("Location:index.php");
}

session_start();
$session = new Session();
$session->controlarTiempoDeSesion();


$_SESSION['nombre']=$_POST['nombre'];
$_SESSION['apellido']=$_POST['apellido'];
$_SESSION['tipo_dni']=$_POST['tipo_dni'];
$_SESSION['dni']=$_POST['dni'];
$_SESSION['email']=$_POST['email'];
$_SESSION['cod_area']=$_POST['cod_area'];
$_SESSION['telefono']=$_POST['telefono'];
$_SESSION['provincia']=$_POST['provincia'];
$_SESSION['ciudad']=$_POST['ciudad'];
$_SESSION['cp']=$_POST['cp'];
$_SESSION['calle']=$_POST['calle'];
$_SESSION['altura']=$_POST['altura'];
$_SESSION['piso']=$_POST['piso'];
$_SESSION['departamento']=$_POST['departamento'];
//$_SESSION['total']=$_POST['total'];
$_SESSION['referencia']=$_POST['referencia'];

$usuario = new Usuario();
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
	"identification" => array(
			"type" => $_POST['tipo_dni'],
			"number" => $_POST['dni']
	),
	"address" => array(
		"street_name" => $_POST['calle'],
		"street_number" => (int)$_POST['altura'],
		"zip_code" => $_POST['cp']
	)
	),
	"auto_return"=>"all",
	"back_urls" => array(
		"success" => "https://www.protechdry.com.ar/landingIframe.php",
		"failure" => "https://www.protechdry.com.ar/landingIframe.php",
		"pending" => "https://www.protechdry.com.ar/landingIframe.php"
	),
		"external_reference" => "".$_POST['referencia'].""

);

$preference = $mp->create_preference($preference_data);



?>
<!DOCTYPE html>
<html lang="en">
<head>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119680604-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-119680604-1');
</script>

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
	
	<!-- <div class="slider-angosto">
 	<ul>
	 <!--  	<li><img src="banners/banner_angosto_1.png"  width="100%"></li>
	 	<li><img src="banners/banner_angosto_2.png"  width="100%"></li>
	 	<li><img src="banners/banner_angosto_1.png"  width="100%"></li>
	 	<li><img src="banners/banner_angosto_2.png"   width="100%"></li>-->
 	<!--</ul>
 </div>-->



		<div class="compra-row row">
		<div class="container">
			<div  class=" listar-cont hidden-xs hidden-sm col-md-8 col-lg-8">

				<ul class="lista-compraMp">
					<li class="titulo-lista-comprar-mp">Medio de pago</li>
					<li>Mercado Pago</li>
				</ul>

				<ul class="lista-compraMp">
					<li class="titulo-lista-comprar-mp">Direccion de Envio</li>
					<li><?php echo $_POST['calle'];?> <?php echo $_POST['altura'];?>, <?php echo $_POST['ciudad'];?></li>
					<li><?php echo $_POST['provincia'];?>, Argentina</li>
				</ul>

				<ul class="lista-compraMp">
					<li class="titulo-lista-comprar-mp">Datos personales</li>
					<li><?php echo $_POST['nombre']; ?> <?php echo $_POST['apellido']; ?></li>
					<li><?php echo $_POST['email']; ?></li>
					<li>54 <?php echo $_POST['cod_area'];?> <?php echo $_POST['telefono']; ?></li>
				</ul>
			
			
			<div class="row">
				
				<div  class=" listar-cont articulos hidden-xs hidden-sm  col-md-12 col-lg-12">

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
				       <a id="pago-btn" href="<?php echo $preference["response"]["init_point"]; ?>"mp-mode="modal" onreturn="execute_my_onreturn" onClick="registrarUsuario('<?php echo $_POST['nombre']?>','<?php echo $_POST['apellido']?>','<?php echo $_POST['tipo_dni']?>','<?php echo $_POST['dni']?>','<?php echo $_POST['email']?>','<?php echo $_POST['cod_area']?>','<?php echo $_POST['telefono']?>','<?php echo $_POST['provincia']?>','<?php echo $_POST['ciudad']?>','<?php echo $_POST['cp']?>','<?php echo $_POST['calle']?>','<?php echo $_POST['altura']?>','<?php echo $_POST['piso']?>','<?php echo $_POST['departamento']?>','<?php echo $_POST['referencia'] ?>',1);"  name="MP-Checkout"class="carrito-checkout-btn">Pagar</a>
								</div>
							</div>
						</div>
					
			</div>
		</div>
	</div>
	
		<div class="logo-row row">
		<div class="container">
			<div  class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				
				<img id="logo-comprarMP" src="elementos_separados/logo.png" alt="">	
				<h1 class="text-center" style="font-weight: bolder;color: #15a0db;">
					¡FELICITACIONES! <br> ¡El envio a tu domicilio es gratuito!
				</h1>		
		
			</div>
		</div>
	</div>


<!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>

<!-- FOOTER -->
<?php 
include("include/footer.php");
 ?>

<!-- FUNCIONES JS -->
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="https://resources.mlstatic.com/mptools/render.js"></script> 
<script type="text/javascript">
(function(){function $MPC_load(){window.$MPC_loaded !== true && (function(){var s = document.createElement("script");s.type = "text/javascript";s.async = true;s.src = document.location.protocol+"//secure.mlstatic.com/mptools/render.js";var x = document.getElementsByTagName('script')[0];x.parentNode.insertBefore(s, x);window.$MPC_loaded = true;})();}window.$MPC_loaded !== true ? (window.attachEvent ?window.attachEvent('onload', $MPC_load) : window.addEventListener('load', $MPC_load, false)) : null;})();
</script>

<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

</body>
</html>