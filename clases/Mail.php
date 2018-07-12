<?php
require_once('Producto.php');
class Mail{

	function __construct(){}


	function enviarComprobantePagoExitosoMercadoPago(){

		$total=0;

		$subtotal=0;

		$descuentos=0;

		$destinatario = $_SESSION["email"];

		$data=serialize($_SESSION['carrito']);

		$carritoObtenido=unserialize($data);

		$asunto = "Compra de productos Oeste Neumaticos"; 

$cuerpo = ' 
			<html> 
			<head> 
			   <title>¡Enhorabuena!</title> 
			</head> 
			<body> 
			<h1 style="color:orange;">Oeste Neumaticos</h1>
			<p><i>'.date("d-m-y").'</i></p> 
			<p><i>Comprobante N°:'.$_SESSION['referencia'].'</i></p>
			<p><i>Comprobante Mercado Pago°:'.$_GET['collection_id'].'</i></p>
			<p><i>('.ucwords(strtolower($_SESSION['nombre'])).' '.ucwords(strtolower($_SESSION['apellido'])).','.$_SESSION['tipo_dni'].' '.$_SESSION['dni'].')</i></p>';

			$cuerpo.='<p style="color:black;">Entrega este comprobante al momento de retirar tu compra
			efectuada en nuestro sitio web <b>OesteNeumaticos.com</b><br<br>
			Si nececitas que te lo enviemos a cualquier punto del pais, comunicate con nosotros, o de otra manera, ¡lo haremos nosotros!.
			 </p>

			</p>

			<table>
				<tr>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Precio unitario</th>
					<th>Cantidad</th>
					<th>Precio total por unidad</th>
				</tr>';

foreach ($carritoObtenido as $producto) {

			if ($producto->cantidad!=0 && $producto->tiene_descuento==0) {
				$cuerpo.="<tr>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->marca;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->modelo;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->precio;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad*$producto->precio;
				$cuerpo.="</td>";
				$cuerpo.="</tr>";

				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

			}
			if ($producto->cantidad!=0 && $producto->tiene_descuento==1) {
				$cuerpo.="<tr>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->marca;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->modelo;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->precio_descuento;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad*$producto->precio_descuento;
				$cuerpo.="</td>";
				$cuerpo.="</tr>";

				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

				$descuentos=$descuentos+($producto->precio_descuento*$producto->cantidad)-($producto->precio*$producto->cantidad);
			}
		}//for each

$total=+$subtotal+$descuentos;


$cuerpo.="<tr><td></td><td></td><td></td><td></td> <td><p style='margin-left:45%;'><b>Total: ".$total."$</b></p></td></tr>";
$cuerpo.="</table>
			<p><i>Pringles 1898,(011)3161-6596 Ituzaingo, GBA</i></p>
			<p><i>ventas@oesteneumaticos.com.ar</i></p>
			</body></html>
			

			";





//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: Oeste Neumaticos <ventas@oesteneumaticos.com.ar>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: tatirod91@gmail.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc: tatyrod5@gmail.com\r\n"; 


mail($destinatario,$asunto,$cuerpo,$headers);

//echo "Hemos enviado un comprobante de compra a tu email, lo requerimos al momento de la entrega";
	}//function
	function enviarComprobantePagoExitosoTodoPago(){

		$total=0;

		$subtotal=0;

		$descuentos=0;

		$destinatario = $_SESSION["email"];

		$data=serialize($_SESSION['carrito']);

		$carritoObtenido=unserialize($data);

		$asunto = "Compra de productos Oeste Neumaticos"; 

$cuerpo = ' 
			<html> 
			<head> 
			   <title>¡Enhorabuena!</title> 
			</head> 
			<body> 
			<h1 style="color:orange;">Oeste Neumaticos</h1>
			<p><i>'.date("d-m-y").'</i></p> 
			<p><i>Comprobante N°:'.$_SESSION['referencia'].'</i></p>
			<p><i>Comprobante Todo Pago°:'.$_GET['operationid'].'</i></p>
			<p><i>('.ucwords(strtolower($_SESSION['nombre'])).' '.ucwords(strtolower($_SESSION['apellido'])).','.$_SESSION['tipo_dni'].' '.$_SESSION['dni'].')</i></p>';

			$cuerpo.='<p style="color:black;">Entrega este comprobante al momento de retirar tu compra
			efectuada en nuestro sitio web <b>OesteNeumaticos.com</b><br<br>
			Si nececitas que te lo enviemos a cualquier punto del pais, comunicate con nosotros, o de otra manera, ¡lo haremos nosotros!.
			 </p>

			</p>

			<table>
				<tr>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Precio unitario</th>
					<th>Cantidad</th>
					<th>Precio total por unidad</th>
				</tr>';

foreach ($carritoObtenido as $producto) {

			if ($producto->cantidad!=0 && $producto->tiene_descuento==0) {
				$cuerpo.="<tr>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->marca;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->modelo;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->precio;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad*$producto->precio;
				$cuerpo.="</td>";
				$cuerpo.="</tr>";

				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

			}
			if ($producto->cantidad!=0 && $producto->tiene_descuento==1) {
				$cuerpo.="<tr>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->marca;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->modelo;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->precio_descuento;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad*$producto->precio_descuento;
				$cuerpo.="</td>";
				$cuerpo.="</tr>";

				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

				$descuentos=$descuentos+($producto->precio_descuento*$producto->cantidad)-($producto->precio*$producto->cantidad);
			}
		}//for each

$total=+$subtotal+$descuentos;


$cuerpo.="<tr><td></td><td></td><td></td><td></td> <td><p style='margin-left:45%;'><b>Total: ".$total."$</b></p></td></tr>";
$cuerpo.="</table>
			<p><i>Pringles 1898,(011)3161-6596 Ituzaingo, GBA</i></p>
			<p><i>ventas@oesteneumaticos.com.ar</i></p>

			</body></html>

			";





//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: Oeste Neumaticos <ventas@oesteneumaticos.com.ar>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: tatirod91@gmail.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc: tatyrod5@gmail.com\r\n"; 


mail($destinatario,$asunto,$cuerpo,$headers);

//echo "Hemos enviado un comprobante de compra a tu email, lo requerimos al momento de la entrega";
	}//function

	function enviarComprobantePagoPendienteMercadoPago(){

		$total=0;

		$subtotal=0;

		$descuentos=0;

		$destinatario = $_SESSION["email"];

		$data=serialize($_SESSION['carrito']);

		$carritoObtenido=unserialize($data);

		$asunto = "Compra de productos Oeste Neumaticos"; 

$cuerpo = ' 
			<html> 
			<head> 
			   <title>¡Enhorabuena!</title> 
			</head> 
			<body> 
			<h1 style="color:orange;">Oeste Neumaticos</h1>
			<p><i>'.date("d-m-y").'</i></p> 
			<p><i>Comprobante N°:'.$_SESSION['referencia'].'</i></p>
			<p><i>Comprobante MP°:'.$_GET['collection_id'].'</i></p>
			<p><i>('.ucwords(strtolower($_SESSION['nombre'])).' '.ucwords(strtolower($_SESSION['apellido'])).','.$_SESSION['tipo_dni'].' '.$_SESSION['dni'].')</i></p>';

			$cuerpo.='<p style="color:black;">¡Pagaste en efectivo! Entrega este comprobante al momento de retirar tu compra
			efectuada en nuestro sitio web <b>OesteNeumaticos.com</b><br>
			Ademas veni con el comprobante de compra de <b>Mercado Pago.</b><br><br>

			Si nececitas que te lo enviemos a cualquier punto del pais, comunicate con nosotros, o de otra manera, ¡lo haremos nosotros!.

			 </p>

			</p>

			<table>
				<tr>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Precio unitario</th>
					<th>Cantidad</th>
					<th>Precio total por unidad</th>
				</tr>';

foreach ($carritoObtenido as $producto) {

			if ($producto->cantidad!=0 && $producto->tiene_descuento==0) {
				$cuerpo.="<tr>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->marca;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->modelo;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->precio;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad*$producto->precio;
				$cuerpo.="</td>";
				$cuerpo.="</tr>";

				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

			}
			if ($producto->cantidad!=0 && $producto->tiene_descuento==1) {
				$cuerpo.="<tr>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->marca;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->modelo;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.=$producto->precio_descuento;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad;
				$cuerpo.="</td>";
				$cuerpo.="<td>";
				$cuerpo.= $producto->cantidad*$producto->precio_descuento;
				$cuerpo.="</td>";
				$cuerpo.="</tr>";

				$subtotal=$subtotal+$producto->precio*$producto->cantidad;

				$descuentos=$descuentos+($producto->precio_descuento*$producto->cantidad)-($producto->precio*$producto->cantidad);
			}
		}//for each

$total=+$subtotal+$descuentos;


$cuerpo.="<tr><td></td><td></td><td></td><td></td> <td><p style='margin-left:45%;'><b>Total: ".$total."$</b></p></td></tr>";
$cuerpo.="</table>
			<p><i>Pringles 1898,(011)3161-6596 Ituzaingo, GBA</i></p>
			<p><i>ventas@oesteneumaticos.com.ar</i></p>

			</body></html>";





//para el envío en formato HTML 
$headers = "MIME-Version: 1.0\r\n"; 
$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

//dirección del remitente 
$headers .= "From: Oeste Neumaticos <ventas@oesteneumaticos.com.ar>\r\n"; 

//dirección de respuesta, si queremos que sea distinta que la del remitente 
$headers .= "Reply-To: tatirod91@gmail.com\r\n"; 

//direcciones que recibián copia 
//$headers .= "Cc: tatyrod5@gmail.com\r\n"; 


mail($destinatario,$asunto,$cuerpo,$headers);

//echo "Hemos enviado un comprobante de compra a tu email, lo requerimos al momento de la entrega";
	}//function





 function enviarToken($email){

 	$destinatario=$email;
$token=md5($email);

		 	$asunto = "Recuperar contraseña Oeste Neumaticos"; 

		$cuerpo = ' 
		<html> 
		<head> 
		   <title>Recuperar contraseña Oeste Neumaticos</title> 
		</head> 
		<body> 
		<h1 style="color:orange;">Oeste Neumaticos</h1>
		<p><i>'.date("d-m-y").'</i></p> 
		<p>Hola te enviamos este email para que puedas <b>registrarte o recuperar tu contraseña</b></p>
		<p>Tan solo haz click en el siguiente click, para poder crear tu nueva contraseña.
		Cualquier ayuda o consulta no dudes en contactarte con <b>Oeste Neumaticos</b></p>
		<br>
		<a href="https://www.OesteNeumaticos.com.ar/registrarUsuario.php?email='.$destinatario.'&token='.$token.'">https://www.oesteneumaticos.com.ar/registrarUsuario.php?email='.$destinatario.'&token='.$token.'</a>"';

		$cuerpo.="	<p><i>Pringles 1898,(011)3161-6596 Ituzaingo, GBA</i></p></body></html>";





		//para el envío en formato HTML 
		$headers = "MIME-Version: 1.0\r\n"; 
		$headers .= "Content-type: text/html; charset=iso-8859-1\r\n"; 

		//dirección del remitente 
		$headers .= "From: Oeste Neumaticos <ventas@oesteneumaticos.com.ar>\r\n"; 

		//direcciones que recibián copia 
		//$headers .= "Cc: tatyrod@gmail.com\r\n"; 


		mail($destinatario,$asunto,$cuerpo,$headers);


 }//function

}//class

 ?>