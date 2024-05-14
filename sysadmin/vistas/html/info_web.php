<?php
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
session_start();
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
//echo $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Configuracion";
permisos($modulo, $cadena_permisos);
$query_empresa = mysqli_query($conexion, "select * from perfil where id_perfil=1");
$row           = mysqli_fetch_array($query_empresa);

$favicon = $row['favicon'];

?>
<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper">

	<?php require 'includes/menu.php'; ?>

	<!-- ============================================================== -->
	<!-- Start right Content here -->
	<!-- ============================================================== -->
	<div class="content-page">
		<!-- Start content -->
		<div class="content">
			<div class="container">
				<?php if ($permisos_ver == 1) {
				?>
					<div class="col-lg-12">
						<div class="portlet">
							<div class="portlet-heading bg-primary">
								<h3 class="portlet-title">
									Datos de Tienda
								</h3>
								<div class="portlet-widgets">
									<a href="javascript:;" data-toggle="reload"><i class="ion-refresh"></i></a>
									<span class="divider"></span>
									<a data-toggle="collapse" data-parent="#accordion1" href="#bg-primary"><i class="ion-minus-round"></i></a>
									<span class="divider"></span>
									<a href="#" data-toggle="remove"><i class="ion-close-round"></i></a>
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">

									<form class="form-horizontal" role="form" id="perfil" enctype="multipart/form-data">
										<div class="row">
											<div class="col-md-3">
												<div id='load_img' align="center">
													<strong>LOGO DE LA EMPRESA</strong>
													<img src="<?php echo $row['logo_url']; ?>" class="img-responsive" alt="profile-image" width="200px" height="200px">
												</div>
												<div class="form-group">

													<input class="form-control" data-buttonText="Logo" type="file" name="imagefile" id="imagefile" onchange="upload_image();">
												</div>
												<div id='load_img2' align="center">
													<strong>BANNER HOME</strong>
													<img src="<?php echo $row['banner']; ?>" class="img-responsive" alt="profile-image" width="200px" height="200px">
												</div>


												<div class="form-group">
													<input class="form-control" data-buttonText="Logo" type="file" name="imagefile2" id="imagefile2" onchange="upload_image_banner();">
												</div>

												<div id="load_img2" class="text-center">
													<strong>Favicon</strong>
													<img src="<?php echo $row['favicon']; ?>" class="img-responsive" alt="profile-image" width="200px" height="200px">
												</div>

												<div class="form-group">
													<input class="form-control" data-buttonText="Logo" type="file" name="imagefile3" id="imagefile3" onchange="upload_image_favicon();">
												</div>


											</div>

											<!-- end col -->

											<div class="col-md-9">
												<div class="card-box">
													<div style="background-color: lightyellow" class="card-box">
														<a href="../../doc/Términos y Condiciones para Proveedores de Imporsuit.pdf"></a>
														<label class="form-check-label" for="flexSwitchCheckChecked"><strong>Deseas ser proveedor de Imporsuit?</strong><br><a target="blank" href="../../doc/Términos y Condiciones para Proveedores de Imporsuit.pdf">Leer términos y condiciones</a> <br>Al marcar esta casilla, usted acepta y se compromete a cumplir con los Términos y Condiciones. </label>
														<input style="width: 30px; height: 30px" class="" type="checkbox" role="switch" id="flotar" <?php if (get_row('perfil', 'habilitar_proveedor', 'id_perfil', 1) == 1) { ?> checked<?php } ?>>


													</div><br>
													<div class="form-group row">
														<label for="inputPassword3" class="col-sm-3  col-form-label">Razón Social:</label>
														<div class="col-sm-9">
															<input type="text" class="form-control UpperCase" name="nombre_empresa" value="<?php echo $row['nombre_empresa'] ?>" required autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="giro" class="col-sm-3  col-form-label">Giro:</label>
														<div class="col-sm-9">
															<input type="text" class="form-control UpperCase" name="giro" value="<?php echo $row['giro_empresa'] ?>" required autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="fiscal" class="col-sm-3 col-form-label">RNC/Cedula:</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" required name="fiscal" value="<?php echo $row['fiscal_empresa'] ?>" autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="inputPassword3" class="col-sm-3 col-form-label">Teléfono:</label>
														<div class="col-sm-6">
															<input type="text" class="form-control" name="telefono" value="<?php echo $row['telefono'] ?>" required autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="inputEmail3" class="col-sm-3 col-form-label">Email:</label>
														<div class="col-sm-9">
															<input type="email" class="form-control" name="email" value="<?php echo $row['email'] ?>" autocomplete="off">
														</div>
													</div>



													<div class="form-group row">
														<label for="inputPassword3" class="col-sm-3 col-form-label">Dirección:</label>
														<div class="col-sm-9">
															<input type="text" class="form-control UpperCase" name="direccion" value="<?php echo $row["direccion"]; ?>" required autocomplete="off">
														</div>
													</div>
													<div class="form-group row">
														<label for="inputPassword3" class="col-sm-3 col-form-label">Incrustar mapa:</label>
														<div class="col-sm-9">
															<textarea type="text" class="form-control " name="mapa" value="<?php echo $row["mapa"]; ?>" required autocomplete="off"><?php echo $row["mapa"]; ?></textarea>
														</div>
													</div>
													<div class="form-group row">
														<label for="inputPassword3" class="col-sm-3 col-form-label">Texto para footer</label>
														<div class="col-sm-9">
															<textarea type="text" class="form-control " name="texto_contactos" value="<?php echo $row["texto_contactos"]; ?>" required autocomplete="off"><?php echo $row["texto_contactos"]; ?></textarea>
														</div>
													</div>


													<div style="background-color: lightyellow" class="card-box">
														<span class="help-block">Banner Principal </span><br><br><br>
														<div class="row">
															<div class="col-sm-6">
																<div class="form-group row">
																	<label for="inputPassword3" class="col-sm-2 col-form-label">Titulo</label>
																	<div class="col-sm-10">
																		<input type="text" class="form-control UpperCase" name="titulo_slider" value="<?php echo $row["titulo_slider"]; ?>" autocomplete="off">
																	</div>
																</div>

																<div class="form-group row">
																	<label for="inputPassword3" class="col-sm-2 col-form-label">Boton</label>
																	<div class="col-sm-10">
																		<input type="text" class="form-control UpperCase" name="texto_btn_slider" value="<?php echo $row["texto_btn_slider"]; ?>" autocomplete="off">
																	</div>
																</div>

																<div class="form-group row">
																	<label for="inputPassword3" class="col-sm-2 col-form-label">Enlace Boton</label>
																	<div class="col-sm-10">
																		<input type="text" class="form-control" name="enlace_btn_slider" value="<?php echo $row["enlace_btn_slider"]; ?>" autocomplete="off">
																	</div>
																</div>
															</div>
															<div class="col-sm-6">
																<textarea type="text" class="form-control " name="texto_slider" value="<?php echo $row["texto_slider"]; ?>" autocomplete="off"><?php echo $row["texto_slider"]; ?></textarea>
																<span class="help-block">Texto del slider </span>
																<div class="form-group row">
																	<label for="inputPassword3" class="col-sm-2 col-form-label">Alineacion</label>
																	<div class="col-sm-10">
																		<?php $alineacion = $row["alineacion_slider"]; ?>
																		<select class="form-control" name="alineacion_slider">
																			<option value="1" <?php if ($alineacion == 1 or $alineacion == 0) {
																									echo 'selected';
																								} ?>>Izquierda </option>

																			<option value="2" <?php if ($alineacion == 2) {
																									echo 'selected';
																								} ?>>Centro </option>
																			<option value="3" <?php if ($alineacion == 3) {
																									echo 'selected';
																								} ?>>Derecha </option>
																		</select>
																	</div>
																</div>
															</div>
															
														</div>
													</div>

												</div>
												<div class=" row">
													<div class="col-sm-3">
														<input type="color" name="color" value="<?php echo $row["color"]; ?>">
														<span class="help-block">Color Barra:</span>
													</div>
													<div class="col-sm-3">
														<input type="color" name="color_footer" value="<?php echo $row["color_footer"]; ?>">
														<span class="help-block">Color Footer:</span>
													</div>
													<div class="col-sm-3">
														<input type="color" name="color_botones" value="<?php echo $row["color_botones"]; ?>">
														<span class="help-block">Color Botones:</span>
													</div>

												</div>

												</br>



												<div class=" row">
													<div class="col-sm-3">
														<input type="color" name="texto_cabecera" value="<?php echo $row["texto_cabecera"]; ?>">
														<span class="help-block">Texto Cabecera:</span>
													</div>

													<div class="col-sm-3">
														<input type="color" name="texto_boton" value="<?php echo $row["texto_boton"]; ?>">
														<span class="help-block">Texto Botones:</span>
													</div>
													<div class="col-sm-3">
														<input type="color" name="texto_footer" value="<?php echo $row["texto_footer"]; ?>">
														<span class="help-block">Texto Footer:</span>
													</div>
													<div class="col-sm-3">
														<input type="color" name="texto_precio" value="<?php echo $row["texto_precio"]; ?>">
														<span class="help-block">Texto Precio:</span>
													</div>

												</div>
												</br>




												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Ciudad:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="ciudad" value="<?php echo $row["ciudad"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Región/Provincia:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="estado" value="<?php echo $row["estado"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Código postal:</label>
													<div class="col-sm-4">
														<input type="text" class="form-control UpperCase" name="codigo_postal" value="<?php echo $row["codigo_postal"]; ?>" autocomplete="off">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Facebook:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control " name="facebook" value="<?php echo $row["facebook"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Instagram:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="instagram" value="<?php echo $row["instagram"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Tiktok:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="tiktok" value="<?php echo $row["tiktok"]; ?>">
													</div>
												</div>
												<div class="form-group row">
													<label for="inputPassword3" class="col-sm-3 col-form-label">Whastapp:</label>
													<div class="col-sm-9">
														<input type="text" class="form-control UpperCase" name="whatsapp" value="<?php echo $row["whatsapp"]; ?>">
														<span class="help-block">Colocar el codigo postal mas el telefono (593995169770)</span>
													</div>
												</div>

												<div class='col-md-12' id="resultados_ajax"></div><!-- Carga los datos ajax -->


												<div class="form-group m-b-0 row">
													<div class="offset-3 col-sm-9">
														<button type="submit" class="btn btn-info waves-effect waves-light"><i class="fa fa-refresh"></i> Actualizar Datos</button>

														<a type="button" href="../../../index.php" target="_blank" class="btn btn-danger">Vista Preliminar</a>
													</div>
												</div>


									</form>

								</div>

							</div>
							<!-- end row -->


						</div>
						</form>
						<!-- /.box -->


					</div>
				<?php
				} else {
				?>
					<section class="content">
						<div class="alert alert-danger" align="center">
							<h3>Acceso denegado! </h3>
							<p>No cuentas con los permisos necesario para acceder a este módulo.</p>
						</div>
					</section>
				<?php
				}
				?>


			</div>
		</div>
	</div>
</div>


</div>
<!-- end container -->
</div>
<!-- end content -->

<?php require 'includes/pie.php'; ?>

</div>
<!-- ============================================================== -->
<!-- End Right content here -->
<!-- ============================================================== -->


</div>
<!-- END wrapper -->

<?php require 'includes/footer_start.php'
?>
<!-- ============================================================== -->
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script>
	$("#perfil").submit(function(event) {
		$('.guardar_datos').attr("disabled", true);

		var parametros = $(this).serialize();
		$.ajax({
			type: "POST",
			url: "../ajax/editar_perfil_web.php",
			data: parametros,
			beforeSend: function(objeto) {
				$("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			},
			success: function(datos) {
				$("#resultados_ajax").html(datos);
				$('.guardar_datos').attr("disabled", false);
				//desaparecer la alerta
				$(".alert-success").delay(400).show(10, function() {
					$(this).delay(2000).hide(10, function() {
						$(this).remove();
					});
				}); // /.alert

			}
		});
		event.preventDefault();
	})


	$(document).on('change', 'input[type="checkbox"]', function(e) {
		if (this.id == "flotar") {
			if (this.checked) {
				id = 1;
			} else {
				id = 0;
			}
			$.ajax({
				type: "GET",
				url: "../ajax/habilitaproveedor.php",
				data: "id=" + id,
				beforeSend: function(objeto) {
					$("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
				},
				success: function(datos) {
					$("#resultados").html(datos);
				}
			});

		}

	});
</script>

<script>
	function upload_image() {

		var inputFileImage = document.getElementById("imagefile");
		var file = inputFileImage.files[0];
		if ((typeof file === "object") && (file !== null)) {
			$("#load_img").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			var data = new FormData();
			data.append('imagefile', file);


			$.ajax({
				url: "../ajax/imagen_ajax.php", // Url to which the request is send
				type: "POST", // Type of request to be send, called as method
				data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function(data) // A function to be called if request succeeds
				{
					$("#load_img").html(data);

				}
			});
		}


	}

	function upload_image_banner() {
		var inputFileImage = document.getElementById("imagefile2");
		var file = inputFileImage.files[0];
		if ((typeof file === "object") && (file !== null)) {
			$("#load_img2").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			var data = new FormData();
			data.append('imagefile2', file);


			$.ajax({
				url: "../ajax/imagen_ajax_banner.php", // Url to which the request is send
				type: "POST", // Type of request to be send, called as method
				data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
				contentType: false, // The content type used when sending data to the server.
				cache: false, // To unable request pages to be cached
				processData: false, // To send DOMDocument or non processed data file it is set to false
				success: function(data) // A function to be called if request succeeds
				{
					$("#load_img2").html(data);

				}
			});
		}


	}

	function upload_image_favicon() {

		var inputFileImage = document.getElementById("imagefile3");
		var file = inputFileImage.files[0];
		console.log(file);
		if ((typeof file === "object") && (file !== null)) {
			$("#load_img3").html('<img src="../../img/ajax-loader.gif"> Cargando...');
			var data = new FormData();
			data.append('imagefile3', file);

		}
		$.ajax({
			url: "../ajax/imagen_ajax_favicon.php", // Url to which the request is send
			type: "POST", // Type of request to be send, called as method
			data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false, // The content type used when sending data to the server.
			cache: false, // To unable request pages to be cached
			processData: false, // To send DOMDocument or non processed data file it is set to false
			success: function(data) // A function to be called if request succeeds
			{
				$("#load_img3").html(data);

			}
		});

	}
</script>
<script>
	$(document).ready(function() {
		$(".UpperCase").on("keypress", function() {
			$input = $(this);
			setTimeout(function() {
				$input.val($input.val().toUpperCase());
			}, 50);
		})
	})
</script>

<?php require 'includes/footer_end.php'
?>