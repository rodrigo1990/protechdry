<?php
session_start();
require_once("../clases/Usuario.php");
require_once("../clases/Producto.php");


  $usuario=new Usuario();

  $usuario->mostrarCantidad();



?>