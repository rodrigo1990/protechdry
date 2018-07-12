<?php 
require_once("BaseDatos.php");


class Buscador{

		public $baseDatos;


	public function __construct(){

		$this->baseDatos = new BaseDatos;
	}

public function buscarCubiertas($cubiertaBuscada){

	//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$cubiertaBuscada = str_replace($caracteres_malos, $caracteres_buenos, $cubiertaBuscada);
$resultado=0;
//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

if (isset($cubiertaBuscada)) {


	$marca="%{$cubiertaBuscada}%";
	$modelo="%{$cubiertaBuscada}%";
	$ancho="%{$cubiertaBuscada}%";
	$alto="%{$cubiertaBuscada}%";


	$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho ,ALT.descripcion AS alto
	FROM producto PRO JOIN marca MAR ON PRO.id_marca=MAR.id
					  JOIN ancho ANC ON PRO.id_ancho=ANC.id
					  JOIN alto ALT ON PRO.id_alto=ALT.id
	WHERE MAR.descripcion  LIKE (?) OR PRO.modelo LIKE (?) OR ANC.descripcion LIKE (?) OR ALT.descripcion LIKE (?)");

				$stmt->bind_param("ssss",$marca,$modelo,$ancho,$alto);

				$stmt->execute();

				$stmt->store_result();


		if ($stmt->num_rows  == 0) {

			$mensaje = '<li class="list-busqueda-menu">No hay ningún producto con este nombre</li>';


		}else {//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
				
			$stmt->bind_param("ssss",$marca,$modelo,$ancho,$alto);

				$stmt->execute();

				$resultado=$stmt->get_result();

			echo '<li class="list-busqueda-menu">Resultados para <strong>'.$cubiertaBuscada.'</strong></li>';
				

			//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
			$mensaje="";
			while($fila=$resultado->fetch_assoc()){

			$id=$fila['id'];
			$marca = $fila['marca'];
			$modelo=$fila['modelo'];
			$ancho=$fila['ancho'];
			$alto=$fila['alto'];

		//Output
			$mensaje.= '<li class="list-busqueda-menu"> <a class="a-busqueda-menu" href="vermasproducto.php?id='.$id.'"><strong>Marca:</strong> '.$marca.'<strong> Modelo: </strong> '.$modelo.' <strong>Medida:</strong> '.$ancho.'x '.$alto.'<br></a></li>';

									

		};//while

	}//else

	echo $mensaje;

			}//if isset
}

public function buscarCubiertasAdmin($cubiertaBuscada){

	//Filtro anti-XSS
$caracteres_malos = array("<", ">", "\"", "'", "/", "<", ">", "'", "/");
$caracteres_buenos = array("& lt;", "& gt;", "& quot;", "& #x27;", "& #x2F;", "& #060;", "& #062;", "& #039;", "& #047;");
$cubiertaBuscada = str_replace($caracteres_malos, $caracteres_buenos, $cubiertaBuscada);
$resultado=0;
//Variable vacía (para evitar los E_NOTICE)
$mensaje = "";

if (isset($cubiertaBuscada)) {

	$cubierta="%{$cubiertaBuscada}%";

	$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho ,ALT.descripcion AS alto
	FROM producto PRO JOIN marca MAR ON PRO.id_marca=MAR.id
					  JOIN ancho ANC ON PRO.id_ancho=ANC.id
					  JOIN alto ALT ON PRO.id_alto=ALT.id
	WHERE MAR.descripcion  LIKE (?) OR PRO.modelo LIKE (?) OR ANC.descripcion LIKE (?) OR ALT.descripcion LIKE (?)");

				$stmt->bind_param("ssss",$cubierta,$cubierta,$cubierta,$cubierta);

				$stmt->execute();

				$stmt->store_result();


		if ($stmt->num_rows  == 0) {

			$mensaje = '<li class="list-busqueda-menu">No hay ningún producto con este nombre</li>';


		}else {//Si existe alguna fila que sea igual a $consultaBusqueda, entonces mostramos el siguiente mensaje
				
			$stmt->bind_param("ssss",$cubierta,$cubierta,$cubierta,$cubierta);

				$stmt->execute();

				$resultado=$stmt->get_result();

			echo '<li class="list-busqueda-menu">Resultados para <strong>'.$cubiertaBuscada.'</strong></li>';
				

			//La variable $resultado contiene el array que se genera en la consulta, así que obtenemos los datos y los mostramos en un bucle
			$mensaje="";
			while($fila=$resultado->fetch_assoc()){

			$id=$fila['id'];
			$marca = $fila['marca'];
			$modelo=$fila['modelo'];
			$ancho=$fila['ancho'];
			$alto=$fila['alto'];

		//Output
			$mensaje.= '<li class="list-busqueda-menu"> <a class="a-busqueda-menu" href="usuario-admin-actualizar-productos-ver-mas-2.php?id='.$id.'" target="_blank"><strong>Marca:</strong> '.$marca.'<strong> Modelo: </strong> '.$modelo.' <strong>Medida:</strong> '.$ancho.'x '.$alto.'<br></a></li>';

									

		};//while

	}//else

	echo $mensaje;

			}//if isset
}

public function buscarPorFiltros($tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto){

		$confirmacion_busqueda=0;
		$z=0;


		if($tipo_de_vehiculo!='valor_nulo' && $rodado=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										WHERE TV.descripcion=(?)");

			$stmt->bind_param("s",$tipo_de_vehiculo);

			$confirmacion_busqueda=1;


	}elseif($rodado!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?)");

			$stmt->bind_param("i",$rodado);

			$confirmacion_busqueda=1;


	}elseif($marca!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){
			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?)");

			$stmt->bind_param("s",$marca);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?)");

			$stmt->bind_param("s",$categoria);

			$confirmacion_busqueda=1;


	}elseif($ancho!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?)");

			$stmt->bind_param("i",$ancho);

			$confirmacion_busqueda=1;		


	}elseif($alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_alto=(?)");

			$stmt->bind_param("i",$alto);

			$confirmacion_busqueda=1;		


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo' && $marca=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?)");

			$stmt->bind_param("si",$tipo_de_vehiculo,$rodado);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo' && $rodado=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?)");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$marca);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("si",$tipo_de_vehiculo,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$alto!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("si",$tipo_de_vehiculo,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?)");

			$stmt->bind_param("is",$rodado,$marca);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("is",$rodado,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ii",$rodado,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ii",$rodado,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("ss",$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("si",$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("si",$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("si",$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("si",$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($ancho!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ii",$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?)");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$marca);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$categoria);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$ancho);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$alto!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$alto);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("sss",$tipo_de_vehiculo,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("iss",$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("isi",$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isi",$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("isi",$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isi",$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("iii",$rodado,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ssi",$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssi",$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("siss",$tipo_de_vehiculo,$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $alto!='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}






	elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $ancho!='valor_nulo' && $alto=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $alto!='valor_nulo' && $ancho=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isii",$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $categoria !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $marca=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isii",$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $categoria!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssii",$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $tipo_de_vehiculo!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssii",$marca,$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho!='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $alto!='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sssii",$tipo_de_vehiculo,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("issii",$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sissii",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}






if($confirmacion_busqueda==1){
		$stmt->execute();

		$resultado=$stmt->get_result();
		
		while($fila=$resultado->fetch_assoc()){
			$z++;

			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-15 col-sm-15 col-md-15 col-lg-15'>
					<div class='producto-responsive'>


						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='125' height='125'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'  >Ver mas</a></div>

						</div>
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
					$cien=100;
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-15 col-sm-15 col-md-15 col-lg-15'>
						<div class='producto-responsive'>

						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='125' height='125'>
						<h3 class='producto-porcentaje-descuento'>".-floor(($fila['precio']-$fila['precio_descuento'])/$fila['precio']*$cien)."%</h3>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $".$fila['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."' >Ver mas</a></div>
				
					</div>
					</div>";	

					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
		}//while
		
	

		$stmt->close();
}//if confirmacion_busqueda==1
}//function


	public function buscarPorFiltrosAscendente($tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto){

		$confirmacion_busqueda=0;
		$z=0;

		if($tipo_de_vehiculo!='valor_nulo' && $rodado=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										WHERE TV.descripcion=(?)
										ORDER BY PRO.precio ASC");

			$stmt->bind_param("s",$tipo_de_vehiculo);

			$confirmacion_busqueda=1;


	}elseif($rodado!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("i",$rodado);

			$confirmacion_busqueda=1;


	}elseif($marca!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){
			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("s",$marca);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("s",$categoria);

			$confirmacion_busqueda=1;


	}elseif($ancho!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("i",$ancho);

			$confirmacion_busqueda=1;		


	}elseif($alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("i",$alto);

			$confirmacion_busqueda=1;		


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo' && $marca=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$rodado);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo' && $rodado=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$marca);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$alto!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("is",$rodado,$marca);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("is",$rodado,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ii",$rodado,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ii",$rodado,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ss",$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($ancho!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ii",$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$marca);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$categoria);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$ancho);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$alto!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$alto);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sss",$tipo_de_vehiculo,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("iss",$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("iii",$rodado,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("siss",$tipo_de_vehiculo,$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $alto!='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}






	elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $ancho!='valor_nulo' && $alto=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $alto!='valor_nulo' && $ancho=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isii",$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $categoria !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $marca=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isii",$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $categoria!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssii",$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $tipo_de_vehiculo!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssii",$marca,$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho!='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $alto!='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sssii",$tipo_de_vehiculo,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("issii",$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sissii",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}






if($confirmacion_busqueda==1){
		$stmt->execute();

		$resultado=$stmt->get_result();
		
		while($fila=$resultado->fetch_assoc()){
			$z++;

		if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-15 col-sm-15 col-md-15 col-lg-15'>
					<div class='producto-responsive'>


						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='125' height='125'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'>Ver mas</a></div>

						</div>
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
					$cien=100;
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-15 col-sm-15 col-md-15 col-lg-15'>
						<div class='producto-responsive'>

						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='125' height='125'>
						<h3 class='producto-porcentaje-descuento'>".-floor(($fila['precio']-$fila['precio_descuento'])/$fila['precio']*$cien)."%</h3>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $".$fila['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'>Ver mas</a></div>
				
					</div>
					</div>";	

					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
		}//while producto-buscador-filtros
		
	

		$stmt->close();
}//if confirmacion_busqueda==1
}//function
public function buscarPorFiltrosDescendente($tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto){

		$confirmacion_busqueda=0;
		$z=0;

		if($tipo_de_vehiculo!='valor_nulo' && $rodado=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										WHERE TV.descripcion=(?)
										ORDER BY PRO.precio DESC");

			$stmt->bind_param("s",$tipo_de_vehiculo);

			$confirmacion_busqueda=1;


	}elseif($rodado!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("i",$rodado);

			$confirmacion_busqueda=1;


	}elseif($marca!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){
			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("s",$marca);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("s",$categoria);

			$confirmacion_busqueda=1;


	}elseif($ancho!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("i",$ancho);

			$confirmacion_busqueda=1;		


	}elseif($alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("i",$alto);

			$confirmacion_busqueda=1;		


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo' && $marca=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$rodado);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo' && $rodado=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$marca);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$alto!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("is",$rodado,$marca);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("is",$rodado,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ii",$rodado,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ii",$rodado,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ss",$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($ancho!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ii",$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$marca);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$categoria);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$ancho);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$alto!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$alto);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sss",$tipo_de_vehiculo,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("iss",$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("iii",$rodado,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("siss",$tipo_de_vehiculo,$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $alto!='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}






	elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $ancho!='valor_nulo' && $alto=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $alto!='valor_nulo' && $ancho=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isii",$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $categoria !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $marca=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isii",$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $categoria!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssii",$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $tipo_de_vehiculo!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssii",$marca,$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho!='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $alto!='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sssii",$tipo_de_vehiculo,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("issii",$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sissii",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}






if($confirmacion_busqueda==1){
		$stmt->execute();

		$resultado=$stmt->get_result();
		
		while($fila=$resultado->fetch_assoc()){
			$z++;

	if($fila['tiene_descuento']==0){
				

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-15 col-sm-15 col-md-15 col-lg-15'>
					<div class='producto-responsive'>


						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='125' height='125'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'>Ver mas</a></div>

						</div>
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
					$cien=100;
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-15 col-sm-15 col-md-15 col-lg-15'>
						<div class='producto-responsive'>

						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='125' height='125'>
						<h3 class='producto-porcentaje-descuento'>".-floor(($fila['precio']-$fila['precio_descuento'])/$fila['precio']*$cien)."%</h3>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $".$fila['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'>Ver mas</a></div>
				
					</div>
					</div>";	

					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
		}//while
		
	

		$stmt->close();
}//if confirmacion_busqueda==1
}//function


public function buscarPorFiltrosXs($tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto){

		$confirmacion_busqueda=0;
		$z=0;


		if($tipo_de_vehiculo!='valor_nulo' && $rodado=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										WHERE TV.descripcion=(?)");

			$stmt->bind_param("s",$tipo_de_vehiculo);

			$confirmacion_busqueda=1;


	}elseif($rodado!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?)");

			$stmt->bind_param("i",$rodado);

			$confirmacion_busqueda=1;


	}elseif($marca!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){
			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?)");

			$stmt->bind_param("s",$marca);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?)");

			$stmt->bind_param("s",$categoria);

			$confirmacion_busqueda=1;


	}elseif($ancho!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?)");

			$stmt->bind_param("i",$ancho);

			$confirmacion_busqueda=1;		


	}elseif($alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_alto=(?)");

			$stmt->bind_param("i",$alto);

			$confirmacion_busqueda=1;		


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo' && $marca=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?)");

			$stmt->bind_param("si",$tipo_de_vehiculo,$rodado);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo' && $rodado=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?)");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$marca);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("si",$tipo_de_vehiculo,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$alto!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("si",$tipo_de_vehiculo,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?)");

			$stmt->bind_param("is",$rodado,$marca);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("is",$rodado,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ii",$rodado,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ii",$rodado,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("ss",$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("si",$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("si",$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("si",$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("si",$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($ancho!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ii",$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?)");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$marca);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$categoria);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$ancho);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$alto!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$alto);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("sss",$tipo_de_vehiculo,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("iss",$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("isi",$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isi",$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("isi",$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isi",$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("iii",$rodado,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("ssi",$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssi",$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)");

			$stmt->bind_param("siss",$tipo_de_vehiculo,$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $alto!='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}






	elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $ancho!='valor_nulo' && $alto=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $alto!='valor_nulo' && $ancho=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isii",$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $categoria !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $marca=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("isii",$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $categoria!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssii",$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $tipo_de_vehiculo!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("ssii",$marca,$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho!='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $alto!='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sssii",$tipo_de_vehiculo,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("issii",$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)");

			$stmt->bind_param("sissii",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}






if($confirmacion_busqueda==1){
		$stmt->execute();

		$resultado=$stmt->get_result();
		
		while($fila=$resultado->fetch_assoc()){
			$z++;

			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					<div class='producto-responsive'>


						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='125' height='125'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'  >Ver mas</a></div>

						</div>
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
					$cien=100;
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
						<div class='producto-responsive'>

						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='125' height='125'>
						<h3 class='producto-porcentaje-descuento'>".-floor(($fila['precio']-$fila['precio_descuento'])/$fila['precio']*$cien)."%</h3>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $".$fila['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."' >Ver mas</a></div>
				
					</div>
					</div>";	

					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
		}//while
		
	

		$stmt->close();
}//if confirmacion_busqueda==1
}//function


	public function buscarPorFiltrosAscendenteXs($tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto){

		$confirmacion_busqueda=0;
		$z=0;

		if($tipo_de_vehiculo!='valor_nulo' && $rodado=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										WHERE TV.descripcion=(?)
										ORDER BY PRO.precio ASC");

			$stmt->bind_param("s",$tipo_de_vehiculo);

			$confirmacion_busqueda=1;


	}elseif($rodado!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("i",$rodado);

			$confirmacion_busqueda=1;


	}elseif($marca!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){
			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("s",$marca);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("s",$categoria);

			$confirmacion_busqueda=1;


	}elseif($ancho!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("i",$ancho);

			$confirmacion_busqueda=1;		


	}elseif($alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("i",$alto);

			$confirmacion_busqueda=1;		


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo' && $marca=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$rodado);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo' && $rodado=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$marca);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$alto!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("is",$rodado,$marca);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("is",$rodado,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ii",$rodado,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ii",$rodado,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ss",$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("si",$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($ancho!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ii",$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$marca);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$categoria);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$ancho);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$alto!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$alto);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sss",$tipo_de_vehiculo,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("iss",$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isi",$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("iii",$rodado,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssi",$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("siss",$tipo_de_vehiculo,$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $alto!='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}






	elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $ancho!='valor_nulo' && $alto=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $alto!='valor_nulo' && $ancho=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isii",$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $categoria !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $marca=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("isii",$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $categoria!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssii",$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $tipo_de_vehiculo!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("ssii",$marca,$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho!='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $alto!='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sssii",$tipo_de_vehiculo,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("issii",$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio ASC");

			$stmt->bind_param("sissii",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}






if($confirmacion_busqueda==1){
		$stmt->execute();

		$resultado=$stmt->get_result();
		
		while($fila=$resultado->fetch_assoc()){
			$z++;

		if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					<div class='producto-responsive'>


						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='125' height='125'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'  >Ver mas</a></div>

						</div>
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
					$cien=100;
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
						<div class='producto-responsive'>

						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='125' height='125'>
						<h3 class='producto-porcentaje-descuento'>".-floor(($fila['precio']-$fila['precio_descuento'])/$fila['precio']*$cien)."%</h3>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $".$fila['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."' >Ver mas</a></div>
				
					</div>
					</div>";	

					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
		}//while producto-buscador-filtros
		
	

		$stmt->close();
}//if confirmacion_busqueda==1
}//function
public function buscarPorFiltrosDescendenteXs($tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto){

		$confirmacion_busqueda=0;
		$z=0;

		if($tipo_de_vehiculo!='valor_nulo' && $rodado=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										WHERE TV.descripcion=(?)
										ORDER BY PRO.precio DESC");

			$stmt->bind_param("s",$tipo_de_vehiculo);

			$confirmacion_busqueda=1;


	}elseif($rodado!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("i",$rodado);

			$confirmacion_busqueda=1;


	}elseif($marca!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado =='valor_nulo' && $categoria=='valor_nulo' && $ancho=='valor_nulo' && $alto=='valor_nulo'){
			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("s",$marca);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("s",$categoria);

			$confirmacion_busqueda=1;


	}elseif($ancho!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("i",$ancho);

			$confirmacion_busqueda=1;		


	}elseif($alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $marca =='valor_nulo' && $rodado=='valor_nulo'  && $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("i",$alto);

			$confirmacion_busqueda=1;		


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo' && $marca=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$rodado);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo' && $rodado=='valor_nulo' && $categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$marca);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ss",$tipo_de_vehiculo,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$alto!='valor_nulo' && $rodado=='valor_nulo' && $marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$tipo_de_vehiculo,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("is",$rodado,$marca);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("is",$rodado,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ii",$rodado,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ii",$rodado,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ss",$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("si",$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($ancho!='valor_nulo'&& $alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ii",$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$marca);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$marca=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sis",$tipo_de_vehiculo,$rodado,$categoria);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$ancho);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$rodado!='valor_nulo'&&$alto!='valor_nulo'&&$marca=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$rodado,$alto);

			$confirmacion_busqueda=1;


	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$rodado=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sss",$tipo_de_vehiculo,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$tipo_de_vehiculo,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$rodado=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$categoria!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("iss",$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$marca!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isi",$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $marca=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("iii",$rodado,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$categoria!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssi",$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($categoria!='valor_nulo'&&$ancho!='valor_nulo'&&$alto!='valor_nulo'&&$tipo_de_vehiculo=='valor_nulo'&& $rodado=='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sii",$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("siss",$tipo_de_vehiculo,$rodado,$marca,$categoria);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $categoria=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $alto!='valor_nulo'&& $categoria=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$marca,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $marca=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $marca=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisi",$tipo_de_vehiculo,$rodado,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $alto!='valor_nulo'&& $rodado=='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sssi",$tipo_de_vehiculo,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}






	elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $ancho!='valor_nulo' && $alto=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $categoria=='valor_nulo' && $alto!='valor_nulo' && $ancho=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("issi",$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isii",$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $categoria !='valor_nulo'&& $ancho!='valor_nulo' && $alto!='valor_nulo' && $marca=='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("isii",$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $categoria!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssii",$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($marca !='valor_nulo'&& $tipo_de_vehiculo!='valor_nulo' && $ancho!='valor_nulo' && $alto!='valor_nulo' && $categoria=='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE MAR.descripcion=(?) AND TV.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("ssii",$marca,$tipo_de_vehiculo,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $ancho!='valor_nulo' && $alto=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_ancho=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $categoria!='valor_nulo'&& $alto!='valor_nulo' && $ancho=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sissi",$tipo_de_vehiculo,$rodado,$marca,$categoria,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $categoria=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$marca,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $marca=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sisii",$tipo_de_vehiculo,$rodado,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $rodado=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sssii",$tipo_de_vehiculo,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo' && $tipo_de_vehiculo=='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("issii",$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}elseif($tipo_de_vehiculo!='valor_nulo' && $rodado!='valor_nulo' && $marca!='valor_nulo' && $categoria !='valor_nulo' && $ancho!='valor_nulo'&& $alto!='valor_nulo'){

			$stmt=$this->baseDatos->mysqli->prepare("SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,ROD.descripcion as rodado,TV.descripcion AS tipo_vehiculo,CAT.descripcion
										 FROM producto PRO 	JOIN marca MAR ON MAR.id=PRO.id_marca
										 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
										 					JOIN alto ALT ON ALT.id=PRO.id_alto
										 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
										 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
										 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
										 WHERE TV.descripcion=(?) AND ROD.descripcion=(?) AND MAR.descripcion=(?) AND CAT.descripcion=(?) AND  PRO.id_ancho=(?) AND PRO.id_alto=(?)
										 ORDER BY PRO.precio DESC");

			$stmt->bind_param("sissii",$tipo_de_vehiculo,$rodado,$marca,$categoria,$ancho,$alto);

			$confirmacion_busqueda=1;

	}






if($confirmacion_busqueda==1){
		$stmt->execute();

		$resultado=$stmt->get_result();
		
		while($fila=$resultado->fetch_assoc()){
			$z++;

	if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					<div class='producto-responsive'>


						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='125' height='125'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."'  >Ver mas</a></div>

						</div>
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
					$cien=100;
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
						<div class='producto-responsive'>

						<h3 class='titulo-buscador'>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='125' height='125'>
						<h3 class='producto-porcentaje-descuento'>".-floor(($fila['precio']-$fila['precio_descuento'])/$fila['precio']*$cien)."%</h3>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $".$fila['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila['ancho']." x ".$fila['alto']."</li>
						<li>Rodado:".$fila['rodado']."</li>
						<li>Vehiculo:".$fila['tipo_vehiculo']."</li>
						<li>Categoria:".$fila['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila['id']."' >Ver mas</a></div>
				
					</div>
					</div>";	

					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
		}//while
		
	

		$stmt->close();
}//if confirmacion_busqueda==1
}//function



}//class

 ?>