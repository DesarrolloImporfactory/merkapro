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
$count      = mysqli_query($conexion, "select MAX(codigo_producto) as codigo from productos");
$rw         = mysqli_fetch_array($count);
$product_id = $rw['codigo'] + 1;
//consulta para elegir el impuesto en la modal
$query    = $conexion->query("select * from impuestos");
$impuesto = array();
while ($r = $query->fetch_object()) {$impuesto[] = $r;}
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>

<!-- Begin page -->
<div id="wrapper" class="forced enlarged"> <!-- DESACTIVA EL MENU -->

	<?php require 'includes/menu.php';?>

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
							<div class="portlet-heading" style="background: #171931">
								<h3 class="portlet-title">
									Productos
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
        include '../modal/registro_producto.php';
        include "../modal/editar_producto.php";
        include "../modal/editar_producto_2.php";
        include "../modal/eliminar_producto.php";
        include "../modal/registro_landing.php";
    }
    ?>

									<form class="form-horizontal" role="form" id="datos_cotizacion">
										<div class="form-group row">
											<div class="col-md-3">
												<div class="input-group">
													<input type="text" class="form-control" id="q" placeholder="Código o Nombre" onkeyup='load(1);'>
													</div>
												</div>
												<div class="col-md-3">
												<div class="input-group">
													<select name='categoria' id='categoria' class="form-control" onchange="load(1);">
														<option value="">-- Selecciona Linea --</option>
														<option value="">Todos</option>
														<?php

    $query_categoria = mysqli_query($conexion, "select * from lineas order by nombre_linea");
    while ($rw = mysqli_fetch_array($query_categoria)) {
        ?>
															<option value="<?php echo $rw['id_linea']; ?>"><?php echo $rw['nombre_linea']; ?></option>
															<?php
}
    ?>
													</select>
													<span class="input-group-btn">
														<button class="btn btn-outline-info btn-rounded waves-effect waves-light" type="button" onclick='load(1);'><i class='fa fa-search'></i></button>
													</span>
												</div>
												</div>
												<div class="col-md-2">
													<span id="loader"></span>
												</div>

												<div class="col-md-2">
													<div class="btn-group pull-right">
														<!--button type="button" class="btn btn-success btn-rounded waves-effect waves-light" data-toggle="modal" data-target="#nuevoProducto"><i class="fa fa-plus"></i> Agregar</button-->
													</div>

												</div>
													<div class="col-md-2">
													<div class="btn-group pull-right">
														<?php if ($permisos_editar == 1) {?>
														<div class="btn-group dropup">
															<button aria-expanded="false" class="btn btn-outline-default btn-rounded waves-effect waves-light" data-toggle="dropdown" type="button">
																<i class='fa fa-file-text'></i> Reporte
																<span class="caret">
																</span>
															</button>
															<div class="dropdown-menu">
																<a class="dropdown-item" href="#" onclick="reporte();">
																	<i class='fa fa-file-pdf-o'></i> PDF
																</a>
																<a class="dropdown-item" href="#" onclick="reporte_excel();">
																	<i class='fa fa-file-excel-o'></i> Excel
																</a>
															</div>
														</div>
														<?php }?>
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

			<?php require 'includes/pie.php';?>

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
	<script type="text/javascript" src="../../js/p_marketplace.js"></script>
	<script>
		function precio_venta(){
			var profit = $("#utilidad").val();
			var buying_price = $("#costo").val();

			var parametros = {"utilidad":profit,"costo":buying_price};
			$.ajax({
				dataType: "json",
				type:"POST",
				url:'../ajax/precio.php',
				data: parametros,
				success:function(data){
          //$("#datos").html(data).fadeIn('slow');
          $.each(data, function(index, element) {
          	var precio= element.precio;
          	$("#precio").val(precio);
          });


      }
  })
		}
		function precio_venta_edit(){
			var profit = $("#mod_utilidad").val();
			var buying_price = $("#mod_costo").val();

			var parametros = {"mod_utilidad":profit,"mod_costo":buying_price};
			$.ajax({
				dataType: "json",
				type:"POST",
				url:'../ajax/precio.php',
				data: parametros,
				success:function(data){
          //$("#datos").html(data).fadeIn('slow');
          $.each(data, function(index, element) {
          	var mod_precio= element.mod_precio;
          	$("#mod_precio").val(mod_precio);
          });


      }
  })
		}

	</script>
	<script>
		$(document).ready( function () {
			$(".UpperCase").on("keypress", function () {
				$input=$(this);
				setTimeout(function () {
					$input.val($input.val().toUpperCase());
				},50);
			})
		})
	</script>
	<script>
            function upload_image_a5(product_id){
			$("#load_img_a5").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile_a5");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile_a5',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_a5.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img_a5").html(data);

					}
				});

		}
                
            function upload_image_a4(product_id){
			$("#load_img_a4").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile_a4");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile_a4',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_a4.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img_a4").html(data);

					}
				});

		}
                
            function upload_image_a3(product_id){
			$("#load_img_a3").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile_a3");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile_a3',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_a3.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img_a3").html(data);

					}
				});

		}
                
            
            function upload_image_a2(product_id){
			$("#load_img_a2").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile_a2");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile_a2',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_a2.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img_a2").html(data);

					}
				});

		}
                
            function upload_image_a1(product_id){
			$("#load_img_a1").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile_a1");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile_a1',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_a1.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img_a1").html(data);

					}
				});

		}
                
		function upload_image(product_id){
			$("#load_img").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile',file);



			$.ajax({
					url: "../ajax/imagen_product_ajax.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img").html(data);

					}
				});

		}
                function upload_image1(product_id){
			$("#load_img1").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile1");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile1',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_url1.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img1").html(data);

					}
				});

		}
                
                    function upload_image2(product_id){
			$("#load_img2").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile2");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile2',file);
                        data.append('id_producto',product_id);



			$.ajax({
					url: "../ajax/imagen_product_ajax_url2.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img2").html(data);

					}
				});

		}
                
                
		function upload_image_mod(id_producto){
			$("#load_img_mod").text('Cargando...');
			var inputFileImage = document.getElementById("imagefile_mod");
			var file = inputFileImage.files[0];
			var data = new FormData();
			data.append('imagefile_mod',file);
			data.append('id_producto',id_producto);



			$.ajax({
					url: "../ajax/imagen_product_ajax2.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data: data, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
					contentType: false,       // The content type used when sending data to the server.
					cache: false,             // To unable request pages to be cached
					processData:false,        // To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
						$("#load_img_mod").html(data);

					}
				});

		}
	</script>
	<script>
		function carga_img(id_producto) {
                   //  alert(id_producto)
			$(".outer_img").load("../ajax/img.php?id_producto=" + id_producto);
                        $(".outer_img_a1").load("../ajax/img_a1.php?id_producto=" + id_producto);
                        $(".outer_img_a2").load("../ajax/img_a2.php?id_producto=" + id_producto);
                        $(".outer_img_a3").load("../ajax/img_a3.php?id_producto=" + id_producto);
                        $(".outer_img_a4").load("../ajax/img_a4.php?id_producto=" + id_producto);
                        $(".outer_img_a5").load("../ajax/img_a5.php?id_producto=" + id_producto);
		}
                function carga_img1(id_producto) {
                    //alert(id_producto)
			$(".outer_img2").load("../ajax/img_url1.php?id_producto=" + id_producto);
                        $(".outer_img22").load("../ajax/img_url2.php?id_producto=" + id_producto);
		}
               
		function reporte_excel(){
			var q=$("#q").val();
			window.location.replace("../excel/rep_productos.php?q="+q);
    //VentanaCentrada('../excel/rep_gastos.php?daterange='+daterange+"&employee_id="+employee_id,'Reporte','','500','25','true');+"&tipo="+tipo
}
function reporte(){
		var daterange=$("#range").val();
		var categoria=$("#categoria").val();
		VentanaCentrada('../pdf/documentos/rep_productos.php?daterange='+daterange+"&categoria="+categoria,'Reporte','','800','600','true');
	}
</script>
<?php require 'includes/footer_end.php'
?>

