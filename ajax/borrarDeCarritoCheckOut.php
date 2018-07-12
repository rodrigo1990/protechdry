<?php
session_start();
require_once("../clases/Producto.php");
require_once("../clases/Usuario.php");


$id=$_GET['id'];

	$data=serialize($_SESSION['carrito']);

  	$carritoObtenido=unserialize($data);

  	foreach ($carritoObtenido as $producto) {

  		if($producto->id==$id){
	  		$producto->cantidad=0;
  		}
  		
  	}
  	$_SESSION['carrito']=$carritoObtenido;

    //echo "Producto eliminado";

      $usuario=new Usuario();

  $usuario->mostrarCarritoCheckOut();



/*$nombres = array_column($carritoObtenido, 'marca','id');

echo serialize($nombres);*/



?>

