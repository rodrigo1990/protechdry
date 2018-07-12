<?php
require_once("../clases/Buscador.php");
//Variable de búsqueda
$cubiertaBuscada = $_GET['cubiertaBuscada'];

$buscador = new Buscador();

$buscador->buscarCubiertas($cubiertaBuscada);



?>