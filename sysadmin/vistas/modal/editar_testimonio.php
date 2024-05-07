<?php
if (isset($conexion)) {
    ?>
	<div id="editarTestimonio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Testimonio</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_testimonio" name="editar_testimonio">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_nombre" class="control-label">Nombre:</label>
									<input type="text" class="form-control" id="mod_nombre" name="mod_nombre"  autocomplete="off" required>
									<input id="mod_id_testimonio" name="mod_id_testimonio" type='hidden'>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_descripcion" class="control-label">Testimonio</label>
									<textarea class="form-control "  id="mod_descripcion" name="mod_descripcion" maxlength="255" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
                                                
                                                <div class="row">
                                                    <div class="col-md-12">
								<div class="form-group">
                                                                    <label for="descripcion" class="control-label">Página:</label>
                                                <select class='form-control' name='mod_id_producto' id='mod_id_producto' required>
												<option value="">-- Selecciona --</option>
                                                                                                <option style="background-color: #D9EDF7" value="-1">PÁGINA DE INICIO</option>
                                                                                                
												<?php

    $query_proveedor = mysqli_query($conexion, "select * from productos where pagina_web=1 and estado_producto=1 order by nombre_producto ");
    while ($rw = mysqli_fetch_array($query_proveedor)) {
        ?>
													<option value="<?php echo $rw['id_producto']; ?>"><?php echo $rw['nombre_producto']; ?></option>
													<?php
}
    ?>
											</select>
                                                	</div>
							</div>
						</div>

                                                
                                                 
						<div class="row">
							<div class="col-md-6">
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