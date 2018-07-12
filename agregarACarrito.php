
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta name="robots" content="noindex">

</head>
<body>
	
</body>
</html>
<?php
require_once("clases/Producto.php");
require_once("clases/Usuario.php");
require_once("clases/Session.php");


session_start();
$session = new Session();
$session->controlarTiempoDeSesion();


$usuario=new Usuario();

$usuario->cargarCarrito();

?>