<?php
if (isset($conexion)) {
    ?>
	<div id="editarLinea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Cambiar Estado</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_linea" name="editar_linea">
						<div id="resultados_ajax2"></div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label for="mod_nombre" class="control-label">Seleccione Estado:</label>
									<select class='form-control' name='mod_estado' id='mod_estado' >
												<option value="">-- Selecciona --</option>
												<?php
echo "select * from estado_guia";
    $query_categoria = mysqli_query($conexion, "select * from estado_guia_sistema");
    while ($rw = mysqli_fetch_array($query_categoria)) {
        ?>
													<option value="<?php echo $rw['id_estado']; ?>"><?php echo $rw['estado']; ?></option>
													<?php
}
    ?>
											</select>
									<input id="mod_id" name="mod_id" type='hidden'>
								</div>
							</div>
						</div>

						
<div class="row">
							
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