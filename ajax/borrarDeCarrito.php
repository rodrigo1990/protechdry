<?php
session_start();
require_once("../clases/Producto.php");
require_once("../clases/Usuario.php");


$usuario = new Usuario();

$id=$_GET['id'];
$talle=$_GET['talle'];
$color=$_GET['color'];

	$data=serialize($_SESSION['carrito']);

  	$carritoObtenido=unserialize($data);

  	foreach ($carritoObtenido as $producto) {

  		if($producto->id==$id && $producto->talle==$talle && $producto->color==$color){
	  		$producto->cantidad=0;
  		}
  		
  	}
  	$_SESSION['carrito']=$carritoObtenido;

    //echo "Producto eliminado";
   // echo '<i id="carrito-close" class="material-icons" onClick="cerrarVentanaCarrito();">close</i>';
    $usuario->mostrarCarrito();

?>