<!-- MODAL -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <img src="elementos_separados/logo.png" width="30%" alt="">
        </div>
        <div class="modal-body">
        	<form id="modal-form" name="modal-form" action="comprar.php?session=true" method="POST">
        	<label for="email-modal"><h3>Ingrese su email</h3></label>
        	<input autocomplete="off" type="text" class="form-control" id="email-modal" name="email-modal" placeholder="Ej: minombre@protechdry.com.ar">
        	<p id="email-modal-alert">Ingrese un email valido por ejemplo: minombre@protechdry.com.ar</p>
       		<a id="comprar-modal-btn" onclick="document.getElementById('modal-form').submit();" class="carrito-checkout-btn">Continuar</a>
			</form>
        </div>
        <div class="modal-footer">
        	<ul>
        		<li><b>Guardamos su correo electrónico de manera 100% segura para:</b></li><br>
        		<li><i class="modal-icon material-icons">done</i><b>Notificar sobre los estados de su compra.</b></li>
        		<li><i class="modal-icon material-icons">done</i><b>Guardar el historial de compras.</b></li>
        		<li><i class="modal-icon material-icons">done</i><b>Facilitar el proceso de compras.</b></li>
        	</ul>
        </div>
      </div>
      
    </div>
  </div>
  
</div>