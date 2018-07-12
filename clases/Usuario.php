<?php 
require_once("BaseDatos.php");
require_once("Producto.php");

class Usuario{

function __construct(){}

function cargarCarrito(){
			$contadorArray=0;

		//Cuento la cantidad de posiciones con cantidad mayor 0 en el carrito

		$data=serialize($_SESSION['carrito']);

			$carritoObtenido=unserialize($data);

			foreach ($carritoObtenido as $producto) {

				if($producto->cantidad!=0){

					$contadorArray++;

				}//if

		}//forEach

		if(!isset($_SESSION['carrito'])){//sino esta seteada $_session agrega el producto al carrito (al menos que tenga 10 productos)

				$_SESSION['carrito'][]=new Producto($_POST['id'],$_POST['marca'],$_POST['modelo'],$_POST['precio'],$_POST['cantidad'],$_POST['imagen'],$_POST['talle'],$_POST['color'],$_POST['tiene_descuento'],$_POST['precio_descuento']);

		header('Location: vermasproducto.php?id='.$_POST['id'].'&alert=on');

		}elseif(isset($_SESSION['carrito']) && $contadorArray<=9){// sino itera hasta encontrar un id igual
				
				$data=serialize($_SESSION['carrito']);

			  	$carritoObtenido=unserialize($data);

			  	$x=0;//si x 1 es igual a uno lo almacena en el array sino unicamente suma las cantidades y se va del for con el break;
			  
			  	foreach ($carritoObtenido as $producto) {


					if($producto->id == $_POST['id'] && $producto->talle==$_POST['talle'] && $producto->color==$_POST['color']){

						$producto->cantidad=$producto->cantidad+$_POST['cantidad'];
						$producto->talle=$_POST['talle'];
						$producto->color=$_POST['color'];

						$x=2;

						break;

					}else{

						$x=1;

					}

				}//forEach

				if($x==1 && $contadorArray<=9){

					$carritoObtenido[]=new Producto($_POST['id'],$_POST['marca'],$_POST['modelo'],$_POST['precio'],$_POST['cantidad'],$_POST['imagen'],$_POST['talle'],$_POST['color'],$_POST['tiene_descuento'],$_POST['precio_descuento']);
					
					$x=0;

				}else{
					echo "<script>alert('No puedes seguir agregando productos al carrito');</script>";	
					header('Location: index.php?session=true');
				
				}

				$_SESSION['carrito']=$carritoObtenido;

				header('Location: vermasproducto.php?id='.$_POST['id'].'&alert=on');
		}else{
				echo "<script>alert('No puedes seguir agregando productos al carrito');</script>";	
				header('Location: index.php?session=true');
		}
}//function

function mostrarCarrito(){

	//if(isset($_GET['session'])){
	if(isset($_SESSION['carrito'])){

	  	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);

	  	$total=0;

	  	$i=0;
		
		


		  	//recorro la lista
			foreach ($carritoObtenido as $producto) {

				//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
				if($producto->cantidad != 0){

					$i++;

					echo '<li>
					
							<img src="img/'.$producto->imagen.'" class="carrito-img img-responsive" width="100" eight="80"
							</li>';

					echo "<li class='item-descripcion-carrito'>";

					echo "
					Marca:".$producto->marca."<br>Modelo:".$producto->modelo."<br>
					 Cantidad unidades: ".$producto->cantidad."<br>
					 Talle: ".$producto->talle."<br>
					 Color: ".$producto->color."<br>
					 Precio:".$producto->cantidad*$producto->precio."$";

					echo '<i class="carrito-borrar-item material-icons" onClick=borrarDeCarrito('.$producto->id.',"'.$producto->talle.'","'.$producto->color.'");>delete</i>';
					 echo "</li>";

					$total=$total+$producto->precio*$producto->cantidad;

				//	echo "<button onClick='borrarDeCarrito(".$producto->id.")'>Eliminar</button><br>";

				}
			}//forEach

			if($total!=0){
			echo "<li class='item-total-carrito'>";
			echo "<a class='boton-comprar-carrito Boton-LinearGradient1' data-toggle='modal' data-target='#myModal' >Comprar</a><br>";
			echo "</li>";

			//echo "</div>";

			}else{
					echo "<li class='item-descripcion-vacio-carrito'>";
					echo "Tu carrito de compras se encuentra vacio";
					echo "</li>";
				}//if anidado
	}else{
		echo "<li class='item-descripcion-vacio-carrito'>";
					echo "Tu carrito de compras se encuentra vacio";
					echo "</li>";		
	}	
//href='comprar.php?session=true&total=".$total."
/*}else{
	session_destroy();
	echo "<p>El carrito esta vacio </p>";
}*/

}//function mostrarCarrito()

function mostrarSubtotal(){

  	$total=0;

if(isset($_SESSION['carrito'])){


  	$i=0;

	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);
		

		  	//recorro la lista
			foreach ($carritoObtenido as $producto) {

				//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
				if($producto->cantidad != 0){

					$i++;

					$total=$total+$producto->precio*$producto->cantidad;


				}
			}//forEach

			
}//if isset

echo $total;

}//function

function mostrarDescuento(){

  	$total=0;

if(isset($_SESSION['carrito'])){


  	$i=0;

	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);
		

		  	//recorro la lista
			foreach ($carritoObtenido as $producto) {

				//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
				if($producto->cantidad != 0){
					if($producto->tiene_descuento==1){

						$i++;

						$total=$total+($producto->precio_descuento*$producto->cantidad)-($producto->precio*$producto->cantidad);

					}
				}
			}//forEach

			
}//if isset

echo $total;

}//function

function mostrarTotal(){

  	$descuentos=0;
  	$subtotal=0;
  	$total=0;

if(isset($_SESSION['carrito'])){


  	$i=0;

	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);
		

		  	//recorro la lista
			foreach ($carritoObtenido as $producto) {

				//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
				if($producto->cantidad != 0){
					
					if($producto->tiene_descuento==1){
					
						$descuentos=$descuentos+($producto->precio_descuento*$producto->cantidad)-($producto->precio*$producto->cantidad);
					
					}
					
					$subtotal=$subtotal+$producto->precio*$producto->cantidad;




				}
			}//forEach

			$total=$subtotal+$descuentos;

			
}//if isset

return $total;

}//function
function verificarCarrito(){

	$baseDatos = new BaseDatos();

	$hubo_precios_modificados=0;



	 if(isset($_SESSION['carrito'])){


	  	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);
	  	
	  	//recorro la lista
		foreach ($carritoObtenido as $producto) {

			//si la cantidad del producto es diferente de  0 acumulo el total
			if($producto->cantidad != 0 && $producto->tiene_descuento==0){

				$stmt=$baseDatos->mysqli->prepare("SELECT PRO.id,PRO.precio,MAR.descripcion,PRO.modelo,PRO.tiene_descuento
												   FROM producto PRO JOIN marca MAR ON PRO.id_marca=MAR.id 
												   WHERE PRO.id=(?) AND MAR.descripcion=(?) AND PRO.modelo=(?)");

				$stmt->bind_param("iss",$producto->id, $producto->marca, $producto->modelo);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila=$resultado->fetch_assoc();

				if($fila['id']==''){//si el id esta vacio es que fue adulterada, la marca el modelo o el tiene descuento por lo tanto corta y redirige al index

					session_destroy();
					header("Location:index.php"); 

				}else if($producto->precio != $fila['precio'] or $producto->tiene_descuento != $fila['tiene_descuento'] ){// sino unicamente actualiza los precios si es que fueran diferentes, la sesion y el registro en la base de datos

					$producto->precio=$fila['precio'];
					$producto->tiene_descuento=$fila['tiene_descuento'];
					$hubo_precios_modificados=1;
				}




			}else if($producto->cantidad != 0 && $producto->tiene_descuento==1){

				$stmt=$baseDatos->mysqli->prepare("SELECT PRO.id,PRO.precio,PRO.precio_descuento,MAR.descripcion,PRO.modelo,PRO.tiene_descuento
												   FROM producto PRO JOIN marca MAR ON PRO.id_marca=MAR.id 
												   WHERE PRO.id=(?) AND MAR.descripcion=(?) AND PRO.modelo=(?)");

				$stmt->bind_param("iss",$producto->id, $producto->marca, $producto->modelo);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila=$resultado->fetch_assoc();

				if($fila['id']==''){
					session_destroy();
					header("Location:index.php"); 


				}else if($producto->precio_descuento != $fila['precio_descuento'] or $producto->tiene_descuento != $fila['tiene_descuento']){

					$producto->precio=$fila['precio'];
					$producto->tiene_descuento=$fila['tiene_descuento'];
					$producto->precio_descuento=$fila['precio_descuento'];

					$hubo_precios_modificados=1;
				}


				
			}

		}//forEach

		$_SESSION['carrito']=$carritoObtenido;


		if($hubo_precios_modificados==1){
			$hubo_precios_modificados=0;
			echo "<script>alert('Hemos actualizado los precios de tu carrito');</script>";
		}
	}else{
		header("Location:index.php");
	}

}

function listarListaDeArticulosComprados(){

	//if(isset($_GET['session'])){
	if(isset($_SESSION['carrito'])){

	  	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);

	  	
		  	//recorro la lista
			foreach ($carritoObtenido as $producto) {

				//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
				if($producto->cantidad != 0){
					if($producto->tiene_descuento==0){

						
						echo "<li>";

						echo "
						Marca:".$producto->marca.", ".$producto->modelo.", ".$producto->cantidad." c/u, ".$producto->cantidad*$producto->precio."$";
						 echo "</li>";
					 }else{
					 	echo "<li>";

						echo "
						Marca:".$producto->marca.", ".$producto->modelo.", ".$producto->cantidad." c/u, ".$producto->cantidad*$producto->precio_descuento."$";
						 echo "</li>";
					 }
				}


			}//forEach

	}		

}//function mostrarCarrito()


function mostrarCantidad(){
		$cant=0;  

if(isset($_SESSION['carrito'])){



	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);
		

		  	//recorro la lista
			foreach ($carritoObtenido as $producto) {

				//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
				if($producto->cantidad != 0){

					$cant+=$producto->cantidad;
					

		
				}
			}//forEach

			
}//if isset

echo $cant;

}

function mostrarCarritoCheckOut(){

	$contador=0;

	$usuario = new Usuario();

	$subtotal=0;
	$descuentos=0;
	$total=0;



	if(isset($_SESSION['carrito'])){
	  	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);

	  	echo "<div class='container'>";
	  	echo "<h1 class='titulos-checkout'>1. Confirma tu Compra</h1>";
	  	echo "<div class='table-responsive'>";
	  	echo "<table id='tabla-checkout'class='table'>
				<tr>
				<th>Producto</th>
				<th></th>
				<th>Talle</th>
				<th>Color</th>
				<th>Envio</th>
				<th>Precio</th>
				<th>Cantidad</th>
				<th>Total</th>
				</tr>";
	  	//recorro la lista
		foreach ($carritoObtenido as $producto) {

			//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
			if($producto->cantidad != 0 && $producto->tiene_descuento==0){

				$contador++;


				echo "<tr>
				<td><img width='100' height='100' src='img/".$producto->imagen."'/></td>
				<td><h4>".$producto->marca."<br>".$producto->modelo."</h4></td>
				<td>".$producto->talle."</td>
				<td>".$producto->color."</td>
				<td><h4>a calcular</h4></td> 
				<td><h4>".$producto->precio."$</h4></td> 
				<td>
				<div class='quantity'>
				<input type='number' class='cantidad-input' id='cantidad".$contador."' name='cantidad' min='1' max='20' onChange=actualizarCantidad".$contador."(".$producto->id.",'".$producto->color."','".$producto->talle."') value='".$producto->cantidad."'/>
				</div>
				</td> 
				<td><h4 class='total-tabla-checkout'>".$producto->cantidad*$producto->precio."$</h4><i class='close-total-checkout material-icons' onClick='borrarDeCarritoCheckOut(".$producto->id.")'>close</i><br></tr>";
				
				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

			}else if($producto->cantidad !=0 && $producto->tiene_descuento==1){

				$contador++;

				echo "<tr>
				<td><img width='100' height='100' src='img/".$producto->imagen."'/></td>
				<td><h4>".$producto->marca."<br>".$producto->modelo."</h4></td>
				<td>".$producto->talle."</td>
				<td>".$producto->color."</td>
				<td><h4>a calcular</h4></td> 
				<td><h4>".$producto->precio."$</h4></td> 
				<td>
				<div class='quantity'>
				<input type='number' class='cantidad-input' id='cantidad".$contador."' name='cantidad' min='1' max='20' onChange=actualizarCantidad".$contador."(".$producto->id.",'".$producto->color."','".$producto->talle."') value='".$producto->cantidad."'/>
				</div>
				</td> 
				<td><h4 class='total-tabla-checkout'>".$producto->cantidad*$producto->precio_descuento."$</h4><i class='close-total-checkout material-icons' onClick='borrarDeCarritoCheckOut(".$producto->id.")'>close</i><br></tr>";				
				
				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

				$descuentos=$descuentos+($producto->precio_descuento*$producto->cantidad)-($producto->precio*$producto->cantidad);

			}
		}//forEach

		$total=+$subtotal+$descuentos;

		echo "<tr><td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
				<td class='totales'><h4><b>Subtotal:</b></h4></td>
					<td class='totales'><h4 class='total-tabla-checkout'><b>".$subtotal."$</b></h4></td>
					
					</tr>";
		echo "<tr><td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'><h4><b>Descuentos:</b></h4></td>
					<td class='totales'><h4 class='total-tabla-checkout'><b><span class='span-table'>".$descuentos."$</span></b></h4></td>
					</tr>";
		echo "<tr><td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>
					<td class='totales'></td>

					<td class='totales'><h4><b>Total:</b></h4></td>
					<td class='totales'><h4 class='total-tabla-checkout'><b>".$total."$</b></h4></td>
					</tr>";
		echo "</table>";
			echo "</div>";//table responsive
		echo "</div>";//container


}else{
	header("location: index.php");
}


}//function mostrarCarrito()

function mostrarTotalCheckOut(){

	if(isset($_GET['session'])){
	  	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);

	  	$subtotal=0;
	  	$descuento=0;

	  	//recorro la lista
		foreach ($carritoObtenido as $producto) {

			//si la cantidad del producto es diferente de  0 acumulo el total
			if($producto->cantidad != 0 && $producto->tiene_descuento==0){

			$subtotal=$subtotal+$producto->precio*$producto->cantidad;

			}else if($producto->cantidad != 0 && $producto->tiene_descuento==1){
				$descuento=$descuento+$producto->precio_descuento*$producto->cantidad-($producto->precio*$producto->cantidad);
				$subtotal=$subtotal+$producto->precio*$producto->cantidad;
			}

		}//forEach

		$total=$subtotal+$descuento;

		echo "	 <ul>
				  <li>Subtotal:<span>".$subtotal."$</span></li>
				  <li>Descuento:<span>".$descuento."$</span></li>
				  <li>Total:<span id='total'>".$total."$</span></li>
				  </ul>
				  <input type='hidden' name='total' value='".$total."'/>
				  <button id='btn-form'>Comprar</button>";


	}else{
		session_destroy();
		echo "<p>El carrito esta vacio </p>";
	}


}



function mostrarComprobantes($email){

		$baseDatos = new BaseDatos();


		$stmt=$baseDatos->mysqli->prepare("SELECT DISTINCT UCP.comprobante_nro,UCP.fecha,MDP.descripcion
									  FROM usuario_compra_producto UCP JOIN medio_de_pago MDP ON UCP.id_medio_pago=MDP.id_medio_pago
									  									JOIN usuario USU ON USU.email=UCP.email_usuario
									  WHERE UCP.email_usuario=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){

			$total=0;
			$buscar=$fila['comprobante_nro'];

			$sql2="SELECT UCP.marca as marca,UCP.modelo,UCP.precio,UCP.tiene_descuento,UCP.precio_descuento,UCP.cantidad
				   FROM usuario_compra_producto UCP 
				   WHERE UCP.comprobante_nro='$buscar'";

			$consulta2=mysqli_query($baseDatos->conexion,$sql2);

			echo "	<div class='container'>
					<div class='row'>
					<div class='col-xs-12 col-sm-12 col-md-12 col-lg-12'>
					<div class='comprobante'>
					<div class='row'>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
						<h5><b>Nro Comprobante:".$buscar."</b></h5>
						</div>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
						<h5><b>Medio de Pago : ".$fila['descripcion']."</b></h5>
						</div>
						<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>
						<h5 class='fecha'><b>".$fila['fecha']."</b></h5>
						</div>
					</div>";

					echo "<ul>";
					//Listo los registros que corresponden a los nro de comprobante
					while($fila2=mysqli_fetch_assoc($consulta2)){

							if($fila2['tiene_descuento']==1){

							$total=$total+$fila2['precio_descuento']*$fila2['cantidad'];

							echo " <li><p>".$fila2['marca']." ".$fila2['modelo']." ".$fila2['cantidad']."/u $".$fila2['precio_descuento']."</p></li>";
							
							}else{

							$total=$total+$fila2['precio']*$fila2['cantidad'];	

							echo "<li><p>".$fila2['marca']." ".$fila2['modelo']." ".$fila2['cantidad']."/u $".$fila2['precio']."</p></li>";
							
							}//if

						}//while

					echo "</ul>";

						echo "<h4 class='total-comprobante'><b>Total:$".$total."</b></h4>";
						echo "<a class='carrito-checkout-btn' href='comprobante.php?nro=".$buscar."' target='__blank'>Imprimir</a>";
						echo "</div>";
						echo "</div>";
						echo "</div>";
						echo "</div>";


		}//while prin
		$stmt->close();

	}//function

function listarUnSoloComprobante($comprobante,$email){

		$baseDatos = new BaseDatos();

		$total=0;

		$stmt2=$baseDatos->mysqli->prepare("SELECT UCP.fecha,MDP.descripcion
											   FROM usuario_compra_producto UCP JOIN medio_de_pago MDP ON UCP.id_medio_pago=MDP.id_medio_pago
											   WHERE UCP.comprobante_nro=(?)");

		$stmt2->bind_param("s",$comprobante);

		$stmt2->execute();

		$resultado2=$stmt2->get_result();

		$fila2=$resultado2->fetch_assoc();

		$stmt=$baseDatos->mysqli->prepare("SELECT UCP.marca as marca,UCP.modelo,UCP.precio,UCP.tiene_descuento,UCP.precio_descuento,UCP.cantidad
											   FROM usuario_compra_producto UCP JOIN medio_de_pago MDP ON UCP.id_medio_pago=MDP.id_medio_pago
											   WHERE UCP.comprobante_nro=(?) AND UCP.email_usuario=(?)");

		$stmt->bind_param("ss",$comprobante,$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		echo "<div class='comprobante'>
					<div class='row'>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
						<h5><b>Nro Comprobante:".$comprobante."</b></h5>
						</div>
						<div class='col-xs-4 col-sm-4 col-md-4 col-lg-4'>
						<h5><b>Medio de Pago : ".$fila2['descripcion']."</b></h5>
						</div>
						<div class='col-xs-2 col-sm-2 col-md-2 col-lg-2'>
						<h5 class='fecha'><b>".$fila2['fecha']."</b></h5>
						</div>
					</div>";

					echo "<ul>";

		while($fila=$resultado->fetch_assoc()){

			if($fila['tiene_descuento']==1){

				$total=$total+$fila['precio_descuento']*$fila['cantidad'];

				echo "<li><p>".$fila['marca']." ".$fila['modelo']." ".$fila['cantidad']."/u $".$fila['precio_descuento']."</p></li>";
				
			}else{

				$total=$total+$fila['precio']*$fila['cantidad'];	

				echo "<li><p>".$fila['marca']." ".$fila['modelo']." ".$fila['cantidad']."/u $".$fila['precio']."</p></li>";
				
			}//if



		}//while

		echo "</ul>";
		$stmt->close();

		echo "<p class='total-comprobante'><b>Total:$".$total."</b></p>";
		echo "</div>";



}//function

function actualizarCarrito($id,$color,$talle,$cantidad){
	
	  	$data=serialize($_SESSION['carrito']);

	  	$carritoObtenido=unserialize($data);


	  	//recorro la lista
		foreach ($carritoObtenido as $producto) {

			//si la cantidad del producto es diferente de  0 muestro la informacion del carrito
			if($producto->cantidad != 0){
				if($producto->id == $id AND $producto->color==$color AND $producto->talle==$talle){
					$producto->cantidad=$cantidad;


				}

			}//if
		}//forEach

		$_SESSION['carrito']=$carritoObtenido;

}//function

public function obtenerIp(){

if (!empty($_SERVER['HTTP_CLIENT_IP'])){

	return $_SERVER['HTTP_CLIENT_IP'];
}//if
if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	
	return $_SERVER['HTTP_X_FORWARDED_FOR'];
	
	return $_SERVER['REMOTE_ADDR'];
}//if
}//function





}//class



?>	