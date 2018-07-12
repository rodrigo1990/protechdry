function buscarCubiertasAdmin(){

	var cubiertaBuscada = $("#busqueda_cubiertas_admin").val();

		if(cubiertaBuscada != ''){

			$.ajax({
			data:"cubiertaBuscada="+ cubiertaBuscada,
			url:'ajax/busquedaCubiertasAdmin.php',
			type:'get',
			success:function(response){
			//alert(response);
			document.getElementById("resultadoBusquedaAdmin").style.display = "block";
			$("#resultadoBusquedaAdmin").html(response)

			}
			});

		}else{
			document.getElementById("resultadoBusquedaAdmin").style.display = "none";

		}
}