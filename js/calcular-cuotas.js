
	function calcularCuotas(precio){

		var mensaje=0;

		if($("#calcular-cuotas-select").val()=='1'){

			mensaje="Paga en 1 cuota de "+precio+"";

			$("#resultado-calcular-cuotas-h3").html(mensaje);

		}else if($("#calcular-cuotas-select").val()=='2'){

			precio=precio/3;
			mensaje="Paga en 3 cuotas sin interes de "+precio.toFixed(2)+"";

			$("#resultado-calcular-cuotas-h3").html(mensaje);

		}else if($("#calcular-cuotas-select").val()=='3'){

			precio=(precio*1.8670)/6;
			mensaje="Paga en 6 cuotas de "+precio.toFixed(2)+"";

			$("#resultado-calcular-cuotas-h3").html(mensaje);

		}else if($("#calcular-cuotas-select").val()=='4'){

			precio=(precio*1.8759)/9;
			mensaje="Paga en 9 cuotas de "+precio.toFixed(2)+"";

			$("#resultado-calcular-cuotas-h3").html(mensaje);

		}else if($("#calcular-cuotas-select").val()=='5'){

			precio=(precio*1.8773)/12;

			mensaje="Paga en 12 cuotas de "+precio.toFixed(2)+"";

			$("#resultado-calcular-cuotas-h3").html(mensaje);

		}








	}
