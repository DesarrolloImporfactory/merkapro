<?php
if (isset($conexion)) {
    ?>
	<div id="editarHorizontal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Linea</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_horizontal" name="editar_linea">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="mod_nombre" class="control-label">Nombre:</label>
									<input type="text" class="form-control UpperCase" id="mod_nombre_horizontal" name="mod_nombre_horizontal"  autocomplete="off" required>
									<input id="mod_id_horizontal" name="mod_id_horizontal" type='hidden'>
								</div>
							</div>
                                                    
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Posición:</label>
                                                                        <select id="mod_posicion" name="mod_posicion" class="form-control">
                                                                            <option value="1">Barra Superior</option>
                                                                            <option value="2">Barra Inferior</option>
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