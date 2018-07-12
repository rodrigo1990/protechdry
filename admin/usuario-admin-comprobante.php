<?php 
require_once("clases/Administrador.php");
require_once("clases/Session.php");


session_start();
$session = new Session();
$session->controlarTiempoDeSesion();

$admin=new Administrador();

if($_SESSION['login']==FALSE){
	header("Location:index.php");
}

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
	<title>Imprimir</title>
	<link rel="stylesheet" type="text/css" href="estilos_css/estilos.css">
	<script>
		function imprimir(){
		
			window.print();

		}
	$(document).ready(function(){

		imprimir();

	});

	</script>

</head>
<body>
<?php 

$admin->listarUnSoloComprobanteAdmin($_GET['nro']);
 ?>	
</body>
</html>