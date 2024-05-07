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
$modulo = "Ventas";
permisos($modulo, $cadena_permisos);
//Finaliza Control de Permisos
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);
//consulta para elegir el comprobante
$query = $conexion->query("select * from comprobantes");
$tipo  = array();
while ($r = $query->fetch_object()) {$tipo[] = $r;}

//consulta para elegir el comprobante
$query_vendedor = $conexion->query("select * from users");
$vendedor  = array();
while ($r = $query_vendedor->fetch_object()) {$vendedor[] = $r;}
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>
<style>
     .agregar_producto:hover {
    cursor: pointer;
    background-color: lightskyblue;
  }
  .content_left_right {
      display: flex;
    }
 .fijo {
  position: -webkit-sticky !important; /* Para soporte en Safari */
  position: sticky !important;
  top: 0; /* Ajustar si es necesario */
  //z-index: 1020; /* Bootstrap utiliza 1030 para la navbar, así que usa un valor más bajo */
}
</style>
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
							<div class="portlet-heading bg-primary">
								<h3 class="portlet-title">
									Nueva Venta
								</h3>
								<div class="portlet-widgets">
									<div class="btn-group dropdown">
										<button type="button" class="btn btn-primary btn-sm dropdown-toggle waves-effect waves-light" data-toggle="dropdown" aria-expanded="false"> <i class='fa fa-dollar'></i> Caja<i class="caret"></i> </button>
										<div class="dropdown-menu dropdown-menu-right">
											<?php if ($permisos_editar == 1) {?>
											<a class="dropdown-item text-muted" href="#" data-toggle="modal" data-target="#caja" onclick="obtener_caja('<?php echo $user_id; ?>');"><i class='fa fa-search'></i>  Ver Caja</a>
											<?php }
    if ($permisos_eliminar == 1) {?>
											<a class="dropdown-item text-muted" href="#" data-toggle="modal" data-target="#myModal2" onclick="imprimir_factura('<?php echo $user_id; ?>');"><i class='fa fa-inbox'></i> Corte de Caja</a>
											<?php }
    ?>


										</div>
									</div>
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">
									<?php
include "../modal/buscar_productos_ventas.php";
include "../modal/buscar_productos_libre.php";
    include "../modal/registro_cliente.php";
    include "../modal/registro_producto.php";
    include "../modal/caja.php";
    include "../modal/anular_factura.php";
    ?>
									<div class="row content_left_right">
										<div class="col-lg-6">
											<div class="card-box">

												<div class="widget-chart">
													<div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
													<form class="form-horizontal" role="form" id="barcode_form">
                                                                                                          
                                                                                                            <audio id="myAudio">
  <source src="../../img_sistema/agregar.mp3" type="audio/mp3">
  Tu navegador no soporta el elemento de audio.
</audio>
                                                                                                            
                                                                                                            <audio id="myAudioEliminar">
  <source src="../../img_sistema/eliminar.mp3" type="audio/mp3">
  Tu navegador no soporta el elemento de audio.
</audio>
														<div class="form-group row">
															<label for="barcode_qty" class="col-md-1 control-label">Cant:</label>
															<div class="col-md-2">
																<input type="text" class="form-control formulario" id="barcode_qty" value="1" autocomplete="off">
															</div>

															<label for="barcode" class="control-label">Codigo:</label>
															<div class="col-md-5" align="left">
																<div class="input-group">
																	<input type="text" class="form-control formulario_derecha" id="barcode" autocomplete="off"  tabindex="1" autofocus="true" >
																	<span class="input-group-btn">
																		<button type="submit" class="btn btn-default"><span class="fa fa-barcode "></span></button>
																	</span>
																</div>
															</div>
                                                                                                                        
   
															<div class="col-md-2">
																
                                                                                                                          <div class="btn-group">                                                                                                                     
 <button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light formulario" data-toggle="modal" data-target="#buscar">
																	<span class="fa fa-search"></span> Buscar
																</button>
                                                                                                                           
                                                                                                                            
</div>
															</div>
														</div>
                                                                                                            <div class="form-group row">
                                                                                                                <?php

												$query_producto = mysqli_query($conexion, "select * from productos where drogshipin=0 order by id_producto");
												while ($row = mysqli_fetch_array($query_producto)) {
                                                                              
                                                                                                     $id_producto          = $row['id_producto'];
            $codigo_producto      = $row['codigo_producto'];
            $nombre_producto      = $row['nombre_producto'];
            $descripcion_producto = $row['descripcion_producto'];
            $linea_producto       = $row['id_linea_producto'];
            $med_producto         = $row['id_med_producto'];
            $id_proveedor         = $row['id_proveedor'];
            $inv_producto         = $row['inv_producto'];
            $impuesto_producto    = $row['iva_producto'];
            $costo_producto       = $row['costo_producto'];
            $utilidad_producto    = $row['utilidad_producto'];
            $precio_producto      = $row['valor1_producto'];
            $precio_mayoreo       = $row['valor2_producto'];
            $precio_especial      = $row['valor3_producto'];
            $precio_normal        = $row['valor4_producto'];
            $stock_producto       = $row['stock_producto'];
            $stock_min_producto   = $row['stock_min_producto'];
            $tienda      = $row['tienda'];
            $image_path           = $row['image_path'];
												?>
                                                                                                                                      <div  class="col-md-3" >
                                                                                                                                          <div  style="padding:10px; min-height: 125px"  align="center" class="card agregar_producto" onclick="agregar_pos('<?php echo $id_producto;?>')">
    <div  class="card-body">
                                                                                                            <?php
if ($image_path == null) {
                echo '<img src="../../img_sistema/LOGOS-IMPORSUIT.jpg" class="" width="100%" style="max-height:280px; min-height:100px !important;">';
            } else {
                echo '<img src="' . $image_path . '" class="" width="100%" style="max-height:280px; min-height:100px !important;">';
            }

            ?>
        <input type="hidden" class="form-control" style="text-align:right" id="pos_precio_venta_<?php echo $id_producto; ?>"  value="<?php echo $precio_producto; ?>" >
        <input type="hidden" class="form-control" style="text-align:center" id="pos_cantidad_<?php echo $id_producto; ?>"  value="1" >
        <p style="font-size: 8px; margin-bottom: 0px !important;"><?php echo $nombre_producto; ?></br>
    <?php echo stock_punto($stock_producto); ?>
   <strong> $ <?php echo number_format($precio_producto, 2, '.', ''); ?></strong></p>
    
    
    
   
  </div>
                                                                                                                 </div>
                                                                                                             </div>
												<?php
												}
												?>
                                                                                                                </div>
                                                                                                                
													</form>

													

												</div>
											</div>

										</div>

                                                                            <div style="" class="fijo col-lg-6">
											<div class="card-box">
												<div class="widget-chart">
													<form role="form" id="datos_factura">
														<div class="form-group row">
															<label class="col-2 col-form-label"></label>
															<div class="col-12">
                                                                                                                             <div id="outer_comprobante"></div><!-- Carga los datos ajax -->
																<div class="input-group">
																	<input type="text" id="nombre_cliente" class="form-control formulario_derecha" placeholder="Buscar Cliente" required  tabindex="2">
																	<span class="input-group-btn">
																		<button type="button" class="btn waves-effect waves-light btn-success " data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
																	</span>
																	<input id="id_cliente" name="id_cliente" type='hidden'>
																</div>
															</div>
														</div>
                                                                                                           
																<div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading" data-toggle="collapse" data-parent="#accordion" data-target="#panel1">Editar informaciòn del Cliente &#9660;</div>
      <div id="panel1" class="panel-collapse collapse">
        <div class="panel-body">
            <div class="row">
           <div class="col-md-4">
																
																	<strong>Nombre: </strong>
                                                                                                                                        <input type="text" class="form-control formulario" autocomplete="off" id="nombre_fac" name="rnc" >
                                                                                                                                        
        </div>
            <div class="col-md-4">
																<div class="form-group">
																	<strong>Email: </strong>
                                                                                                                                        <input type="text" class="form-control formulario" autocomplete="off" id="email_fac" name="telefono_fac" >
                                                                                                                                        
        </div></div>
            
                </div>
            <div class="row">
           <div class="col-md-4">
																
																	<strong>RUC/Cédula: </strong>
                                                                                                                                        <input type="text" class="form-control formulario" autocomplete="off" id="rnc" name="rnc" >
                                                                                                                                        
        </div>
            <div class="col-md-4">
																<div class="form-group">
																	<strong>Teléfono: </strong>
                                                                                                                                        <input type="text" class="form-control formulario" autocomplete="off" id="telefono_fac" name="telefono_fac">
                                                                                                                                        
        </div></div>
            <div class="col-md-4">
																<div class="form-group">
																	<strong>Direccón: </strong>
                                                                                                                                        <input type="text" class="form-control formulario" autocomplete="off" id="direccion_fac" name="direccion_fac">
                                                                                                                                        
        </div></div>
                </div>
            <div class="row">
                
            </div>
            
            
      </div>
    </div>
    
    
  </div>
</div>
                                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group row">
                                                                                                            <div id="resultados" class='col-md-12' style="margin-top:10px; font-size: 10px"></div><!-- Carga los datos ajax -->
                                                                                                            </div>
                                                                                                            <div class="row">
                                                                                                                <input id = "id_comp" class = "form-control" name = "id_comp" value="1" required autocomplete="off" type="hidden">
                                                                                                                 <input id = "id_vend" class = "form-control" name = "id_vend" value="<?php echo $user_id ?>" required autocomplete="off" type="hidden">
                                                                                                                 <input id = "tipo_doc" class = "form-control" name = "tipo_doc" value="1" required autocomplete="off" type="hidden">
                                                                                                                 <input id = "trans" class = "form-control" name = "trans" value="" required autocomplete="off" type="hidden">
                                                                                                               
                                                                                                                </div>
                                                                                                                
														<div class="row">
															
															
																	
                                                                                                                                        
																		
																
															
                                                                                                                  

														</div>
														<div class="row">
															
															<div class="col-md-6">
																<div class="form-group">
																	<div id="resultados4"></div><!-- Carga los datos ajax -->
																</div>
																<div id="resultados5"></div><!-- Carga los datos ajax -->
															</div>
														</div>

														<div class="row">
															<div class="col-md-3">
																<div class="form-group">
																	<label for="condiciones">Pago</label>
																	<select class="form-control input-sm condiciones formulario" id="condiciones" name="condiciones" onchange="showDiv(this)">
																		<option value="1">Efectivo</option>
																		<option value="2">Cheque</option>
																		<option value="3">Transferencia bancaria</option>
																		<option value="4">Crédito</option>
																	</select>
																</div>
															</div>
															
                                                                                                                    <div class="col-md-3">
																<div class="form-group">
																	<label for="condiciones">Forma de Pago</label>
																	<select class="form-control formulario" id="formaPago" name="formaPago" required="required">
																		<option value="01">SIN UTILIZACION DEL SISTEMA FINANCIERO</option>
																		<option value="15">COMPENSACIÓN DE DEUDAS</option>
																		<option value="16">TARJETA DE DÉBITO</option>
																		<option value="17">DINERO ELECTRÓNICO</option>
																		<option value="18">TARJETA PREPAGO</option>
																		<option value="19">TARJETA DE CRÉDITO</option>
																		<option value="20">OTROS CON UTILIZACION DEL SISTEMA FINANCIERO</option>
																		<option value="21">ENDOSO DE TÍTULOS</option>

																	</select>
																</div>
															</div>
                                                                                                                    <div class="col-md-3">
																<div class="form-group">
																	<label for="condiciones">Plazo D&iacute;as</label>
																	<input type="text" class="form-control formulario" id="plazodias" name="plazodias" value="1" required="required">
																</div>
															</div>
                                                                                                                    <div class="col-md-3">
																<div class="form-group">
                                                                                                                                    <label for="resibido">Dinero Recibido</label>
																	<input type="text" class="form-control resibido formulario" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" autocomplete="off" id="resibido" required name="resibido" tabindex="3">
																</div>
															</div>
														</div>
														

														<div class="col-md-12" align="center">
															<button type="submit" id="guardar_factura" class="btn btn-danger btn-block btn-lg waves-effect waves-light formulario" aria-haspopup="true" aria-expanded="false"><span class="fa fa-save"></span> Pagar</button>
															<!--<br><br>
															<button type="button" id="imprimir" class="btn btn-default waves-effect waves-light" onclick="printOrder('1');" accesskey="t" ><span class="fa fa-print"></span> Ticket</button>
															<button type="button" id="imprimir2" class="btn btn-default waves-effect waves-light" onclick="printFactura('1');" accesskey="p"><span class="fa fa-print"></span> Factura</button>-->
														</div>
													</form>

												</div>
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
<script type="text/javascript" src="../../js/venta.js"></script>
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de Clientes -->
<script>
    function editar_datos(){
        
    }
	$(function() {
		$("#nombre_cliente").autocomplete({
			source: "../ajax/autocomplete/clientes.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_cliente').val(ui.item.id_cliente);
				$('#nombre_cliente').val(ui.item.nombre_cliente);
				$('#rnc').val(ui.item.fiscal_cliente);
                                //alert(ui.item.fiscal_cliente);
                                $('#telefono_fac').val(ui.item.telefono_cliente);
                                $('#direccion_fac').val(ui.item.direccion_cliente);
                                $('#nombre_fac').val(ui.item.nombre_cliente);
                                $('#email_fac').val(ui.item.email_cliente);
				$.Notification.notify('custom','bottom right','EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
			}
		});
	});

	$("#nombre_cliente" ).on( "keydown", function( event ) {
		if (event.keyCode== $.ui.keyCode.LEFT || event.keyCode== $.ui.keyCode.RIGHT || event.keyCode== $.ui.keyCode.UP || event.keyCode== $.ui.keyCode.DOWN || event.keyCode== $.ui.keyCode.DELETE || event.keyCode== $.ui.keyCode.BACKSPACE )
		{
			$("#id_cliente" ).val("");
			$("#rnc" ).val("");
			$("#resultados4").load("../ajax/tipo_doc.php");
		}
		if (event.keyCode==$.ui.keyCode.DELETE){
			$("#nombre_cliente" ).val("");
			$("#id_cliente" ).val("");
			$("#rnc" ).val("");
		}
	});
</script>
<!-- FIN -->
<script>
// print order function
function printOrder(id_factura) {
	$('#modal_vuelto').modal('hide');//CIERRA LA MODAL
	if (id_factura) {
		$.ajax({
			url: '../pdf/documentos/imprimir_venta.php',
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
// print order function
function printFactura(id_factura) {
	$('#modal_vuelto').modal('hide');
	if (id_factura) {
		$.ajax({
			url: '../pdf/documentos/imprimir_factura_venta.php',
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
		$(".outer_div3").load("../modal/carga_caja.php?user_id=" + user_id);//carga desde el ajax
	}
</script>
<script>
	function showDiv(select){
		if(select.value==4){
			$("#resultados3").load("../ajax/carga_prima.php");
		} else{
			$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
	function comprobar(select){
		var rnc = $("#rnc").val();
		if(select.value==1 && rnc==''){
			$.Notification.notify('warning','bottom center','NOTIFICACIÓN', 'AL CLIENTE SELECCIONADO NO SE LE PUEDE IMPRIR LA FACTURA, NO TIENE RNC/DEDULA REGISTRADO')
			$("#resultados4").load("../ajax/tipo_doc.php");
		} else{
			//$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
        
         $('#direccion_fac').on('input', function() {
            // Obtener el valor del input
            var nuevoRNC = $(this).val();
            id_cliente=$('#id_cliente').val();
            //alert();
            // Enviar el nuevo RNC al servidor mediante AJAX
            $.ajax({
                url: '../ajax/actualizar_direccion_cliente.php', // Ruta del archivo PHP que procesará la actualización
                type: 'POST',
                data: { rnc: nuevoRNC, id_cliente:id_cliente, }, // Datos a enviar al servidor
                success: function(response) {
                    // Manejar la respuesta del servidor (puede ser un mensaje de éxito o error)
                    console.log(response);
                },
                error: function(xhr, status, error) {
                    // Manejar errores de la petición AJAX
                    console.error(xhr.responseText);
                }
            });
        });
        
        
</script>
<script>
  function getval(sel)
  {
    $.Notification.notify('success', 'bottom center', 'NOTIFICACIÓN', 'CAMBIO DE COMPROBANTE')
    $("#outer_comprobante").load("../ajax/carga_correlativos.php?id_comp="+sel.value);

  }
</script>



