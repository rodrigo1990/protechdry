<?php 

class BaseDatos{

	public $base='protech';
	public $servidor='localhost';
	public $user='root';
	public $pass='';
	public $conexion;
	public $mysqli;


	public function __construct(){
		$this->conexion=mysqli_connect($this->servidor,$this->user,$this->pass,$this->base) or die ("No se ha podido establecer conexion con la base de datos");
		
		$this->mysqli=new mysqli($this->servidor, $this->user,$this->pass, $this->base);
	}

public function listarProductos(){
		//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,PRO.imagen,PRO.es_destacado,PRO.modelo,PRO.tiene_descuento,PRO.precio,PRO.precio_descuento
			 FROM producto PRO 
			 WHERE PRO.es_destacado=1
			 ORDER BY PRO.precio ASC";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

			//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==11){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-6 col-md-3 col-lg-3'>
					
					<div class='producto-responsive text-center'>
								<img  src=img/".$fila['imagen']." width='200' height='200' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<div class='color-cont'>
									<ul>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>
                                <div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
        								</h4>
    							
    						
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
					</div>
						
					</div>";
					if($z==4){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				    $descuento = (($fila['precio']-$fila['precio_descuento'])/$fila['precio'])*100;
				    
			
					if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-6 col-md-3 col-lg-3'>
					
					<div class='producto-responsive text-center'>
								<img  src=img/".$fila['imagen']." width='200' height='200' alt='Protech Dry   ".$fila['modelo']."'>
								<h3 class='descuento'>-".$descuento."% OFF</h3>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<div class='color-cont'>
									<ul>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>
                                <div class='precio-cont'>
    								<h4 class='precio'>
        								    <del>$".$fila['precio']."</del>
        								</h4>
    							
    						<h4 class='precio'>
    								    $".$fila['precio_descuento']."
								</h4>
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
					</div>
						
					</div>";
					if($z==4){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
			}//if es_destacado
		}//while



	}//function

	public function listarProductosHombres(){
		//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,PRO.imagen,PRO.es_destacado,PRO.modelo,PRO.tiene_descuento,PRO.precio,PRO.precio_descuento
		FROM producto PRO 
		WHERE PRO.id BETWEEN 3 AND 4 ORDER BY PRO.precio ASC
			";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

			//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==11){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-6 col-md-6 col-lg-6'>
					
					<div class='producto-responsive-genero text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
							
								<img  src=img/".$fila['imagen']." width='200' height='200' alt='ProtechDry   ".$fila['modelo']."'>
								<br>
								<h4 style='display:inline-block'>".strtoupper($fila['modelo'])."</h4>
								
								<div class='color-cont' style='display:inline-block'>
									<ul>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
    								</h4>
    							
        						
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>
								
								<ul>
								<!-- <li>Categoria:</li> -->
								</ul>
							
							</a>
					</div>
						
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				    $descuento = (($fila['precio']-$fila['precio_descuento'])/$fila['precio'])*100;
				
				    if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-6 col-md-6 col-lg-6'>
					
					<div class='producto-responsive-genero text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
							
								<img  src=img/".$fila['imagen']." width='200' height='200' alt='ProtechDry   ".$fila['modelo']."'>
								<h3 class='descuento'>-".$descuento."% OFF</h3>
								<br>
								<h4 style='display:inline-block'>".strtoupper($fila['modelo'])."</h4>
								
								<div class='color-cont' style='display:inline-block'>
									<ul>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    <del>$".$fila['precio']."</del>
    								</h4>
    							
        						<h4 class='precio'>
        								    $".$fila['precio_descuento']."
    								</h4>
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>
								
								<ul>
								<!-- <li>Categoria:</li> -->
								</ul>
							
							</a>
					</div>
						
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
			}//if es_destacado
		}//while



	}//function
	
	public function listarProductosHombresXs(){
		//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,PRO.imagen,PRO.es_destacado,PRO.modelo,PRO.tiene_descuento,PRO.precio,PRO.precio_descuento
		FROM producto PRO 
		WHERE PRO.id BETWEEN 3 AND 4 ORDER BY PRO.precio ASC
			";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

			//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==5){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					
					<div class='producto-responsive text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." class='img-responsive' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<br>
								<div class='color-cont'>
									<ul style='padding-left:0'>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
    								</h4>
    							
        					
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
							</a>
					</div>
						
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				    
				    if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					
					<div class='producto-responsive text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." class='img-responsive' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<br>
								<div class='color-cont'>
									<ul style='padding-left:0'>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
    								</h4>
    							
        							<h4 class='precio'>
        								    $".$fila['precio_descuento']."
    								</h4>
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
							</a>
					</div>
						
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
			}//if es_destacado
		}//while



	}//function

	public function listarProductosMujeres(){
		//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,PRO.imagen,PRO.es_destacado,PRO.modelo,PRO.tiene_descuento,PRO.precio,PRO.precio_descuento
		FROM producto PRO 
		WHERE PRO.id BETWEEN 1 AND 2 ORDER BY PRO.precio ASC";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

			//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==11){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-6 col-md-6 col-lg-6'>
					
					<div class='producto-responsive-genero text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." width='200' height='200' alt='Protech  ".$fila['modelo']."'>
								<br>
								<h4 style='display:inline-block'>".strtoupper($fila['modelo'])."</h4>
								<div class='color-cont' style='display:inline-block'>
									<ul>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
    								</h4>
    							
        						
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>
								
								<ul>
								<!-- <li>Categoria:</li> -->
								</ul>
							
							</a>
					</div>
						
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				    $descuento = (($fila['precio']-$fila['precio_descuento'])/$fila['precio'])*100;
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-6 col-md-6 col-lg-6'>
					
					<div class='producto-responsive-genero text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." width='200' height='200' alt='Protech  ".$fila['modelo']."'>
								<h3 class='descuento'>-".$descuento."% OFF</h3>
								<br>
								<h4 style='display:inline-block'>".strtoupper($fila['modelo'])."</h4>
								<div class='color-cont' style='display:inline-block'>
									<ul>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    <del>$".$fila['precio']."</del>
    								</h4>
    							
        							<h4 class='precio'>
        								    $".$fila['precio_descuento']."
    								</h4>
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>
								
								<ul>
								<!-- <li>Categoria:</li> -->
								</ul>
							
							</a>
					</div>
						
					</div>";
					if($z==5){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
				
		
				}
			}//if es_destacado
		}//while



	}//function
	
	public function listarProductosMujeresXs(){
		//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,PRO.imagen,PRO.es_destacado,PRO.modelo,PRO.tiene_descuento,PRO.precio,PRO.precio_descuento
		FROM producto PRO 
		WHERE PRO.id BETWEEN 1 AND 2 ORDER BY PRO.precio ASC
			";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

				//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==5){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					
					<div class='producto-responsive text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." class='img-responsive' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<br>
								<div class='color-cont'>
									<ul style='padding-left:0'>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
    								</h4>
    							

								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
							</a>
					</div>
						
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				
				if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					
					<div class='producto-responsive text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." class='img-responsive' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<br>
								<div class='color-cont'>
									<ul style='padding-left:0'>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    <del>$".$fila['precio']."</del>
    								</h4>
    							
        						<h4 class='precio'>
        								    $".$fila['precio_descuento']."
    								</h4>
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
							</a>
					</div>
						
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
			}//if es_destacado
		}//while



	}//function

	public function listarProductosParaDispositivosXs(){
	//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,PRO.imagen,PRO.es_destacado,PRO.modelo,PRO.tiene_descuento,PRO.precio,PRO.precio_descuento
			 FROM producto PRO 
			 WHERE PRO.es_destacado=1
			 ORDER BY PRO.precio ASC";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

			//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==5){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					
					<div class='producto-responsive text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." class='img-responsive' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<br>
								<div class='color-cont'>
									<ul style='padding-left:0'>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								    $".$fila['precio']."
        								</h4>
    							
    							<!--<h4 class='precio'>
    								    $".$fila['precio_descuento']."
								</h4>-->
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
							</a>
					</div>
						
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				
				if($z==1){
						echo "<div class='producto-row row' style=''>";
						echo "<div class='container'>";
					}
				
					echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					
					<div class='producto-responsive text-center'>
							<a href='vermasproducto.php?id=".$fila['id']."'>
								<img  src=img/".$fila['imagen']." class='img-responsive' alt='Protech Dry   ".$fila['modelo']."'>
								<h4>".strtoupper($fila['modelo'])."</h4>
								<br>
								<div class='color-cont'>
									<ul style='padding-left:0'>
										<li class='blanco'></li>
										<li clasS='negro'></li>
									</ul>
								</div>

								<div class='precio-cont'>
    								<h4 class='precio'>
        								   <del>$".$fila['precio']."</del>
        								</h4>
    							
    							<h4 class='precio'>
    								    $".$fila['precio_descuento']."
								</h4>
								</div>
								<a class='comprar-btn' href='vermasproducto.php?id=".$fila['id']."'>COMPRAR</a>

							
							
							</a>
					</div>
						
					</div>";
					if($z==2){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
			}//if es_destacado
		}//while



}//function

public function listarProductosParaDispositivosSm(){
		//contador
		$i=0;
		$z=0;//Descomentar para listar 8 elementos segun grilla bootstrap

		$sql="SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.es_destacado,PRO.tiene_descuento,PRO.precio_descuento,CAT.descripcion,ROD.descripcion as rodado,TV.descripcion as tipo_vehiculo
			 FROM producto PRO  JOIN marca MAR ON MAR.id=PRO.id_marca
			 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
			 					JOIN alto ALT  ON ALT.id=PRO.id_alto
			 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
			 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
			 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
			 WHERE PRO.es_destacado=1
			 ORDER BY PRO.precio ASC";



		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){
		if($fila['es_destacado']==1){

			//lista nada mas los primeros 10 productos
			$i++;
			$z++;//Descomentar para listar 8 elementos segun grilla bootstrap
			if($i==9){break;}


			if($fila['tiene_descuento']==0){

					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
				
					echo "<div class='hidden-xs col-sm-3 hidden-md hidden-lg'>
					<div class='producto-responsive'>


						<h3>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img  src=img/".$fila['imagen']." width='150' height='150'>
						
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
					if($z==4){
						echo "</div>";
						echo "</div>";
						$z=0;
					}

				}else if($fila['tiene_descuento']==1){
				
					if($z==1){
						echo "<div class='producto-row row'>";
						echo "<div class='container'>";
					}
					$cien=100;
					echo "<div class='hidden-xs col-sm-3 hidden-md hidden-lg'>
						<div class='producto-responsive'>

						<h3>".$fila['marca']." <br><span> ".$fila['modelo']."</span></h3>


						<img   src=img/".$fila['imagen']." width='150' height='150'>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila['precio']."</del> $<br>".$fila['precio_descuento']."</h4>
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

					if($z==4){
						echo "</div>";
						echo "</div>";
						$z=0;
					}
		
				}
			}//if es_destacado
		}//while



	}//function

	

	
//LISTAR UN SOLO PRODUCTO
public function listarUnSoloProducto($id){

			$stmt=$this->mysqli->prepare(

				"SELECT PRO.id,MAR.descripcion as marca ,PRO.modelo,PRO.imagen,
				PRO.descripcion_1,PRO.descripcion_2,PRO.descripcion_3,PRO.descripcion_4,PRO.descripcion_5,PRO.descripcion_6,
				PRO.descripcion_7,PRO.precio,PRO.tiene_stock,PRO.tiene_descuento,PRO.precio_descuento
				 FROM producto PRO   JOIN marca MAR ON MAR.id=PRO.id_marca
				 WHERE PRO.id=(?)"


				 );
			$stmt->bind_param("i",$id);

			$stmt->execute();

			$resultado=$stmt->get_result();

		


		while($fila=$resultado->fetch_assoc()){

			if($fila['tiene_stock']==1){
				if($fila['tiene_descuento']==0){


			//desconmentar calcular-cont row para ver el div con los iconos con sus correspondientes modals de calculo de envio y cuotas.
			echo
			"	
				<div class='row'>
				<h1>".strtoupper($fila['modelo'])."</h1>
				</div>

				<div class='row'>
				<h2 style='color:black;display:inline-block'>$".$fila['precio']."</h2>
				<!--<div class='icon-seccion' style='display:inline-block'>
				<div class='arrow_box2'>
						<h3>-20%OFF</h3>
					</div>
				</div>
				</div>-->

								<form id='form-ver-mas'  action='agregarACarrito.php' method='POST'>

				<div class='row'>

					<label>
						<input type='radio' name='color' id='negro-input' value='negro'>
						<div class='colores' id='negro-div' style='background-color:black;width:50px;height:50px;display:inline-block'></div>
					</label>
					
					<label>
						<input type='radio' name='color' id='blanco-input' value='blanco'>
						<div class='colores' id='blanco-div' style='background-color:white;width:50px;height:50px;display:inline-block'></div>
					</label>	

					<div id='color-error' class='agregarACarrito-error' style='color:red'>
						Seleccione un color
					</div>			
				

				</div>


				<div class='row'>
						<select class='form-control select-talle' name='talle' id='talle' style='margin-bottom:1%;display:inline-block;width:50%' id='select-talle'>
							<option value='0'>Seleccione un talle</option>
							<option value='S'>S</option>
							<option value='M'>M</option>
							<option value='L'>L</option>
							<option value='XL'>XL</option>
							<option value='XXL'>XXL</option>
							
							
							
							
						</select>
						<a class='lista-de-talles-link' style='display:inline-block;'data-toggle='modal' data-target='#lista-de-talles-modal'>Guia de talles</a>

						<div id='talle-error' class='agregarACarrito-error' style='color:red'>
							Seleccione un talle
						</div>
				</div>

				<div class='row'>
						<input type='number' min='1' style='display:inline-block' name='cantidad' id='cantidad'>
						<input type='hidden' id='ver-mas-id'  name='id' value='".$fila['id']."'>
						<input type='hidden' id='ver-mas-marca' name='marca' value='".$fila['marca']."'>
						<input type='hidden' id='ver-mas-precio' name='precio' value='".$fila['precio']."'>
						<input type='hidden' id='ver-mas-modelo' name='modelo' value='".$fila['modelo']."'>		
						<input type='hidden' id='ver-mas-imagen' name='imagen' value='".$fila['imagen']."'>			
						<input type='hidden' id='ver-mas-tiene-descuento' name='tiene_descuento' value='".$fila['tiene_descuento']."'>
					<input type='hidden' id='ver-mas-precio-descuento' name='precio_descuento' value='".$fila['precio_descuento']."'>			


						<button type='button' id='btn-carrito' style='padding:21px;margin-left:1%;' class='btn btn-primary' onclick='submitformCompra()'>AGREGAR AL CARRITO</button>
					
				</form>	

								
				</div>
				";
				}elseif($fila['tiene_descuento']==1){
                $descuento = (($fila['precio']-$fila['precio_descuento'])/$fila['precio'])*100;

			//desconmentar calcular-cont row para ver el div con los iconos con sus correspondientes modals de calculo de envio y cuotas.
			echo
			"	
				<div class='row'>
				<h1>".strtoupper($fila['modelo'])."</h1>
				</div>

				<div class='row'>
				<del><h2 style='color: grey;font-size: 2rem;'>$".$fila['precio']."</h2></del>
				<h2 style='color:black;display:inline-block;margin-top:0'>$".$fila['precio_descuento']."</h2>
				<div class='icon-seccion' style='display:inline-block'>
				<div class='arrow_box2'>
						<h3>-".$descuento."%OFF</h3>
					</div>
				</div>
				</div>

								<form id='form-ver-mas'  action='agregarACarrito.php' method='POST'>

				<div class='row'>

					<label>
						<input type='radio' name='color' id='negro-input' value='negro'>
						<div class='colores' id='negro-div' style='background-color:black;width:50px;height:50px;display:inline-block'></div>
					</label>
					
					<label>
						<input type='radio' name='color' id='blanco-input' value='blanco'>
						<div class='colores' id='blanco-div' style='background-color:white;width:50px;height:50px;display:inline-block'></div>
					</label>	

					<div id='color-error' class='agregarACarrito-error' style='color:red'>
						Seleccione un color
					</div>			
				

				</div>


				<div class='row'>
						<select class='form-control select-talle' name='talle' id='talle' style='margin-bottom:1%;display:inline-block;width:50%' id='select-talle'>
							<option value='0'>Seleccione un talle</option>
							<option value='S'>S</option>
							<option value='M'>M</option>
							<option value='L'>L</option>
							<option value='XL'>XL</option>
							<option value='XXL'>XXL</option>
							
							
							
							
						</select>
						<a class='lista-de-talles-link' style='display:inline-block;'data-toggle='modal' data-target='#lista-de-talles-modal'>Guia de talles</a>

						<div id='talle-error' class='agregarACarrito-error' style='color:red'>
							Seleccione un talle
						</div>
				</div>

				<div class='row'>
						<input type='number' min='1' style='display:inline-block' name='cantidad' id='cantidad'>
						<input type='hidden' id='ver-mas-id'  name='id' value='".$fila['id']."'>
						<input type='hidden' id='ver-mas-marca' name='marca' value='".$fila['marca']."'>
						<input type='hidden' id='ver-mas-precio' name='precio' value='".$fila['precio']."'>
						<input type='hidden' id='ver-mas-modelo' name='modelo' value='".$fila['modelo']."'>		
						<input type='hidden' id='ver-mas-imagen' name='imagen' value='".$fila['imagen']."'>			
						<input type='hidden' id='ver-mas-tiene-descuento' name='tiene_descuento' value='".$fila['tiene_descuento']."'>
					<input type='hidden' id='ver-mas-precio-descuento' name='precio_descuento' value='".$fila['precio_descuento']."'>			


						<button type='button' id='btn-carrito' style='padding:21px;margin-left:1%;' class='btn btn-primary' onclick='submitformCompra()'>AGREGAR AL CARRITO</button>
					
				</form>	

								
				</div>
				";
				}
			}
			echo "<div class='row'>
					<ul style='padding-left:0;    color: #0a0303;
    line-height: 21px;font-size:15px;'>";

			if($fila['descripcion_1']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_1'])."</li>";
			}

			if($fila['descripcion_2']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_2'])."</li>";
			}

			if($fila['descripcion_3']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_3'])."</li>";
			}

			if($fila['descripcion_4']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_4'])."</li>";
			}

			if($fila['descripcion_5']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_5'])."</li>";
			}

			if($fila['descripcion_6']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_6'])."</li>";
			}

			if($fila['descripcion_7']!=''){
				echo "<li>-".utf8_encode($fila['descripcion_7'])."</li>";
			}
			
			echo "<li>-No planchar el &#225;rea absorbente.</li>";
			echo "<li>-No usar suavizante</li>";


			echo	"</ul>
				</div>" ;

		}//while

		$stmt->close();




	}//function	

	public function listarImagenes($id){

		$stmt=$this->mysqli->prepare(

				"SELECT imagen_descripcion_1,imagen_descripcion_2,
				imagen_descripcion_3,imagen_descripcion_4,
				imagen_descripcion_5,imagen_descripcion_6,imagen_descripcion_lg
				 FROM producto PRO 
				 WHERE PRO.id=(?)"


				 );
			$stmt->bind_param("i",$id);

			$stmt->execute();

			$resultado=$stmt->get_result();

		


		while($fila=$resultado->fetch_assoc()){

			//desconmentar calcular-cont row para ver el div con los iconos con sus correspondientes modals de calculo de envio y cuotas.
			echo
			"
				<div class='col-lg-5 col-md-12 col-sm-12 col-xs-12 ver-mas-col'>
					<div class='img-gal-cont'>
						 <a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_lg']."' class='image-cont'>
						 	<img src='img-md/".$fila['imagen_descripcion_lg']."'  class='img-responsive'>
						 </a>
					   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:0; top: 10px;z-index: 10;' class='prod-zoom-icon' />
 
					</div>
				</div>	

				<div class='col-lg-7 col-md-12 hidden-sm col-xs-12 ver-mas-col'>
					<div class='row'>

						<div class='img-gal-cont'>
							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_1']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_1']."' class='img-responsive'  width='130px' height='220px' >
							</a>
						   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:0; top: 10px;z-index: 10;'class='prod-zoom-icon' />

						</div>
						<div class='img-gal-cont'>

							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_2']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_2']."'class='img-responsive'  width='130px' height='220px' >
							</a>
						   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:141px; top: 10px;z-index: 10;'class='prod-zoom-icon' />

						</div>
						<div class='img-gal-cont'>
							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_6']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_6']."'class='img-responsive'  width='130px' height='220px' >
							</a>
						   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:259px; top: 10px;z-index: 10;'class='prod-zoom-icon' />

						</div>
					</div>
					<div class='row'>
						<div class='img-gal-cont'>
							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_4']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_4']."'class='img-responsive'  width='130px' height='220px' >
							</a>

						   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:2px; top: 10px;z-index: 10;'class='prod-zoom-icon' />


						</div>
					<div class='img-gal-cont'>

						<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_3']."' class='image-cont'>
							<img src='img-md/".$fila['imagen_descripcion_3']."'class='img-responsive'  width='130px' height='220px' >
						</a>
						   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:141px; top: 10px;z-index: 10;'class='prod-zoom-icon' />



					</div>

					<div class='img-gal-cont'>


						<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_5']."' class='image-cont'>
							<img src='img-md/".$fila['imagen_descripcion_5']."' class='img-responsive' width='130px' height='220px' >
						</a>
						   	<img src='elementos_separados/zoom-icon.png' width='15px'height='15px'style='position: absolute;left:259px; top: 10px;z-index: 10;'class='prod-zoom-icon' />




					</div>
					</div>
				</div>	


					



			";
			
			

		}//while

		$stmt->close();


	}
	public function listarImagenesSm($id){


		$stmt=$this->mysqli->prepare(

				"SELECT imagen_descripcion_1,imagen_descripcion_2,
				imagen_descripcion_3,imagen_descripcion_4,
				imagen_descripcion_5,imagen_descripcion_6,imagen_descripcion_lg
				 FROM producto PRO 
				 WHERE PRO.id=(?)"


				 );
			$stmt->bind_param("i",$id);

			$stmt->execute();

			$resultado=$stmt->get_result();

		


		while($fila=$resultado->fetch_assoc()){

			//desconmentar calcular-cont row para ver el div con los iconos con sus correspondientes modals de calculo de envio y cuotas.
			echo
			"
				

				
					<div class='row' style='margin-top:6%'>
						<div class='container'>
							<div class='hidden-lg hidden-md col-sm-4 hidden-xs'>
						    	<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_1']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_1']."'  width='150px' height='220px' >
							    </a>
							</div>
							<div class='hidden-lg hidden-md col-sm-4 hidden-xs'>
								<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_2']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_2']."'  width='150px' height='220px' >
								</a>
							</div>
							<div class='hidden-lg hidden-md col-sm-4 hidden-xs'>
							    <a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_6']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_6']."'  width='150px' height='220px' >
								</a>
							</div>
						</div>
					</div>
					<div class='row'>
						<div class='container'>
							<div class='hidden-lg hidden-md col-sm-4 hidden-xs'>
							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_4']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_4']."'  width='150px' height='220px' >
								</a>
							</div>
							<div class='hidden-lg hidden-md col-sm-4 hidden-xs'>
							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_3']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_3']."'  width='150px' height='220px' >
								</a>
							</div>
							<div class='hidden-lg hidden-md col-sm-4 hidden-xs'>
							<a data-fancybox='gallery' href='img-md/".$fila['imagen_descripcion_3']."' class='image-cont'>
								<img src='img-md/".$fila['imagen_descripcion_3']."'  width='150px' height='220px' >
								</a>
							</div>
						</div>
					</div>	


			



			";
			
			

		}//while

		$stmt->close();


	}


		public function listarImagenesXs($id){

		$stmt=$this->mysqli->prepare(

				"SELECT imagen_descripcion_1,imagen_descripcion_2,
				imagen_descripcion_3,imagen_descripcion_4,
				imagen_descripcion_5,imagen_descripcion_6,imagen_descripcion_lg
				 FROM producto PRO 
				 WHERE PRO.id=(?)"


				 );
			$stmt->bind_param("i",$id);

			$stmt->execute();

			$resultado=$stmt->get_result();

		


		while($fila=$resultado->fetch_assoc()){

			//desconmentar calcular-cont row para ver el div con los iconos con sus correspondientes modals de calculo de envio y cuotas.
			echo
			"
				<div class='hidden-lg hidden-md hidden-sm col-xs-12 ver-mas-col'>
					<img src='img-md/".$fila['imagen_descripcion_lg']."'>
				</div>	

				<div class='hidden-lg hidden-md hidden-sm col-xs-12 ver-mas-col'>
					<div class='row'>
						<img src='img-md/".$fila['imagen_descripcion_1']."' class='img-responsive'  width='150px' height='220px' >
						<img src='img-md/".$fila['imagen_descripcion_2']."' class='img-responsive'  width='150px' height='220px' >
						<img src='img-md/".$fila['imagen_descripcion_6']."' class='img-responsive'  width='150px' height='220px' >
					</div>
					<div class='row'>
						<img src='img-md/".$fila['imagen_descripcion_4']."' class='img-responsive'  width='150px' height='220px' >
						<img src='img-md/".$fila['imagen_descripcion_3']."' class='img-responsive'  width='150px' height='220px' >
						<img src='img-md/".$fila['imagen_descripcion_5']."' class='img-responsive'  width='150px' height='220px' >
					</div>
				</div>			

			";
			
			

		}//while

		$stmt->close();


	}


	public function listarDescripcion($id_producto){

		

		$stmt=$this->mysqli->prepare("SELECT PRO.imagen_descripcion_1,PRO.descripcion_1,PRO.imagen_descripcion_2,PRO.descripcion_2,PRO.imagen_descripcion_3,PRO.descripcion_3,PRO.titulo_descripcion_1,
											PRO.titulo_descripcion_2,PRO.titulo_descripcion_3,
											ANC.descripcion as ancho,ALT.descripcion as alto,
											ROD.descripcion as rodado,ORG.descripcion as origen,
											TV.descripcion as tipo_vehiculo,CAR.descripcion as carga,
											VEL.descripcion as velocidad,MAR.garantia
									  FROM producto PRO JOIN ancho ANC ON PRO.id_ancho=ANC.id
									  					JOIN alto ALT ON PRO.id_alto=ALT.id
									  					JOIN carga CAR ON PRO.id_carga=CAR.id
									  					JOIN velocidad VEL ON PRO.id_velocidad=VEL.id
									  					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado 
									  					JOIN origen ORG ON PRO.id_origen=ORG.id
									  					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
									  					JOIN marca MAR ON PRO.id_marca=MAR.id
									  WHERE PRO.id=(?)");
		$stmt->bind_param("i",$id_producto);


		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){

			if($fila['descripcion_1']!=''){

					echo "
					<div class='row'>
						<div class='container'>
							<div class='titulo-ver-mas-cont col-xs-12 col-sm-12 col-md-12 col-lg-12'>
								<h1> Descripcion </h1><hr class='titulo-hr'>
							</div>
						</div>
					</div>
			";

				echo  "<div class='ver-mas-cont row'>
						<div class='container'>

							<div class='hidden-xs col-sm-5 col-md-5 col-lg-5'>
								
								<img class='img-responsive img-ver-mas-descripcion' src='img-descripcion/".$fila['imagen_descripcion_1']."'>

							</div>

							<div class='texto-descripcion-cont col-xs-12 col-sm-7 col-md-7 col-lg-7'>
								
								<h3 class='ver-mas-descripcion-p'>".$fila['titulo_descripcion_1']."</h3>

								<p class='ver-mas-descripcion-p'>".$fila['descripcion_1']."</p>
								
							</div>

								<div class='col-xs-12 hidden-sm hidden-md hidden-lg'>
								
								<img class='img-responsive img-ver-mas-descripcion' src='img-descripcion/".$fila['imagen_descripcion_1']."'>

							</div>
						
						</div>
						
						<div class='container'>
							<hr class='linea-titulo-ver-mas'>
						</div>
						
						</div>	


						";

			}//fila

			if($fila['descripcion_2']!=''){

				echo  "<div class='ver-mas-cont row'>

						<div class='container'>

							<div class='texto-descripcion-cont col-xs-12 col-sm-5 col-md-5 col-lg-5'>
								
								<h3 class='ver-mas-descripcion-p'>".$fila['titulo_descripcion_2']."</h3>
							
								<p class='ver-mas-descripcion-p'>".$fila['descripcion_2']."</p>


							</div>

							<div class='col-xs-12 col-sm-7 col-md-7 col-lg-7'>

								<img class='img-responsive img-ver-mas-descripcion' src='img-descripcion/".$fila['imagen_descripcion_2']."'>

								
							</div>

						
						</div>

						<div class='container'>
							<hr class='linea-titulo-ver-mas'>
						</div>

						</div>	


						";

			}//fila
			if($fila['descripcion_3']!=''){

				echo  "<div class='ver-mas-cont row'>

						<div class='container'>

							<div class='hidden-xs col-sm-5 col-md-5 col-lg-5'>
							
								<img class='img-responsive img-ver-mas-descripcion' src='img-descripcion/".$fila['imagen_descripcion_3']."'>

							</div>

							<div class='texto-descripcion-cont col-xs-12 col-sm-7 col-md-7 col-lg-7'>

								<h3 class='ver-mas-descripcion-p'>".$fila['titulo_descripcion_3']."</h3>

								<p class='ver-mas-descripcion-p'>".$fila['descripcion_3']."</p>
								
							</div>

							<div class='col-xs-12 hidden-sm hidden-md hidden-lg'>
							
								<img class='img-responsive img-ver-mas-descripcion' src='img-descripcion/".$fila['imagen_descripcion_3']."'>

							</div>
						
						</div>



						</div>	


						";

			}//fila


			echo "
					<div class='row'>
						<div class='container'>
							<div class='titulo-ver-mas-cont col-xs-12 col-sm-12 col-md-12 col-lg-12'>
								<h1> Ficha Tecnica </h1><hr class='titulo-hr'>
							</div>
						</div>
					</div>
			";




			echo "<div class='row'>";
			echo "<div class='container'>";

			echo "<div class='col-xs-12 co-sm-12 col-md-12 col-lg-12'>";

				echo "<div id='ficha_tecnica' class='table-responsive'>          
				  		<table class='table'>
						    <thead>
						      <tr>
						        <th class='active'>Ancho</th>
						        <th class='active'>Alto</th>
						        <th class='active'>Carga</th>
						        <th class='active'>Velocidad</th>
						        <th class='active'>Rodado</th>
						        <th class='active'>Tipo de vehiculo</th>
						        <th class='active'>Origen</th>
						      </tr>
						    </thead>
						    <tbody>
						      <tr>
						        <td class='active'><i>".$fila['ancho']."</i></td>
						        <td class='active'><i>".$fila['alto']."</i></td>
						        <td class='active'><i>".$fila['carga']."</i></td>
						        <td class='active'><i>".$fila['velocidad']."</i></td>
						        <td class='active'><i>".$fila['rodado']."</i></td>
						        <td class='active'><i>".$fila['tipo_vehiculo']."</i></td>
						        <td class='active'><i>".$fila['origen']."</i></td>
						      </tr>
						    </tbody>
				  		</table>
					</div>";
			echo "</div>";
			echo "</div>";
			echo "</div>";




			echo "
					<div class='row'>
						<div class='container'>
							<div class='garantia col-xs-12 col-sm-12 col-md-12 col-lg-12'>
							<h1><b><i>".$fila['garantia']." A単os <br> Garantia Oficial</i></b></h1>
							<img src='elementos_separados/garantia-icon.png'>
							</div>
						</div>
					</div>
			";

		}//while


		$stmt->close();
	}//function

	public function listarProductosRelacionados($id_producto){

		//contador
		$i=0;//cuenta el total de productos listados
		$z=0;//cuenta 5 hasta completar una fila 

		$stmt=$this->mysqli->prepare("SELECT id_marca
			  								FROM producto 
			  								WHERE id=(?)");
		$stmt->bind_param("i",$id_producto);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila['id_marca']!=''){

			$buscar_id_marca=$fila['id_marca'];

			$sql2="SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,CAT.descripcion,ROD.descripcion as rodado,TV.descripcion as tipo_vehiculo
				 FROM producto PRO  JOIN marca MAR ON MAR.id=PRO.id_marca
				 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
				 					JOIN alto ALT  ON ALT.id=PRO.id_alto
				 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
				 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
				 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
				 WHERE PRO.id_marca=$buscar_id_marca";

			$consulta2=mysqli_query($this->conexion,$sql2);


			

			while($fila2=mysqli_fetch_assoc($consulta2)){
				//lista nada mas los primeros 10 productos
				$i++;//cuenta el total de productos listados
				$z++;//cuenta 5 hasta completar una fila 
				if($i==6){break;}

				if($fila2['tiene_descuento']==0){

						if($z==1){
							echo "<div class='producto-row  row'>";
							echo "<div class='container'>";
						}
					
						echo "<div class='hidden-xs hidden-sm col-md-15 col-lg-15'>
						<div class='producto-responsive'>


							<h3>".$fila2['marca']." <br><span> ".$fila2['modelo']."</span></h3>


							<img  src=img/".$fila2['imagen']." width='165' height='165'>
							
							<div class='producto-precio-responsive'>
							<h4>$".$fila2['precio']."</h4>
							</div>
							
							<ul>
							<li>Medida:".$fila2['ancho']." x ".$fila2['alto']."</li>
							<li>Rodado:".$fila2['rodado']."</li>
							<li>Vehiculo:".$fila2['tipo_vehiculo']."</li>
							<li>Categoria:".$fila2['descripcion']."</li>
							</ul>
							
							<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila2['id']."'>Ver mas</a></div>

							</div>
						</div>";
						if($z==5){
							echo "</div>";
							echo "</div>";
							$z=0;
						}

					}else if($fila2['tiene_descuento']==1){
					
						if($z==1){
							echo "<div class='producto-row  row'>";
							echo "<div class='container'>";
						}
						$cien=100;
						echo "<div class='hidden-xs hidden-sm col-md-15 col-lg-15'>
							<div class='producto-responsive'>

							<h3>".$fila2['marca']." <br><span> ".$fila2['modelo']."</span></h3>


							<img   src=img/".$fila2['imagen']." width='165' height='165'>
						<!--<div class='circulo-cont'>COMENTADO--><h3 class='producto-porcentaje-descuento'>".-floor(($fila2['precio']-$fila2['precio_descuento'])/$fila2['precio']*$cien)."%</h3><!--</div>-->

							<div class='producto-precio-responsive'>
							<h4><del>$".$fila2['precio']."</del> $".$fila2['precio_descuento']." </h4>
							</div>

							<ul>
							<li>Medida:".$fila2['ancho']." x ".$fila2['alto']."</li>
							<li>Rodado:".$fila2['rodado']."</li>
							<li>Vehiculo:".$fila2['tipo_vehiculo']."</li>
							<li>Categoria:".$fila2['descripcion']."</li>
							</ul>

							<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila2['id']."'>Ver mas</a></div>
					
						</div>
						</div>";	

						if($z==5){
							echo "</div>";
							echo "</div>";
							$z=0;
						}
			
					}
			}//while

		}//if($fila['id_marca']!=''){


	}// function relacionados

	public function listarProductosRelacionadosParaDispositivosXs($id_producto){

		//contador
		$i=0;//cuenta el total de productos listados
		$z=0;//cuenta 5 hasta completar una fila 

		$stmt=$this->mysqli->prepare("SELECT id_marca
			  								FROM producto 
			  								WHERE id=(?)");
		$stmt->bind_param("i",$id_producto);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila['id_marca']!=''){

			$buscar_id_marca=$fila['id_marca'];

			$sql2="SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,CAT.descripcion,ROD.descripcion as rodado,TV.descripcion as tipo_vehiculo
				 FROM producto PRO  JOIN marca MAR ON MAR.id=PRO.id_marca
				 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
				 					JOIN alto ALT  ON ALT.id=PRO.id_alto
				 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
				 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
				 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
				 WHERE PRO.id_marca=$buscar_id_marca";

			$consulta2=mysqli_query($this->conexion,$sql2);

			while($fila2=mysqli_fetch_assoc($consulta2)){
				//lista nada mas los primeros 10 productos
				$i++;//cuenta el total de productos listados
				$z++;//cuenta 5 hasta completar una fila 
				if($i==5){break;}

				if($fila2['tiene_descuento']==0){

						if($z==1){
							echo "<div class='producto-row  row'>";
							echo "<div class='container'>";
						}
					
						echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
					<div class='producto-responsive'>


						<h3>".$fila2['marca']." <br><span> ".$fila2['modelo']."</span></h3>


						<img  src=img/".$fila2['imagen']." width='150' height='150'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila2['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila2['ancho']." x ".$fila2['alto']."</li>
						<li>Rodado:".$fila2['rodado']."</li>
						<li>Vehiculo:".$fila2['tipo_vehiculo']."</li>
						<li>Categoria:".$fila2['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila2['id']."'>Ver mas</a></div>

						</div>
					</div>";
						if($z==2){
							echo "</div>";
							echo "</div>";
							$z=0;
						}

					}else if($fila2['tiene_descuento']==1){
					
						if($z==1){
							echo "<div class='producto-row  row'>";
							echo "<div class='container'>";
						}
						$cien=100;
						echo "<div class='col-xs-6 hidden-sm hidden-md hidden-lg'>
						<div class='producto-responsive'>

						<h3>".$fila2['marca']." <br><span> ".$fila2['modelo']."</span></h3>


						<img   src=img/".$fila2['imagen']." width='150' height='150'>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila2['precio']."</del> $<br>".$fila2['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila2['ancho']." x ".$fila2['alto']."</li>
						<li>Rodado:".$fila2['rodado']."</li>
						<li>Vehiculo:".$fila2['tipo_vehiculo']."</li>
						<li>Categoria:".$fila2['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila2['id']."'>Ver mas</a></div>
				
					</div>
					</div>";	

						if($z==2){
							echo "</div>";
							echo "</div>";
							$z=0;
						}
			
					}
			}//while

		}//if($fila['id_marca']!=''){


	}//function relacionadosXs
	
	public function listarProductosRelacionadosParaDispositivosSm($id_producto){

		//contador
		$i=0;//cuenta el total de productos listados
		$z=0;//cuenta 5 hasta completar una fila 

		$stmt=$this->mysqli->prepare("SELECT id_marca
			  								FROM producto 
			  								WHERE id=(?)");
		$stmt->bind_param("i",$id_producto);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila['id_marca']!=''){

			$buscar_id_marca=$fila['id_marca'];

			$sql2="SELECT PRO.id,MAR.descripcion as marca,PRO.modelo,ANC.descripcion as ancho,ALT.descripcion as alto,PRO.imagen,PRO.precio,PRO.tiene_descuento,PRO.precio_descuento,CAT.descripcion,ROD.descripcion as rodado,TV.descripcion as tipo_vehiculo
				 FROM producto PRO  JOIN marca MAR ON MAR.id=PRO.id_marca
				 					JOIN ancho ANC ON ANC.id=PRO.id_ancho
				 					JOIN alto ALT  ON ALT.id=PRO.id_alto
				 					JOIN categoria CAT ON PRO.id_categoria=CAT.id 
				 					JOIN rodado ROD ON PRO.id_rodado=ROD.id_rodado
				 					JOIN tipo_vehiculo TV ON PRO.id_tipo_vehiculo=TV.id_tipo_vehiculo
				 WHERE PRO.id_marca=$buscar_id_marca";

			$consulta2=mysqli_query($this->conexion,$sql2);

			while($fila2=mysqli_fetch_assoc($consulta2)){
				//lista nada mas los primeros 10 productos
				$i++;//cuenta el total de productos listados
				$z++;//cuenta 5 hasta completar una fila 
				if($i==5){break;}

				if($fila2['tiene_descuento']==0){

						if($z==1){
							echo "<div class='producto-row  row'>";
							echo "<div class='container'>";
						}
					
						echo "<div class='hidden-xs col-sm-3 hidden-md hidden-lg'>
					<div class='producto-responsive'>


						<h3>".$fila2['marca']." <br><span> ".$fila2['modelo']."</span></h3>


						<img  src=img/".$fila2['imagen']." width='150' height='150'>
						
						<div class='producto-precio-responsive'>
						<h4>$".$fila2['precio']."</h4>
						</div>
						
						<ul>
						<li>Medida:".$fila2['ancho']." x ".$fila2['alto']."</li>
						<li>Rodado:".$fila2['rodado']."</li>
						<li>Vehiculo:".$fila2['tipo_vehiculo']."</li>
						<li>Categoria:".$fila2['descripcion']."</li>
						</ul>
						
						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila2['id']."'>Ver mas</a></div>

						</div>
					</div>";
						if($z==4){
							echo "</div>";
							echo "</div>";
							$z=0;
						}

					}else if($fila2['tiene_descuento']==1){
					
						if($z==1){
							echo "<div class='producto-row  row'>";
							echo "<div class='container'>";
						}
						$cien=100;
						echo "<div class='hidden-xs col-sm-3 hidden-md hidden-lg'>
						<div class='producto-responsive'>

						<h3>".$fila2['marca']." <br><span> ".$fila2['modelo']."</span></h3>


						<img   src=img/".$fila2['imagen']." width='150' height='150'>

						<div class='producto-precio-responsive'>
						<h4><del>$".$fila2['precio']."</del> $<br>".$fila2['precio_descuento']."</h4>
						</div>

						<ul>
						<li>Medida:".$fila2['ancho']." x ".$fila2['alto']."</li>
						<li>Rodado:".$fila2['rodado']."</li>
						<li>Vehiculo:".$fila2['tipo_vehiculo']."</li>
						<li>Categoria:".$fila2['descripcion']."</li>
						</ul>

						<div class='paralelogramo-btn-responsive'><a href='vermasproducto.php?id=".$fila2['id']."'>Ver mas</a></div>
				
					</div>
					</div>";	

						if($z==4){
							echo "</div>";
							echo "</div>";
							$z=0;
						}
			
					}
			}//while

		}//if($fila['id_marca']!=''){


	}//function relacionadosSm

	public function listarImagenZoom($id_producto){

				$stmt=$this->mysqli->prepare("SELECT imagen_media, imagen_grande
									  FROM producto
									  WHERE id=(?)");
		$stmt->bind_param("i",$id_producto);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo "<img id='img-zoom' src='img-md/".$fila['imagen_media']."' data-zoom-image='img-lg/".$fila['imagen_grande']."'/>";

		
		$stmt->close();

	}//function



//////////FIN LISTAR UN SOLO PRODUCTO	

	public function buscarProvincias($email){

		$stmt=$this->mysqli->prepare("SELECT PRO.provincia_nombre
			  								  FROM usuario USU JOIN ciudad CIU  ON USU.ciudad_id=CIU.id
			  								  					JOIN departamentos DEP ON DEP.id=CIU.departamento_id
			  								  					JOIN provincia PRO ON DEP.provincia_id=PRO.id 
			  								  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila_provincia_usuario=$resultado->fetch_assoc();



		$sql="SELECT provincia_nombre
			  FROM provincia";

		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){

			if($fila_provincia_usuario['provincia_nombre']==$fila['provincia_nombre']){

				echo "<option value='".$fila['provincia_nombre']."' selected>".$fila['provincia_nombre']."</option>";

			}else{

				echo "<option value='".$fila['provincia_nombre']."'>".$fila['provincia_nombre']."</option>";
		
			}
		}//while


	}//function

		public function buscarTipoDocumento($email){

		$stmt=$this->mysqli->prepare("SELECT TD.descripcion
			  								  FROM usuario USU JOIN tipo_documento TD ON USU.tipo_doc=TD.id 
			  								  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila_doc_usuario=$resultado->fetch_assoc();


		$sql="SELECT descripcion
			  FROM tipo_documento";

		$consulta=mysqli_query($this->conexion,$sql);

		while($fila=mysqli_fetch_assoc($consulta)){

			if($fila_doc_usuario['descripcion']==$fila['descripcion']){

			echo "<option value='".$fila['descripcion']."'selected>".$fila['descripcion']."</option>";
		
			}else{

			echo "<option value=".$fila['descripcion'].">".$fila['descripcion']."</option>";

			}
		}


	}//function


public function buscarUsuarioEInsertarloEnTabla($nro_doc,$tipo_doc,$nombre,$apellido,$calle,$altura,$cod_area,$telefono,$email,$cp,$ciudad_nombre,$provincia_nombre,$piso,$departamento){


		//busca el email

		$stmt=$this->mysqli->prepare("SELECT email,calle
							  		  FROM usuario
							  		  WHERE email=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila_existe_usuario=$resultado->fetch_assoc();

			//si el email no existe creara un usuario en la tabla
			if($fila_existe_usuario['email']==''){

				//busco el id de la ciudad
				$stmt=$this->mysqli->prepare("SELECT CIU.id
											  FROM ciudad CIU JOIN departamentos DEP  ON CIU.departamento_id=DEP.id
											  					JOIN provincia PRO ON DEP.provincia_id=PRO.id
											  WHERE CIU.ciudad_nombre=(?) AND PRO.provincia_nombre=(?)");

				$stmt->bind_param("ss",$ciudad_nombre,$provincia_nombre);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila_id_ciudad=$resultado->fetch_assoc();

				$ciudad_id=$fila_id_ciudad['id'];


				//busco id de tipo de doc
				$stmt=$this->mysqli->prepare("SELECT id
											  FROM tipo_documento
											  WHERE descripcion=(?)");

				$stmt->bind_param("s",$tipo_doc);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila_id_tipo_doc=$resultado->fetch_assoc();

				$ciudad_id=$fila_id_ciudad['id'];

				$tipo_doc_id=$fila_id_tipo_doc['id'];



				$stmt=$this->mysqli->prepare("INSERT INTO usuario(nro_doc,tipo_doc,nombre,apellido,calle,altura,cod_area,telefono,email,ciudad_id,cp,piso,departamento,id_tipo_usuario)
					  							VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,1)");

				$stmt->bind_param("iisssiissisis",$nro_doc,$tipo_doc_id,$nombre,$apellido,$calle,$altura,$cod_area,$telefono,strtolower($email),$ciudad_id,$cp,$piso,$departamento);

				$stmt->execute();

				$stmt->close();


				//Si el email ya existe actualiza el resto de los datos
		}else{

				$stmt=$this->mysqli->prepare("SELECT CIU.id
											  FROM ciudad CIU JOIN departamentos DEP  ON CIU.departamento_id=DEP.id
											  					JOIN provincia PRO ON DEP.provincia_id=PRO.id
											  WHERE CIU.ciudad_nombre=(?) AND PRO.provincia_nombre=(?)");

				$stmt->bind_param("ss",$ciudad_nombre,$provincia_nombre);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila_id_ciudad=$resultado->fetch_assoc();

				$ciudad_id=$fila_id_ciudad['id'];

					//busco id de tipo de doc
				$stmt=$this->mysqli->prepare("SELECT id
											  FROM tipo_documento
											  WHERE descripcion=(?)");

				$stmt->bind_param("s",$tipo_doc);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila_id_tipo_doc=$resultado->fetch_assoc();

				$ciudad_id=$fila_id_ciudad['id'];

				$tipo_doc_id=$fila_id_tipo_doc['id'];


				$stmt=$this->mysqli->prepare("UPDATE usuario
											   SET nro_doc=(?),tipo_doc=(?), nombre=(?),apellido=(?), calle=(?),altura=(?),cod_area=(?),telefono=(?),ciudad_id=(?),cp=(?),piso=(?),departamento=(?)
											   WHERE email=(?)");

				$stmt->bind_param("iisssiisisiss",$nro_doc,$tipo_doc_id,$nombre,$apellido,$calle,$altura,$cod_area,$telefono,$ciudad_id,$cp,$piso,$departamento,$email);

				$stmt->execute();

				$stmt->close();



					

			}

	}//FUNCTION


	public function buscarUsuarioEInsertarloEnTablaSinEnvio($nro_doc,$tipo_doc,$nombre,$apellido,$cod_area,$telefono,$email,$tipo_usuario){

		$stmt=$this->mysqli->prepare("SELECT email
							  		  FROM usuario
							  		  WHERE email=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila_existe_usuario=$resultado->fetch_assoc();


			if($fila_existe_usuario['email']==''){

				
				//busco id de tipo de doc
				$stmt=$this->mysqli->prepare("SELECT id
											  FROM tipo_documento
											  WHERE descripcion=(?)");

				$stmt->bind_param("s",$tipo_doc);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila_id_tipo_doc=$resultado->fetch_assoc();

				$tipo_doc_id=$fila_id_tipo_doc['id'];




				$stmt=$this->mysqli->prepare("INSERT INTO usuario(nro_doc,tipo_doc,nombre,apellido,cod_area,telefono,email,id_tipo_usuario)
					  							VALUES (?,?,?,?,?,?,?,1)");

				$stmt->bind_param("iissiis",$nro_doc,$tipo_doc_id,$nombre,$apellido,$cod_area,$telefono,strtolower($email));

				$stmt->execute();

				$stmt->close();


			//Si el email ya existe actualiza el resto de los datos
			}else{//if($fila_existe_usuario['email']=='')		


					//busco id de tipo de doc
				$stmt=$this->mysqli->prepare("SELECT id
											  FROM tipo_documento
											  WHERE descripcion=(?)");

				$stmt->bind_param("s",$tipo_doc);

				$stmt->execute();

				$resultado=$stmt->get_result();

				$fila_id_tipo_doc=$resultado->fetch_assoc();

				$tipo_doc_id=$fila_id_tipo_doc['id'];

				$stmt=$this->mysqli->prepare("UPDATE usuario
											   SET nro_doc=(?),tipo_doc=(?), nombre=(?),apellido=(?),cod_area=(?),telefono=(?)
											   WHERE email=(?)");

				$stmt->bind_param("iississ",$nro_doc,$tipo_doc_id,$nombre,$apellido,$cod_area,$telefono,$email);

				$stmt->execute();

				$stmt->close();


			}



	}//FUNCTION

	

	public function insertarVenta($id_mp,$referencia,$email,$fecha,$recibio_email,$medio_de_pago){

		$data=serialize($_SESSION['carrito']);

		$carritoObtenido=unserialize($data);


		$stmt=$this->mysqli->prepare("SELECT comprobante_nro
									  FROM usuario_compra_producto
									  WHERE comprobante_nro=(?)");

		$stmt->bind_param("s",$referencia);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila_buscar_venta=$resultado->fetch_assoc();

		$idProd=0;

			if($fila_buscar_venta['comprobante_nro']==''){

					foreach ($carritoObtenido as $producto) {

					if ($producto->cantidad!=0) {

						$stmt=$this->mysqli->prepare("INSERT INTO usuario_compra_producto(id_mp,comprobante_nro,email_usuario,id_producto,fecha,cantidad,marca,modelo,precio,tiene_descuento,precio_descuento,recibio_email,id_medio_pago,id_estado_envio,id_estado_venta,color,talle)
					  		  					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,2,3,?,?)");

						$stmt->bind_param("issisissdidiiss",$id_mp,$referencia,$email,$producto->id,$fecha,$producto->cantidad,$producto->marca,$producto->modelo,$producto->precio,$producto->tiene_descuento,$producto->precio_descuento,$recibio_email,$medio_de_pago,$producto->color,$producto->talle);

						$stmt->execute();

						$idProd = $producto->id;

					}//if
				}//foreach

		$stmt->close();
		

			}

		// si es mercado pago
		if($medio_de_pago=='1'){
			
			echo $idProd;
			//echo("Finalizado el proceso de pago, te redireccionaremos a la emision del detalle de  compra. Si tu pago es en efectivo, imprimi el cupon de Mercado Pago y cerra la ventana modal, de esta manera te enviaremos el detalle de compra.");
			
			
		// si es todo pago
		}else if($medio_de_pago=='2'){

			//echo("Finalizado el proceso de pago de Todo Pago, te redireccionaremos a la emision del detalle de  compra. ");
			
		}

	}// function

	public function insertarVentaConEnvio($id_mp,$referencia,$email,$fecha,$recibio_email,$medio_de_pago){

		$data=serialize($_SESSION['carrito']);

		$carritoObtenido=unserialize($data);


		$stmt=$this->mysqli->prepare("SELECT comprobante_nro
									  FROM usuario_compra_producto
									  WHERE comprobante_nro=(?)");

		$stmt->bind_param("s",$referencia);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila_buscar_venta=$resultado->fetch_assoc();

			if($fila_buscar_venta['comprobante_nro']==''){

					foreach ($carritoObtenido as $producto) {

					if ($producto->cantidad!=0) {

						$stmt=$this->mysqli->prepare("INSERT INTO usuario_compra_producto(id_mp,comprobante_nro,email_usuario,id_producto,fecha,cantidad,marca,modelo,precio,tiene_descuento,precio_descuento,recibio_email,id_medio_pago,id_estado_envio,id_estado_venta,color,talle)
					  		  					VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,1,3,?,?)");

						$stmt->bind_param("issisissdidiiss",$id_mp,$referencia,$email,$producto->id,$fecha,$producto->cantidad,$producto->marca,$producto->modelo,$producto->precio,$producto->tiene_descuento,$producto->precio_descuento,$recibio_email,$medio_de_pago,$producto->color,$producto->talle);

						$stmt->execute();



					}//if
				}//foreach

			$stmt->close();

	

			}

				// si es mercado pago
			if($medio_de_pago=='1'){
					
			//echo("Finalizado el proceso de pago, te redireccionaremos a la emision del detalle de  compra. Si tu pago es en efectivo, imprimi el cupon de Mercado Pago y cerra la ventana modal, de esta manera te enviaremos el detalle de compra.");
			
			
		// si es todo pago
		}else if($medio_de_pago=='2'){

			//echo("Finalizado el proceso de pago de Todo Pago, te redireccionaremos a la emision del detalle de  compra. ");
			
		}

	}// function

	public function actualizarIdMpEnVenta($id_mp,$referencia,$recibio_email,$id_estado_venta){


		$stmt=$this->mysqli->prepare("SELECT id_mp
					   				  FROM usuario_compra_producto
					   				  WHERE id_mp=(?) AND comprobante_nro=(?)");

		$stmt->bind_param("is",$id_mp,$referencia);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila_buscar_id_mp=$resultado->fetch_assoc();

			if($fila_buscar_id_mp['id_mp']==''){

			$stmt=$this->mysqli->prepare("UPDATE usuario_compra_producto 
										  SET id_mp=(?), recibio_email=(?),id_estado_venta=(?) 
										  WHERE comprobante_nro=(?)");

			$stmt->bind_param("iiis",$id_mp,$recibio_email,$id_estado_venta,$referencia);

			$stmt->execute();

			$stmt->close();

			}//if

	}//function
	
	public function actualizarIdTpEnVenta($id_tp,$referencia,$recibio_email,$id_estado_venta){


		$stmt=$this->mysqli->prepare("SELECT id_tp
					   				  FROM usuario_compra_producto
					   				  WHERE id_tp=(?) AND comprobante_nro=(?)");

		$stmt->bind_param("is",$id_tp,$referencia);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila_buscar_id_mp=$resultado->fetch_assoc();

			if($fila_buscar_id_mp['id_tp']==''){

			$stmt=$this->mysqli->prepare("UPDATE usuario_compra_producto 
										  SET id_tp=(?), recibio_email=(?),id_estado_venta=(?) 
										  WHERE comprobante_nro=(?)");

			$stmt->bind_param("iiis",$id_tp,$recibio_email,$id_estado_venta,$referencia);

			$stmt->execute();

			$stmt->close();

			}//if

	}//function

	public function eliminarPagoFallido($referencia){



		$sql_buscar_referencia="SELECT comprobante_nro
								FROM usuario_compra_producto
								WHERE comprobante_nro='$referencia'";

		$consulta_buscar_referencia=mysqli_query($this->conexion,$sql_buscar_referencia);
		$fila_buscar_referencia=mysqli_fetch_assoc($consulta_buscar_referencia);

		if($fila_buscar_referencia!=''){

		$sql="DELETE FROM usuario_compra_producto
			  WHERE comprobante_nro = '$referencia'";

		$consulta=mysqli_query($this->conexion,$sql);

		}
	}//function

	public function actualizarToken($email,$token){

			$stmt=$this->mysqli->prepare("UPDATE usuario SET token=(?)WHERE email=(?)");

			$stmt->bind_param("ss",$token,$email);

			$stmt->execute();

			$stmt->close();

	//	$sql="UPDATE usuario SET token='$token' WHERE email='$email'";
	//	$consulta=mysqli_query($this->conexion,$sql);

	}//

	public function buscarToken($token,$email){

		$stmt=$this->mysqli->prepare("SELECT token
									  FROM usuario
									  WHERE token=(?) AND email=(?)");

		$stmt->bind_param("ss",$token,$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila==''){
			return FALSE;
		}else{
			return TRUE;
		}

		$stmt->close();

	}


	public function insertarContrasenia($email,$contrasenia){


			$stmt=$this->mysqli->prepare("UPDATE usuario 
										  SET contrasenia=(?)
										  WHERE email=(?)");

			$stmt->bind_param("ss",$contrasenia,$email);

			$stmt->execute();

			$stmt->close();


		/*$sql="UPDATE usuario 
			  SET contrasenia='$contrasenia'
			  WHERE email='$email'";

		$consulta=mysqli_query($this->conexion,$sql) or die ("No se pudo insertar contrase単a en la base de datos");*/

	}

	public function validarUsuario($email,$contrasenia){

		$stmt=$this->mysqli->prepare("SELECT contrasenia
									  FROM usuario
									  WHERE email=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila["contrasenia"]==$contrasenia){
			return TRUE;
		}else{
			return FALSE;
		}

		$stmt->close();

	}//function

	public function validarEmail($email){

		$stmt=$this->mysqli->prepare("SELECT nro_doc
									  FROM usuario
									  WHERE email=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila["nro_doc"]!=''){
			return TRUE;
		}else{
			return FALSE;
		}

		$stmt->close();

	}//function

public function listarTipoVehiculo(){

		$stmt=$this->mysqli->prepare("SELECT descripcion
									  FROM tipo_vehiculo");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['descripcion']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarAncho(){

		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM ancho ");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

		public function listarAlto(){

		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM alto ");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarRodado(){

		$stmt=$this->mysqli->prepare("SELECT descripcion
									  FROM rodado");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['descripcion']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarMarca(){

		$stmt=$this->mysqli->prepare("SELECT id, descripcion
									  FROM marca");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['descripcion']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarCategoria(){

		$stmt=$this->mysqli->prepare("SELECT descripcion
									  FROM categoria");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['descripcion']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function


	public function buscarNombreDeUsuario($email){

			$stmt=$this->mysqli->prepare("SELECT nombre
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$stmt->close();

		$fila=$resultado->fetch_assoc();


		echo $fila['nombre'];
	}

	public function buscarApellidoDeUsuario($email){

			$stmt=$this->mysqli->prepare("SELECT apellido
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$stmt->close();

		$fila=$resultado->fetch_assoc();


		echo $fila['apellido'];
	}



	public function buscarNumeroDocumentoDeUsuario($email){

			$stmt=$this->mysqli->prepare("SELECT nro_doc
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$stmt->close();

		$fila=$resultado->fetch_assoc();


		echo $fila['nro_doc'];
	}

		public function buscarCodigoAreaDeUsuario($email){

			$stmt=$this->mysqli->prepare("SELECT cod_area
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$stmt->close();

		$fila=$resultado->fetch_assoc();


		echo $fila['cod_area'];
	}

		public function buscarTelefonoDeUsuario($email){

		$stmt=$this->mysqli->prepare("SELECT telefono
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$stmt->close();

		$fila=$resultado->fetch_assoc();


		echo $fila['telefono'];
	}

		public function buscarCiudadDeUsuario($email){

		$stmt=$this->mysqli->prepare("SELECT ciudad_id
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila_ciudad_usuario=$resultado->fetch_assoc();

		if($fila_ciudad_usuario['ciudad_id']!=0){

			$stmt=$this->mysqli->prepare("SELECT ciudad_nombre
										  FROM ciudad
										  WHERE id=(?)");

			$stmt->bind_param("i",$fila_ciudad_usuario['ciudad_id']);

			$stmt->execute();

			$resultado=$stmt->get_result();

			$stmt->close();

			$fila=$resultado->fetch_assoc();

			echo "<option value='".$fila['ciudad_nombre']."'selected>".$fila['ciudad_nombre']."</option>";

		}
	}

		public function buscarPartidoDeUsuario($email){

		$stmt=$this->mysqli->prepare("SELECT ciudad_id
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila_ciudad_usuario=$resultado->fetch_assoc();

		if($fila_ciudad_usuario['ciudad_id']!=0){

			$stmt=$this->mysqli->prepare("SELECT DEP.nombre as departamento_nombre
										  FROM ciudad CIU JOIN departamentos DEP ON CIU.departamento_id=DEP.id
										  WHERE CIU.id=(?)");

			$stmt->bind_param("i",$fila_ciudad_usuario['ciudad_id']);

			$stmt->execute();

			$resultado=$stmt->get_result();

			$stmt->close();

			$fila=$resultado->fetch_assoc();

			echo "<option value='".$fila['departamento_nombre']."'selected>".$fila['departamento_nombre']."</option>";

		}
	}

	public function buscarCodigoPostalDeUsuario($email){


			$stmt=$this->mysqli->prepare("SELECT cp
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila=$resultado->fetch_assoc();

		echo $fila['cp'];



	}


		public function buscarCalleDeUsuario($email){


			$stmt=$this->mysqli->prepare("SELECT calle
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila=$resultado->fetch_assoc();

		echo $fila['calle'];



	}


		public function buscarAlturaDeUsuario($email){


			$stmt=$this->mysqli->prepare("SELECT altura
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila=$resultado->fetch_assoc();

		echo $fila['altura'];



	}

		public function buscarPisoDeUsuario($email){


			$stmt=$this->mysqli->prepare("SELECT piso
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila=$resultado->fetch_assoc();

		echo $fila['piso'];



	}


		public function buscarDepartamentoDeUsuario($email){


			$stmt=$this->mysqli->prepare("SELECT departamento
									  FROM usuario
									  WHERE email=(?)");
		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();


		$fila=$resultado->fetch_assoc();

		if($fila['departamento']!=''){

			echo $fila['departamento'];

		}

	}

	public function verificarTipoUsuario($email){


		$stmt=$this->mysqli->prepare("SELECT id_tipo_usuario
									  FROM usuario
									  WHERE email=(?)");

		$stmt->bind_param("s",$email);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		if($fila["id_tipo_usuario"]==1){// si es cliente
			$_SESSION['login-cliente']=TRUE;
			$_SESSION['email-cliente']=$email;
			return TRUE;
		}else if($fila["id_tipo_usuario"]==2){// si es admin
			$_SESSION['login']=TRUE;
			return FALSE;
		}else if($fila["id_tipo_usuario"]==''){//sino esta registrado
			return 2;
		}

		$stmt->close();



	}

	public function listarRodadoAdmin(){

		$stmt=$this->mysqli->prepare("SELECT id_rodado,descripcion
									  FROM rodado");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id_rodado']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarMarcaAdmin(){

		$stmt=$this->mysqli->prepare("SELECT id, descripcion
									  FROM marca");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarCategoriaAdmin(){

		$stmt=$this->mysqli->prepare("SELECT descripcion
									  FROM categoria");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function


public function listarTipoVehiculoAdmin(){

		$stmt=$this->mysqli->prepare("SELECT id_tipo_vehiculo as id,descripcion
									  FROM tipo_vehiculo");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

public function listarVelocidad(){

		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM velocidad");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

	public function listarCarga(){

		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM carga");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function

		public function listarOrigen(){

		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM origen");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['id']."'>".$fila['descripcion']."</option>";
		}


		$stmt->close();

	}//function


	public function listarPrecio($id){

		$stmt=$this->mysqli->prepare("SELECT precio,tiene_descuento,precio_descuento
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){

			if($fila['tiene_descuento']==1){
				echo $fila['precio_descuento'];
			}else{
				echo $fila['precio'];
			}
			
		}


		$stmt->close();

	}

public function buscarPartidoSegunProvincia($provincia){


		$likeVar = "%" . $provincia . "%";

		$stmt=$this->mysqli->prepare("SELECT DEP.nombre	
		  FROM departamentos DEP JOIN provincia PRO ON PRO.id=DEP.provincia_id		  
		  WHERE PRO.provincia_nombre like ?
		  ORDER BY DEP.nombre ASC");

		$stmt->bind_param("s",$likeVar);

		$stmt->execute();

		

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['nombre']."'>".$fila['nombre']."</option>";
		}


		$stmt->close();
	}

public function buscarCiudadSegunPartido($partido){


		$likeVar = "%" . $partido . "%";

		$stmt=$this->mysqli->prepare("SELECT CIU.ciudad_nombre
									  FROM ciudad CIU JOIN departamentos DEP ON CIU.departamento_id=DEP.id		  
									  WHERE DEP.nombre like ?
									  ORDER BY CIU.ciudad_nombre ASC");

		$stmt->bind_param("s",$likeVar);

		$stmt->execute();

		

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){
			echo "<option value='".$fila['ciudad_nombre']."'>".$fila['ciudad_nombre']."</option>";
		}


		$stmt->close();
	}


	
public function buscarModeloEstablecido($id){

			$stmt=$this->mysqli->prepare("SELECT modelo
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['modelo'];

	}

	public function buscarPrecioEstablecido($id){

			$stmt=$this->mysqli->prepare("SELECT precio
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['precio'];

	}

	public function buscarPrecioDescuentoEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT precio_descuento
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['precio_descuento'];

	}

public function listarMarcaEstablecida($id){

		$stmt=$this->mysqli->prepare("SELECT id_marca
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaMarcaProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM marca");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaMarca=$resultado->fetch_assoc()){

			if($filaMarca['id']==$filaMarcaProducto['id_marca']){

				echo "<option value='".$filaMarca['id']."' selected>".$filaMarca['descripcion']."</option>";

			}else{

				echo "<option value='".$filaMarca['id']."'>".$filaMarca['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarAnchoEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT id_ancho
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaAnchoProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM ancho");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaAncho=$resultado->fetch_assoc()){

			if($filaAncho['id']==$filaAnchoProducto['id_ancho']){

				echo "<option value='".$filaAncho['id']."' selected>".$filaAncho['descripcion']."</option>";

			}else{

				echo "<option value='".$filaAncho['id']."'>".$filaAncho['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarAltoEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT id_alto
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaAltoProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM alto");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaAlto=$resultado->fetch_assoc()){

			if($filaAlto['id']==$filaAltoProducto['id_alto']){

				echo "<option value='".$filaAlto['id']."' selected>".$filaAlto['descripcion']."</option>";

			}else{

				echo "<option value='".$filaAlto['id']."'>".$filaAlto['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarVelocidadEstablecida($id){

		$stmt=$this->mysqli->prepare("SELECT id_velocidad
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaVelocidadProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM velocidad");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaVelocidad=$resultado->fetch_assoc()){

			if($filaVelocidad['id']==$filaVelocidadProducto['id_velocidad']){

				echo "<option value='".$filaVelocidad['id']."' selected>".$filaVelocidad['descripcion']."</option>";

			}else{

				echo "<option value='".$filaVelocidad['id']."'>".$filaVelocidad['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarCargaEstablecida($id){

		$stmt=$this->mysqli->prepare("SELECT id_carga
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaCargaProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM carga");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaCarga=$resultado->fetch_assoc()){

			if($filaCarga['id']==$filaCargaProducto['id_carga']){

				echo "<option value='".$filaCarga['id']."' selected>".$filaCarga['descripcion']."</option>";

			}else{

				echo "<option value='".$filaCarga['id']."'>".$filaCarga['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarOrigenEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT id_origen
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaOrigenProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM origen");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaOrigen=$resultado->fetch_assoc()){

			if($filaOrigen['id']==$filaOrigenProducto['id_origen']){

				echo "<option value='".$filaOrigen['id']."' selected>".$filaOrigen['descripcion']."</option>";

			}else{

				echo "<option value='".$filaOrigen['id']."'>".$filaOrigen['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarRodadoEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT id_rodado
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaRodadoProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id_rodado,descripcion
									  FROM rodado");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaRodado=$resultado->fetch_assoc()){

			if($filaRodado['id_rodado']==$filaRodadoProducto['id_rodado']){

				echo "<option value='".$filaRodado['id_rodado']."' selected>".$filaRodado['descripcion']."</option>";

			}else{

				echo "<option value='".$filaRodado['id_rodado']."'>".$filaRodado['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function listarTipoVehiculoEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT id_tipo_vehiculo
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaTipoVehiculoProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id_tipo_vehiculo,descripcion
									  FROM tipo_vehiculo");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaTipoVehiculo=$resultado->fetch_assoc()){

			if($filaTipoVehiculo['id_tipo_vehiculo']==$filaTipoVehiculoProducto['id_tipo_vehiculo']){

				echo "<option value='".$filaTipoVehiculo['id_tipo_vehiculo']."' selected>".$filaTipoVehiculo['descripcion']."</option>";

			}else{

				echo "<option value='".$filaTipoVehiculo['id_tipo_vehiculo']."'>".$filaTipoVehiculo['descripcion']."</option>";

			}
		}


		$stmt->close();

	}//function

	public function buscarTitulo1Establecido($id){

		$stmt=$this->mysqli->prepare("SELECT titulo_descripcion_1
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['titulo_descripcion_1'];

	}

	public function buscarTitulo2Establecido($id){

		$stmt=$this->mysqli->prepare("SELECT titulo_descripcion_2
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['titulo_descripcion_2'];

	}

	public function buscarTitulo3Establecido($id){

		$stmt=$this->mysqli->prepare("SELECT titulo_descripcion_3
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['titulo_descripcion_3'];

	}

	public function buscarDescripcion1Establecida($id){

		$stmt=$this->mysqli->prepare("SELECT descripcion_1
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['descripcion_1'];

	}

	public function buscarDescripcion2Establecida($id){

		$stmt=$this->mysqli->prepare("SELECT descripcion_2
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['descripcion_2'];

	}

	public function buscarDescripcion3Establecida($id){

		$stmt=$this->mysqli->prepare("SELECT descripcion_3
									  FROM producto
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$fila=$resultado->fetch_assoc();

		echo $fila['descripcion_3'];

	}



	public function listarCategoriaEstablecida($id){

		$stmt=$this->mysqli->prepare("SELECT id_categoria
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		$filaCategoriaProducto=$resultado->fetch_assoc();



		$stmt=$this->mysqli->prepare("SELECT id,descripcion
									  FROM categoria");

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($filaCategoria=$resultado->fetch_assoc()){

			if($filaCategoria['id']==$filaCategoriaProducto['id_categoria']){

				echo "<input type='radio' id='categoria-admin-radio' name='categoria-admin-radio' value='".$filaCategoria['id']."' checked>".$filaCategoria['descripcion']."";

			}else{

				echo "<input type='radio' id='categoria-admin-radio' name='categoria-admin-radio' value='".$filaCategoria['id']."'>".$filaCategoria['descripcion']."";

			}
		}


		$stmt->close();

	}//function

	public function listarDestacadoEstablecido($id){

		$stmt=$this->mysqli->prepare("SELECT es_destacado
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){

			if($fila['es_destacado']==1){

				echo "<input type='radio' name='destacado-admin-radio' id='destacado-admin-radio'value='1' checked>Si";
				echo "<input type='radio' name='destacado-admin-radio' id='destacado-admin-radio'value='0'>No";



			}else{

				echo "<input type='radio' name='destacado-admin-radio' id='destacado-admin-radio' value='1' >Si";
				echo "<input type='radio' name='destacado-admin-radio' id='destacado-admin-radio' value='0'checked>No";
			}
		}


		$stmt->close();

	}//function

	public function listarStockEstablecido($id){

			$stmt=$this->mysqli->prepare("SELECT tiene_stock
									  FROM producto 
									  WHERE id=(?)");

		$stmt->bind_param("i",$id);

		$stmt->execute();

		$resultado=$stmt->get_result();

		while($fila=$resultado->fetch_assoc()){

			if($fila['tiene_stock']==1){

				echo "<input type='radio' name='stock-admin-radio' id='stock-admin-radio'value='1' checked>Si";
				echo "<input type='radio' name='stock-admin-radio' id='stock-admin-radio'value='0'>No";



			}else{

				echo "<input type='radio' name='stock-admin-radio' id='stock-admin-radio' value='1' >Si";
				echo "<input type='radio' name='stock-admin-radio' id='stock-admin-radio' value='0'checked>No";
			}
		}


		$stmt->close();


	}//function



}// CLASS

?>