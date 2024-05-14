<?php
if (isset($conexion)) {
?>
	<div id="nuevoProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Producto</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="guardar_producto" name="guardar_producto">
						<div id="resultados_ajax"></div>

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a href="#info" data-toggle="tab" aria-expanded="false" class="nav-link active">
									Datos Básicos
								</a>
							</li>
							<li class="nav-item">
								<a href="#precios" data-toggle="tab" aria-expanded="true" class="nav-link">
									Precios y Stock
								</a>
							</li>


						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="info">

								<div class="row ">
									<div class="col-md-4">
										<div class="form-group">
											<label for="codigo" class="control-label">Código:</label>
											<div id="cod_resultado"></div><!-- Carga los datos ajax del incremento de la fatura -->
										</div>

									</div>
									<div class="col-md-8">
										<div class="form-group">
											<label for="nombre" class="control-label">Nombre:</label>
											<input type="text" class="form-control UpperCase" id="nombre" name="nombre" autocomplete="off" required>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label for="descripcion" class="control-label">Descripción</label>
											<textarea class="form-control UpperCase" id="descripcion" name="descripcion" maxlength="255" autocomplete="off"></textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label for="linea" class="control-label">Categoria:</label>
											<select class='form-control' name='linea' id='linea' required>
												<option value="">-- Selecciona --</option>
												<?php

												$query_categoria = mysqli_query($conexion, "select * from lineas order by nombre_linea");
												while ($rw = mysqli_fetch_array($query_categoria)) {

												?>
													<option value="<?php echo $rw['id_linea']; ?>"><?php echo $rw['nombre_linea']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="proveedor" class="control-label">Proveedor:</label>
											<select class='form-control' name='proveedor' id='proveedor' required>
												<option value="">-- Selecciona --</option>
												<?php

												$query_proveedor = mysqli_query($conexion, "select * from proveedores order by nombre_proveedor");
												while ($rw = mysqli_fetch_array($query_proveedor)) {
												?>
													<option value="<?php echo $rw['id_proveedor']; ?>"><?php echo $rw['nombre_proveedor']; ?></option>
												<?php
												}
												?>
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col-md-6">
										<img width="100%" src="../../img_sistema/formato_pro.jpg" alt="" />
										
									</div>
                                                                    <div class="col-md-6">
                                                                        <div class="form-group">
											<label for="estado" class="control-label">Formato Pagina Productos:</label>
											<select class="form-control" id="formato" name="formato" required>
												<option value="" selected>-- Selecciona --</option>
												<option value="1">FORMATO 1</option>
												<option value="2">FORMATO 2</option>
												<option value="3">DRAG AND DROP</option>
											</select>
                                                                        </div>
                                                                        
                                                                      
                                                                        </div>
                                                                    


								</div>
								<div class="row">
									<div class="col-md-4">
										
									</div>
									
									<div class="col-md-4">
										
									</div>
								</div>

							</div>
							<div class="tab-pane fade" id="precios">

								<div class="row">
									<!--<div class="col-md-5">
										<div class="form-group">
											<label for="id_imp" class="control-label">Impuesto:</label>
											<select id = "id_imp" class = "form-control" name = "id_imp" required autocomplete="off">
												<option value="">-SELECCIONE-</option>
												<?php foreach ($impuesto as $i) : ?>
													<option value="<?php echo $i->id_imp; ?>"><?php echo $i->nombre_imp; ?></option>
												<?php endforeach; ?>
											</select>
										</div>
									</div>-->
									<div class="col-md-6">
										<div class="form-group">
											<label for="costo" class="control-label">Costo:</label>
											<input type="text" class="form-control" id="costo" name="costo" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="utilidad" class="control-label">Utilidad %:</label>
											<input type="text" class="form-control" id="utilidad" name="utilidad" pattern="\d{1,4}" maxlength="4" onkeyup="precio_venta();">
										</div>
									</div>
								</div>

								<div class="row">
                                                                    <div class="col-md-6">
										<div class="form-group">
											<label for="preciom" class="control-label">Precio Proveedor:</label>
											<input type="text" class="form-control" id="preciom" name="preciom" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label for="precio" class="control-label">Precio de Venta (Sugerido):</label>
											<input type="text" class="form-control" id="precio" name="precio" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
										</div>
									</div>
									

									<!-- 		<div class="col-md-3">
										<div class="form-group">
											<label for="precioe" class="control-label">PVP Online:</label>
											<input type="text" class="form-control" id="precioe" name="precioe" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label for="precion" class="control-label">P Referencial:</label>
											<input type="text" class="form-control" id="precion" name="precion" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12">
										</div>
									</div> -->
								</div>

								<div class="row">
									

									<div class="col-md-6">
										<div class="form-group">
											<label for="precionla" class="control-label">¿Precio Referencial?</label>
											<input type="checkbox" name="precioech" id="precionla">
											<div class="form-group">

												<label for="precion" class="control-label">P Referencial:</label>
												<input type="text" class="form-control" id="precion" name="precion" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" value="0" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="12" disabled>
											</div>
										</div>
									</div>

									<script>
										
										

										const precionla = document.getElementById('precionla');
										const precion = document.getElementById('precion');
										precionla.addEventListener('change', (e) => {
											if (precionla.checked) {
												precion.disabled = false;
											} else {
												precion.disabled = true;
											}
										});
									</script>
								</div>

								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label for="inv" class="control-label">Maneja Inventario:</label>
											<select class="form-control" id="inv" name="inv" required>
												<option value="">- Selecciona -</option>
												<option value="0">Si</option>
												<option value="1">No</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="stock" class="control-label">Stock Inicial:</label>
											<input type="text" class="form-control" id="stock" name="stock" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="0" maxlength="8">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label for="minimo" class="control-label">Stock Minimo:</label>
											<input type="text" class="form-control" id="minimo" name="minimo" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" value="1" maxlength="8">
										</div>
									</div>

								</div>



							</div>

							<div class="tab-pane fade" id="img">

								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label for="image" class="col-sm-2 control-label">Imagen</label>
											<div class="col-sm-10">
												<input type="file" class='form-control' name="imagefile" id="imagefile" onchange="upload_image(<?php echo $product_id; ?>);">
											</div>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-2"></div>
									<div class="col-sm-6 col-lg-8 col-md-4 webdesign illustrator">
										<div class="gal-detail thumb">
											<div id="load_img">
												<img src="../../img/productos/default.jpg" class="thumb-img" width="200" alt="Bussines profile picture">
											</div>
										</div>
									</div>
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