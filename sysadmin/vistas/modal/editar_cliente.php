<?php
if (isset($conexion)) {
    ?>
	<div id="editarCliente" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Cliente</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_cliente" name="editar_cliente">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_nombre" class="control-label">Nombre Comercial:</label>
									<input type="text" class="form-control UpperCase" id="mod_nombre" name="mod_nombre" autocomplete="off" required>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Razón Social:</label>
									<input type="text" class="form-control UpperCase" id="mod_razon_social" name="mod_razon_social" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_fiscal" class="control-label">RNC/Cedula:</label>
									<input type="text" class="form-control" id="mod_fiscal" name="mod_fiscal" autocomplete="off">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="telefono" class="control-label">Telefono:</label>
									<input type="text" class="form-control" id="mod_telefono" name="mod_telefono" autocomplete="off" required>
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fiscal" class="control-label">Ciudad:</label>
									<input type="text" class="form-control" id="mod_ciudad" name="mod_ciudad" autocomplete="on">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="telefono" class="control-label">Giro de negocio:</label>
									<input type="text" class="form-control" id="mod_giro_negocio" name="mod_giro_negocio" autocomplete="off" required>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_direccion" class="control-label">Dirección:</label>
									<textarea class="form-control UpperCase"  id="mod_direccion" name="mod_direccion" maxlength="255" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fiscal" class="control-label">Nombre Contacto:</label>
									<input type="text" class="form-control" id="mod_nombre_contacto" name="mod_nombre_contacto" autocomplete="on">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label for="telefono" class="control-label">Teléfono Contacto:</label>
									<input type="text" class="form-control" id="mod_telefono_contacto" name="mod_telefono_contacto" autocomplete="off" required>
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="fiscal" class="control-label">Cargo Contacto:</label>
									<input type="text" class="form-control" id="mod_cargo_contacto" name="mod_cargo_contacto" autocomplete="on">
								</div>
							</div>
							<div class="col-md-6">
                                                            <div class="form-group">
									<label for="direccion" class="control-label">Crédito hasta:</label>
                                                                        <select class="form-control" id="mod_credito" name="mod_credito">
                                                                            <option value="">Escoja una opción</option>
                                                                            <option value="0">Sin crédito</option>
                                                                            <option value="15">Hasta 15 días</option>
                                                                            <option value="30">Hasta 30 días</option>
                                                                            <option value="60">Hasta 60 días</option>
                                                                            <option value="90">Hasta 90 días</option>
                                                                             <option value="180">Hasta 180 días</option>
                                                                            
                                                                        </select>
								</div>
								
							</div>
						</div>
                                                
                                                <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="direccion" class="control-label">Observaciones:</label>
									<textarea class="form-control UpperCase"  id="mod_observaciones" name="mod_observaciones" maxlength="255" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-8">
								<div class="form-group">
									<label for="encargado" class="control-label">Email:</label>
									<input type="mod_email" class="form-control" id="mod_email" name="mod_email" autocomplete="off">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<label for="mod_estado" class="control-label">Estado:</label>
									<select class="form-control" id="mod_estado" name="mod_estado" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>Activo</option>
										<option value="0">Inactivo</option>
									</select>
								</div>
							</div>
						</div>

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="actualizar_datos">Actualizar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>