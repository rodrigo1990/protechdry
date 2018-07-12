$(document).ready(function() {
	document.getElementById("warning-buscador-filtros-default").style.display = "block";

	$(".buscador-filtros-select").change(function(){

		var tipo_de_vehiculo = $("#tipo-de-vehiculo option:selected").val();
		var rodado = $("#rodado option:selected").val();
		var marca = $("#marca option:selected").val();
		var categoria = $("#categoria option:selected").val();
		var ancho = $("#ancho option:selected").val();
		var alto = $("#alto option:selected").val();
		var ordenar =$("#ordenar option:selected").val();

		if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
			document.getElementById("warning-buscador-filtros-default").style.display = "block";
			document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";
			}else{
			document.getElementById("warning-buscador-filtros-default").style.display = "none";

			}
		if(ordenar=='valor_nulo'){

				$.ajax({
				data:{tipo_de_vehiculo:tipo_de_vehiculo,rodado:rodado,marca:marca,categoria:categoria,ancho:ancho,alto:alto},
				url:'ajax/buscadorFiltros.php',
				type:'post',
				success:function(response){
				if(response==''){

					if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
						document.getElementById("warning-buscador-filtros-default").style.display = "block";
						document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";
					}else{
					 document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "block";
					 document.getElementById("warning-buscador-filtros-default").style.display = "none";

					 }
					}else{
					document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";	
					}

				$("#resultado-buscador-filtros").html(response);
				}//success:function(response){

				});//ajax

		}else if(ordenar=='ascendente'){

				$.ajax({
				data:{tipo_de_vehiculo:tipo_de_vehiculo,rodado:rodado,marca:marca,categoria:categoria,ancho:ancho,alto:alto},
				url:'ajax/buscadorFiltrosAscendente.php',
				type:'post',
				success:function(response){

				if(response==''){

					if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
						document.getElementById("warning-buscador-filtros-default").style.display = "block";
						document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";
					}else{
					 	document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "block";
					 	document.getElementById("warning-buscador-filtros-default").style.display = "none";

					 }
					}else{
					document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";	
					}

				$("#resultado-buscador-filtros").html(response);
				
				}//success:function(response){

				});//ajax

		}else if(ordenar=='descendente'){

					$.ajax({
				data:{tipo_de_vehiculo:tipo_de_vehiculo,rodado:rodado,marca:marca,categoria:categoria,ancho:ancho,alto:alto},
				url:'ajax/buscadorFiltrosDescendente.php',
				type:'post',
				success:function(response){

				if(response==''){

					if(tipo_de_vehiculo=='valor_nulo' && rodado=='valor_nulo' && marca=='valor_nulo' && categoria=='valor_nulo'&& ancho=='valor_nulo'&& alto=='valor_nulo'){
						document.getElementById("warning-buscador-filtros-default").style.display = "block";
						document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";
					}else{
						 document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "block";
						 document.getElementById("warning-buscador-filtros-default").style.display = "none";

					 }
					}else{
					document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";	
					}



				$("#resultado-buscador-filtros").html(response);
				}//success:function(response){
				});//ajax

		}//}else if(ordenar=='descendente'){

	

	});//$(".buscador-filtros-select").change(function(){

});//ready


function reestablecerBusqueda(){
var valor_nulo="valor_nulo"; 
$("#tipo-de-vehiculo").val(valor_nulo);
$("#rodado").val(valor_nulo);
$("#marca").val(valor_nulo);
$("#categoria").val(valor_nulo);
$("#ancho").val(valor_nulo);
$("#alto").val(valor_nulo);
$("#ordenar").val(valor_nulo);

$("#resultado-buscador-filtros").html("");

document.getElementById("warning-buscador-filtros-default").style.display = "block";
document.getElementById("warning-buscador-filtros-sin-resultados").style.display = "none";



}