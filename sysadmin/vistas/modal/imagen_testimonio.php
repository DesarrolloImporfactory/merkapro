<?php
if (isset($conexion)) {
    ?>
	<div id="imagenLinea" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
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
									Imagen 
								</a>
							</li>
							
							
                                                        
						</ul>
						<div class="tab-content">
							<div class="tab-pane fade show active" id="info2">

								
                                                       
                                                            
                                                            

								<div class="outer_img"></div>


								
								

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