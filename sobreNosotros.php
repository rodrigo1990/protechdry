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
		<link rel="stylesheet" type="text/css" href="estilos_css/estilos.css">

	<link rel="stylesheet" type="text/css" href="estilos_css/estilos2.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="js/jquery.sticky.js"></script>
		<!-- OWL CARROUSEL -->
	<link rel="stylesheet" href="owlcarousel/dist/assets/owl.carousel.min.css">
	<link rel="stylesheet" href="owlcarousel/dist/assets/owl.theme.default.min.css">
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

	<?php
	include("include/slider.php")
	
	?>


<div class="row nosotros-row" >
	<div class="container">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-left">
			<div class="row" style='padding-bottom:5%'>

			</div>
			<p>Ofrecemos una solución para quienes padecen incontinencia urinaria leve a moderada, tanto hombres como mujeres.
			 Nuestra ropa interior es de algodón y tiene una tecnología probada y patentada.
			  Posee un área antialérgica y súper fina que permite absorber la orina y neutralizar el olor.
			   Se puede lavar y reutilizar más de 100 veces. 
			   Contamos con distintos modelos y talles que se adaptan al gusto y a la comodidad de cada cliente.</p> 

			<h3>Beneficios</h3>

			<p>Al ser lavable y reutilizable, nuestra ropa interior resulta más económica y ecológica.
			 Tiene un diseño discreto y una tecnología ultra-absorbente y que neutraliza los olores,
			  lo que permitirá al usuario recuperar su confianza, tranquilidad y libertad.</p>
			
			<h3>Características:</h3>
			<ul>
				<li>	Se puede lavar en lavarropas más de 100 veces a 40°C.</li>
				<li>	La estructura 3D con su área multifuncional garantiza una ultra-absorción.</li>
				<li>	Las fibras funcionales de la estructura 3D neutralizan los olores por completo.</li>
				<li>	Las costuras selladas retienen el líquido dentro del área absorbente, lo que significa que no habrá fugas y va a permanecer seco todo el día.</li>
				<li>	La tecnología de capas múltiples garantiza que las áreas en contacto con la piel permanezcan secas.</li>
				<li>	Ninguno de los componentes usados representan riesgo contra la salud.</li>
				<li>	Es una opción reutilizable para los pañales sanitarios que genera ahorro a corto y largo plazo.</li>
				<li>	Con un diseño discreto, con protección ofrecida por la ropa interior Protech Dry le permite al usuario recuperar la confianza en todos los aspectos de su vida diaria.</li>
			
			
			
			</ul>
			<h3>Recomendaciones:</h3>
			<ul>
				<li> Asegurse de elegir el talle correcto.</li>
				<li> La escructura absorbente debe estar en contacto con el área genital.</li>
				<li> No usar suavizante al lavar la ropa interior Protech Dry; esto disminuirá la efectividad de la absorción.</li>
				<li> No planchar el área absorbente.</li>
				<li> Apto para secarropas. </li>
				<li> No se recomienda lavar a más de 40°C.</li>
				<li> No usar lavandina en el área absorbente.</li>
			</ul>

		</div>
	</div>
</div>





<!-- MODAL COMPRAR -->
<?php 
include("include/modal-comprar.php");
include("include/footer.php");
 ?>








	


<!-- FUNCIONES JS -->
<script src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
var $jQuery_3_2_1 = $.noConflict();
</script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<!-- MENU FIXED  -->
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.sticky.js"></script>
<script type="text/javascript" src="js/sticky.js"></script>
<script type="text/javascript" src="js/script.js"></script>
<script type="text/javascript" src="js/carrito.js"></script>
<script type="text/javascript" src="js/validaciones-modal.js"></script>
<script src="owlcarousel/docs/assets/vendors/jquery.min.js"></script>
<script type="text/javascript">
	var $jQueryOwl = $.noConflict();
</script>
<script src="owlcarousel/dist/owl.carousel.js"></script>
<script src="https://secure.mlstatic.com/sdk/javascript/v1/mercadopago.js"></script>
<script>
  $jQueryOwl('.owl-carousel').owlCarousel({
    loop:true,
    margin:10,
    autoplay:true,
    autoplayTimeout:7500,
    nav:false,
    dots:true,
    items:3,
    responsive:{
        0:{
            items:1
        },
        1200:{
            items:1
        }
    }
})
</script>

</body>


</html>
