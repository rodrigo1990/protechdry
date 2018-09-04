<?php
require_once("clases/BaseDatos.php");
require_once("clases/Producto.php");
require_once("clases/Session.php");
require_once("clases/Usuario.php");

session_start();
//session_destroy();
$session = new Session();
$session->controlarTiempoDeSesion();

$_SESSION['login']=FALSE;
$_SESSION['login-cliente']=FALSE;


$bd=new BaseDatos();
$usuario=new Usuario();

   if(!isset($_GET['id']) OR $_GET['id']==''){

			header('Location: index.php');

	}

 ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-119680604-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-119680604-1');
</script>

		<title>PROTECH</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width" />
	<!-- JQUERY -->
	<script src="jquery/jquery-3.2.1.min.js"></script>
	<script type="text/javascript">
	var $jQuery_3_2_1 = $.noConflict();
	</script>
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" media="screen">
	<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
	<!-- ESTILOS PROPIOS -->
	<link rel="stylesheet" type="text/css" href="estilos_css/fuentes.css"> 
	<link rel="stylesheet" type="text/css" href="estilos_css/estilos2.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>	
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
	<link rel="stylesheet" href="estilos_css/animate.css">
	<!-- FANCY BOX -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.4/jquery.fancybox.min.css" />
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
include ("include/menu.php");
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

<div class="row ver-mas-row " style='margin-top:5%'>

	<div class="container">

		<div class="hidden-xs col-sm-8 col-md-8 col-lg-8">
			<?php $bd->listarImagenes($_GET['id']);?>
		</div><!-- col -->

		<div class="producto-ver-mas col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<?php


				$bd->listarUnSoloProducto($_GET['id']);

					





			 ?>	
		</div><!-- col -->

			<?php $bd->listarImagenesXs($_GET['id']);?>


	 </div><!-- container -->

</div><!-- row -->


<?php $bd->listarImagenesSm($_GET['id']) ?>















<?php 
if(isset($_GET['alert'])){
  if($_GET['alert']=='on'){
  	echo '<!-- MODAL -->
    <div class="modal fade" id="confirm-modal" role="dialog">
      <div class="modal-dialog">
      
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <img src="elementos_separados/logo.png" width="30%" alt="">
          </div>
          <div class="modal-body">
          <h1>¡Has agregado un producto al carrito!</h1>
          <a class="modal-confirm-button " data-dismiss="modal" style="float:left;margin-left:2%;"><h4>Seguir comprando</h4></a>
          <a class="modal-confirm-button" style="float:right;margin-right:2%;" onClick="cambiarDeConfirmModalACheckoutModal();"><h4>Ir al checkout</h4></a>
          	
          </div>
        </div>
        
      </div>
    </div>';

    $_GET['alert']='off';


  }else {
  }
}



 ?>




<!-- MODAL -->
  <div class="modal fade" id="lista-de-talles-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <img src="elementos_separados/logo.png" width="30%" alt="">
        </div>
        <div class="modal-body">
        	<img src='img/guia-de-talles/guia-de-talles.jpg' class='img-responsive'>
        </div>
        
      </div>
      
    </div>
  </div>
  
</div>


<!-- MODAL COMPRAR -->
<?php 
include("include/modal-comprar.php");
 ?>

 <!-- modal mis pedidos -->
<?php include("include/modal-mis-pedidos.php") ?>


<?php include("include/footer.php") ?>








<!-- STYLABLE SPINNER -->
<script src="https://code.jquery.com/jquery-1.11.3.min.js"integrity="sha256-7LkWEzqTdpEfELxcZZlS6wAx5Ff13zZ83lYO2/ujj7g=" crossorigin="anonymous"></script>
<script type="text/javascript">
var $jQuery_1_11_3 = $.noConflict();
</script>
<script type="text/javascript" src="js/jquery.numble.min.js"></script>

<!-- ELEVATE ZOOM -->
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>	
<script type="text/javascript">
var $jQuery_1_8_3 = $.noConflict();
</script>
<script type="text/javascript" src="js/jquery.elevatezoom.js"></script>

<!-- Fancybox -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.3.4/jquery.fancybox.min.js"></script>

<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>

<script type="text/javascript" src="js/jquery.sticky.js"></script>
<script type="text/javascript" src="js/sticky.js"></script>


<script>
   	$jQuery_1_8_3('#img-zoom').elevateZoom();
   	$jQuery_1_11_3("input[type=number]").numble({minValue:1,maxValue:30,initialValue:1,allowNegative:false});

</script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

  <script type='text/javascript'>
    $jQuery_3_2_1(window).on('load',function(){
        $jQuery_3_2_1('#confirm-modal').modal('show');
    });
</script>
<script>
	function cambiarDeConfirmModalACheckoutModal(){
		$jQuery_3_2_1('#confirm-modal').modal('toggle');
		$jQuery_3_2_1('#myModal').modal('show');
		
	}
</script>
<!-- FUNCIONES JS -->
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/carrito.js"></script>
<script type="text/javascript" src="js/validaciones-modal.js"></script>
<script type="text/javascript" src="js/preloader.js"></script>



<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'ec0bb246-1cf7-4fba-8381-c435cc995783', f: true }); done = true; } }; })();</script>
</body>
</html>