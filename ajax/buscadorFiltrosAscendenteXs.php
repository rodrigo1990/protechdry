<?php 
require_once("../clases/Buscador.php");
$buscador=new Buscador();


$buscador->buscarPorFiltrosAscendenteXs($_POST['tipo_de_vehiculo'],$_POST['rodado'],$_POST['marca'],$_POST['categoria'],$_POST['ancho'],$_POST['alto']);

 ?>