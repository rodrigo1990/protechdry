<?php 
require_once("clases/Producto.php");
require_once("clases/Usuario.php");
require_once("clases/BaseDatos.php");
require_once("sdk-php-master-mp/lib/mercadopago.php");
require_once("clases/Session.php");

if(!isset($_POST['email-modal'])){
	header("Location:index.php");
}
session_start();
$usuario= new Usuario();

$usuario->verificarCarrito();

$session = new Session();
$session->controlarTiempoDeSesion();

$bd=new BaseDatos();



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









	<!-- Carrito de compras -->
<div class="row">
	<div class="slider-checkout">
		
		<ul id="slider-checkout" class="normal">
		<li>
				<!-- TABLA CHECKOUT -->
	<div id="carrito-CheckOut">

		<?php 

		$usuario->mostrarCarritoCheckOut();



		?>
		</div><!-- carrito-CheckOut-row -->

	<div class="btn-row row">
		<div class="container">
		
			<div id="carrito-checkout-btn-datos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<a id="carrito-checkout-btn-datos" class="carrito-checkout-btn">Carga de datos</a>
			</div>
		</div><!-- container -->
	</div>	<!--btn-row -->
</li>

<li>
<div id="checkout-form-row">
	<div class="row">
	<div class="container">
		<h1 class='titulos-checkout'>2. Carga Tus Datos </h1>
		<p class="descripcion-checkout"><i>Solicitaremos unicamente tus datos escenciales para realizar el proceso de compra de una manera  segura,<br> fiable, y con mayor calidad.</i></p>
	<form id="form-checkout" name="myform"  action=''  method='POST' onkeypress="return anular(event)">
			<div class="form-group-margin col-xs-12 col-sm-6 col-md-6 col-lg-6">
				
				<p class="form-group-identidad-p">Nombre <span>*</span><span style="font-size:80%;">( * Dato obligatorio )</span></p>

				<input class="form-group-identidad" type='text'  id='nombre' name='nombre' value="<?php $bd->buscarNombreDeUsuario($_POST['email-modal']);?>"><br>
				<p class="form-alert" id="nombre-form-alert">Ingrese un nombre valido</p>


				<p class="form-group-identidad-p">Apellido <span>*</span></p>

				<input class="form-group-identidad" type='text' id='apellido' name='apellido' value="<?php $bd->buscarApellidoDeUsuario($_POST['email-modal']);?>"><br>
				<p class="form-alert" id="apellido-form-alert">Ingrese un apellido valido</p>
				
				<p class="form-group-identidad-p">Tipo dni <span>*</span></p>
		
				<select class="form-group-identidad" type='text'  id='tipo_dni' name='tipo_dni'><br>
					<?php 

					$bd->buscarTipoDocumento($_POST['email-modal']);

					 ?>
				</select>
				<p class="form-group-identidad-p">dni <span>*</span></p>

				<input class="form-group-identidad" type='text'  id='dni' name='dni' value="<?php $bd->buscarNumeroDocumentoDeUsuario($_POST['email-modal']);?>"><br>
				<p class="form-alert" id="dni-form-alert">Ingrese un dni valido ej:35365531</p>


				<P class="form-group-identidad-p">Email <span>*</span></p>

				<input class="form-group-identidad" type='text'  id='email' name='email' value="<?php echo $_POST['email-modal'] ?>"><br>
				<p class="form-alert" id="email-form-alert">Ingrese un email valido ej:user@mail.com</p>


				<p class="form-group-identidad-p">Telefono <span>*</span></p>

				<input class="form-group-identidad small" type="text" id="cod_area" name="cod_area" maxlength="4" size="3" value="<?php $bd->buscarCodigoAreaDeUsuario($_POST['email-modal']);?>">

				<span>15</span><input class="form-group-identidad medium" type='text' id='telefono' name='telefono' value="<?php $bd->buscarTelefonoDeUsuario($_POST['email-modal']);?>"><br>
				<p class="form-alert" id="telefono-form-alert">Ingrese un telefono valido ej:46612929</p>
				<p class="form-alert" id="cod_area-form-alert">Ingrese un codigo de area valido</p>

				<?php

				//echo "<input type='hidden' class='identificacionMp' id ='total' name='total' value='".$_GET['total']."'>";

				?>

				<?php 

					echo "<input type='hidden' class='identifcacionMp' id = 'referencia' name='referencia' value='".uniqid('')."'>";

				 ?>
				 <div class="form-checkbox">
			<!--	<label class="form-group-identidad-p" for="necesita_envio">Necesito envio <br> a domicilio </label>
				<input class="form-group-identidad-check" type="checkbox" id="necesita_envio" name="necesita_envio" value="yes">
				<!--  <label class="form-group-identidad-p" for="pagar_mp">Pagar con<br></label>
				<input class="form-group-identidad-check" type="radio" id="pagar_mp"value="1" name="medio_pago">-->

				<!--  <label class="form-group-identidad-p" for="pagar_mp">Pagar con<br><img class='icon-form' src="elementos_separados/todopago-icon.png" width="108px" height="30px" alt=""></label>
				<input class="form-group-identidad-check" type="radio" id="pagar_tp" value="2" name="medio_pago">-->
				</div>
		</div><!-- col -->
		<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
			<!-- SECCION UBICACION !!!!!!!!!!!!!!!!!!! -->
				<p class="form-group-identidad-p">provincia <span>*</span></p>

				<select class="form-group-identidad " type='text' id='provincia' name='provincia' form='form-checkout'>
				<option value="" selected="selected">Selecciona tu provincia</option>
				<?php 

				$bd->buscarProvincias($_POST['email-modal']);

				 ?>
				</select>

				<p class="form-group-identidad-p">partido <span>*</span></p>
				<select class="form-group-identidad" name="partido" id="partido" form='form-checkout'>
					<option value="" selected="selected">Selecciona tu partido</option>
					<?php 
					$bd->buscarPartidoDeUsuario($_POST['email-modal']);
					 ?>
				</select>


				<p class="form-alert" id="provincia-form-alert">Ingrese una provincia</p>

				<p class="form-group-identidad-p">Ciudad <span>*</span></p>

				<select class="form-group-identidad " type='text' id='ciudad' name='ciudad' form='form-checkout'>
				<option value="" selected='selected'>Selecciona tu ciudad</option>
				<?php 
				$bd->buscarCiudadDeUsuario($_POST['email-modal']);
				 ?>
				</select>
				<p class="form-alert" id="ciudad-form-alert">Ingrese una ciudad</p>



				<p class="form-group-identidad-p">Codigo Postal <span>*</span></p>

				<input type='text' class="form-group-identidad "  id='cp' name='cp' maxlength='8' value="<?php $bd->buscarCodigoPostalDeUsuario($_POST['email-modal']);?>"><br>
				<a id="a-cp" href="http://www.correoargentino.com.ar/formularios/cpa" target="_blank">No conozco mi codigo postal </a>
				<p class="form-alert" id="cp-form-alert">Ingrese un codigo postal valido ej:1708</p>
			
			

				<p class="form-group-identidad-p">Calle <span>*</span></p>

				<input type='text' class="form-group-identidad " id='calle' name='calle' value="<?php $bd->buscarCalleDeUsuario($_POST['email-modal']);?>"><br>
				<p class="form-alert" id="calle-form-alert">Ingrese un nombre de calle valido</p>

				<p class="form-group-identidad-p">Altura <span>*</span></p>

				<input type='text' class="form-group-identidad "  id='altura' name='altura'  value="<?php $bd->buscarAlturaDeUsuario($_POST['email-modal']);?>"><br>
				<p class="form-alert" id="altura-form-alert">Ingrese una altura valida</p>

				<p class="form-group-identidad-p">Piso y departamento</p>
				<input type="text" class="form-group-identidad small " id="piso" name="piso" size="3" placeholder="piso" value="<?php $bd->buscarPisoDeUsuario($_POST['email-modal']);?>">
				<p class="form-alert" id="piso-form-alert">Ingrese un numero de piso</p>

				<!-- <p>Departamento</p> -->
				<input type="text" class="form-group-identidad small " id="departamento" name="departamento" size="3" placeholder="depto" value="<?php $bd->buscarDepartamentoDeUsuario($_POST['email-modal']);?>">
				<p class="form-alert" id="departamento-form-alert">Debes ingresar un departamento valido</p> <br>

				 <span style="color:orange;"><h4 style="margin-left: 10%;"><b>ENVIOS A CABA Y GBA GRATUITOS</b></h4></span>

				
		
		</div>
			 </form>
	</div><!-- container -->

	<div class="btn-row row">
	<div class="container">
	<div class="hidden-xs col-sm-6 col-md-6 col-lg-6">
		<a id="carrito-checkout-btn-compra2" class="carrito-checkout-btn">Confirmar compra</a>
	</div>
	<div id="" class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		
		<a  href="javascript: submitform()"id="carrito-checkout-btn-comprar" class="carrito-checkout-btn">Comprar</a>
	</div>
	</div>
</div>	<!-- btn-row -->

</div>
</ul>
	</div><!-- slider -->

</div><!-- row -->	


<!-- BOTONES -->




<!-- modal mis pedidos -->
<?php// include("include/modal-mis-pedidos.php") ?>
<?php include("include/footer.php") ?>


  <!-- FUNCIONES JS -->
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/validaciones.js"></script>
	<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'ec0bb246-1cf7-4fba-8381-c435cc995783', f: true }); done = true; } }; })();</script>
</body>
</html>