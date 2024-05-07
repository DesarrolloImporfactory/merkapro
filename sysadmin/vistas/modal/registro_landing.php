<?php
if (isset($conexion)) {
    ?>
	<div id="nuevoLanding" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Landing Page</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_landing" name="editar_landing">
						<div id="resultados_ajax"></div>

						<ul class="nav nav-tabs">
							<li class="nav-item">
								<a href="#info2" data-toggle="tab" aria-expanded="false" class="nav-link active">
									Bloque 1 - Promesa
								</a>
							</li>
							
							<li class="nav-item">
								<a href="#img3" data-toggle="tab" aria-expanded="true" class="nav-link">
									Bloque 2 - Dolor
								</a>
							</li>
                                                        
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="info2">

								<div class="row">
									
									<div class="col-md-12">
										<div class="form-group">
										<label for="codigo" class="control-label">Descripcion (SEO):</label>	
                                                                                <div class="col-sm-10">
                                                                                    <input id="mod_id_landing" name="mod_id_landing" type='hidden'>
											<textarea type="text" class="form-control"  name="mod_descripcion1" id="mod_descripcion1"></textarea> 
                                                                                        </div>
										</div>
									</div>
								</div>
                                                            <div class="row">
									
									<div class="col-md-12">
										<div class="form-group">
											<label for="codigo" class="control-label">Texto Boton Compra 1:</label>
                                                                                        <div class="col-sm-10">
                                                                                            <input class="form-control" type="text" name="mod_boton1" id="mod_boton1"> 
                                                                                        </div>
										</div>
									</div>
								</div>
                                                            
                                                            

								<div class="outer_img2"></div>


								
								

							</div>
							

							<div class="tab-pane fade" id="img3">

								<div class="row">
									
									<div class="col-md-12">
										<div class="form-group">
										<label for="codigo" class="control-label">Descripcion (SEO)2:</label>	
                                                                                <div class="col-sm-10">
											<textarea type="text" class="form-control"  name="mod_descripcion2" id="mod_descripcion2"></textarea> 
                                                                                        </div>
										</div>
									</div>
								</div>
                                                            <div class="row">
									
									<div class="col-md-12">
										<div class="form-group">
											<label for="codigo" class="control-label">Texto Boton Compra 2:</label>
                                                                                        <div class="col-sm-10">
                                                                                            <input class="form-control" type="text" name="mod_boton2" id="mod_boton2"> 
                                                                                        </div>
										</div>
									</div>
								</div>
                                                            <div class="outer_img22"></div>
                                                            
                                                            
                                                         
								

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
        <script src="https://cdn.ckeditor.com/ckeditor5/18.0.0/classic/ckeditor.js"></script>
        <!--script>
        ClassicEditor
            .create( document.querySelector( '#txtDescripcion' ) )
            .catch( error => {
            console.error( error );
            } );
        </script-->
	<?php
}
?>