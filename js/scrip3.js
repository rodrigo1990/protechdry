




///////////////////////////////////////////////MENU FIXED

$(window).load(function(){
	      $("#menu-fixed").sticky({ topSpacing: 0 });
	    });


$(window).load(function(){
	if ((screen.width==768)) {
	     $("#buscador-fixed").sticky({ topSpacing: -50 });
	     }else{

	     $("#buscador-fixed").sticky({ topSpacing: 55 });
	     }
	    });






function borrarDeCarritoCheckOut(id){

				$.ajax({
				data:{id:id,session:"true"},
				url:'ajax/borrarDeCarritoCheckOut.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);
				
					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});



				}
				});
	}

function buscarCubiertas(){

	var cubiertaBuscada = $("#busqueda_cubiertas").val();

		if(cubiertaBuscada != ''){

			$.ajax({
			data:"cubiertaBuscada="+ cubiertaBuscada,
			url:'ajax/busquedaCubiertas.php',
			type:'get',
			success:function(response){
			//alert(response);
			document.getElementById("resultadoBusqueda").style.display = "block";
			$("#resultadoBusqueda").html(response)

			}
			});

		}else{
			document.getElementById("resultadoBusqueda").style.display = "none";

		}
}

function buscarCubiertasXs(){

	var cubiertaBuscada = $("#busqueda_cubiertas_xs").val();

		if(cubiertaBuscada != ''){

			$.ajax({
			data:"cubiertaBuscada="+ cubiertaBuscada,
			url:'ajax/busquedaCubiertas.php',
			type:'get',
			success:function(response){
			//alert(response);
			document.getElementById("resultadoBusquedaXs").style.display = "block";
			$("#resultadoBusquedaXs").html(response)

			}
			});

		}else{
			document.getElementById("resultadoBusquedaXs").style.display = "none";

		}
}

function buscarCubiertasSm(){

	var cubiertaBuscada = $("#busqueda_cubiertas_sm").val();

		if(cubiertaBuscada != ''){

			$.ajax({
			data:"cubiertaBuscada="+ cubiertaBuscada,
			url:'ajax/busquedaCubiertas.php',
			type:'get',
			success:function(response){
			//alert(response);
			document.getElementById("resultadoBusquedaSm").style.display = "block";
			$("#resultadoBusquedaSm").html(response)

			}
			});

		}else{
			document.getElementById("resultadoBusquedaSm").style.display = "none";

		}
}

function registrarUsuario(nombre,apellido,tipo_dni,dni,email,cod_area,telefono,provincia,ciudad,cp,calle,altura,piso,departamento,referencia,medio_pago){
				
			$.ajax({
			data:{nombre:nombre,apellido:apellido,tipo_dni:tipo_dni,dni:dni,email:email,cod_area:cod_area,telefono:telefono,provincia:provincia,ciudad:ciudad,cp:cp,calle:calle,altura:altura,piso:piso,departamento:departamento,referencia:referencia,medio_pago:medio_pago},
			url:'ajax/registrarUsuario.php',
			type:'post',
			success:function(response){

				if(response==1){
					window.location.href = "index.php";
				}else{
					alert(response);
				}
			}
			});


		}

function registrarUsuarioSinEnvio(nombre,apellido,tipo_dni,dni,email,cod_area,telefono,referencia,medio_pago){
				
			$.ajax({
			data:{nombre:nombre,apellido:apellido,tipo_dni:tipo_dni,dni:dni,email:email,cod_area:cod_area,telefono:telefono,referencia:referencia,medio_pago:medio_pago},
			url:'ajax/registrarUsuarioSinEnvio.php',
			type:'post',
			success:function(response){

				if(response==1){
					window.location.href = "index.php";
				}else{
					alert(response);
				}
			}
			});


		}

		function eliminarPagoFallido(referencia){

				$.ajax({
				data:{referencia:referencia},
				url:'ajax/eliminarPagoFallido.php',
				type:'post',
				success:function(response){
				}
				});
		}

		function actualizarCantidad1(id){

	var cantidad= $("#cantidad1").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}

function actualizarCantidad2(id){

	var cantidad= $("#cantidad2").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad3(id){

	var cantidad= $("#cantidad3").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}

function actualizarCantidad4(id){

	var cantidad= $("#cantidad4").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad5(id){

	var cantidad= $("#cantidad5").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad6(id){

	var cantidad= $("#cantidad6").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad7(id){

	var cantidad= $("#cantidad7").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad8(id){

	var cantidad= $("#cantidad8").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad9(id){

	var cantidad= $("#cantidad9").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}
function actualizarCantidad10(id){

	var cantidad= $("#cantidad10").val();
	var session="true"

				$.ajax({
				data:{cantidad:cantidad,id:id,session:session},
				url:'ajax/actualizarCantidad.php',
				type:'get',
				success:function(response){
				$("#carrito-CheckOut").html(response);

					$.ajax({
					data:"session=true",
					url:'ajax/mostrarTotal.php',
					type:'get',
					success:function(response){

						$("#comprar-total").html(response);



					}
					});


				}
				});

}



	function validarUsuario(){

		var email=$("#email").val();
		var contrasenia=$("#contrasenia").val();
	
			$.ajax({

				data:{email:email,contrasenia:contrasenia},
				url:'ajax/validarUsuario.php',
				type:'post',
				success:function(response){
					if(response=="TRUE"){


						$.ajax({
							data:{email:email},
							url:'ajax/validarTipoUsuario.php',
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



function submitformCompra(){

		var id=$("#ver-mas-id").val();
		var marca=$("#ver-mas-marca").val();
		var precio=$("#ver-mas-precio").val();
		var modelo=$("#ver-mas-modelo").val();
		var imagen=$("#ver-mas-imagen").val();
		var tieneDescuento=$("#ver-mas-tiene-descuento").val();
		var precioDescuento=$("#ver-mas-precio-descuento").val();
		var cantidad=$("#ver-mas-cantidad").val();

		$.ajax({
			data:{id:id,marca:marca,precio:precio,modelo:modelo,cantidad:cantidad,imagen:imagen,tieneDescuento:tieneDescuento,precioDescuento:precioDescuento},
			url:'ajax/agregarACarrito.php',
			type:'post',
			success:function(response2){

			$.ajax({
				url:'ajax/mostrarSubtotal.php',
				type:'post',
				success:function(response2){

					$("#menu-total").html(response2);
					$("#menu-total-xs").html(response2);
					$("#menu-total-sm").html(response2);
				}
			});

			$.ajax({
				url:'ajax/mostrarCantidad.php',
				type:'post',
				success:function(response2){

					$("#cantidad-strong").html(response2);
					$("#cantidad-strong-xs").html(response2);
					$("#cantidad-strong-sm").html(response2);
				}
			});


			}
			});


		// document.forms["form-ver-mas"].submit();
		}


//funcion de mercado pago para estado de ventas
function execute_my_onreturn (json) {
    if (json.collection_status=='approved'){
        alert ('Pago acreditado');
    } else if(json.collection_status=='pending'){

        alert ('Pago pendiente cierra la ventana, y aguarde hasta ser redirigido.');
       	window.location.href = "landing.php?collection_id="+json.collection_id+"&collection_status=pending&referencia=<?php echo $_POST['referencia'] ?>";


    } else if(json.collection_status=='in_process'){ 

        alert ('El pago está siendo revisado');  

    } else if(json.collection_status=='rejected'){

        alert ('El pago fué rechazado, el usuario puede intentar nuevamente el pago');
         eliminarPagoFallido("<?php echo $_POST['referencia'] ?>");

    } else if(json.collection_status==null){

        alert ('No has finalizado el proceso de pago');
        eliminarPagoFallido("<?php echo $_POST['referencia'] ?>");
    }
}


//submitea formulario de usuario
function submitform(){
	 document.forms["myform"].submit();
	}
function submitFormActualizarProducto(){
	 document.forms["admin-actualizacion-producto"].submit();
	}

//cierra ventana que referencia al
function cerrarVentanaInfo(){
	 document.getElementById("fixed-contacto-info").style.display = "none";
}

//submitea el formulario de ver mas producto
/*function submitformCompra(){
		 document.forms["form-ver-mas"].submit();
		}
*/
 function anular(e) {
      tecla = (document.all) ? e.keyCode : e.which;
      return (tecla != 13);
 }