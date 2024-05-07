<?php
session_start();
if (!isset($_SESSION['user_login_status']) and $_SESSION['user_login_status'] != 1) {
	header("location: ../../login.php");
	exit;
}
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Archivo de funciones PHP
require_once "../funciones.php";
//Inicia Control de Permisos
include "../permisos.php";
$user_id = $_SESSION['id_users'];
get_cadena($user_id);
$modulo = "Pedidos";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$title          = "Ventas";
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);
$pais = get_row('perfil', 'pais', 'id_perfil', 1);
?>

<?php require 'includes/header_start.php'; ?>

<?php require 'includes/header_end.php'; ?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged"> <!-- DESACTIVA EL MENU -->
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
									Nueva Cotización
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
									include "../modal/buscar_productos_ventas.php";
									include "../modal/registro_cliente.php";
									include "../modal/registro_producto.php";
									?>
									<div class="row">
										<?php
										$sql_productos = "SELECT tienda, COUNT(*) as cantidad_productos
                                                                                FROM productos
                                                                                GROUP BY tienda;";

										//echo $sql_productos;


										$sql_producto_tienda = mysqli_query($conexion, $sql_productos);

										if ($sql_producto_tienda) {

											while ($row_tienda = mysqli_fetch_assoc($sql_producto_tienda)) {

												$tienda         = $row_tienda["tienda"];
												if ($tienda !== "" && $tienda !== null && $tienda !== 'enviado' && $pais == 1) {
													// echo $tienda;

										?>
													<div class="col-lg-3">
														<div class="card-box">
															<a id="" href="nueva_cotizacion_1.php?id=<?php echo $tienda; ?>">
																<div class="widget-chart">

																	<img width="100px" src="../../img_sistema/logo_tienda.png" alt="" />

																	<?php


																	echo $tienda ?>


																</div>
															</a>
														</div>

													</div>
												<?php }
												?>
										<?php


											}
										} ?>
										<div class="col-lg-3">
											<div class="card-box">
												<a id="" href="nueva_cotizacion_1.php?id=local">
													<div class="widget-chart">

														<img width="100px" src="../../img_sistema/logo_tienda.png" alt="" />

														PRODUCTOS LOCALES


													</div>
												</a>
											</div>

										</div>




									</div>
									<!-- end row -->


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
<!-- Todo el codigo js aqui-->
<!-- ============================================================== -->
<script type="text/javascript" src="../../js/VentanaCentrada.js"></script>
<script type="text/javascript" src="../../js/cotizacion.js"></script>
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de Clientes -->
<script>
	$(function() {
		$("#nombre_cliente").autocomplete({
			source: "../ajax/autocomplete/clientes.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_cliente').val(ui.item.id_cliente);
				$('#nombre_cliente').val(ui.item.nombre_cliente);
				$('#tel1').val(ui.item.fiscal_cliente);
				$('#em').val(ui.item.email_cliente);
				$.Notification.notify('success', 'bottom right', 'EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
			}
		});
	});

	$("#nombre_cliente").on("keydown", function(event) {
		if (event.keyCode == $.ui.keyCode.LEFT || event.keyCode == $.ui.keyCode.RIGHT || event.keyCode == $.ui.keyCode.UP || event.keyCode == $.ui.keyCode.DOWN || event.keyCode == $.ui.keyCode.DELETE || event.keyCode == $.ui.keyCode.BACKSPACE) {
			$("#id_cliente").val("");
			$("#tel1").val("");
			$("#em").val("");
		}
		if (event.keyCode == $.ui.keyCode.DELETE) {
			$("#nombre_cliente").val("");
			$("#id_cliente").val("");
			$("#tel1").val("");
			$("#em").val("");
		}
	});
</script>
<!-- FIN -->
<script>
	// print order function
	function printFactura(id_factura) {
		$('#modal_vuelto').modal('hide');
		if (id_factura) {
			$.ajax({
				url: '../pdf/documentos/imprimir_cotizacion.php',
				type: 'post',
				data: {
					id_factura: id_factura
				},
				dataType: 'text',
				success: function(response) {
					var mywindow = window.open('', 'Stock Management System', 'height=400,width=600');
					mywindow.document.write('<html><head><title>Facturación</title>');
					mywindow.document.write('</head><body>');
					mywindow.document.write(response);
					mywindow.document.write('</body></html>');
					mywindow.document.close(); // necessary for IE >= 10
					mywindow.focus(); // necessary for IE >= 10
					mywindow.print();
					mywindow.close();
				} // /success function

			}); // /ajax function to fetch the printable order
		} // /if orderId
	} // /print order function
</script>
<script>
	function obtener_caja(user_id) {
		$(".outer_div3").load("../modal/carga_caja.php?user_id=" + user_id); //carga desde el ajax
	}
</script>
<script>
	function showDiv(select) {
		if (select.value == 4) {
			$("#resultados3").load("../ajax/carga_prima.php");
		} else {
			$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
</script>

<?php require 'includes/footer_end.php'
?>