<?php
if (isset($conexion)) {
	if ($_SERVER['HTTP_HOST'] == 'localhost') {
		$destino = new mysqli('localhost', 'root', '', 'master');
	} else {
		$destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
	}
?>
	<div id="subirProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Categoria Producto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_producto" name="editar_producto">
						<div id="resultados_ajax3"></div>


						<div class="tab-content">
							<div class="tab-pane fade show active" id="mod_info1">


								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<input type="hidden" id="producto_subir" name="producto_subir">
											<label for="mod_linea" class="control-label">Escoje una categoria para nuestro Market Place.</label>
											<select class='form-control' name='mod_linea_subir' id='mod_linea_subir' required>
												<option value="">-- Selecciona --</option>
												<?php

												$query_categoria = mysqli_query($destino, "select * from lineas order by nombre_linea");
												while ($rw = mysqli_fetch_array($query_categoria)) {
												?>
													<option value="<?php echo $rw['id_linea']; ?>"><?php echo $rw['nombre_linea']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div align="center" class="col-md-12">
										<button type="button" onclick="subir_market()" class="btn btn-primary waves-effect waves-light" id="actualizar_datos">Subir al Market Place</button>
									</div>
								</div>



							</div>

							<!--							<div class="tab-pane fade" id="img2">

								<div class="outer_img"></div>


							</div>-->

							<!--                                                    <div class="tab-pane fade" id="imagenes">

								
                                                            
                                                          <div class="outer_img_a1"></div>
                                                          <div class="outer_img_a2"></div>
                                                          <div class="outer_img_a3"></div>
                                                          <div class="outer_img_a4"></div>
                                                          <div class="outer_img_a5"></div>
                                                           
                                                          
                                                           
                                                        
                                                          
                                                            
                                                        
                                                          
                                                            
                                                        
                                                          
                                                            
								

							</div>-->

						</div>



				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cancelar</button>

				</div>
				</form>
			</div>
		</div>
	</div><!-- /.modal -->
<?php
}
?>