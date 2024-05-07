<?php
if (isset($conexion)) {
    ?>
	<div id="nuevaFlotante" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Texto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_horizontal" name="guardar_horizontal">
						<div id="resultados_ajax_horizontal"></div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Texto:</label>
									<input type="text" class="form-control UpperCase" id="nombre" name="nombre"  autocomplete="off" required>
								</div>
							</div>
                                                    
                                                    <div class="col-md-6">
								<div class="form-group">
									<label for="nombre" class="control-label">Posición:</label>
                                                                        <select id="posicion" name="posicion" class="form-control">
                                                                            <option value="1">Barra Superior</option>
                                                                            <option value="2">Barra Inferior</option>
                                                                        </select>
								</div>
							</div>
						</div>

						
                                             
                                                 
						

					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
						<button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos_horizontal">Guardar</button>
					</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
	<?php
}
?>