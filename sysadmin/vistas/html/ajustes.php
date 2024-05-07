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
$modulo = "Productos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
?>

<?php require 'includes/header_start.php'; ?>
<style>
	.btn-excel {
        background-color: #1b6d41;
        color: white;
    }
</style>
<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged">

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
									Ajustes de Inventario
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
							<?php
							include "../modal/agregar_stock.php";
							include "../modal/eliminar_stock.php";
							?>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">
									<div class="form-group row">
										<div class="col-md-5">
											<div class="input-group" style="padding-bottom: 10px;">
												<input type="text" id="nombre_producto" class="form-control" placeholder="Nombre de Producto" required tabindex="2" autocomplete="off">
												<input id="id_producto" name="id_producto" type='hidden'>
												<span class="input-group-btn">
													<button type="button" id="btnBuscar" class="btn btn-outline-info btn-rounded waves-effect waves-light">
														<span class="fa fa-search"></span> Buscar
													</button>
												</span>
											</div>
											<span id="loader1"></span>
										</div>
										<div class="d-flex flex-column" style="width: 58%;">
											<div class="col-md-15">
												<span id="loader"></span>
												<div id='outer_div'></div><!-- Carga los datos ajax -->
											</div>
										</div>
									</div>
									<div class="datos_ajax_delete"></div><!-- Datos ajax Final -->
									<div id="resultados_ajax"></div>


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
<script type="text/javascript" src="../../js/ver_historial.js"></script>
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/productos_inventario.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
<!-- Codigos Para el Auto complete de Clientes -->
<script>

</script>
<!-- FIN -->
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
<script>
  function descargarExcel() {
    // Leer la tabla HTML
    let table = document.getElementById('reporte_ajustes');
    let workbook = XLSX.utils.table_to_book(table);

    // Exportar a Excel
    XLSX.writeFile(workbook, 'nombre_del_archivo.xlsx');
  }
</script>

<script>
	function ajustarProducto(button) {
		var fila = $(button).closest('tr');
		var id_producto = fila.data('id_producto');
		var nombre_producto = fila.data('nombre_producto');

		// Actualizamos los valores en los campos correspondientes, si es necesario
		$('#id_producto').val(id_producto);
		$('#nombre_producto').val(nombre_producto);

		// Hacer algo similar a lo que se hace en el autocomplete select
		$('#outer_div').load("../ajax/carga_ajuste.php?id_producto=" + id_producto);
		$.Notification.notify('custom', 'bottom center', 'EXITO!', 'AJUSTE DE PRODUCTO INICIADO!')
	}
</script>

<?php require 'includes/footer_end.php'
?>