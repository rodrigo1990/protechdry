<?php 
session_start();
require_once("clases/Producto.php");
require_once("clases/BaseDatos.php");
require_once("clases/Mail.php");

if(isset($_GET['collection_id'])){
$BaseDatos=new BaseDatos();
$mail = new Mail();

	if ($_GET['collection_status']=='approved'){

	$BaseDatos->actualizarIdMpEnVenta($_GET['collection_id'],$_SESSION['referencia'],0,2);
		
		//$mail->enviarComprobantePagoExitosoMercadoPago();

	}else if($_GET['collection_status']=='pending'){

	$BaseDatos->actualizarIdMpEnVenta($_GET['collection_id'],$_SESSION['referencia'],0,1);
	//$mail->enviarComprobantePagoPendienteMercadoPago();
	}else if($_GET['collection_status']=='in_process'){

	$BaseDatos->actualizarIdMpEnVenta($_GET['collection_id'],$_SESSION['referencia'],0,1);
	//$mail->enviarComprobantePagoPendienteMercadoPago();
	}else if($_GET['collection_status']=='rejected'){

	$BaseDatos->actualizarIdMpEnVenta($_GET['collection_id'],$_SESSION['referencia'],0,4);
	//$mail->enviarComprobantePagoPendienteMercadoPago();
	}


session_destroy(); 
}else{
	header("location: index.php");
}
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
	
		<style>
			body{
				overflow-x:hidden;
				overflow-y:hidden;
			}

		</style>
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







<div class="row">
	<div class="container">
		<div class="landing-cont col-xs-12 col-sm-12 col-md-12 col-lg-12">
		 	<h1><b>¡Compra realizada!</b</h1>

		 	<h3><b>Sigue comprando y enterandote de nuestras ofertas</b></h3>
		 	<img src="elementos_separados/logo.png" alt="" class="img-reponsive" style="width:300px;margin-left:auto !important;margin-right:auto !important;display:block !important;">
		</div>

	</div>
</div>



 


 </body>
 </html>