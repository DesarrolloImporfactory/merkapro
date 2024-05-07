<?php
if (isset($conexion)) {
?>
	<div id="editarIconos" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-edit'></i> Editar Item</h4>
				</div>
				<div class="modal-body">
					<form class="form-horizontal" method="post" id="editar_iconos" name="editar_iconos">
						<div id="resultados_ajax2"></div>

						<div class="form-group d-flex flex-column">
							<input type="hidden" id="mod_id" name="mod_id">
							<div>
								<label for="nombre" class="control-label">Texto Icono:</label>
								<input type="text" class="form-control" id="texto_icon" name="texto_icon" autocomplete="off">
							</div>
							<div>
								<label for="nombre" class="control-label">Sub-texto Icono:</label>
								<input type="text" class="form-control" id="subtexto_icon" name="subtexto_icon" autocomplete="off">
							</div>
							<div>
								<label for="nombre" class="control-label">Enlace Icono:</label>
								<input type="text" class="form-control" id="enlace_icon" name="enlace_icon" autocomplete="off">
							</div>
							<div>

								<label for="nombre" class="control-label">Icono:</label>
								<select id="icon_select" name="icon_select" style="width: 100%;"></select>

								<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
								<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
								<script>
									document.addEventListener('DOMContentLoaded', function() {

										// Define la variable que almacenará los nombres de los íconos
										var iconsArray = [];

										// Realiza una solicitud AJAX para obtener los datos del archivo JSON
										$.getJSON('../json/iconos.json', function(data) {
											// Itera sobre cada objeto en el array 'data'
											$.each(data, function(index, item) {
												// Añade el valor de 'icon-name' a iconsArray
												iconsArray.push(item['icon-name']);
											});
											console.log(iconsArray); // Por ejemplo, imprime en consola

											var selectElement = document.getElementById('icon_select');

											// Añade las opciones al select
											iconsArray.forEach(function(icon) {
												var option = new Option(icon, icon);
												selectElement.add(option);
											});

											$(selectElement).select2({
												width: '100%',
												// No necesitas modificar minimumResultsForSearch para activar la caja de búsqueda.
												templateResult: function(state) {
													// Esta función controla cómo se muestran los resultados.
													if (!state.id) {
														return state.text; // Para el placeholder o estados sin id
													}
													var $state = $(
														'<span><i class="fas ' + state.element.value + '"></i> ' + state.text + '</span>'
													);
													return $state;
												},
												templateSelection: function(state) {
													// Esta función controla cómo se muestra la opción seleccionada.
													if (!state.id) {
														return state.text; // Para el placeholder o estados sin id
													}
													return $('<span><i class="fas ' + state.element.value + '"></i> ' + state.text + '</span>');
												},
												escapeMarkup: function(m) {
													return m; // Permite HTML en los resultados
												}
											});
										});
									});
								</script>
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