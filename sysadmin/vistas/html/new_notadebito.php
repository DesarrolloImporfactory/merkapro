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
									Nueva Nota D&eacute;bito
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
									<div class="row">
										<div class="col-lg-12">
											<div class="card-box">
												<div class="widget-chart">
													<form id="form_debito" method="post" action="../ajax/guardar_notadebito.php">
														<div class="form-group row">
															<label for="fecha" class="col-md-1 control-label">Fecha Emisi&oacute;n:</label>
															<div class="col-md-3">
																<input type="date" class="form-control" id="fechaEmision" name="fechaEmision" required="required" autocomplete="off"/>
																<!--<input type="text" class="form-control" id="barcode_qty" value="1" autocomplete="off">-->
															</div>
															<label for="condiciones" class="control-label">Tipo Documento:</label>
															<div class="col-md-3" align="left">
																<div class="input-group">
																	<select class="form-control"  name="tipoDocumentodebito" id="tipoDocumentodebito" required="required">
																		<option value="01">Factura</option>
																	</select>
																	<!--<input type="text" class="form-control" id="barcode" autocomplete="off"  tabindex="1" autofocus="true" >-->
																</div>
															</div>
															
														</div>
														<div class="form-group row">
															<label for="condiciones" class="control-label">Fecha Doc Modificado: </label>
															<div class="col-md-3" >
																<input type="date" id="fechaDocModificado" class="form-control" name="fechaDocModificado" required="required" autocomplete="off" />
															</div>
															<label for="fecha" class="col-md-3 control-label">Nro Comprobante:</label>
															<div class="col-md-3">
																<input type="text" id="numeroDocMod" class="form-control" name="numeroDocMod" required="required" placeholder="###-###-#########">
																<!--<input type="text" class="form-control" id="barcode_qty" value="1" autocomplete="off">-->
															</div>
														</div>
														<div class="form-group row">
															<div class="col-md-8">
																<div class="col-md-2">
																	<div class="btn-group">                                                                                                                     
																		<!--<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar">
																				<span class="fa fa-search"></span> Buscar
																			</button>
																															
																																<button type="button" accesskey="a" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#libre">
																			<span class="fa fa-plus"></span> Libre
																		</button>-->
																		<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" id="nuevoDetalle" >
																			<i class="fa fa-plus"> Nuevo</i>
																		</button>
																	</div>
																</div>
																<div class='col-md-12' style="margin-top:10px">
																	<div class="table-responsive">
																		<table class="table table-sm" id="detalles">
																			<thead class="thead-default">
																				<tr>
																					<th>Razón Modificación</th>
																					<th>Valor Modificación</th>
																					<th></th>
																				</tr>
																			</thead>
																			<tbody>
																				<tr>

																				</tr>
																				<tr>
																					<td class="text-right" colspan="1">SubTotal Sin Impuesto</td>
																					<td class="text-right"><b>$ <span id="subTotalSinImpuesto">0.00</span></b><input type="hidden" id="subTotalSinImpuesto2" name="subTotalSinImpuesto2" ></td>
																					
																					<td></td>
																				</tr>
																				<tr>
																					<td class="text-right" colspan="1">SUBTOTAL 12%</td>
																					<td class="text-right"><b>$ <span id="subTotal12">0.00</span></b><input type="hidden" id="subTotal122" name="subTotal122"></td>
																					<td></td>
																				</tr>
																				<tr>
																					<td class="text-right" colspan="1">SUBTOTAL 0%</td>
																					<td class="text-right"><b>$ <span id="subTotal0">0.00</span></b></td>
																					<td></td>
																				</tr>
																				<tr>
																					<td class="text-right" colspan="1">IVA (12)% </td>
																					<td class="text-right">$ <span id="iva12">0.00</span>    </td>
																					<td></td>
																				</tr>
																				<tr>
																					<td style="font-size: 14pt;" class="text-right" colspan="1"><b>TOTAL $</b></td>
																					<td style="font-size: 16pt;" class="text-right"><b><span id="valorTotal">0.00</span></b><input type="hidden" id="valorTotal2" name="valorTotal2"></td>
																					<td></td>
																				</tr>
																			</tbody>
																		</table>
																	</div>
																</div>
															</div>
															<div class="col-md-4">
																<div class="form-group row">
																	<label class="col-2 col-form-label"></label>
																	<div class="col-12">
																		<div class="input-group">
																			<input type="text" id="nombre_cliente" class="form-control" placeholder="Buscar Cliente" required  tabindex="2">
																			<span class="input-group-btn">
																				<button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
																			</span>
																			<input id="id_cliente" name="id_cliente" type='hidden'>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="fiscal">RNC/Cedula</label>
																				<input type="text" class="form-control" autocomplete="off" id="rnc" name="rnc" disabled="true">
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="id_comp" class="control-label">Comprobante:</label>
																				<select id = "id_comp" class = "form-control" name = "id_comp" required autocomplete="off" onchange="getval(this);">
																					<option value="">-SELECCIONE-</option>
																					<?php foreach ($tipo as $c): ?>
																						<option value="<?php echo $c->id_comp; ?>"><?php echo $c->nombre_comp; ?></option>
																					<?php endforeach;?>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="id_comp" class="control-label">Vendedor:</label>
																				<select id = "id_vend" class = "form-control" name = "id_vend" required autocomplete="off" >
																					<option value="">-SELECCIONE-</option>
																					<?php foreach ($vendedor as $v): ?>
																						<option value="<?php echo $v->id_users; ?>"><?php echo $v->nombre_users.' '.$v->apellido_users; ?></option>
																					<?php endforeach;?>
																				</select>
																			</div>
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="fiscal">No. Comprobante</label>
																				<div id="outer_comprobante"></div><!-- Carga los datos ajax -->
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<div id="resultados4"></div><!-- Carga los datos ajax -->
																			</div>
																			<div id="resultados5"></div><!-- Carga los datos ajax -->
																		</div>
																	</div>
																	<div class="row">
																		<div class="col-md-6">
																			<div class="form-group">
																				<label for="condiciones">Pago</label>
																				<select class="form-control input-sm condiciones" id="condiciones" name="condiciones" onchange="showDiv(this)">
																					<option value="1">Efectivo</option>
																					<option value="2">Cheque</option>
																					<option value="3">Transferencia bancaria</option>
																					<option value="4">Crédito</option>
																				</select>
																			</div>
																		</div>
																		<div class="col-md-6">
																			<div class="form-group">
																				<div id="resultados3"></div><!-- Carga los datos ajax del incremento de la fatura -->
																			</div>
																		</div>
																	</div>
																	<div class="col-md-12" align="center">

																		<!--<button type="submit" id="guardar_factura" class="btn btn-danger btn-block btn-lg waves-effect waves-light" aria-haspopup="true" aria-expanded="false"><span class="fa fa-save"></span> Guardar</button>-->
																		<input type="submit" style="display: none" id="guardar_notadeb">
																		<button type="button" id="guardar_debito" class="btn btn-danger btn-block btn-lg waves-effect waves-light" aria-haspopup="true" aria-expanded="false"><span class="fa fa-save"></span> Guardar</button>
																			<!--<br><br>
																			<button type="button" id="imprimir" class="btn btn-default waves-effect waves-light" onclick="printOrder('1');" accesskey="t" ><span class="fa fa-print"></span> Ticket</button>
																			<button type="button" id="imprimir2" class="btn btn-default waves-effect waves-light" onclick="printFactura('1');" accesskey="p"><span class="fa fa-print"></span> Factura</button>-->
																	</div>
																</div>
															</div>
														</div>
														
														
													</form>
												</div>
											</div>
										</div>
										<!--<div class="col-lg-8">
											<div class="card-box">

												<div class="widget-chart">
													<div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div> Carga los datos ajax
													<form class="form-horizontal" role="form" id="barcode_form">
														
														<div class="form-group row">
															<label for="barcode_qty" class="col-md-1 control-label">Cant:</label>
															<div class="col-md-2">
																<input type="text" class="form-control" id="barcode_qty" value="1" autocomplete="off">
															</div>

															<label for="condiciones" class="control-label">Codigo:</label>
															<div class="col-md-5" align="left">
																<div class="input-group">
																	<input type="text" class="form-control" id="barcode" autocomplete="off"  tabindex="1" autofocus="true" >
																	<span class="input-group-btn">
																		<button type="submit" class="btn btn-default"><span class="fa fa-barcode"></span></button>
																	</span>
																</div>
															</div>
											                                                       
   
															<div class="col-md-2">
																<div class="btn-group">                                                                                                                     
 																		<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar">
																	<span class="fa fa-search"></span> Buscar
																</button>
                                                                                                                           
                                                                                                                            <button type="button" accesskey="a" class="btn btn-warning waves-effect waves-light" data-toggle="modal" data-target="#libre">
																	<span class="fa fa-plus"></span> Libre
																</button>
																</div>
															</div>
														</div>
													</form>

													<div id="resultados" class='col-md-12' style="margin-top:10px"></div> Carga los datos ajax 

												</div>
											</div>

										</div>

										<div class="col-lg-4">
											<div class="card-box">
												<div class="widget-chart">
													<form role="form" id="datos_credito">
														<div class="form-group row">
															<label class="col-2 col-form-label"></label>
															<div class="col-12">
																<div class="input-group">
																	<input type="text" id="nombre_cliente" class="form-control" placeholder="Buscar Cliente" required  tabindex="2">
																	<span class="input-group-btn">
																		<button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
																	</span>
																	<input id="id_cliente" name="id_cliente" type='hidden'>

																	<input id="fechaEmision2" name="fechaEmision2" type='hidden'>
																	<input id="tipoDocumentocredito2" name="tipoDocumentocredito2" type='hidden'>
																	<input id="fechaDocModificado2" name="fechaDocModificado2" type='hidden'>
																	<input id="numeroDocMod2" name="numeroDocMod2" type='hidden'>
																	<input id="motivo2" name="motivo2" type='hidden'>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">RNC/Cedula</label>
																	<input type="text" class="form-control" autocomplete="off" id="rnc" name="rnc" disabled="true">
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<label for="id_comp" class="control-label">Comprobante:</label>
																	<select id = "id_comp" class = "form-control" name = "id_comp" required autocomplete="off" onchange="getval(this);">
																		<option value="">-SELECCIONE-</option>
																		<?php foreach ($tipo as $c): ?>
																			<option value="<?php echo $c->id_comp; ?>"><?php echo $c->nombre_comp; ?></option>
																		<?php endforeach;?>
																	</select>
																</div>
															</div>
                                                                                                                    <div class="col-md-6">
																<div class="form-group">
																	<label for="id_comp" class="control-label">Vendedor:</label>
																	<select id = "id_vend" class = "form-control" name = "id_vend" required autocomplete="off" >
																		<option value="">-SELECCIONE-</option>
																		<?php foreach ($vendedor as $v): ?>
																			<option value="<?php echo $v->id_users; ?>"><?php echo $v->nombre_users.' '.$v->apellido_users; ?></option>
																		<?php endforeach;?>
																	</select>
																</div>
															</div>

														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">No. Comprobante</label>
																	<div id="outer_comprobante"></div> Carga los datos ajax
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<div id="resultados4"></div> Carga los datos ajax 
																</div>
																<div id="resultados5"></div> Carga los datos ajax 
															</div>
														</div>

														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="condiciones">Pago</label>
																	<select class="form-control input-sm condiciones" id="condiciones" name="condiciones" onchange="showDiv(this)">
																		<option value="1">Efectivo</option>
																		<option value="2">Cheque</option>
																		<option value="3">Transferencia bancaria</option>
																		<option value="4">Crédito</option>
																	</select>
																</div>
															</div>
															<div class="col-md-6">
																<div class="form-group">
																	<div id="resultados3"></div> Carga los datos ajax del incremento de la fatura 
																</div>
															</div>
														</div>

														<div class="col-md-12" align="center">
															<button type="submit" id="guardar_factura" class="btn btn-danger btn-block btn-lg waves-effect waves-light" aria-haspopup="true" aria-expanded="false"><span class="fa fa-save"></span> Guardar</button>
															<br><br>
															<button type="button" id="imprimir" class="btn btn-default waves-effect waves-light" onclick="printOrder('1');" accesskey="t" ><span class="fa fa-print"></span> Ticket</button>
															<button type="button" id="imprimir2" class="btn btn-default waves-effect waves-light" onclick="printFactura('1');" accesskey="p"><span class="fa fa-print"></span> Factura</button>
														</div>
													</form>

												</div>
											</div>

										</div> -->

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
<!--<script type="text/javascript" src="../../js/notadebito.js"></script>-->
<!-- ============================================================== -->
<!-- Codigos Para el Auto complete de Clientes -->
<script>
	var count = 0;
	$(function() {
		$("#nombre_cliente").autocomplete({
			source: "../ajax/autocomplete/clientes.php",
			minLength: 2,
			select: function(event, ui) {
				event.preventDefault();
				$('#id_cliente').val(ui.item.id_cliente);
				$('#nombre_cliente').val(ui.item.nombre_cliente);
				$('#rnc').val(ui.item.fiscal_cliente);
				$.Notification.notify('custom','bottom right','EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
			}
		});
	});
	$("#nuevoDetalle").click(function() {
        count = count + 1;
        $('#detalles tbody tr:first').before("<tr>"
												+"<td><input type = 'text' name = 'motivo[" + count + "]' required='required' class='form-cotrol'/></td>"
												+"<td><input type = 'text' name = 'valorMod[" + count + "]' class = 'valor form-cotrol' id = 'valorMod" + count + "' required='required' onchange = 'calcularValores()'/></td>"
												+"<td> <button class='btn btn-danger link-boton accion'  type='button' onclick = 'eliminarFila(this)'><i class='fa fa-trash icon-white'></i></button></td>"
											+"</tr>");
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

	function eliminarFila(e) {
                        $(e).parent().parent().remove();
                        calcularValores();
                    }

                    function calcularValores() {
                        var subTotalSinImpuesto = 0;
                        $(".valor").each(function(index, element) {
                            subTotalSinImpuesto += parseFloat($(element).val());
                        });
                        $("#subTotalSinImpuesto").text(subTotalSinImpuesto.toFixed(2));
                        $("#subTotalSinImpuesto2").val(subTotalSinImpuesto.toFixed(2));
                        calcularTotal();
                    }

                    function calcularTotal() {
                        var total = 0;
                        var iva12 = 0;
                        if ($('input:radio[name=impuesto]:checked').val() == '2') {
                            iva12 = parseFloat($("#subTotalSinImpuesto").text()) * 0.12;
                            $("#iva12").text(iva12.toFixed(2));
                        } else {
                            $("#iva12").text('0.00');
                        }

                        total = (iva12 + parseFloat($("#subTotalSinImpuesto").text())).toFixed(2);
                        $("#valorTotal").text(total);
                        $("#valorTotal2").val(total);

                        $("#subTotal12").text("0.00");
                        $("#subTotal122").val("0.00");
                        
                        $("#subTotal0").text("0.00");
                        $("#subTotaNoObjeto").text("0.00");
                        $("#subTotaExento").text("0.00");
                        var subTotalSinImpuesto = $("#subTotalSinImpuesto").text()
                        var checked = $('input:radio[name=impuesto]:checked').val();
                        if (checked == '2') {
                            $("#subTotal12").text(subTotalSinImpuesto);
                            $("#subTotal122").val(subTotalSinImpuesto);
                        } else if (checked == '0') {
                            $("#subTotal0").text(subTotalSinImpuesto);
                        }
                        else if (checked == '6') {
                            $("#subTotaNoObjeto").text(subTotalSinImpuesto);
                        }
                        else if (checked == '7') {
                            $("#subTotaExento").text(subTotalSinImpuesto);
                        }
                    }

                    $("input[name=impuesto]").change(function() {
                        calcularTotal();
                    });

                    $("#valorICE").change(function(e) {
                        if (parseFloat($("#valorICE").val()) > 0) {
                            $("#codICE").prop('disabled', false);
                        } else {
                            $("#codICE").prop('disabled', true);
                            $("#codICE").val("");
                        }
                    });

			$("#guardar_debito").click(function() { 
				
                let filas = $("#detalles").find('tbody tr').length;
                    //var nFilas = $("#carrito > tr").length;
                if( filas == 6){
					swal({
						title: 'No hay ningun elemento en la tabla Nota debito',
						text: 'Intentar Nuevamente',
						type: 'error',
						confirmButtonText: 'ok'
          			})
                        //alert('entra');
                    /*$('#detalles > tbody:last').append('<tr class="warning-element" style="border-left: 2px solid #ff5050 !important; background: #fce3e3;" id="mensajeregistro"><td class="text-center" colspan=9><h4>NO HAY DETALLES AGREGADOS</h4></td></tr>');     
                        //$('#productosagregados tbody:last').append("<tr><td><h1>hola</h1></td></tr>");
                    $("#submitPago").attr('disabled', true);*/
                }else{
                    $("#guardar_notadeb").click();
                }
                    
                
				/*swal({
					title: 'DINERO RESIBIDO ES MENOR AL MONTO TOTAL',
					text: 'Intentar Nuevamente',
					type: 'error',
					confirmButtonText: 'ok'
          		})*/
				/*for(var i=0; i<7;i++)
				{
					var id = "#toggle"+ (i+1);
					$(id).addClass("show");

				}   */
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
</script>
<script>
  function getval(sel)
  {
    $.Notification.notify('success', 'bottom center', 'NOTIFICACIÓN', 'CAMBIO DE COMPROBANTE')
    $("#outer_comprobante").load("../ajax/carga_correlativos.php?id_comp="+sel.value);

  }
</script>

<?php require 'includes/footer_end.php'
?>

