<?php 
session_start();
require_once("../clases/Producto.php");
require_once("../clases/Usuario.php");


$usuario=new Usuario();

$usuario->actualizarCarrito($_GET['id'],$_GET['color'],$_GET['talle'],$_GET['cantidad']);


$usuario->mostrarCarritoCheckOut();




 ?>