<?php 
require_once("clases/Producto.php");
require_once("clases/Session.php");
require_once("clases/BaseDatos.php");
require_once("clases/Usuario.php");
session_start();
$usuario=new Usuario();
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
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
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
<link rel="stylesheet" href="estilos_css/animate.css">


		<title>PROTECH</title>
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

	<?php 
	include("include/menu.php");
	 ?>



<?php $bd->listarProductosMujeres(); ?>


<?php $bd->listarProductosMujeresXs(); ?>




<!-- MODAL COMPRAR -->
<?php 
include("include/modal-comprar.php");
 ?>


<?php include("include/footer.php");
 ?>





	


<!--End of Zendesk Chat Script-->

	<!-- FUNCIONES JS -->
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/carrito.js"></script>
<script type="text/javascript" src="js/validaciones-modal.js"></script>
<script type="text/javascript" src="js/jquery.sticky.js"></script>
<script type="text/javascript" src="js/sticky.js"></script>
<script src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
var $jQuery_3_2_1 = $.noConflict();
</script>
<script type="text/javascript" src="js/preloader.js"></script>


<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>

</body>


</html>
