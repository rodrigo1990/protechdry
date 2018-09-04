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
	
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css" media="screen">
	<!-- ESTILOS PROPIOS -->
	<link rel="stylesheet" type="text/css" href="estilos_css/fuentes.css">
	<link rel="stylesheet" type="text/css" href="estilos_css/estilos2.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    include("include/banner-xs.php")
    ?>
    

	<?php 
	include("include/menu.php");
	 ?>
	

	<?php
	include("include/slider.php")
	
	?>

	<!-- Slider -->
		<div class="slider-info text-center" style="position:absolute;left:50%;" >
			<div style="position:relative;left:-50%;top:50%;z-index: 2000;display:none">
				<h2>Ropa interior de algodón</h2>
				<h1>RECOMENDADA PARA INCONTINENCIA MODERADA</h1>
				<br>
				<a class='slider-button' href="todosLosProductos.php">COMPRAR</a>
			</div>
		</div>
		
		<div class="row titulo">
			<div class="container">
				<div class="col-sm-12 text-center">
					<h2>ROPA INTERIOR PARA HOMBRE Y MUJER <br> indicada para  incontinencia leve y moderada</h2>
					<hr class="center-block">
				</div>
			</div>
		</div>

		<div class="icon-seccion row">
			<div class="arrow_box">
						<h3>BENEFICIOS</h3>
					</div>
			<div class="container">

				<div class="col-sm-12">
					
					<ul class="beneficios flex-container text-center" style="margin-top:2%;">
						<li id="li-uno">
							<div class="img" id="icon-01"></div>
							<h4 id="h4-tecno">Tecnologìa</h4>
						</li>
						<li id="li-dos">
							<div class="img" id="icon-02"></div>
							<h4>Algodón</h4>
						</li>
						<li id="li-tres">
							<div class="img" id="icon-03"></div>
							<h4>Ultra-absorbente</h4>
						</li>
						<li id="li-cuatro">
							<div class="img" id="icon-04"></div>
							<h4>+100 lavados</h4>
						</li>
						<li id="li-cinco">
							<div class="img" id="icon-05"></div>
							<h4>Ecológico</h4>
						</li>
						<li id="li-seis">
							<div class="img" id="icon-06"></div>
							<h4>Hipoalergénico</h4>
						</li>
						<li id="li-siete">
							<div class="img" id="icon-07"></div>
							<h4>Calidad de vida</h4>
						</li>
					</ul>
				</div>
			</div>
		</div>


<?php $bd->listarProductos(); ?>

<?php $bd->listarProductosParaDispositivosXs(); ?>

<div class="row slider-2" style="">
	<div class="container">
		<!-- Set up your HTML -->
		<div class="owl-carousel" style="">
		  <div><img src="banners/banner_2_1.jpg" class="center-block" style="width: 80%;" alt="Protech Dry"></div>
		  <div><img src="banners/banner_2_2.jpg" class="center-block" style="width: 80%;" alt="Protech Dry"></div>
		  <div><img src="banners/banner_2_3.jpg" class="center-block" style="width: 80%;" alt="Protech Dry"></div>

		</div>
	</div>
</div>




<!-- MODAL COMPRAR -->
<?php 
include("include/modal-comprar.php");
include("include/footer.php");
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







	


<!--End of Zendesk Chat Script-->

<!-- FUNCIONES JS -->
<script src="jquery/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
var $ = $.noConflict();
</script>
<script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>

<!-- MENU FIXED  -->
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
    loop:false,
    margin:10,
    autoplay:true,
    autoplayTimeout:7500,
    nav:true,
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
<script>
$(document).ready(function () {
  $('.banner-xs-button').click(function() {
  $('html, body').animate({
    scrollTop: $("#primer-row").offset().top
  }, 1000)
  
  setTimeout(function(){
   $(".banner-xs-row").hide();
}, 2000);
  
 
})
});
</script>
<script type="text/javascript" src="js/preloader.js"></script>
<script type='text/javascript' data-cfasync='false'>window.purechatApi = { l: [], t: [], on: function () { this.l.push(arguments); } }; (function () { var done = false; var script = document.createElement('script'); script.async = true; script.type = 'text/javascript'; script.src = 'https://app.purechat.com/VisitorWidget/WidgetScript'; document.getElementsByTagName('HEAD').item(0).appendChild(script); script.onreadystatechange = script.onload = function (e) { if (!done && (!this.readyState || this.readyState == 'loaded' || this.readyState == 'complete')) { var w = new PCWidget({c: 'ec0bb246-1cf7-4fba-8381-c435cc995783', f: true }); done = true; } }; })();</script>
</body>


</html>
