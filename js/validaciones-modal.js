$(document).ready(function() {

			if($("#email-modal").val()==''){

				$("#comprar-modal-btn").css("pointer-events","none");
				$("#comprar-modal-btn").css("background-color","grey");

			}

		var emailValido=/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

			$("#email-modal").keyup(function(){

			    email=$("#email-modal").val();

			    if(email.length==0||email.search(emailValido)){
			    $("#email-modal-alert").css("display","block");

			  	$("#comprar-modal-btn").css("pointer-events","none");
				$("#comprar-modal-btn").css("background-color","grey");

			    }
			    
				else{

			    $("#email-modal-alert").css("display","none");

			 	$("#comprar-modal-btn").css("pointer-events","initial");

				$("#comprar-modal-btn").css("background-color","#15a0db");

			    }

			});//keyup
		});