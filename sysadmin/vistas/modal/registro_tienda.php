<?php
if (isset($conexion)) {
    ?>
	<div id="nuevaLinea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nueva Tienda</h4>
				</div>
                            <form class="form-horizontal" method="post" id="guardar_tienda" name="guardar_tienda">
				<div class="modal-body">
					
						<div id="resultados_ajax"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Nombre Tienda:</label>
									<input type="text" class="form-control UpperCase" id="nombre" name="nombre"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Contacto:</label>
									<input type="text" class="form-control UpperCase" id="contacto" name="contacto"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Whatsapp:</label>
									<input type="text" class="form-control UpperCase" id="whatsapp" name="whatsapp"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Fecha Ingreso:</label>
									<input type="date" class="form-control UpperCase" id="ingreso" name="ingreso"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Fecha Actualiza:</label>
									<input type="date" class="form-control UpperCase" id="actualiza" name="actualiza"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Fecha Caduca:</label>
									<input type="date" class="form-control UpperCase" id="caduca" name="caduca"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Plan:</label>
                                                                        <select  class="form-control " id="plan" name="plan"  autocomplete="off" required>
                                                                            <option value="">Seleccione Plan</option>
                                                                             <option value="1">Prueba</option>
                                                                            <option value="2">Free</option>
                                                                            <option value="3">Premium</option>
                                                                        </select>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Subdominio:</label>
									<input type="text" class="form-control " id="subdominio" name="subdominio"  autocomplete="off" required>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Carpeta:</label>
                                                                      <input type="text" class="form-control " id="carpeta" name="carpeta"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Dominio Propio:</label>
									<input type="text" class="form-control " id="dominio" name="dominio"  autocomplete="off" >
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Email:</label>
                                                                      <input type="text" class="form-control " id="email" name="email"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Base de datos:</label>
									<input type="text" class="form-control " id="db_name" name="db_name"  autocomplete="off" >
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Usuario Base de Datos:</label>
                                                                      <input type="text" class="form-control " id="db_user" name="db_user"  autocomplete="off" required>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="fecha" class="control-label">Password Base de datos:</label>
                                                                        <input type="password" class="form-control " id="db_pass" name="db_pass"  autocomplete="off" >
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<label for="nombre" class="control-label">Referido:</label>
                                                                      <select class="form-control" id="referido" name="referido" required>
										<option value="">-- Selecciona --</option>
										<option value="1" >SI</option>
										<option value="0" selected>NO</option>
									</select>
								</div>
							</div>
                                                    <div class="col-md-4">
								<div class="form-group">
									<label for="nombre" class="control-label">Token:</label>
                                                                      <label for="fecha" class="control-label">Padre:</label>
                                                                        <input type="text" class="form-control " id="token" name="token"  autocomplete="off" >
								</div>
							</div>
                                                    <div class="col-md-4">
								<div class="form-group">
									<label for="fecha" class="control-label">Padre:</label>
                                                                        <input type="text" class="form-control " id="padre" name="padre"  autocomplete="off" >
								</div>
							</div>
						</div>

						
                                                
                                                
                                                 
						

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>
