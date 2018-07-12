<!-- MODAL MIS PEDIDOS -->
  <div class="modal fade" id="pedidos-modal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <img src="elementos_separados/logo.png" width="30%" alt="">
        </div>
        <div id="pedidos-modal-body" class="modal-body">
        	
        	<label for="email-modal"><h4>Ingrese su email</h4></label>
			<input class="form-control" autocomplete="off" type="text" name="email" id="email" placeholder="minombre@NeumaticosOeste.com">
        	
        	<label for="contrasenia-modal"><h4>Ingrese su contraseña</h4></label>
			<input class="form-control" autocomplete="off" type="password" name="contrasenia" id="contrasenia">
			
			<a href="recuperar-contrasenia.php">Recuperar contraseña</a><br>
			
			<p class="form-alert pedidos-alert" id="validarUsuario-form-alert">Usuario y/o contraseña incorrectos</p><br>
			<a class="carrito-checkout-btn" onClick="validarUsuario()">Ingresar</a >
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
  