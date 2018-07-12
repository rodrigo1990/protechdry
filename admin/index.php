<?php 
session_start();
session_destroy();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<script src="../jquery/jquery-3.2.1.min.js"></script>
	<!-- BOOTSTRAP -->
	<link rel="stylesheet" href="../bootstrap-3.3.7-dist/css/bootstrap.min.css" media="screen">
	<script src="../bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
<!-- ESTILOS PROPIOS -->
	<link rel="stylesheet" type="text/css" href="../estilos_css/fuentes.css">
		<link rel="stylesheet" type="text/css" href="../estilos_css/estilos.css">

	<link rel="stylesheet" type="text/css" href="../estilos_css/estilos2.css">
	<!-- MATERIAL ICONS -->
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons"rel="stylesheet">
	<!-- MENU FIXED  -->
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" src="../js/jquery.sticky.js"></script>
	<!-- ANIMATED.CSS -->
	<link rel="stylesheet" href="../estilos_css/animate.css">

	<!-- FUNCIONES JS -->
	<!--  <script type="text/javascript" src="../js/script.js"></script>-->
</head>
<body>
	<div class="row admin-login">
		<div class="container">

			<form action="" style="text-align: center;">
				<div class="row">
					<img src="../elementos_separados/logo.png" style='width:150px !important;margin-left:2%;' alt="">
				</div>
				
				<label for="usuario" style='margin:0;'>Usuario</label>
				<input type="text" name='email' class='form-control' id='email' style='margin-left:auto;margin-right: auto;display: block;width: 50% !important;'>
				<label for="pass" style='margin:0;'>Pass</label>
				<input type="password" name='contrasenia' class='form-control' id='contrasenia' style='margin-left:auto;margin-right: auto;display: block;width: 50% !important;'>

				<p class="form-alert pedidos-alert" id="validarUsuario-form-alert" style="">Usuario y/o contraseña incorrectos</p><br>

				<a class="carrito-checkout-btn" onClick="validarUsuario();">Ingresar</a >


			</form>
		</div>
	</div>
  <script>

	function validarUsuario(){

		var email=$("#email").val();
		var contrasenia=$("#contrasenia").val();
	
			$.ajax({

				data:{email:email,contrasenia:contrasenia},
				url:'../ajax/validarUsuario.php',
				type:'post',
				success:function(response){
					if(response=="TRUE"){


						$.ajax({
							data:{email:email},
							url:'../ajax/validarTipoUsuario.php',
							type:'post',
							success:function(response2){

								if(response2=='FALSE'){//FALSE = tipo_usuario=admin
									window.location.href = "usuario-admin.php";
								}else if(response2=='TRUE'){// si es cliente
									window.location ="usuario.php?email="+email+"";
								}
							}
							});

					}else{
					$("#validarUsuario-form-alert").css("display","block");
					}

				}
				});
	}

		</script>
</body>
</html>