<?php
if (isset($conexion)) {
?>
	<style>
		/* Estilos para la lista y los inputs para que parezcan texto plano */
		.info-input {
			border: none;
			/* Elimina el borde */
			outline: none;
			/* Elimina el resaltado al enfocar */
			background: none;
			/* Fondo transparente */
			width: 100%;
			/* Ajusta el ancho según sea necesario */
			color: black;
			/* Color del texto */
			font-size: 18px;
			/* Tamaño del texto */
			padding: 2px;
			/* Espaciado interno, ajusta según sea necesario */
		}

		.info-input[readonly] {
			cursor: default;
			/* Cambia el cursor para que no parezca editable */
		}

		.info-input_stock {
			border: none;
			/* Elimina el borde */
			outline: none;
			/* Elimina el resaltado al enfocar */
			background: none;
			/* Fondo transparente */
			width: 100%;
			/* Ajusta el ancho según sea necesario */
			color: black;
			/* Color del texto */
			font-size: 22px;
			/* Tamaño del texto */
			padding: 2px;
			/* Espaciado interno, ajusta según sea necesario */
		}

		.info-input_stock[readonly] {
			cursor: default;
			/* Cambia el cursor para que no parezca editable */
		}

		/* Elimina las viñetas de las listas */
		ul {
			list-style-type: none;
			/* Elimina las viñetas */
			padding: 0;
			/* Elimina el padding predeterminado si es necesario */
			margin: 0;
			/* Elimina el margen predeterminado si es necesario */
		}

		/* Aplica subrayado a los textos en negritas */
		strong {
			text-decoration: underline;
			/* Subraya el texto */
		}

		.info-input_descripcion {
			width: 100%;
			/* Ajusta el ancho al contenedor */
			height: auto;
			/* Altura automática según el contenido */
			background: none;
			/* Sin fondo */
			border: none;
			/* Sin bordes */
			outline: none;
			/* Sin contorno al enfocar */
			resize: none;
			/* No permitir redimensionamiento */
			overflow: hidden;
			/* Oculta la barra de desplazamiento si no es necesaria */
			padding: 0;
			/* Sin padding para mantener el estilo uniforme */
			white-space: pre-wrap;
			/* Conserva los espacios y saltos de línea */
			font-family: inherit;
			/* Hereda la fuente del documento */
			font-size: inherit;
			/* Hereda el tamaño de fuente del documento */
		}

		.styled-hr {
			border: none;
			/* Elimina el borde predeterminado */
			height: 1px;
			/* Establece la altura de la línea */
			background-color: #dee2e6;
			/* Define el color de la línea, similar al de tu imagen */
			margin: 0px 0;
			/* Agrega espacio vertical antes y después del hr */
		}

		.view.overlay {
			width: 100%;
			/* Asegura que el contenedor de la imagen ocupe todo el ancho disponible */
		}

		.card-img-top {
			max-width: 100%;
			/* Hace que la imagen nunca sea más ancha que su contenedor */
			height: 400px;
			/* Mantiene la proporción de la imagen ajustando su altura automáticamente */
		}

		/* Estilo para el contenedor principal */
		div[style*="flex: 1; display: flex;"] {
			flex-direction: column;
			/* Cambia la dirección del flex a columna en dispositivos móviles si es necesario */
			padding: 10px;
			/* Ajusta el padding para dispositivos móviles */
		}

		@media (max-width: 768px) {

			/* Estilos específicos para móviles */
			div[style*="flex: 1; display: flex;"] {
				padding-left: 0;
				/* Elimina el padding izquierdo en móviles para más espacio */
				align-items: center;
				/* Centra los elementos horizontalmente */
			}
		}

		/* Estilos base que aplican a cualquier tamaño de pantalla */
		.modal-body {
			display: flex;
			flex-direction: row-reverse;
			/* Predeterminadamente en modo columna */
		}

		.info-section,
		.image-section {
			width: 100%;
		}

		.info-section {
			padding-right: 20px;
			border-right: 1px solid #dee2e6;
		}

		.image-section {
			padding-left: 20px;
		}

		.image-section {
			display: flex;
			/* Activa flexbox */
			justify-content: center;
			/* Centra horizontalmente */
			align-items: center;
			/* Centra verticalmente */
			height: 100%;
			/* Opcional: establece una altura si es necesario */
		}

		/* Media query para pantallas mayores a 768px */
		@media (max-width: 763px) {
			.card-img-top {
				height: 300px;
				padding-bottom: 10px;
				/* Mantiene la proporción de la imagen ajustando su altura automáticamente */
			}

			.modal-body {
				flex-direction: column;
				/* Cambia a modo fila para pantallas grandes */
			}

			.info-section {
				padding-right: 0px;
				border-right: 0px solid #dee2e6;
			}

			.image-section {
				padding-left: 00px;
			}
		}

		#mod_telefono_tienda {
			color: blue;
			/* Establece el color del texto a azul */
			border: none;
			/* Elimina el borde */
			background-color: transparent;
			/* Fondo transparente */
			cursor: pointer;
			/* Cambia el cursor a forma de mano para indicar que es un enlace */
			transition: color 0.3s ease;
			/* Transición suave para el cambio de color */
		}

		/* Estilo para el input del número de teléfono al pasar el mouse */
		#mod_telefono_tienda:hover {
			color: deepskyblue;
			/* Cambia el color a un azul más claro al pasar el mouse */
		}
	</style>
	<div id="editarProducto" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title text-center" id="facebookLabel">Descripción del Producto</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<!-- imagen -->
					<div class="image-section">
						<div class="view overlay">
                                                    <img class="card-img" style="width: 100%" id="mod_image_path">
						</div>
					</div>
					<!-- fin imagen -->
					<hr class="styled-hr">
					<div class="info-section">
						<ul>
							<h3>Información</h4>
								<li style="font-size: 20px;"><strong>Código del Producto:</strong> <input type="text" id="mod_codigo" class="info-input" readonly></li>
								<li style="font-size: 20px;"><strong>Nombre Producto:</strong> <input type="text" id="mod_nombre" class="info-input" readonly></li>

								<div class="d-flex flex-row">
									<li style="font-size: 20px; border-right: 1px solid #dee2e6;"><strong>Precio:</strong> <input type="text" id="mod_precio" class="info-input" readonly></li>
									<li style="font-size: 20px; padding-left:10px"><strong>Precio Sugerido:</strong> <input type="text" id="mod_precioe" class="info-input" readonly></li>
								</div>
								<li style="font-size: 22px;"><strong>Stock:</strong> <input type="text" id="mod_stock" style="color: #3EDF2B; font-weight: bold;" class="info-input_stock" readonly></li>
								<hr class="styled-hr">
								<li style="font-size: 22px;"><strong>Proveedor:</strong> <input type="text" id="mod_tienda" class="info-input_stock" readonly></li>
								<li>
									<a id="link-telefono-tienda" href="#" target="_blank">
										<input type="text" id="mod_telefono_tienda" class="info-input_stock" readonly>
									</a>
								</li>
						</ul>

					</div>


				</div>
				<hr class="styled-hr">
				<div style="padding-left: 20px; padding-bottom: 20px;">
					<h3>Descripción</h4>
						<textarea id="mod_descripcion" class="info-input_descripcion" readonly></textarea>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div>
<?php
}
?>