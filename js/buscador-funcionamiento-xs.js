$(document).ready(function() {
	document.getElementById("warning-buscador-filtros-default-xs").style.display = "block";

	$(".buscador-filtros-select").change(function(){

		var tipo_de_vehiculo = $("#tipo-de-vehiculo-xs option:selected").val();
		var rodado = $("#rodado-xs option:selected").val();
		var marca = $("#marca-xs option:selected").val();
		var categoria = $("#categoria-xs option:selected").val();
		var ancho = $("#ancho-xs option:selected").val();
		var alto = $("#alto-xs option:selected").val();
		var ordenar =$("#ordenar-xs option:selected").val();

		if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
			document.getElementById("warning-buscador-filtros-default-xs").style.display = "block";
			document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";
			}else{
			document.getElementById("warning-buscador-filtros-default-xs").style.display = "none";

			}
		if(ordenar=='valor_nulo'){

				$.ajax({
				data:{tipo_de_vehiculo:tipo_de_vehiculo,rodado:rodado,marca:marca,categoria:categoria,ancho:ancho,alto:alto},
				url:'ajax/buscadorFiltrosXs.php',
				type:'post',
				success:function(response){
				if(response==''){

					if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
						document.getElementById("warning-buscador-filtros-default-xs").style.display = "block";
						document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";
					}else{
					 document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "block";
					 document.getElementById("warning-buscador-filtros-default-xs").style.display = "none";

					 }
					}else{
					document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";	
					}

				$("#resultado-buscador-filtros-xs").html(response);
				}//success:function(response){

				});//ajax

		}else if(ordenar=='ascendente'){

				$.ajax({
				data:{tipo_de_vehiculo:tipo_de_vehiculo,rodado:rodado,marca:marca,categoria:categoria,ancho:ancho,alto:alto},
				url:'ajax/buscadorFiltrosAscendenteXs.php',
				type:'post',
				success:function(response){

				if(response==''){

					if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
						document.getElementById("warning-buscador-filtros-default-xs").style.display = "block";
						document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";
					}else{
					 	document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "block";
					 	document.getElementById("warning-buscador-filtros-default-xs").style.display = "none";

					 }
					}else{
					document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";	
					}

				$("#resultado-buscador-filtros-xs").html(response);
				
				}//success:function(response){

				});//ajax

		}else if(ordenar=='descendente'){

					$.ajax({
				data:{tipo_de_vehiculo:tipo_de_vehiculo,rodado:rodado,marca:marca,categoria:categoria,ancho:ancho,alto:alto},
				url:'ajax/buscadorFiltrosDescendenteXs.php',
				type:'post',
				success:function(response){

				if(response==''){

					if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
						document.getElementById("warning-buscador-filtros-default-xs").style.display = "block";
						document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";
					}else{
						 document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "block";
						 document.getElementById("warning-buscador-filtros-default-xs").style.display = "none";

					 }
					}else{
					document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";	
					}



				$("#resultado-buscador-filtros-xs").html(response);
				}//success:function(response){
				});//ajax

		}//}else if(ordenar=='descendente'){

	

	});//$(".buscador-filtros-select").change(function(){

});//ready


function reestablecerBusquedaXs(){
var valor_nulo="valor_nulo"; 
$("#tipo-de-vehiculo-xs").val(valor_nulo);
$("#rodado-xs").val(valor_nulo);
$("#marca-xs").val(valor_nulo);
$("#categoria-xs").val(valor_nulo);
$("#ancho-xs").val(valor_nulo);
$("#alto-xs").val(valor_nulo);
$("#ordenar-xs").val(valor_nulo);

$("#resultado-buscador-filtros-xs").html("");

document.getElementById("warning-buscador-filtros-default-xs").style.display = "block";
document.getElementById("warning-buscador-filtros-sin-resultados-xs").style.display = "none";



}