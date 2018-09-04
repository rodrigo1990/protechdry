<?php 
require_once("BaseDatos.php");


class Administrador{

function __construct(){}


	public function listarUsuarios(){

		$bd=new BaseDatos();


			$sql="SELECT USU.nro_doc,TD.descripcion as tipo_documento,USU.nombre,USU.apellido,USU.calle,USU.altura,
						USU.cod_area,USU.telefono,USU.email,CIU.ciudad_nombre as ciudad,
						PRO.provincia_nombre as provincia,USU.cp,USU.piso,USU.departamento
					FROM usuario USU JOIN ciudad CIU ON USU.ciudad_id=CIU.id
									  JOIN departamentos DEP ON CIU.departamento_id=DEP.id
									 JOIN provincia PRO ON DEP.provincia_id=PRO.id
									 JOIN tipo_documento TD ON USU.tipo_doc=TD.id 
					WHERE id_tipo_usuario=1
					ORDER BY USU.nro_doc ASC";



			$consulta=mysqli_query($bd->conexion,$sql);


			 	echo "<table id='tabla-usuarios-admin'class='table-responsive table-striped table-hover table-bordered'>
					<tr>
					<th>Nro documento</th>
					<th>Tipo documento</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Calle</th>
					<th>Altura</th>
					<th>Telefono</th>
					<th>Email</th>
					<th>Domicilio</th>
					<!--<th>Acciones</th>-->
					</tr>";

			while($fila=mysqli_fetch_assoc($consulta)){

				echo "<tr>
						<td>".$fila['nro_doc']."</td>
						<td>".$fila['tipo_documento']."</td>
						<td>".$fila['nombre']."</td>
						<td>".$fila['apellido']."</td>
						<td>".$fila['calle']."</td>
						<td>".$fila['altura']."</td>
						<td>(".$fila['cod_area'].")".$fila['telefono']."</td>
						<td>".$fila['email']."</td>
						<td>".$fila['provincia']."<br>".$fila['ciudad']."<br> CP:".$fila['cp']."<br>Piso:".$fila['piso']." Depto:".$fila['departamento']."</td>
						<!--<td>
							<a href='usuario-admin-listar-compras.php?email=".$fila['email']."'>Ver comprobantes</a>
						</td>-->


				</tr>";


					}

				echo "</table>";
	}//function
	public function listarUsuario($email){

		$bd=new BaseDatos();


			$sql="SELECT USU.nro_doc,TD.descripcion as tipo_documento,USU.nombre,USU.apellido,USU.calle,USU.altura,
						USU.cod_area,USU.telefono,USU.email,CIU.ciudad_nombre as ciudad,
						PRO.provincia_nombre as provincia,USU.cp,USU.piso,USU.departamento
					FROM usuario USU JOIN ciudad CIU ON USU.ciudad_id=CIU.id
									  JOIN departamentos DEP ON CIU.departamento_id=DEP.id
									 JOIN provincia PRO ON DEP.provincia_id=PRO.id
									 JOIN tipo_documento TD ON USU.tipo_doc=TD.id 
					WHERE id_tipo_usuario=1 AND USU.email='$email'
					ORDER BY USU.nro_doc ASC";



			$consulta=mysqli_query($bd->conexion,$sql);


			 	echo "<table id='tabla-usuarios-admin'class='table-responsive table-striped table-hover table-bordered'>
					<tr>
					<th>Nro documento</th>
					<th>Tipo documento</th>
					<th>Nombre</th>
					<th>Apellido</th>
					<th>Calle</th>
					<th>Altura</th>
					<th>Telefono</th>
					<th>Email</th>
					<th>Domicilio</th>
					<!--<th>Acciones</th>-->
					</tr>";

			while($fila=mysqli_fetch_assoc($consulta)){

				echo "<tr>
						<td>".$fila['nro_doc']."</td>
						<td>".$fila['tipo_documento']."</td>
						<td>".$fila['nombre']."</td>
						<td>".$fila['apellido']."</td>
						<td>".$fila['calle']."</td>
						<td>".$fila['altura']."</td>
						<td>(".$fila['cod_area'].")".$fila['telefono']."</td>
						<td>".$fila['email']."</td>
						<td>".$fila['provincia']."<br>".$fila['ciudad']."<br> CP:".$fila['cp']."<br>Piso:".$fila['piso']." Depto:".$fila['departamento']."</td>
						<!--<td>
							<a href='usuario-admin-listar-compras.php?email=".$fila['email']."'>Ver comprobantes</a>
						</td>-->


				</tr>";


					}

				echo "</table>";
	}//function

	public function listarComprobantes($email){

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

	public function altaProducto($modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$rodado,$vehiculo,$categoria,$precio,$precio_descuento,$es_destacado,$titulo_1,$descripcion_1,$titulo_2,$descripcion_2,$titulo_3,$descripcion_3,$imagen_descripcion_1,$imagen_descripcion_2,$imagen_descripcion_3,$imagen_home,$imagen_media,$imagen_grande){
		//busca el email

		$baseDatos = new BaseDatos();

		$ext_descrip_1=pathinfo($_FILES['imagen-1-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_1=rand(100000000,999999999).".".$ext_descrip_1;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_1;

		// 1=si 0=no
		$insertar=1;
		$img_descrip_1_insert=0;
		$img_descrip_2_insert=0;
		$img_descrip_3_insert=0;
		$img_home_insert=0;
		$img_media_insert=0;
		$img_grande_insert=0;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-1-admin-input']['tmp_name'], $target_path)) {

			 	$img_descrip_1_insert=1;
			  echo "El archivo ". basename( $_FILES['imagen-1-admin-input']['name']). " ha sido subido <br>";
			
			} else{

			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-1-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-1-admin-input']['name'])." ya existe<br>";
			$insertar=0;
			
		}



		$ext_descrip_2=pathinfo($_FILES['imagen-2-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_2=rand(100000000,999999999).".".$ext_descrip_2;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_2;


		if(file_exists($target_path)==FALSE){

			if(move_uploaded_file($_FILES['imagen-2-admin-input']['tmp_name'], $target_path)) { 

				$img_descrip_2_insert=1;

			 	echo "El archivo ". basename( $_FILES['imagen-2-admin-input']['name']). " ha sido subido <br>";
			
			} else{

			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-2-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-2-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}


		$ext_descrip_3=pathinfo($_FILES['imagen-3-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_3=rand(100000000,999999999).".".$ext_descrip_3;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_3;

		if(file_exists($target_path)==FALSE){

			if(move_uploaded_file($_FILES['imagen-3-admin-input']['tmp_name'], $target_path)) {

			$img_descrip_3_insert=1;
			 echo "El archivo ". basename( $_FILES['imagen-3-admin-input']['name']). " ha sido subido<br>";
			
			} else{
			
			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-3-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}
		}else{

			echo "El archivo ".basename( $_FILES['imagen-3-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}



		$ext_home=pathinfo($_FILES['imagen-home-admin-input']['name'],PATHINFO_EXTENSION);

		$new_home=rand(100000000,999999999).".".$ext_home;

		$target_path = "img/";
		$target_path = $target_path . $new_home;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-home-admin-input']['tmp_name'], $target_path)) {

			 	$img_home_insert=1;

			  echo "El archivo ". basename( $_FILES['imagen-home-admin-input']['name']). " ha sido subido <br>";
			
			} else{

			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-home-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-home-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}



		$ext_media=pathinfo($_FILES['imagen-media-admin-input']['name'],PATHINFO_EXTENSION);

		$new_media=rand(100000000,999999999).".".$ext_media;

		$target_path = "img-md/";
		$target_path = $target_path . $new_media;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-media-admin-input']['tmp_name'], $target_path)) {

			 	$img_media_insert=1;

			  echo "El archivo ". basename( $_FILES['imagen-media-admin-input']['name']). " ha sido subido<br>";
			
			} else{

				echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-media-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-media-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}



		$ext_grande=pathinfo($_FILES['imagen-grande-admin-input']['name'],PATHINFO_EXTENSION);

		$new_grande=rand(100000000,999999999).".".$ext_grande;

		$target_path = "img-lg/";
		$target_path = $target_path . $new_grande;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-grande-admin-input']['tmp_name'], $target_path)) {

			 	$img_grande_insert=1;

			  echo "El archivo ". basename( $_FILES['imagen-grande-admin-input']['name']). " ha sido subido <br>";
			
			} else{

				echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-grande-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-grande-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}

		if($insertar==1){
			if($precio_descuento!=''){

				$stmt=$baseDatos->mysqli->prepare("INSERT INTO producto(modelo,id_marca,id_ancho,id_alto,id_velocidad,
																	id_carga,id_origen,precio,tiene_descuento,precio_descuento,id_rodado,
																	id_tipo_vehiculo, id_categoria, es_destacado,titulo_descripcion_1,descripcion_1,titulo_descripcion_2,descripcion_2,titulo_descripcion_3,descripcion_3,imagen_descripcion_1,imagen_descripcion_2,
																	imagen_descripcion_3,imagen,imagen_media,imagen_grande,tiene_stock) 
									  		  VALUES (?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)");

				$stmt->bind_param("siiiiiiddiiiissssssssssss",$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$precio,$precio_descuento,$rodado,$vehiculo,$categoria,$es_destacado,$titulo_1,$descripcion_1,$titulo_2,$descripcion_2,$titulo_3,$descripcion_3,$new_descrip_1,$new_descrip_2,$new_descrip_3,$new_home,$new_media,$new_grande);

				$stmt->execute();

				$stmt->close();

			}else if($precio_descuento==''){

				$stmt=$baseDatos->mysqli->prepare("INSERT INTO producto(modelo,id_marca,id_ancho,id_alto,id_velocidad,
																	id_carga,id_origen,precio,tiene_descuento,precio_descuento,id_rodado,
																	id_tipo_vehiculo, id_categoria, es_destacado,titulo_descripcion_1,descripcion_1,titulo_descripcion_2,descripcion_2,titulo_descripcion_3,descripcion_3,imagen_descripcion_1,imagen_descripcion_2,
																	imagen_descripcion_3,imagen,imagen_media,imagen_grande,tiene_stock) 
									  		  VALUES (?,?,?,?,?,?,?,?,0,0,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)");

				

				$stmt->bind_param("siiiiiidiiiissssssssssss",$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$precio,$rodado,$vehiculo,$categoria,$es_destacado,$titulo_1,$descripcion_1,$titulo_2,$descripcion_2,$titulo_3,$descripcion_3,$new_descrip_1,$new_descrip_2,$new_descrip_3,$new_home,$new_media,$new_grande);

				$stmt->execute();

				$stmt->close();

			}


			echo("Producto subido con exito<br>");


			echo ("<a href='usuario-admin.php'>Volver al panel de administracion</a><br>");
			echo ("<a href='usuario-admin-subir-productos.php'>Volver a subir productos</a><br>");

		}else{

			if($img_descrip_1_insert==1){
					unlink("img-descripcion/".$imagen_descripcion_1."");
				}
				 if ($img_descrip_2_insert==1){
					unlink("img-descripcion/".$imagen_descripcion_2."");
				}
				 if($img_descrip_3_insert==1){
					unlink("img-descripcion/".$imagen_descripcion_3."");
				}
				 if($img_home_insert==1){
					unlink("img/".$imagen_home."");
				}
				 if($img_media_insert==1){
					unlink("img-md/".$imagen_media."");
				}
				 if($img_grande_insert==1){
					unlink("img-lg/".$imagen_grande."");
				}

			echo ("No se ha realizado el alta del producto, intente nuevamente");
			echo ("<a href='usuario-admin.php'>Volver al panel de administracion</a><br>");
			echo ("<a href='usuario-admin-subir-productos.php'>Volver a subir productos</a><br>");

		}

		
	}


	public function altaProductoNoDestacado($modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$rodado,$vehiculo,$categoria,$precio,$precio_descuento,$titulo_1,$descripcion_1,$titulo_2,$descripcion_2,$titulo_3,$descripcion_3,$imagen_descripcion_1,$imagen_descripcion_2,$imagen_descripcion_3,$imagen_home,$imagen_media,$imagen_grande){

		//busca el email

		$baseDatos = new BaseDatos();

		$ext_descrip_1=pathinfo($_FILES['imagen-1-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_1=rand(100000000,999999999).".".$ext_descrip_1;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_1;

		// 1=si 0=no
		$insertar=1;
		$img_descrip_1_insert=0;
		$img_descrip_2_insert=0;
		$img_descrip_3_insert=0;
		$img_home_insert=0;
		$img_media_insert=0;
		$img_grande_insert=0;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-1-admin-input']['tmp_name'], $target_path)) {

			 	$img_descrip_1_insert=1;
			  echo "El archivo ". basename( $_FILES['imagen-1-admin-input']['name']). " ha sido subido <br>";
			
			} else{

			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-1-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-1-admin-input']['name'])." ya existe<br>";
			$insertar=0;
			
		}



		$ext_descrip_2=pathinfo($_FILES['imagen-2-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_2=rand(100000000,999999999).".".$ext_descrip_2;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_2;


		if(file_exists($target_path)==FALSE){

			if(move_uploaded_file($_FILES['imagen-2-admin-input']['tmp_name'], $target_path)) { 

				$img_descrip_2_insert=1;

			 	echo "El archivo ". basename( $_FILES['imagen-2-admin-input']['name']). " ha sido subido <br>";
			
			} else{

			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-2-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-2-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}


		$ext_descrip_3=pathinfo($_FILES['imagen-3-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_3=rand(100000000,999999999).".".$ext_descrip_3;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_3;

		if(file_exists($target_path)==FALSE){

			if(move_uploaded_file($_FILES['imagen-3-admin-input']['tmp_name'], $target_path)) {

			$img_descrip_3_insert=1;
			 echo "El archivo ". basename( $_FILES['imagen-3-admin-input']['name']). " ha sido subido<br>";
			
			} else{
			
			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-3-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}
		}else{

			echo "El archivo ".basename( $_FILES['imagen-3-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}



		$ext_home=pathinfo($_FILES['imagen-home-admin-input']['name'],PATHINFO_EXTENSION);

		$new_home=rand(100000000,999999999).".".$ext_home;

		$target_path = "img/";
		$target_path = $target_path . $new_home;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-home-admin-input']['tmp_name'], $target_path)) {

			 	$img_home_insert=1;

			  echo "El archivo ". basename( $_FILES['imagen-home-admin-input']['name']). " ha sido subido <br>";
			
			} else{

			echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-home-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-home-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}



		$ext_media=pathinfo($_FILES['imagen-media-admin-input']['name'],PATHINFO_EXTENSION);

		$new_media=rand(100000000,999999999).".".$ext_media;

		$target_path = "img-md/";
		$target_path = $target_path . $new_media;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-media-admin-input']['tmp_name'], $target_path)) {

			 	$img_media_insert=1;

			  echo "El archivo ". basename( $_FILES['imagen-media-admin-input']['name']). " ha sido subido<br>";
			
			} else{

				echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-media-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-media-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}



		$ext_grande=pathinfo($_FILES['imagen-grande-admin-input']['name'],PATHINFO_EXTENSION);

		$new_grande=rand(100000000,999999999).".".$ext_grande;

		$target_path = "img-lg/";
		$target_path = $target_path . $new_grande;

		if(file_exists($target_path)==FALSE){

			 if(move_uploaded_file($_FILES['imagen-grande-admin-input']['tmp_name'], $target_path)) {

			 	$img_grande_insert=1;

			  echo "El archivo ". basename( $_FILES['imagen-grande-admin-input']['name']). " ha sido subido <br>";
			
			} else{

				echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-grande-admin-input']['name'])." un error, trate de nuevo!<br>";
			
			}

		}else{

			echo "El archivo ".basename( $_FILES['imagen-grande-admin-input']['name'])." ya existe<br>";
			$insertar=0;

		}

		if($insertar==1){


			$es_destacado=0;

			if($precio_descuento!=''){

				$stmt=$baseDatos->mysqli->prepare("INSERT INTO producto(modelo,id_marca,id_ancho,id_alto,id_velocidad,
																	id_carga,id_origen,precio,tiene_descuento,precio_descuento,id_rodado,
																	id_tipo_vehiculo, id_categoria, es_destacado,titulo_descripcion_1,descripcion_1,titulo_descripcion_2,descripcion_2,titulo_descripcion_3,descripcion_3,imagen_descripcion_1,imagen_descripcion_2,
																	imagen_descripcion_3,imagen,imagen_media,imagen_grande,tiene_stock) 
									  		  VALUES (?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)");

				$stmt->bind_param("siiiiiiddiiiissssssssssss",$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$precio,$precio_descuento,$rodado,$vehiculo,$categoria,$es_destacado,$titulo_1,$descripcion_1,$titulo_2,$descripcion_2,$titulo_3,$descripcion_3,$new_descrip_1,$new_descrip_2,$new_descrip_3,$new_home,$new_media,$new_grande);

				$stmt->execute();

				$stmt->close();

			}else if($precio_descuento==''){


				$es_destacado=0;
				
				
				$stmt=$baseDatos->mysqli->prepare("INSERT INTO producto(modelo,id_marca,id_ancho,id_alto,id_velocidad,
																	id_carga,id_origen,precio,tiene_descuento,precio_descuento,id_rodado,
																	id_tipo_vehiculo, id_categoria, es_destacado,titulo_descripcion_1,descripcion_1,titulo_descripcion_2,descripcion_2,titulo_descripcion_3,descripcion_3,imagen_descripcion_1,imagen_descripcion_2,
																	imagen_descripcion_3,imagen,imagen_media,imagen_grande,tiene_stock) 
									  		  VALUES (?,?,?,?,?,?,?,?,0,0,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)");

				

				$stmt->bind_param("siiiiiidiiiissssssssssss",$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$precio,$rodado,$vehiculo,$categoria,$es_destacado,$titulo_1,$descripcion_1,$titulo_2,$descripcion_2,$titulo_3,$descripcion_3,$new_descrip_1,$new_descrip_2,$new_descrip_3,$new_home,$new_media,$new_grande);

				$stmt->execute();

				$stmt->close();

			}


			echo("Producto subido con exito<br>");


			echo ("<a href='usuario-admin.php'>Volver al panel de administracion</a><br>");
			echo ("<a href='usuario-admin-subir-productos.php'>Volver a subir productos</a><br>");

		}else{

			if($img_descrip_1_insert==1){
					unlink("img-descripcion/".$imagen_descripcion_1."");
				}
				 if ($img_descrip_2_insert==1){
					unlink("img-descripcion/".$imagen_descripcion_2."");
				}
				 if($img_descrip_3_insert==1){
					unlink("img-descripcion/".$imagen_descripcion_3."");
				}
				 if($img_home_insert==1){
					unlink("img/".$imagen_home."");
				}
				 if($img_media_insert==1){
					unlink("img-md/".$imagen_media."");
				}
				 if($img_grande_insert==1){
					unlink("img-lg/".$imagen_grande."");
				}

			echo ("No se ha realizado el alta del producto, intente nuevamente");
			echo ("<a href='usuario-admin.php'>Volver al panel de administracion</a><br>");
			echo ("<a href='usuario-admin-subir-productos.php'>Volver a subir productos</a><br>");

		}
		
					

	}//function

	public function eliminarProducto($id){

		$baseDatos = new BaseDatos();


		$stmt=$baseDatos->mysqli->prepare("SELECT imagen,imagen_media,imagen_grande,imagen_descripcion_1,imagen_descripcion_2,imagen_descripcion_3 
										   FROM producto
										   WHERE id=(?)");

				$stmt->bind_param("i",$id);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila=$resultado->fetch_assoc();

				if($fila['imagen']!=''){
					unlink("img/".$fila['imagen']."");
				}
				if($fila['imagen_media']!=''){
					unlink("img-md/".$fila['imagen_media']."");
				}
				if($fila['imagen_grande']!=''){
					unlink("img-lg/".$fila['imagen_grande']."");
				}
				if($fila['imagen_descripcion_1']!=''){
					unlink("img-descripcion/".$fila['imagen_descripcion_1']."");
				}
				if($fila['imagen_descripcion_2']!=''){
					unlink("img-descripcion/".$fila['imagen_descripcion_2']."");
				}
				if($fila['imagen_descripcion_3']!=''){
					unlink("img-descripcion/".$fila['imagen_descripcion_3']."");
				}

		$stmt=$baseDatos->mysqli->prepare("DELETE 
										   FROM producto
										   WHERE id=(?)");

				$stmt->bind_param("i",$id);

				$stmt->execute();

				echo("Producto eliminado con exito <br>");

				echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

				$stmt->close();
	}

	public function actualizarDestacado($es_destacado,$id){

		$baseDatos = new BaseDatos();


		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET es_destacado=(?)
											WHERE id=(?)");

		$stmt->bind_param("ii",$es_destacado,$id);

		$stmt->execute();

		echo "Se ha actualizado el campo es_destacado de la base de datos";
		echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

	}

	public function actualizarEstadoStock($stock,$id){

		$baseDatos = new BaseDatos();


		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET tiene_stock=(?)
											WHERE id=(?)");

		$stmt->bind_param("ii",$stock,$id);

		$stmt->execute();

		$stmt->close();


		echo "Se ha actualizado el campo tiene_stock de la base de datos";
		echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";



	}

	public function actualizarEstadoStockYDestacado($stock,$es_destacado,$id){

	$baseDatos = new BaseDatos();


	$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET tiene_stock=(?),es_destacado=(?)
										WHERE id=(?)");

	$stmt->bind_param("iii",$stock,$es_destacado,$id);

	$stmt->execute();

	$stmt->close();


	echo "Se ha actualizado el campo tiene_stock y el campo es_destacado de la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

}

	public function actualizarPrecio($precio,$id){

	$baseDatos = new BaseDatos();


	$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET precio=(?)
										WHERE id=(?)");

	$stmt->bind_param("di",$precio,$id);

	$stmt->execute();

	$stmt->close();

	echo "Se ha actualizado el precio en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

	}
	public function actualizarPrecioDescuento($precio_descuento,$id){

	$baseDatos = new BaseDatos();

	if($precio_descuento==0 or $precio_descuento==0.0){

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET precio_descuento=(?),tiene_descuento=0
										WHERE id=(?)");

	$stmt->bind_param("di",$precio_descuento,$id);

	$stmt->execute();

	$stmt->close();
	
	echo "Se ha actualizado el precio descontado en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

	}else{



	$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET precio_descuento=(?),tiene_descuento=1
										WHERE id=(?)");

	$stmt->bind_param("di",$precio_descuento,$id);

	$stmt->execute();

	$stmt->close();

	echo "Se ha actualizado el precio descontado en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";


	}

	





	}

	public function actualizarPrecioYPrecioDescuento($precio,$precio_descuento,$id){

	$baseDatos = new BaseDatos();

	if($precio_descuento==0 or $precio_descuento==0.0 ){

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio=(?),precio_descuento=(?),tiene_descuento=0
											WHERE id=(?)");

		$stmt->bind_param("ddi",$precio,$precio_descuento,$id);

		$stmt->execute();

		$stmt->close();

	

	}else{


		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio=(?),precio_descuento=(?),tiene_descuento=1
											WHERE id=(?)");

		$stmt->bind_param("ddi",$precio,$precio_descuento,$id);

		$stmt->execute();

		$stmt->close();

		

	}

	echo "Se ha actualizado el precio y el  precio descontado en  la base de datos";
		echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";
	




	}

	public function actualizarPrecioPrecioDescuentoYDestacado($precio,$precio_descuento,$es_destacado,$id){

	$baseDatos = new BaseDatos();


	if($precio_descuento==0 or $precio_descuento==0.0){


		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio=(?),precio_descuento=(?),es_destacado=(?),tiene_descuento=0
											WHERE id=(?)");

		$stmt->bind_param("ddii",$precio,$precio_descuento,$es_destacado,$id);

		$stmt->execute();

		$stmt->close();




	}else{

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio=(?),precio_descuento=(?),es_destacado=(?),tiene_descuento=1
											WHERE id=(?)");

		$stmt->bind_param("ddii",$precio,$precio_descuento,$es_destacado,$id);

		$stmt->execute();

		$stmt->close();

		

	}

	echo "Se ha actualizado precio,precio descontado y es_destacado en  la base de datos";
		echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

	





	}

	public function actualizarPrecioPrecioDescuentoDestacadoStock($precio,$precio_descuento,$es_destacado,$stock,$id){

	$baseDatos = new BaseDatos();

	if($precio_descuento==0 or $precio_descuento==0.0){

	$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET precio=(?),precio_descuento=(?),es_destacado=(?),tiene_stock=(?),tiene_descuento=0
										WHERE id=(?)");

	$stmt->bind_param("ddiii",$precio,$precio_descuento,$es_destacado,$stock,$id);

	$stmt->execute();

	$stmt->close();


	


	}else{


	$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET precio=(?),precio_descuento=(?),es_destacado=(?),tiene_stock=(?),tiene_descuento=1
										WHERE id=(?)");

	$stmt->bind_param("ddiii",$precio,$precio_descuento,$es_destacado,$stock,$id);

	$stmt->execute();

	$stmt->close();

	}

	echo "Se ha actualizado precio,precio descontado y es_destacado en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";

	
	}



public function actualizarPrecioDestacadoYStock($precio,$es_destacado,$stock,$id){

	$baseDatos = new BaseDatos();


	$stmt=$baseDatos->mysqli->prepare("UPDATE producto
										SET precio=(?),es_destacado=(?),tiene_stock=(?)
										WHERE id=(?)");

	$stmt->bind_param("diii",$precio,$es_destacado,$stock,$id);

	$stmt->execute();

	$stmt->close();

	echo "Se ha actualizado precio,es_destacado y tiene_stock en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";


}

public function actualizarPrecioDescuentoDestacadoYStock($precio_descuento,$es_destacado,$stock,$id){

	$baseDatos = new BaseDatos();


	if($precio_descuento==0 or $precio_descuento ==0.0){

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio_descuento=(?),es_destacado=(?),tiene_stock=(?),tiene_descuento=0
											WHERE id=(?)");

		$stmt->bind_param("diii",$precio_descuento,$es_destacado,$stock,$id);

		$stmt->execute();

		$stmt->close();

	}else{


		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio_descuento=(?),es_destacado=(?),tiene_stock=(?),tiene_descuento=1
											WHERE id=(?)");

		$stmt->bind_param("diii",$precio_descuento,$es_destacado,$stock,$id);

		$stmt->execute();

		$stmt->close();
	}
	echo "Se ha actualizado precio descontado,es_destacado y tiene_stock en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";
}

public function actualizarStockPrecioPrecioDescuento($stock,$precio,$precio_descuento,$id){

	$baseDatos = new BaseDatos();


	if($precio_descuento==0 or $precio_descuento ==0.0){

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio_descuento=(?),tiene_stock=(?),tiene_descuento=0
											WHERE id=(?)");

		$stmt->bind_param("dii",$precio_descuento,$stock,$id);

		$stmt->execute();

		$stmt->close();

	}else{


		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET precio_descuento=(?),tiene_stock=(?),tiene_descuento=1
											WHERE id=(?)");

		$stmt->bind_param("dii",$precio_descuento,$stock,$id);

		$stmt->execute();

		$stmt->close();
	}
	echo "Se ha actualizado precio, precio descontado y tiene_stock en  la base de datos";
	echo "<a href='usuario-admin-actualizar-productos.php'>Volver</a>";
}


public function listarTodoslosProductos(){

	$bd=new BaseDatos();

			$sql="SELECT PRO.id, MAR.descripcion,PRO.modelo,PRO.precio,PRO.precio_descuento,
					CASE 
					WHEN PRO.es_destacado=1 THEN 'si'
					WHEN PRO.es_destacado=0 THEN 'no'
					END AS es_destacado,
					CASE
					WHEN PRO.tiene_stock=1 THEN 'si'
					WHEN PRO.tiene_stock=0 THEN 'no'
					END AS tiene_stock,
					CASE
					WHEN PRO.tiene_descuento=1 THEN 'si'
					WHEN PRO.tiene_descuento=0 THEN 'no'
					END AS tiene_descuento
				  FROM producto PRO JOIN marca MAR ON PRO.id_marca=MAR.id";



			$consulta=mysqli_query($bd->conexion,$sql);


			 	echo "<table style='margin-left:15%' id='tabla-usuarios-admin'class='table-responsive table-striped table-hover table-bordered'>
					<tr>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Precio</th>
					<th>Precio Descuento</th>
					<th>¿Es destacado?</th>
					<th>¿Tiene stock?</th>
					<th>¿Tiene descuento?</th>
					<th>Editar</th>
					</tr>";

			while($fila=mysqli_fetch_assoc($consulta)){

				echo "<tr>
						<td>".$fila['descripcion']."</td>
						<td>".$fila['modelo']."</td>
						<td>".$fila['precio']."</td>
						<td>".$fila['precio_descuento']."</td>
						<td>".$fila['es_destacado']."</td>
						<td>".$fila['tiene_stock']."</td>
						<td>".$fila['tiene_descuento']."</td>
						<td><a class='a-busqueda-menu' href='usuario-admin-actualizar-productos-ver-mas-2.php?id=".$fila['id']."' target='_blank'>Editar</a></td>
						

				</tr>";


					}

				echo "</table>";

}

public function listarVentas(){
	$baseDatos= new BaseDatos();

	$stmt=$baseDatos->mysqli->prepare("SELECT DISTINCT UCP.comprobante_nro,UCP.id_mp,UCP.id_tp,UCP.fecha,UCP.email_usuario,EE.descripcion as envio, EV.descripcion as venta
									  FROM usuario_compra_producto UCP JOIN estado_envio EE ON UCP.id_estado_envio=EE.id
									  									JOIN estado_venta EV ON UCP.id_estado_venta=EV.id
									  ORDER BY UCP.id_estado_envio ASC");


		$stmt->execute();

		$resultado=$stmt->get_result();

		echo "<table style='margin-left:3%' id='tabla-usuarios-admin'class='table-responsive table-striped table-hover table-bordered'>
					<tr>

					<th>Nro Comprobante</th>
					<th>Nro Mercado Pago</th>
					<!--<th>Nro Todo Pago </th>-->
					<th>Email</th>
			
					<th>Productos Comprados</th>
					<th>Total</th>
					<th>Fecha</th>
					<th>Estado envio</th>
					<th>Actualizar estado envio</th>
					<th>Estado pago</th>
					<th>Actualizar estado pago</th>
					</tr>";

		while($fila=$resultado->fetch_assoc()){

			$total=0;
			$buscar=$fila['comprobante_nro'];

			$sql2="SELECT UCP.marca as marca,UCP.modelo,UCP.tiene_descuento,UCP.precio,UCP.precio_descuento,UCP.cantidad,UCP.color,UCP.talle
				   FROM usuario_compra_producto UCP
				   WHERE UCP.comprobante_nro='$buscar'";

			$consulta2=mysqli_query($baseDatos->conexion,$sql2);

			echo "<tr>

				<td>".$fila['comprobante_nro']."</td>
				<td>".$fila['id_mp']."</td>
				<!--<td>".$fila['id_tp']."</td>-->
				<td><a href='usuario-admin-listar-usuario.php?email=".$fila['email_usuario']."' target='_blank'>".$fila['email_usuario']."</a></td>
		
				<td>";
				

			while($fila2=mysqli_fetch_assoc($consulta2)){


				if($fila2['tiene_descuento']==1){

							$total=$total+$fila2['precio_descuento']*$fila2['cantidad'];

							echo "<p>";
							echo $fila2['marca'];
							echo " ";
							echo $fila2['modelo']; 
							echo " (";
							echo $fila2['cantidad'];
							echo " unidades)";
							echo "<br>";
							echo $fila2['color'];
							echo  "<br>";
							echo $fila2['talle'];
							echo  "<br>";
							echo "<b>Precio descuento: ".$fila2['precio_descuento']."</b>";
							echo "<br>";
							echo "<b>Precio: ".$fila2['precio']."</b>";
							echo "</p>";
							echo "<br>";
							
														
							}else{

							$total=$total+$fila2['precio']*$fila2['cantidad'];

							echo "<p>";
							echo $fila2['marca'];
							echo " ";
							echo $fila2['modelo']; 
							echo " (";
							echo $fila2['cantidad'];
							echo " unidades)";
							echo "<br>";
							echo "<b>Precio: ".$fila2['precio']."</b>";
							echo "</p>";
							echo "<br>";
							
							
							
							}//if

				

			}
			echo "</td>";
			echo "<td>$".$total."</td>";
			echo "<td>".$fila['fecha']."</td>";

			if($fila['envio']=='Pendiente'){
				echo "<td><span style='color:orange'>".$fila['envio']."</span></td>";
				
			}else if($fila['envio']=='Retira en local'){
				echo "<td><span style='color:darksalmon'>".$fila['envio']."</span></td>";	
			}else if($fila['envio']=='Exito'){
				echo "<td><span style='color:green'>".$fila['envio']."</span></td>";
			}

			echo "<td><a href='usuario-admin-actualizarEstadoEnvio.php?comprobante=".$fila['comprobante_nro']."&estado=1'>Pendiente</a><br>
						
						<a href='usuario-admin-actualizarEstadoEnvio.php?comprobante=".$fila['comprobante_nro']."&estado=3'>Exito</a></td>";


			if($fila['venta']=='NS'){
				echo "<td><span style='color:red'>".$fila['venta']."</span></td>";
			}
			else if($fila['venta']=='Pendiente'){
				echo "<td><span style='color:orange'>".$fila['venta']."</span></td>";
				
			}else if($fila['venta']=='Exito'){
				echo "<td><span style='color:green'>".$fila['venta']."</span></td>";	
			}else if($fila['venta']=='Rechazado'){
				echo "<td><span style='color:red'>".$fila['venta']."</span></td>";	
			}

			echo "<td><a href='usuario-admin-actualizarEstadoVenta.php?comprobante=".$fila['comprobante_nro']."&estado=1'>Pendiente</a><br>
						<a href='usuario-admin-actualizarEstadoVenta.php?comprobante=".$fila['comprobante_nro']."&estado=2'>Exito</a><br>
						<a href='usuario-admin-actualizarEstadoVenta.php?comprobante=".$fila['comprobante_nro']."&estado=4'>Rechazado</a><br>
						";


			echo "</tr>";
		}//while prin

		echo "</table>";
}//function

function listarUnSoloComprobanteAdmin($comprobante){

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
											   FROM usuario_compra_producto UCP
											   WHERE UCP.comprobante_nro=(?)");

		$stmt->bind_param("s",$comprobante);

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

public function actualizarEstadoEnvio($comprobante,$estadoEnvio){

		$baseDatos= new BaseDatos();

	$stmt=$baseDatos->mysqli->prepare("UPDATE usuario_compra_producto
										SET id_estado_envio=(?)
										WHERE comprobante_nro=(?)");

		$stmt->bind_param("is",$estadoEnvio,$comprobante);


		$stmt->execute();


		$stmt->close();




}

public function actualizarEstadoVenta($comprobante,$estadoVenta){

		$baseDatos= new BaseDatos();

	$stmt=$baseDatos->mysqli->prepare("UPDATE usuario_compra_producto
										SET id_estado_venta=(?)
										WHERE comprobante_nro=(?)");

		$stmt->bind_param("is",$estadoVenta,$comprobante);


		$stmt->execute();


		$stmt->close();




}
public function actualizarProducto($id,$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$rodado,$tipoVehiculo,
	$categoria,$precio,$precioDescuento,$destacado,$stock,$titulo1,$descripcion1,$titulo2,$descripcion2,$titulo3,
	$descripcion3,$imagen_descripcion_1,$imagen_descripcion_2,$imagen_descripcion_3,$imagen_home,$imagen_media,$imagen_grande){

	$baseDatos= new BaseDatos();

	if($precioDescuento != 0 OR $precioDescuento != 0.0){

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET modelo=(?),id_marca=(?),id_ancho=(?),id_alto=(?),id_velocidad=(?),id_carga=(?),
												id_origen=(?),id_rodado=(?),id_tipo_vehiculo=(?),id_categoria=(?),precio=(?),
												precio_descuento=(?),tiene_descuento=1,es_destacado=(?),tiene_stock=(?),titulo_descripcion_1=(?),descripcion_1=(?),
												titulo_descripcion_2=(?),descripcion_2=(?),titulo_descripcion_3=(?),descripcion_3=(?)
											WHERE id=(?)");

		$stmt->bind_param("siiiiiiiiiddiissssssi",$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$rodado,$tipoVehiculo,$categoria,$precio,$precioDescuento,$destacado,$stock,$titulo1,$descripcion1,$titulo2,$descripcion2,$titulo3,$descripcion3,$id);

		$stmt->execute();

		echo "Se han actualizado todos los registros correctamente <br>";

	}else{

		$stmt=$baseDatos->mysqli->prepare("UPDATE producto
											SET modelo=(?),id_marca=(?),id_ancho=(?),id_alto=(?),id_velocidad=(?),id_carga=(?),
												id_origen=(?),id_rodado=(?),id_tipo_vehiculo=(?),id_categoria=(?),precio=(?),
												precio_descuento=(?),tiene_descuento=0,es_destacado=(?),tiene_stock=(?),titulo_descripcion_1=(?),descripcion_1=(?),
												titulo_descripcion_2=(?),descripcion_2=(?),titulo_descripcion_3=(?),descripcion_3=(?)
											WHERE id=(?)");

		$stmt->bind_param("siiiiiiiiiddiissssssi",$modelo,$marca,$ancho,$alto,$velocidad,$carga,$origen,$rodado,$tipoVehiculo,$categoria,$precio,$precioDescuento,$destacado,$stock,$titulo1,$descripcion1,$titulo2,$descripcion2,$titulo3,$descripcion3,$id);

		$stmt->execute();

		echo "Se han actualizado todos los registros correctamente<br>";

	}


	if($imagen_descripcion_1!=''){

		$stmt=$baseDatos->mysqli->prepare("SELECT imagen_descripcion_1
										   FROM producto
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		if($fila['imagen_descripcion_1']!=''){
			
			$ext_descrip_1=pathinfo($_FILES['imagen-1-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_1=rand(100000000,999999999).".".$ext_descrip_1;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_1;

			
			if(file_exists($target_path)==FALSE){

				$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen_descripcion_1=(?)
												WHERE id=(?)");

				$stmt->bind_param("si",$new_descrip_1,$id);

				$stmt->execute();

				unlink("img-descripcion/".$fila['imagen_descripcion_1']."");

				if(move_uploaded_file($_FILES['imagen-1-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-1-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-1-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }
			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_descripcion_1." ya existe<br>";
			 }



		}else{

			$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen_descripcion_1=(?)
												WHERE id=(?)");

			$stmt->bind_param("si",$imagen_descripcion_1,$id);

			$stmt->execute();

			//solamente ingresar imagen nueva

			$target_path = "img-descripcion/";
			$target_path = $target_path . basename( $_FILES['imagen-1-admin-input']['name']);

			
			if(file_exists($target_path)==FALSE){

				if(move_uploaded_file($_FILES['imagen-1-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-1-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-1-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			 }else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_descripcion_1." ya existe<br>";
			 }

		}//else

	}//($fila['imagen_descripcion_3']!=''){


	if($imagen_descripcion_2!=''){

		$stmt=$baseDatos->mysqli->prepare("SELECT imagen_descripcion_2
										   FROM producto
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		if($fila['imagen_descripcion_2']!=''){


			$ext_descrip_2=pathinfo($_FILES['imagen-2-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_2=rand(100000000,999999999).".".$ext_descrip_2;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_2;

			if(file_exists($target_path)==FALSE){


				$stmt=$baseDatos->mysqli->prepare("UPDATE producto
													SET imagen_descripcion_2=(?)
													WHERE id=(?)");

				$stmt->bind_param("si",$new_descrip_2,$id);

				$stmt->execute();

				
				//eliminar imagen
				unlink("img-descripcion/".$fila['imagen_descripcion_2']."");

				if(move_uploaded_file($_FILES['imagen-2-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-2-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-2-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }
			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_descripcion_2." ya existe<br>";
			 }

		}else{

			$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen_descripcion_2=(?)
												WHERE id=(?)");

			$stmt->bind_param("si",$imagen_descripcion_2,$id);

			$stmt->execute();

			//solamente ingresar imagen nueva

			$target_path = "img-descripcion/";
			$target_path = $target_path . basename( $_FILES['imagen-2-admin-input']['name']);


			if(file_exists($target_path)==FALSE){

				if(move_uploaded_file($_FILES['imagen-2-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-2-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-2-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_descripcion_2." ya existe<br>";
			 }

		}//else

	}//($fila['imagen_descripcion_3']!=''){

	if($imagen_descripcion_3!=''){

		$stmt=$baseDatos->mysqli->prepare("SELECT imagen_descripcion_3
										   FROM producto
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		if($fila['imagen_descripcion_3']!=''){

		$ext_descrip_3=pathinfo($_FILES['imagen-3-admin-input']['name'],PATHINFO_EXTENSION);

		$new_descrip_3=rand(100000000,999999999).".".$ext_descrip_3;

		$target_path = "img-descripcion/";
		$target_path = $target_path . $new_descrip_3;

			if(file_exists($target_path)==FALSE){

				
				$stmt=$baseDatos->mysqli->prepare("UPDATE producto
													SET imagen_descripcion_3=(?)
													WHERE id=(?)");

				$stmt->bind_param("si",$new_descrip_3,$id);

				$stmt->execute();
	

				//eliminar imagen
				unlink("img-descripcion/".$fila['imagen_descripcion_3']."");

				if(move_uploaded_file($_FILES['imagen-3-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-3-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-3-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_descripcion_3." ya existe<br>";
			 }


		}else{

			$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen_descripcion_3=(?)
												WHERE id=(?)");

			$stmt->bind_param("si",$imagen_descripcion_3,$id);

			$stmt->execute();

			//solamente ingresar imagen nueva

			$target_path = "img-descripcion/";
			$target_path = $target_path . basename( $_FILES['imagen-3-admin-input']['name']);

			if(file_exists($target_path)==FALSE){

				if(move_uploaded_file($_FILES['imagen-3-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-3-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-3-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_descripcion_3." ya existe<br>";
			 }

		}//else

	}//($fila['imagen_descripcion_3']!=''){


if($imagen_home!=''){

		$stmt=$baseDatos->mysqli->prepare("SELECT imagen
										   FROM producto
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		if($fila['imagen']!=''){

		$ext_home=pathinfo($_FILES['imagen-home-admin-input']['name'],PATHINFO_EXTENSION);

		$new_home=rand(100000000,999999999).".".$ext_home;

		$target_path = "img/";
		$target_path = $target_path . $new_home;	

			if(file_exists($target_path)==FALSE){


				$stmt=$baseDatos->mysqli->prepare("UPDATE producto
													SET imagen=(?)
													WHERE id=(?)");

				$stmt->bind_param("si",$new_home,$id);

				$stmt->execute();

			

					//eliminar imagen
				unlink("img/".$fila['imagen']."");

				if(move_uploaded_file($_FILES['imagen-home-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-home-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-home-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_home." ya existe<br>";
			 }

		}else{

			$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen=(?)
												WHERE id=(?)");

			$stmt->bind_param("si",$imagen_home,$id);

			$stmt->execute();

			//solamente ingresar imagen nueva

			$target_path = "img/";
			$target_path = $target_path . basename( $_FILES['imagen-home-admin-input']['name']);

			if(file_exists($target_path)==FALSE){

				if(move_uploaded_file($_FILES['imagen-home-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-home-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-home-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			 }else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_home." ya existe<br>";
			 }

		}//else

	}//($fila['imagen_descripcion_3']!=''){

if($imagen_media!=''){

		$stmt=$baseDatos->mysqli->prepare("SELECT imagen_media
										   FROM producto
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		if($fila['imagen_media']!=''){

			$ext_media=pathinfo($_FILES['imagen-media-admin-input']['name'],PATHINFO_EXTENSION);

		$new_media=rand(100000000,999999999).".".$ext_media;

		$target_path = "img-md/";
		$target_path = $target_path . $new_media;	

			if(file_exists($target_path)==FALSE){

				$stmt=$baseDatos->mysqli->prepare("UPDATE producto
									SET imagen_media=(?)
									WHERE id=(?)");

				$stmt->bind_param("si",$new_media,$id);

				$stmt->execute();

			


				//eliminar imagen
				unlink("img-md/".$fila['imagen_media']."");

				if(move_uploaded_file($_FILES['imagen-media-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-media-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-media-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_media." ya existe<br>";
			 }

		}else{

			$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen_media=(?)
												WHERE id=(?)");

			$stmt->bind_param("si",$imagen_media,$id);

			$stmt->execute();

			//solamente ingresar imagen nueva

			$target_path = "img-md/";
			$target_path = $target_path . basename( $_FILES['imagen-media-admin-input']['name']);

			if(file_exists($target_path)==FALSE){

				if(move_uploaded_file($_FILES['imagen-media-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-media-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-media-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			  }else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_media." ya existe<br>";
			 }

		}//else

	}//($fila['imagen_descripcion_3']!=''){

	if($imagen_grande!=''){

		$stmt=$baseDatos->mysqli->prepare("SELECT imagen_grande
										   FROM producto
										   WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();


		if($fila['imagen_grande']!=''){

		$ext_grande=pathinfo($_FILES['imagen-grande-admin-input']['name'],PATHINFO_EXTENSION);

		$new_grande=rand(100000000,999999999).".".$ext_grande;

		$target_path = "img-lg/";
		$target_path = $target_path . $new_grande;

			if(file_exists($target_path)==FALSE){

				$stmt=$baseDatos->mysqli->prepare("UPDATE producto
									SET imagen_grande=(?)
									WHERE id=(?)");

				$stmt->bind_param("si",$new_grande,$id);

				$stmt->execute();

			


				//eliminar imagen
				unlink("img-lg/".$fila['imagen_grande']."");

				if(move_uploaded_file($_FILES['imagen-grande-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-grande-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-grande-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			}else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_grande." ya existe<br>";
			 }

		}else{

			$stmt=$baseDatos->mysqli->prepare("UPDATE producto
												SET imagen_grande=(?)
												WHERE id=(?)");

			$stmt->bind_param("si",$imagen_grande,$id);

			$stmt->execute();

			//solamente ingresar imagen nueva

			$target_path = "img-lg/";
			$target_path = $target_path . basename( $_FILES['imagen-grande-admin-input']['name']);

			if(file_exists($target_path)==FALSE){

				if(move_uploaded_file($_FILES['imagen-grande-admin-input']['tmp_name'], $target_path)) {

				  echo "El archivo ". basename( $_FILES['imagen-grande-admin-input']['name']). " ha sido subido <br>";
				
				}else{

				  echo "Ha ocurrido en la subida de ".basename( $_FILES['imagen-grande-admin-input']['name'])." un error, trate de nuevo!<br>";
				 
				 }

			 }else{// IF FILE_EXISTS

			 	echo "El archivo ".$imagen_grande." ya existe<br>";
			 }

		}//else

	}//($fila['imagen_descripcion_3']!=''){


	$stmt->close();

}//function

}//class
?>