<?php 
require_once("clases/Administrador.php");
require_once("clases/Session.php");


session_start();
$session = new Session();
$session->controlarTiempoDeSesion();



if($_SESSION['login']==FALSE){
	header("Location:index.php");
}

$admin=new Administrador();

	if($_POST['precio-admin-actualizar-checkbox']=='' && $_POST['precio-descuento-admin-actualizar-checkbox']=='' && isset($_POST['destacado-admin-actualizar-checkbox']) && !isset($_POST['stock-admin-actualizar-checkbox']) ){
		
		$admin->actualizarDestacado($_POST['destacado-admin-actualizar-checkbox'],$_POST['id']);
	
	}else if($_POST['precio-admin-actualizar-checkbox']=='' && $_POST['precio-descuento-admin-actualizar-checkbox']=='' && isset($_POST['stock-admin-actualizar-checkbox']) && !isset($_POST['destacado-admin-actualizar-checkbox']) ){ 
		
		$admin->actualizarEstadoStock($_POST['stock-admin-actualizar-checkbox'],$_POST['id']);
	
	}elseif($_POST['precio-admin-actualizar-checkbox']=='' && $_POST['precio-descuento-admin-actualizar-checkbox']=='' && isset($_POST['stock-admin-actualizar-checkbox']) && isset($_POST['destacado-admin-actualizar-checkbox']) ){  
	
		$admin->actualizarEstadoStockYDestacado($_POST['stock-admin-actualizar-checkbox'],$_POST['destacado-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']!='' && $_POST['precio-descuento-admin-actualizar-checkbox']=='' && !isset($_POST['destacado-admin-actualizar-checkbox']) && !isset($_POST['stock-admin-actualizar-checkbox'])){

		$admin->actualizarPrecio($_POST['precio-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']=='' && isset($_POST['precio-descuento-admin-actualizar-checkbox']) && !isset($_POST['destacado-admin-actualizar-checkbox']) && !isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarPrecioDescuento($_POST['precio-descuento-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']!='' && $_POST['precio-descuento-admin-actualizar-checkbox']!='' && !isset($_POST['destacado-admin-actualizar-checkbox']) && !isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarPrecioYPrecioDescuento($_POST['precio-admin-actualizar-checkbox'],$_POST['precio-descuento-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']!='' && $_POST['precio-descuento-admin-actualizar-checkbox']!='' && isset($_POST['destacado-admin-actualizar-checkbox']) && !isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarPrecioPrecioDescuentoYDestacado($_POST['precio-admin-actualizar-checkbox'],$_POST['precio-descuento-admin-actualizar-checkbox'],$_POST['destacado-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']!='' && $_POST['precio-descuento-admin-actualizar-checkbox']=='' && isset($_POST['destacado-admin-actualizar-checkbox']) && isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarPrecioDestacadoYStock($_POST['precio-admin-actualizar-checkbox'],$_POST['destacado-admin-actualizar-checkbox'],$_POST['stock-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']=='' && $_POST['precio-descuento-admin-actualizar-checkbox']!='' && isset($_POST['destacado-admin-actualizar-checkbox']) && isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarPrecioDescuentoDestacadoYStock($_POST['precio-descuento-admin-actualizar-checkbox'],$_POST['destacado-admin-actualizar-checkbox'],$_POST['stock-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']!='' && $_POST['precio-descuento-admin-actualizar-checkbox']!='' && isset($_POST['destacado-admin-actualizar-checkbox']) && isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarPrecioPrecioDescuentoDestacadoStock($_POST['precio-admin-actualizar-checkbox'],$_POST['precio-descuento-admin-actualizar-checkbox'],$_POST['destacado-admin-actualizar-checkbox'],$_POST['stock-admin-actualizar-checkbox'],$_POST['id']);

	}else if($_POST['precio-admin-actualizar-checkbox']!='' && $_POST['precio-descuento-admin-actualizar-checkbox']!=''  && isset($_POST['stock-admin-actualizar-checkbox'])){
																		
		$admin->actualizarStockPrecioPrecioDescuento($_POST['stock-admin-actualizar-checkbox'],$_POST['precio-admin-actualizar-checkbox'],$_POST['precio-descuento-admin-actualizar-checkbox'],$_POST['id']);

	}
	?>