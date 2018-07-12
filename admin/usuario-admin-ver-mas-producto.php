<?php
require_once("clases/BaseDatos.php");
require_once("clases/Producto.php");
require_once("clases/Session.php");
require_once("clases/Usuario.php");

session_start();
$session = new Session();
$session->controlarTiempoDeSesion();

if($_SESSION['login']==FALSE){
	header("Location:index.php");
}


$bd=new BaseDatos();
$usuario=new Usuario();

  if(!isset($_GET['id'])){

			header('Location: index.php');

	}

 ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Document</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- JQUERY -->
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



	<!-- FUNCIONES JS -->
	<script type="text/javascript" src="js/script.js"></script>
	<script type="text/javascript" src="js/carrito.js"></script>

	<!-- STYLABLE SPINNER -->
	<script src="//code.jquery.com/jquery-1.11.3.min.js"></script>
	<script type="text/javascript">
		var $jQuery_1_11_3 = $.noConflict();
	</script>
	<script type="text/javascript" src="Easy-Stylable-jQuery-Number-Input-Spinner-Plugin-Numble/dist/jquery.numble.min.js"></script>

	<!-- ELEVATE ZOOM -->
	<script type="text/javascript" src="elevatezoom-master/jquery-1.8.3.min.js"></script>	
	<script type="text/javascript">
		var $jQuery_1_8_3 = $.noConflict();
	</script>
	<script type="text/javascript" src="elevatezoom-master/jquery.elevateZoom.js"></script>
	



	<!-- ZENDESK CHAT -->
	<script type="text/javascript">

		window.$zopim||(function(d,s){var z=$zopim=function(c){z._.push(c)},$=z.s=
		d.createElement(s),e=d.getElementsByTagName(s)[0];z.set=function(o){z.set.
		_.push(o)};z._=[];z.set._=[];$.async=!0;$.setAttribute("charset","utf-8");
		$.src="https://v2.zopim.com/?4eooxqQhEm2xIDd0tohkfnN1KIKglQAI";z.t=+new Date;$.
		type="text/javascript";e.parentNode.insertBefore($,e)})(document,"script");

	</script>


</head>


<body>
<!-- MENU -->
<?php 
include ("include/menu-no-animated.php");
 ?>

 <!-- CARRITO DE COMPRAS !! -->
<div class="container">
<div id="carrito" class="animated slideInDown carrito-ver-mas">

	<i id="carrito-close" class="material-icons"  onClick="cerrarVentanaCarrito();">close</i>
	<ul id="carrito-lista">
		<?php 

		$bd=new BaseDatos();
		$usuario->mostrarCarrito();

		?>
	</ul>
</div>
</div>

<div class="ver-mas-row row">

	<div class="container">

		<div class="img-zoom-cont hidden-xs hidden-sm col-md-6 col-lg-6">
			<?php $bd->listarImagenZoom($_GET['id']);?>
		</div><!-- col -->

		<div class="producto-ver-mas col-xs-12 col-sm-12 col-md-6 col-lg-6">

		<?php


			$bd->listarUnSoloProducto($_GET['id']);

				





		 ?>	
		 
		</div><!-- col -->

	 </div><!-- container -->

</div><!-- row -->

		<?php

			$bd->listarDescripcion($_GET['id']);
			

		


		 ?>	

	<?php
	$bd->listarProductosRelacionados($_GET['id']);
  ?>




<!-- MODAL COMPRAR -->
<?php 
include("include/modal-comprar.php");
 ?>

 <!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>

<!-- FOOTER -->
<?php 
include("include/footer.php");
 ?>

<!-- MODAL CALCULAR ENVIO -->
  <div class="modal fade" id="calcular-cuotas" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <img src="elementos_separados/logo.png" width="30%" alt="">
        </div>
        <div id="pedidos-modal-body" class="modal-body">
        	
        				<a class="carrito-checkout-btn" onClick="">Calcular</a >
        </div>
        <div class="modal-footer-calcular modal-footer">
        
        </div>
      </div>
      
    </div>
  </div>

  <!-- MODAL CALCULAR CUOTAS -->
  <div class="modal fade" id="calcular-envio" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <img src="elementos_separados/logo.png" width="30%" alt="">
        </div>
        <div id="pedidos-modal-body" class="modal-body">
        	
        	<label for="email-modal"><h4>Ingrese su codigo postal</h4></label>
			<input class="form-control" type="text" name="calcular-envio" id="calcular-envio-input"><br><br>
        				
			
			<a class="carrito-checkout-btn" onClick="">Calcular</a >

			<h3>El costo del envio es :</h3>

        </div>
        <div class="modal-footer-calcular modal-footer">
        </div>
      </div>
      
    </div>
  </div>

<script>
   	$jQuery_1_8_3('#img-zoom').elevateZoom();
   	$jQuery_1_11_3("input[type=number]").numble({minValue:0,maxValue:30,initialValue:0,allowNegative:false});

</script>
<script>

		
	function submitformCompra(){
			 document.forms["form-ver-mas"].submit();
			}







	</script>
</body>
</html>