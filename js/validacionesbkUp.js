/////////////////////////////////////VALIDACIONES
$(document).ready(function() {

	///////////////////////////

////////////Selector de div
	var i=0;
	var x=0;// contador para saber en que pantalla estoy
	var z=0;//contador para manipular selectot de envios
	var envios_esta_activado=false;

		validarCompraAlCargar();// para validar si el usuario fue previamente registrado y habilitar boton de compra por defecto



	$("#partido").change(function(){
		partido = $("#partido").val();

		if(partido=="LA MATANZA" || partido=="LOMAS DE ZAMORA" || partido=="QUILMES" || partido=="ALMIRANTE BROWN"
			|| partido=="MERLO" || partido=="MORENO" || partido=="LANUS" || partido=="FLORENCIO VARELA" || partido=="GENERAL SAN MARTIN"
			|| partido=="SAN MIGUEL" || partido=="TIGRE" || partido=="TRES DE FEBRERO" || partido=="AVELLANEDA" || partido=="MALVINAS ARGENTINAS"
			|| partido=="BERAZATEGUI" || partido=="MORON" || partido=="ESTEBAN ECHEVERRIA" || partido=="SAN ISIDRO" || partido=="VICENTE LOPEZ"
			|| partido=="JOSE C. PAZ" || partido=="HURLINGHAM" || partido=="ITUZAINGO" || partido=="EZEIZA" || partido=="SAN FERNANDO" || partido=='CAPITAL FEDERAL'  ){
				$("#form-checkout").removeAttr("action");
				$('#form-checkout').attr('action', 'comprarMpConEnvioGratis.php');            	
            }else{
            	$("#form-checkout").removeAttr("action");
				$('#form-checkout').attr('action', 'comprarMpConEnvio.php');
            }

	});







	$( "#carrito-checkout-btn-datos").click(function() {

		if(x==0){	

		$("#slider-checkout").addClass("ir-form");

	}else{

		$("#slider-checkout").removeClass("ir-compra");
		$("#slider-checkout").addClass("ir-form");
			
	}

	});	

	$( "#carrito-checkout-btn-compra2").click(function() {

		x=1;

		$("#slider-checkout").removeClass("ir-form");
		$("#slider-checkout").addClass("ir-compra");



	});
//////////// FINSelector de div


///////////Activar envios

    //check the enabled state on load
    if ($("#necesita_envio").not(":checked")) {

        $("#provincia").attr("disabled", "disabled");
        $("#provincia").css("background-color","lightgray");

        $("#ciudad").attr("disabled", "disabled");
        $("#ciudad").css("background-color","lightgray");

        $("#partido").attr("disabled", "disabled");
        $("#partido").css("background-color","lightgray");

        $("#cp").attr("disabled", "disabled");
        $("#cp").css("background-color","lightgray");

        $("#calle").attr("disabled", "disabled");
        $("#calle").css("background-color","lightgray");

        $("#altura").attr("disabled", "disabled");
        $("#altura").css("background-color","lightgray");

        $("#piso").attr("disabled", "disabled");
        $("#piso").css("background-color","lightgray");

        $("#departamento").attr("disabled", "disabled");
        $("#departamento").css("background-color","lightgray");

        
            $("#form-checkout").removeAttr("action");
			$('#form-checkout').attr('action', 'comprarMpSinEnvio.php');


    }

    //toggle the enabled state when the checkbox is clicked
    $("#necesita_envio").click(function() {
    	if(z==1){

	    	$("#provincia").attr("disabled", "disabled");
	    	$("#provincia").css("background-color","lightgray");

	    	  $("#ciudad").attr("disabled", "disabled");
	        $("#ciudad").css("background-color","lightgray");

	        $("#partido").attr("disabled", "disabled");
	        $("#partido").css("background-color","lightgray");

	          $("#cp").attr("disabled", "disabled");
	        $("#cp").css("background-color","lightgray");

	        $("#calle").attr("disabled", "disabled");
	        $("#calle").css("background-color","lightgray");

	        $("#altura").attr("disabled", "disabled");
	        $("#altura").css("background-color","lightgray");

	        $("#piso").attr("disabled", "disabled");
	        $("#piso").css("background-color","lightgray");

	        $("#departamento").attr("disabled", "disabled");
	        $("#departamento").css("background-color","lightgray");

	    	z=0;
	    	envios_esta_activado=false;

            validarCompraAlCargar();

            $("#form-checkout").removeAttr("action");
			$('#form-checkout').attr('action', 'comprarMpSinEnvio.php');


    	

    	}else if(z==0){


            $("#provincia").removeAttr("disabled");
            $("#provincia").css("background-color","white");


            $("#ciudad").removeAttr("disabled");
            $("#ciudad").css("background-color","white");

            $("#partido").removeAttr("disabled");
            $("#partido").css("background-color","white");

         	 $("#cp").removeAttr("disabled");
	        $("#cp").css("background-color","white");

	        $("#calle").removeAttr("disabled");
	        $("#calle").css("background-color","white");

	        $("#altura").removeAttr("disabled");
	        $("#altura").css("background-color","white");

	        $("#piso").removeAttr("disabled");
	        $("#piso").css("background-color","white");

	        $("#departamento").removeAttr("disabled");
	        $("#departamento").css("background-color","white");


            z=1;
    

            envios_esta_activado=true;

            validarCompraAlCargar();

            
	            $("#form-checkout").removeAttr("action");
				$('#form-checkout').attr('action', 'comprarMpConEnvio.php');
			
	          
            }
       });
    
	




	$("#provincia").change(function(){

		var provincia = $("#provincia option:selected").val();

				$.ajax({
				data:"provincia="+ provincia,
				url:'ajax/buscarPartidoSegunProvincia.php',
				type:'post',
				success:function(response){

					$("#partido").html(response);

					var partido = $("#partido option:selected").val();

					$.ajax({
					data:"partido="+ partido,
					url:'ajax/buscarCiudadSegunPartido.php',
					type:'post',
					success:function(response){
					$("#ciudad").html(response);
					$("#ciudad").trigger("change");

					}
					});


				}
				});

	});

	$("#partido").change(function(){

			var partido = $("#partido option:selected").val();

			$.ajax({
			data:"partido="+ partido,
			url:'ajax/buscarCiudadSegunPartido.php',
			type:'post',
			success:function(response){
			$("#ciudad").html(response);


			}
			});

	});




			var soloLetrasSinEspacios=/^[a-zA-Z]*$/;
			var soloNumeros=/^[0-9]*$/;
			var emailValido=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var listaDeCod_Area=[11,220,221,223,230,236,237,249,260,261,263,264,266,280,291,294,297,298,299,336,341,342,343,345,348,351,353,358,362,364,370,376,379,380,381,383,385,387,388,2202,2221,2223,2224,2225,2226,2227,2229,2241,2242,2243,2244,2245,2246,2252,2254,2255,2257,2261,2262,2264,2265,2266,2267,2268,2271,2272,2273,2274,2281,2283,2284,2285,2286,2291,2292,2296,2297,2302,2314,2316,2317,2320,2323,2324,2325,2326,2331,2333,2334,2335,2336,2337,2338,2342,2343,2344,2345,2346,2352,2353,2354,2355,2356,2357,2358,2392,2393,2394,2395,2396,2473,2474,2475,2477,2478,2622,2624,2625,2626,2646,2647,2648,2651,2652,2655,2656,2657,2658,2901,2902,2903,2920,2921,2922,2923,2924,2925,2926,2927,2928,2929,2931,2932,2933,2934,2935,2936,2940,2942,2945,2946,2948,2952,2953,2954,2962,2963,2964,2966,2972,2982,2983,3327,3329,3382,3385,3387,3388,3400,3401,3402,3404,3405,3406,3407,3408,3409,3435,3436,3437,3438,3442,3444,3445,3446,3447,3454,3455,3456,3458,3460,3462,3463,3464,3465,3466,3467,3468,3469,3471,3472,3476,3482,3483,3487,3489,3491,3492,3493,3496,3497,3498,3521,3522,3524,3525,3532,3533,3537,3541,3542,3543,3544,3546,3547,3548,3549,3562,3563,3564,3571,3572,3573,3574,3575,3576,3582,3583,3584,3585,3711,3715,3716,3718,3721,3725,3731,3734,3735,3741,3743,3751,3754,3755,3756,3757,3758,3772,3773,3774,3775,3777,3781,3782,3786,3821,3825,3826,3827,3832,3835,3837,3838,3841,3843,3844,3845,3846,3854,3855,3856,3857,3858,3861,3862,3863,3865,3867,3868,3869,3873,3876,3877,3878,3885,3886,3887,3888,3891,3892,3894];
			var soloLetrasYNumeros=/^[a-zA-Z0-9]+$/;
			var soloLetrasEspaciosYNumeros=/^[a-zA-Z0-9\s]+$/;
			var soloLetrasEspaciosYNumerosReconoceCampoVacio=/^[a-zA-Z0-9\s]*$/;


			var nombre_esta_validado=false;
			var apellido_esta_validado=false;
			var dni_esta_validado=false;
			var email_esta_validado=true;
			var cod_area_esta_validado=false;
			var telefono_esta_validado=false;

			var provincia_esta_validado=false;
			var ciudad_esta_validado=false;
			var cp_esta_validado=false;
			var calle_esta_validado=false;
			var altura_esta_validado=false;
			var piso_esta_validado=true;
			var departamento_esta_validado=true;



			var nombre;
			var apellido;
			var dni;
			var email;
			var cod_area;
			var telefono;
			var cp;
			var calle;
			var altura;
			var piso;
			var departamento;

			$("#nombre").keyup(function(){

			    nombre=$("#nombre").val();

			    if(nombre.length<3||nombre.search(soloLetrasSinEspacios)){
			    $("#nombre-form-alert").css("display","block");
			    nombre_esta_validado=false;
			    validar_compra();

			    }

				else{
			    $("#nombre-form-alert").css("display","none");
			    nombre_esta_validado=true;
			    validar_compra();
			    }

			});//keyup

			$("#apellido").keyup(function(){

			    apellido=$("#apellido").val();

			    if(apellido.length<3||apellido.search(soloLetrasSinEspacios)){
			    $("#apellido-form-alert").css("display","block");
			    apellido_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#apellido-form-alert").css("display","none");
			    apellido_esta_validado=true;
			    validar_compra();
			    }

			});//keyup

			$("#dni").keyup(function(){

			    dni=$("#dni").val();

			    if(dni.length!=8||dni.search(soloNumeros)){
			    $("#dni-form-alert").css("display","block");
			    dni_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#dni-form-alert").css("display","none");
			    dni_esta_validado=true;
			    validar_compra();
			    }

			});//keyup

			$("#email").keyup(function(){

			    email=$("#email").val();

			    if(email.length==0||email.search(emailValido)){
			    $("#email-form-alert").css("display","block");
			    email_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#email-form-alert").css("display","none");
			    email_esta_validado=true;
			    validar_compra();
			    }

			});//keyup

			$("#cod_area").keyup(function(){

				cod_area=$("#cod_area").val();

				for(i=0;i<listaDeCod_Area.length;i++){
					if(cod_area!=listaDeCod_Area[i]){
						$("#cod_area-form-alert").css("display","block");
						cod_area_esta_validado=false;
						validar_compra();
					}else{
						$("#cod_area-form-alert").css("display","none");
						cod_area_esta_validado=true;
						validar_compra();
						break;

					}
				}


			});//keyup

			$("#telefono").keyup(function(){

			    telefono=$("#telefono").val();

			    if(telefono.length<8||telefono.length>8||telefono.search(soloNumeros)){
			    $("#telefono-form-alert").css("display","block");
			    telefono_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#telefono-form-alert").css("display","none");
			    telefono_esta_validado=true;
			    validar_compra();
			    }

			});//keyup

		$('#provincia').change(function() {
			    if (!$('#provincia').val()) {
  				$("#provincia-form-alert").css("display","block");
			    provincia_esta_validado=false;
			    validar_compra();
			    }
			    else {
			    $("#provincia-form-alert").css("display","none");
			    provincia_esta_validado=true;
			    validar_compra();
			    }
			});//change

		$('#ciudad').change(function() {

			    if (!$('#ciudad').val()) {
  				$("#ciudad-form-alert").css("display","block");
			    ciudad_esta_validado=false;
			    validar_compra();

			    alert($("#ciudad").val());
			    console.log("ingrese ciudad");
			    }
			    else {
			    $("#ciudad-form-alert").css("display","none");
			    ciudad_esta_validado=true;
			    validar_compra();
			    console.log("ciudad esta validado");
			    }
			});//change

			$("#cp").keyup(function(){

			    cp=$("#cp").val();

			    if(cp.length>8||cp.search(soloNumeros)){
			    $("#cp-form-alert").css("display","block");
			    cp_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#cp-form-alert").css("display","none");
			    cp_esta_validado=true;
			    validar_compra();
			    }

			});//keyup	



			$("#calle").keyup(function(){

			    calle=$("#calle").val();

			    if(calle.length<3||calle.search(soloLetrasEspaciosYNumeros)){
			    $("#calle-form-alert").css("display","block");
			    calle_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#calle-form-alert").css("display","none");
			    calle_esta_validado=true;
			    validar_compra();
			    }

			});//keyup


			$("#altura").keyup(function(){

			    altura=$("#altura").val();

			    if(altura.length==0||altura.search(soloNumeros)){
			    $("#altura-form-alert").css("display","block");
			    altura_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#altura-form-alert").css("display","none");
			    altura_esta_validado=true;
			    validar_compra();
			    }

			});//keyup


		$("#piso").keyup(function(){

			    piso=$("#piso").val();

			    if(piso.search(soloNumeros)){
			    $("#piso-form-alert").css("display","block");
			    piso_esta_validado=false;
			    validar_compra();
			    }
			    
				else{
			    $("#piso-form-alert").css("display","none");
			    piso_esta_validado=true;
			    validar_compra();
			    }




			});//keyup
		$("#departamento").keyup(function(){

		    departamento=$("#departamento").val();

			

		    if(departamento.search(soloLetrasEspaciosYNumerosReconoceCampoVacio)){
		    	$("#departamento-form-alert").css("display","block");
		    	departamento_esta_validado=false;
		    	validar_compra();
		    }else{
		    	$("#departamento-form-alert").css("display","none");
		    	departamento_esta_validado=true;
		    	validar_compra();
		    }



		});//keyup


			function validar_compra(){
			if(envios_esta_activado==true){
				if(nombre_esta_validado==true&&apellido_esta_validado==true&&dni_esta_validado==true&&email_esta_validado==true&&cod_area_esta_validado==true&&telefono_esta_validado==true&&provincia_esta_validado==true&&ciudad_esta_validado==true&&cp_esta_validado==true&&calle_esta_validado==true&&altura_esta_validado==true&&piso_esta_validado==true && departamento_esta_validado==true){
					//$("#btn-form").css("display","block");
					$("#carrito-checkout-btn-comprar").css("pointer-events","initial");
					$("#carrito-checkout-btn-comprar").css("background-color","#15a0db");



				}else{
					//$("#btn-form").css("display","none");
					$("#carrito-checkout-btn-comprar").css("pointer-events","none");
					$("#carrito-checkout-btn-comprar").css("background-color","grey");
				}
			}else if(envios_esta_activado==false){
				if(nombre_esta_validado==true&&apellido_esta_validado==true&&dni_esta_validado==true&&email_esta_validado==true&&cod_area_esta_validado==true&&telefono_esta_validado==true){
					//$("#btn-form").css("display","block");
					$("#carrito-checkout-btn-comprar").css("pointer-events","");
					$("#carrito-checkout-btn-comprar").css("background-color", "");


					$("#carrito-checkout-btn-comprar").css("pointer-events","initial");
					$("#carrito-checkout-btn-comprar").css("background-color","#15a0db");

				}else{
					//$("#btn-form").css("display","none");
					$("#carrito-checkout-btn-comprar").css("pointer-events","none");
					$("#carrito-checkout-btn-comprar").css("background-color","grey");
				}
			}
			}//validar_compra

			function validarCompraAlCargar(){

			var listaDeCod_Area=[11,220,221,223,230,236,237,249,260,261,263,264,266,280,291,294,297,298,299,336,341,342,343,345,348,351,353,358,362,364,370,376,379,380,381,383,385,387,388,2202,2221,2223,2224,2225,2226,2227,2229,2241,2242,2243,2244,2245,2246,2252,2254,2255,2257,2261,2262,2264,2265,2266,2267,2268,2271,2272,2273,2274,2281,2283,2284,2285,2286,2291,2292,2296,2297,2302,2314,2316,2317,2320,2323,2324,2325,2326,2331,2333,2334,2335,2336,2337,2338,2342,2343,2344,2345,2346,2352,2353,2354,2355,2356,2357,2358,2392,2393,2394,2395,2396,2473,2474,2475,2477,2478,2622,2624,2625,2626,2646,2647,2648,2651,2652,2655,2656,2657,2658,2901,2902,2903,2920,2921,2922,2923,2924,2925,2926,2927,2928,2929,2931,2932,2933,2934,2935,2936,2940,2942,2945,2946,2948,2952,2953,2954,2962,2963,2964,2966,2972,2982,2983,3327,3329,3382,3385,3387,3388,3400,3401,3402,3404,3405,3406,3407,3408,3409,3435,3436,3437,3438,3442,3444,3445,3446,3447,3454,3455,3456,3458,3460,3462,3463,3464,3465,3466,3467,3468,3469,3471,3472,3476,3482,3483,3487,3489,3491,3492,3493,3496,3497,3498,3521,3522,3524,3525,3532,3533,3537,3541,3542,3543,3544,3546,3547,3548,3549,3562,3563,3564,3571,3572,3573,3574,3575,3576,3582,3583,3584,3585,3711,3715,3716,3718,3721,3725,3731,3734,3735,3741,3743,3751,3754,3755,3756,3757,3758,3772,3773,3774,3775,3777,3781,3782,3786,3821,3825,3826,3827,3832,3835,3837,3838,3841,3843,3844,3845,3846,3854,3855,3856,3857,3858,3861,3862,3863,3865,3867,3868,3869,3873,3876,3877,3878,3885,3886,3887,3888,3891,3892,3894];


		
			nombre=$("#nombre").val();

		    if(nombre.length<3||nombre.search(soloLetrasSinEspacios)){

			    nombre_esta_validado=false;

		    }

			else{
			    nombre_esta_validado=true;
		    }

		    apellido=$("#apellido").val();

		    if(apellido.length<3||apellido.search(soloLetrasSinEspacios)){
			    apellido_esta_validado=false;
		    }
			    
			else{
			    apellido_esta_validado=true;
		    }	

		    dni=$("#dni").val();

		    if(dni.length!=8||dni.search(soloNumeros)){
			    dni_esta_validado=false;
		    }
			    
			else{
			    dni_esta_validado=true;
		    }

		    email=$("#email").val();

		    if(email.length==0||email.search(emailValido)){
			    email_esta_validado=false;
		    }
			    
			else{
			    email_esta_validado=true;
		    }

		    cod_area=$("#cod_area").val();

				for(i=0;i<listaDeCod_Area.length;i++){
					if(cod_area!=listaDeCod_Area[i]){
						cod_area_esta_validado=false;
					}else{
						cod_area_esta_validado=true;
						break;

					}
				}

			telefono=$("#telefono").val();

			    if(telefono.length<8||telefono.length>8||telefono.search(soloNumeros)){
				    telefono_esta_validado=false;
			    }
			    
				else{
				    telefono_esta_validado=true;
			    }

			 //VALIDACION DE PROVINCIA
				if (!$('#provincia').val()) {
				    provincia_esta_validado=false;
			    }
			    else {
				    provincia_esta_validado=true;
			    }

			 //VALIDACION DE CIUDAD
			 if (!$('#ciudad').val()) {
			    ciudad_esta_validado=false;
			    }
			    else {
			    ciudad_esta_validado=true;
			    }



			cp=$("#cp").val();

		    if(cp.length>8||cp.search(soloNumeros)){
				    cp_esta_validado=false;
				    console.log("codigo postal incorrecto");
		    }
			    
			else{
			    cp_esta_validado=true;
			    console.log("codigo postal validado");
		    }

	      	calle=$("#calle").val();

		    if(calle.length<3||calle.search(soloLetrasEspaciosYNumeros)){
			    calle_esta_validado=false;
		    }
		    
			else{
			    calle_esta_validado=true;
		    }

		    altura=$("#altura").val();

		    if(altura.length==0||altura.search(soloNumeros)){
			    altura_esta_validado=false;
		    }
			    
			else{
			    altura_esta_validado=true;
		    }



		    validar_compra();
	}//FUNCTION




});// ready