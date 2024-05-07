<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: ../../login.php");
	exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Categorias";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title     = "Categorias";
$pacientes = 1;
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
							<div class="portlet-heading" style="background-color: #171931">
								<h3 class="portlet-title">
									Lineas
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

									<?php
									if ($permisos_editar == 1) {
										include '../modal/registro_linea.php';
										include "../modal/editar_linea.php";
										include "../modal/eliminar_linea.php";
										include "../modal/imagen_linea.php";
									}
									?>

									<form class="form-horizontal" role="form" id="datos_cotizacion">
										<div class="form-group row">
											<div class="col-md-6">
												<div class="input-group">
													<input type="text" class="form-control" id="q" placeholder="Buscar por Nombre" onkeyup='load(1);'>
													<span class="input-group-btn">
														<button type="button" class="btn btn-info waves-effect waves-light" onclick='load(1);'>
															<span class="fa fa-search"></span> Buscar</button>
													</span>
												</div>
											</div>
											<div class="col-md-3">
												<span id="loader"></span>
											</div>
											<div class="col-md-3">
												<div class="btn-group pull-right">
													<button type="button" class="btn btn-success waves-effect waves-light" data-toggle="modal" data-target="#nuevaLinea"><i class="fa fa-plus"></i> Nueva</button>
												</div>

											</div>

										</div>
									</form>
									<div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
									<div class='outer_div'></div><!-- Carga los datos ajax -->



								</div>
							</div>
						</div>
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
<!-- Todo el codigo js aqui -->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/lineas.js"></script>
<script>
	$(document).ready(function() {
		$(".UpperCase").on("keypress", function() {
			$input = $(this);
			setTimeout(function() {
				$input.val($input.val().toUpperCase());
			}, 50);
		})
	})

	function upload_image_mod_linea(id_producto) {
		$("#load_img_mod").text('Cargando...');
		var inputFileImage = document.getElementById("imagefile_mod");
		var file = inputFileImage.files[0];
		var data = new FormData();
		data.append('imagefile_mod', file);
		data.append('id_producto', id_producto);



		$.ajax({
			url: "../ajax/imagen_linea.php", // Url to which the request is send
			type: "POST", // Type of request to be send, called as method
			data: data, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
			contentType: false, // The content type used when sending data to the server.
			cache: false, // To unable request pages to be cached
			processData: false, // To send DOMDocument or non processed data file it is set to false
			success: function(data) // A function to be called if request succeeds
			{
				$("#load_img_mod").html(data);

			}
		});

	}

	function carga_img_l(id_producto) {
		//   alert(id_producto)
		$(".outer_img").load("../ajax/img_linea.php?id_producto=" + id_producto);

	}
</script>
<?php require 'includes/footer_end.php'
?>