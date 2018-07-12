/////////////FUNCIONES DE CARRITO
var i=0;
$(document).ready(function() {

 document.getElementById("carrito").style.display = "none";
 		//Desplegar carrito
		$( "#btn-carrito").click(function() {

			if(i==1){
			$("#carrito").removeClass("animated");
			$("#carrito").removeClass("fadeOutUp");
			$("#carrito").addClass("animated");
			$("#carrito").addClass("slideInDown");
			}

		 	 document.getElementById("carrito").style.display = "block";

		});

		//Desplegar carrito XS
		$jQuery_3_2_1("#btn-carrito-cel").on('click touchstart', function () {

			if(i==1){
			$("#carrito").removeClass("animated");
			$("#carrito").removeClass("fadeOutUp");
			$("#carrito").addClass("animated");
			$("#carrito").addClass("slideInDown");
			}

		 	 document.getElementById("carrito").style.display = "block";
		});
		
		//Desplegar carrito SM
		$jQuery_3_2_1("#btn-carrito-ipad").on('click touchstart', function () {

			if(i==1){
			$("#carrito").removeClass("animated");
			$("#carrito").removeClass("fadeOutUp");
			$("#carrito").addClass("animated");
			$("#carrito").addClass("slideInDown");
			}

		 	 document.getElementById("carrito").style.display = "block";
		});



});// ready


function cerrarVentanaCarrito() {
	
  	$("#carrito").removeClass("animated");
	$("#carrito").removeClass("slideInDown");
	$("#carrito").addClass("animated");
	$("#carrito").addClass("zoomOut");

	i=1;
 	 document.getElementById("carrito").style.display = "none";

}



function borrarDeCarrito(id,talle,color){

				$.ajax({
				data:{id:id,talle:talle,color:color},
				url:'ajax/borrarDeCarrito.php',
				type:'get',
				success:function(response){
				//$(".carrito").html(response);
				//alert(response);
				//window.location="index.php?session=true";
				$("#carrito-lista").html(response);

					$.ajax({
					url:'ajax/mostrarCantidad.php',
					success:function(response){

					//respuesta para dispositivos lg
					$("#cantidad-strong").html(response);
					//respuesta para dispositivos xs
					$("#cantidad-strong-xs").html(response);
					//respuesta para dispositivos sm
					$("#cantidad-strong-sm").html(response);

					$.ajax({
					url:'ajax/mostrarTotalIndex.php',
					success:function(response){
					//respuesta para dispositivos lg
					$("#menu-total").html(response);
					//respuesta para dispositivos xs
					$("#menu-total-xs").html(response);
					//respuesta para dispositivos sm
					$("#menu-total-sm").html(response);



					}
					});	

					}
					});




				}
				});
	}