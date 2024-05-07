<?php
if (isset($conexion)) {
    ?>
	<div id="editarLinea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Linea</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_linea" name="editar_linea">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_nombre" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="mod_nombre" name="mod_nombre"  autocomplete="off" required>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_descripcion" class="control-label">Descripción</label>
									<textarea class="form-control UpperCase"  id="mod_descripcion" name="mod_descripcion" maxlength="255" autocomplete="off"></textarea>
								</div>
							</div>
						</div>
<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion" class="control-label">Online:</label>
									<select class="form-control" id="mod_online" name="mod_online" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>SI</option>
										<option value="0">NO</option>
									</select>
								</div>
							</div>
						</div>
                                                <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion" class="control-label">Tipo:</label>
									<select class="form-control" id="mod_tipo" name="mod_tipo" required>
										<option value="">-- Selecciona --</option>
										<option value="1" selected>PRINCIPAL</option>
										<option value="2">SUBCATEGORIA</option>
									</select>
								</div>
							</div>
						</div>
                                                 <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="descripcion" class="control-label">Categoria Principal:</label>
									<select class='form-control' name='mod_linea_padre' id='mod_linea_padre' >
												<option value="">-- Selecciona --</option>
												<?php

    $query_categoria = mysqli_query($conexion, "select * from lineas where tipo=1 order by nombre_linea");
    while ($rw = mysqli_fetch_array($query_categoria)) {
        ?>
													<option value="<?php echo $rw['id_linea']; ?>"><?php echo $rw['nombre_linea']; ?></option>
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