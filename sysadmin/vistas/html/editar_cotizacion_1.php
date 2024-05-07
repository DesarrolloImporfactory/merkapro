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
$title          = "Pedidos";
$Ventas         = 1;
$nombre_usuario = get_row('users', 'usuario_users', 'id_users', $user_id);

if (isset($_GET['id_factura'])) {
    $id_factura  = intval($_GET['id_factura']);
    $campos      = "clientes.id_cliente, clientes.nombre_cliente, clientes.fiscal_cliente, clientes.email_cliente, facturas_cot.id_vendedor, facturas_cot.fecha_factura, facturas_cot.condiciones, facturas_cot.validez, facturas_cot.numero_factura, facturas_cot.nombre,facturas_cot.telefono, facturas_cot.provincia,facturas_cot.c_principal,facturas_cot.c_secundaria,facturas_cot.referencia, facturas_cot.observacion, facturas_cot.ciudad_cot, facturas_cot.guia_enviada";
    //echo "select $campos from facturas_cot, clientes where facturas_cot.id_cliente=clientes.id_cliente and id_factura='" . $id_factura . "'";
    $sql_factura = mysqli_query($conexion, "select $campos from facturas_cot, clientes where facturas_cot.id_cliente=clientes.id_cliente and id_factura='" . $id_factura . "'");
    $count       = mysqli_num_rows($sql_factura);
    if ($count == 1) {
        $rw_factura                 = mysqli_fetch_array($sql_factura);
        $id_cliente                 = $rw_factura['id_cliente'];
        $nombre_cliente             = $rw_factura['nombre_cliente'];
        $fiscal_cliente             = $rw_factura['fiscal_cliente'];
        $email_cliente              = $rw_factura['email_cliente'];
        $id_vendedor_db             = $rw_factura['id_vendedor'];
        $fecha_factura              = date("d/m/Y", strtotime($rw_factura['fecha_factura']));
        $condiciones                = $rw_factura['condiciones'];
        $validez                    = $rw_factura['validez'];
        $numero_factura             = $rw_factura['numero_factura'];
        
        $nombredestino            = $rw_factura['nombre'];
        $provinciadestino             = $rw_factura['provincia'];
        $ciudaddestino             = $rw_factura['ciudad_cot'];
        $guia_enviada             = $rw_factura['guia_enviada'];
        
        $direccion =$rw_factura['c_principal'].' '.$rw_factura['c_secundaria'];
    $referencia =$rw_factura['referencia'];
    $telefono =$rw_factura['telefono'];
    $observacion =$rw_factura['observacion'];
        
    //calcular segun la ciudad
    $valor_base= get_row('ciudad_laar', 'precio', 'codigo', $ciudaddestino);
    
        
        
        $_SESSION['id_factura']     = $id_factura;
        $_SESSION['numero_factura'] = $numero_factura;
    } else {
        //header("location: facturas.php");
        exit;
    }
} else {
    //header("location: facturas.php");
    exit;
}
//consulta para elegir el comprobante
$query = $conexion->query("select * from comprobantes");
$tipo  = array();
while ($r = $query->fetch_object()) {$tipo[] = $r;}
?>

<?php require 'includes/header_start.php';?>

<?php require 'includes/header_end.php';?>
<style>
   

.stepwizard-step p {
    margin-top: 10px;    
}

.stepwizard-row {
    display: table-row;
}

.stepwizard {
    display: table;     
    width: 100%;
    position: relative;
}

.stepwizard-step button[disabled] {
    opacity: 1 !important;
    filter: alpha(opacity=100) !important;
}

.stepwizard-row:before {
    top: 14px;
    bottom: 0;
    position: absolute;
    content: " ";
    width: 100%;
    height: 1px;
    background-color: #ccc;
    z-order: 0;
    
}

.stepwizard-step {    
    display: table-cell;
    text-align: center;
    position: relative;
}

.btn-circle {
  width: 30px;
  height: 30px;
  text-align: center;
  padding: 6px 0;
  font-size: 12px;
  line-height: 1.428571429;
  border-radius: 15px;
}
</style>
<!-- Begin page -->
<div id="wrapper" class="forced enlarged">

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
									Editar Pedido
								</h3>
								<div class="portlet-widgets">
								</div>
								<div class="clearfix"></div>
							</div>
							<div id="bg-primary" class="panel-collapse collapse show">
								<div class="portlet-body">
									<?php
include "../modal/buscar_productos_ventas.php";
    include "../modal/registro_cliente.php";
    include "../modal/registro_producto.php";
    include "../modal/caja.php";
    ?>
									<div class="row">
										<div class="col-lg-8">
											<div class="card-box">

												<div class="widget-chart">
													<div id="resultados_ajaxf" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
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
																<button type="button" accesskey="a" class="btn btn-primary waves-effect waves-light" data-toggle="modal" data-target="#buscar">
																	<span class="fa fa-search"></span> Buscar
																</button>
															</div>
														</div>
													</form>
                                                                                                        
                                                                                                        <div class="table-responsive">												<div id="resultados" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
<!--div class="stepwizard">
    <div class="stepwizard-row">
        <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle">1</button>
            <p>Ingresdo</p>
        </div>
        <div class="stepwizard-step">
            <button type="button" class="btn btn-primary btn-circle">2</button>
            <p>Preparado</p>
        </div>
        <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
            <p>Impreso</p>
        </div> 
         <div class="stepwizard-step">
            <button type="button" class="btn btn-default btn-circle" disabled="disabled">3</button>
            <p>Impreso</p>
        </div> 
    </div>
</div-->
    </div>	

												</div>
											</div>
                <?php if($guia_enviada==1){
                    $url= get_row('guia_laar', 'url_guia', 'id_pedido', $id_factura);
                    $traking="https://fenix.laarcourier.com/Tracking/Guiacompleta.aspx?guia=".get_row('guia_laar', 'guia_laar', 'id_pedido', $id_factura);
                 ?>
                <div class="row">
    <div class="col-md-3">
        </br>
        <a style="cursor: pointer;" type="button" href="<?php echo $url; ?>" target="blank"  class="btn btn-danger">Imprimir Guía</a>
</div>
    <div class="col-md-3">
        </br>
        <a style="cursor: pointer;" type="button" href="<?php echo $traking; ?>" target="blank"  class="btn btn-danger">Ver estado</a>
</div>
    
    </div>
                <?php
                }   else{      
                ?>
<H2>DATOS PARA LA GUIA</H2>
<form role="form" id="datos_pedido">
    

                                                                        <div class="row">
                                                                    
                                                                            <div class="col-md-6">
                                                                                <span class="help-block">Nombre Destinatario  </span>
                                                                                <input id="nombredestino" name="nombredestino" class="form-control" value="<?php echo $nombredestino; ?>">  
                                                                            
                                                                            </div>
                                                                                
                                                                                <div class="col-md-6">
                                                                                      <span class="help-block">Identificacion  </span>
                                                                                    <input id="identificacion" name="identificacion" class="form-control" placeholder="Ingrese Identificacion" value="">
                                                                                  
                                                                                </div>
                                                                          
                                                                        </div>
                                                                         <div class="row">
                                                                    
                                                                            <div class="col-md-6">
                                                                                 <span class="help-block">Provincia  </span>
                                                                                <select onchange="cargar_provincia_pedido()" class="datos form-control" id="provinica" name="provinica"  required>
    <option value="">Provincia *</option>
    <?php
    $sql2 = "select * from provincia_laar ";
    $query2 = mysqli_query($conexion, $sql2);

    while ($row2 = mysqli_fetch_array($query2)) {
        $id_prov = $row2['id_prov'];
        $provincia = $row2['provincia'];
        $cod_provincia = $row2['codigo_provincia'];

        // Obtener el valor almacenado en la tabla orgien_laar
        $valor_seleccionado = $provinciadestino ;

        // Verificar si el valor actual coincide con el almacenado en la tabla
        $selected = ($valor_seleccionado == $cod_provincia) ? 'selected' : '';

        // Imprimir la opción con la marca de "selected" si es el valor almacenado
        echo '<option value="' . $cod_provincia . '" ' . $selected . '>' . $provincia . '</option>';
    }
    ?>
</select>
                                                                               
                                                                                
                                                                                
                                                                            </div>
                                                                                
                                                                                <div class="col-md-6">
                                                                                     <span class="help-block">Ciudad  </span>
                                                                                     <div id="div_ciudad">
                                                                                    <select  onchange="calcular_guia()" class="datos form-control" id="ciudad_entrega" name="ciudad_entrega"  required>
                  <option value="">Ciudad *</option>
                  <?php
                           $sql2="select * from ciudad_laar ";
                           //echo $sql2;
                           $query2 = mysqli_query($conexion, $sql2);
                        
                            $rowcount=mysqli_num_rows($query2);
                            //echo $rowcount;
                            $i=1;
                           while ($row2 = mysqli_fetch_array($query2)) {
                               $id_ciudad       = $row2['id_ciudad']; 
                                 $nombre      = $row2['nombre']; 
                                 $cod_ciudad      = $row2['codigo'];
                                 $valor_seleccionado = $ciudaddestino ;
                                   $selected = ($valor_seleccionado == $cod_ciudad) ? 'selected' : '';

        // Imprimir la opción con la marca de "selected" si es el valor almacenado
        echo '<option value="' . $cod_ciudad . '" ' . $selected . '>' . $nombre . '</option>';
                           
?>
        
         <?php }?>
         </select>
                                                                                     </div>
                                                                                   
                                                                                </div>
                                                                          
                                                                        </div>

                                                                    <div class="row">
                                                                    
                                                                            <div class="col-md-6">
                                                                                <span class="help-block">Dirección  </span>
                                                                                <input id="direccion_destino" name="direccion_destino" class="form-control" value="<?php echo $direccion; ?>">  
                                                                            
                                                                            </div>
                                                                                
                                                                                <div class="col-md-6">
                                                                                      <span class="help-block">Referencia  </span>
                                                                                    <input id="referencia" name="referencia" class="form-control" placeholder="Referencia" value="<?php echo $referencia; ?>">
                                                                                  
                                                                                </div>
                                                                          
                                                                        </div>

<div class="row">
                                                                    
                                                                            <div class="col-md-6">
                                                                                <span class="help-block">Teléfono  </span>
                                                                                <input id="telefono" name="telefono" class="form-control" value="<?php echo $telefono; ?>">  
                                                                            
                                                                            </div>
                                                                                
                                                                                <div class="col-md-6">
                                                                                      <span class="help-block">Celular  </span>
                                                                                    <input id="celular" name="celular" class="form-control" placeholder="Celular" value="">
                                                                                  
                                                                                </div>
                                                                          
                                                                        </div>
<div class="row">
                                                                    
                                                                            <div class="col-md-6">
                                                                                <span class="help-block">Numero de casa  </span>
                                                                                <input id="numerocasa" name="numerocasa" class="form-control" value="<?php echo $observacion; ?>">  
                                                                            
                                                                            </div>
    
     <div class="col-md-3">
         <span class="help-block">Recaudo  </span>
         <select onchange="calcular_guia()" id="cod" name="cod" class="form-control">
            <option value="">Seleccionar</option>
             <option value="true">Con Recuado</option>
              <option value="false">Sin Recaudo </option>
         </select>
         
                                                                                 
                                                                            
                                                                            </div>
    
      <div class="col-md-3">
         <span class="help-block">Seguro   </span>
         <select onchange="calcular_guia()" id="seguro" name="seguro" class="form-control">
            <option value="">Deseas asegurar la mercadería </option>
             <option value="1">SI</option>
              <option value="0">NO </option>
         </select>
         <input id="valorasegurado" name="valorasegurado" class="form-control" placeholder="Valor a aegurar">
         
                                                                                 
                                                                            
                                                                            </div>
                                                                                
                                                                              
                                                                          
                                                                        </div>
    <div class="row">
        <div class="col-md-12">
             <span class="help-block">Observaciones para la entrega  </span>
              <input id="observacion" name="observacion" class="form-control" value="<?php echo $observacion; ?>"> 
        </div>
    </div>
<div class="row">
    <div class="col-md-3">
        </br>
<button style="cursor: pointer;" type="button" onclick="generar_guia()" class="btn btn-danger">Generar Guía</button>
</div>
    <div class="col-md-3">
        </br>
        <button style="cursor: pointer;" type="button" onclick="calcular_guia()()" class="btn btn-primary">Calcular</button>
</div>
    <div class="col-md-6">
        </br>
        
        <div style="" id="valor_envio">
         <table  class="table table-sm table-striped">
    <tr> <th><img width="100px" src="../../img_sistema/logo-dark.png" alt=""/></th>
        <th>$<?php echo number_format($valor_base,2)?></th>
    </tr>
     
</table>
        </div>    
    </div>
    </div>
    </form>
<?php 
                    
                }         
                ?>
										</div>

										<div class="col-lg-4">
											<div class="card-box">
												<div class="widget-chart">
												<div class="editar_factura" class='col-md-12' style="margin-top:10px"></div><!-- Carga los datos ajax -->
													
                                                                                                <form role="form" id="datos_factura">
														<input id="id_vendedor" name="id_vendedor" type='hidden' value="<?php echo $id_vendedor_db; ?>">
                                                                                                                
                                                                                                                
														<div class="form-group row">
															<label class="col-2 col-form-label"></label>
															<div class="col-12">
																<div class="input-group">
																	<input type="text" id="nombre_cliente" class="form-control" required value="<?php echo $nombre_cliente; ?>" tabindex="2">
																	<span class="input-group-btn">
																		<button type="button" class="btn waves-effect waves-light btn-success" data-toggle="modal" data-target="#nuevoCliente"><li class="fa fa-plus"></li></button>
																	</span>
																	<input id="id_cliente" name="id_cliente" type='hidden' value="<?php echo $id_cliente; ?>">
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="cotizacion">No. Cotización</label>
																	<input type="text" class="form-control" autocomplete="off" id="cotizacion"  name="cotizacion" value="<?php echo $numero_factura; ?>" readonly>
																</div>
															</div>
																<div class="col-md-6">
																<div class="form-group">
																	<label for="validez">Validez</label>
																	<select class='form-control' id="validez" name="validez">
																		<option value="1" <?php if ($validez == 1) {echo "selected";}?>>5 días</option>
																		<option value="2" <?php if ($validez == 2) {echo "selected";}?>>10 días</option>
																		<option value="3" <?php if ($validez == 3) {echo "selected";}?>>15 días</option>
																		<option value="4" <?php if ($validez == 4) {echo "selected";}?>>30 días</option>
																		<option value="5" <?php if ($validez == 5) {echo "selected";}?>>60 días</option>
																	</select>
																</div>
															</div>
														</div>
														<div class="row">
															<div class="col-md-6">
																<div class="form-group">
																	<label for="fiscal">RUC/Cedula</label>
																	<input type="text" class="form-control" autocomplete="off" id="rnc" name="rnc" disabled="true" value="<?php echo $fiscal_cliente; ?>">
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
                                                                                                                
                                                                                                                <div class="row">
															<div class="col-md-8">
																<div class="form-group">
																	<label for="condiciones">Forma de Pago</label>
																	<select class="form-control" id="formaPago" name="formaPago" required="required">
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
															<div class="col-md-4">
																<div class="form-group">
																	<label for="condiciones">Plazo D&iacute;as</label>
																	<input type="text" class="form-control" id="plazodias" name="plazodias" required="required">
																</div>
															</div>
														</div>
                                                                                                                
														<div class="row">
															<div class="col-md-6">
																<button type="button" class="btn btn-danger waves-effect waves-light" aria-haspopup="true" aria-expanded="false" id="btn_actualizar"><span class="fa fa-refresh"></span> Actualizar</button>
															</div>
															<div class="col-md-6">
																<button type="button" class="btn btn-primary waves-effect waves-light" id="btn_guardar"><span class="ti-shopping-cart-full"></span> Facturar</button>
															</div>
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
	<script type="text/javascript" src="../../js/editar_cotizacion.js"></script>
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
					$('#rnc').val(ui.item.fiscal_cliente);
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
function cargar_provincia_pedido(){
			
			var id_provincia = $('#provinica').val();
                        alert($('#provinica').val())
  //var data = new FormData(formulario);

			$.ajax({
					url: "../ajax/cargar_ciudad_pedido.php",        // Url to which the request is send
					type: "POST",             // Type of request to be send, called as method
					data:  {
				provinica: id_provincia,
                               
                                
			}, 			  // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                                        dataType: 'text',// To send DOMDocument or non processed data file it is set to false
					success: function(data)   // A function to be called if request succeeds
					{
                    
        
                                           
                                            $('#div_ciudad').html(data);
						

					}
				});

		}
                
function calcular_guia() {
     
	nombre_destino=$('#nombredestino').val();//CIERRA LA MODAL
        ciudad=$('#ciudad_entrega').val();;
       //alert(ciudad);
        direccion=$('#direccion').val();//CIERRA LA MODAL
        referencia=$('#referencia').val();//CIERRA LA MODAL
        telefono=$('#telefono').val();//CIERRA LA MODAL
        celular=$('#celular').val();//CIERRA LA MODAL
        observacion=$('#observacion').val();//CIERRA LA MODAL
        cod=$('#cod').val();//CIERRA LA MODAL
        seguro=$('#seguro').val();//CIERRA LA MODAL
        productos_guia=$('#productos_guia').val();
        cantidad_total=$('#cantidad_total').val();
        //alert(cantidad_total);
        valor_total=$('#valor_total').val();
        costo_total=$('#costo_total').val();
         valorasegurado=$('#valorasegurado').val();
        
           
    id_factura=1;
	if (id_factura=1) {
		$.ajax({
			url: '../ajax/calcular_guia.php',
			type: 'post',
			data: {
				nombre_destino: nombre_destino,
                                ciudad: ciudad,
                                direccion: direccion,
                                referencia: referencia,
                                telefono: telefono,
                                celular: celular,
                                observacion: observacion,
                                cod: cod,
                                seguro: seguro,
                                productos_guia: productos_guia,
                                cantidad_total: cantidad_total,
                                valor_total: valor_total,
                                costo_total: costo_total,
                                valorasegurado: valorasegurado,
                                
			},
			dataType: 'text',
			success: function(response) {
				//alert(response)
                                
                                 $('#valor_envio').html(response);
            } // /success function

        }); // /ajax function to fetch the printable order
    } // /if orderId
}



function generar_guia(id_factura) {
	nombre_destino=$('#nombredestino').val();
        identificacion=$('#identificacion').val();
        ciudad=$('#ciudad_entrega').val();;
       //alert(ciudad);
        direccion_destino=$('#direccion_destino').val();//CIERRA LA MODAL
        //alert(direccion_destino);
        referencia=$('#referencia').val();//CIERRA LA MODAL
        telefono=$('#telefono').val();//CIERRA LA MODAL
        celular=$('#celular').val();//CIERRA LA MODAL
        observacion=$('#observacion').val();//CIERRA LA MODAL
        cod=$('#cod').val();//CIERRA LA MODAL
        seguro=$('#seguro').val();//CIERRA LA MODAL
        productos_guia=$('#productos_guia').val();
        cantidad_total=$('#cantidad_total').val();
        valor_total=$('#valor_total').val();
        costo_total=$('#costo_total').val();
        numerocasa=$('#numerocasa').val();
        valor_envio=$('#valor_envio').val();
         valorasegurado=$('#valorasegurado').val();
        
        id_pedido_cot=$('#id_pedido_cot').val();
        //alert(id_pedido_cot);
        
        
    
   
    id_factura=1;
	if (id_factura=1) {
		$.ajax({
			url: '../ajax/enviar_laar.php',
			type: 'post',
			data: {
				nombre_destino: nombre_destino,
                                ciudad: ciudad,
                                direccion: direccion_destino,
                                referencia: referencia,
                                telefono: telefono,
                                celular: celular,
                                 observacion: observacion,
                                 cod: cod,
                                 seguro: seguro,
                                  productos_guia: productos_guia,
                                cantidad_total: cantidad_total,
                                valor_total: valor_total,
                                numerocasa: numerocasa,
                                id_pedido_cot: id_pedido_cot,
                                identificacion: identificacion,
                                valorasegurado: valorasegurado,
                                
			},
			dataType: 'text',
			success: function(response) {
                            
                            if(response=='ok'){
                              location.reload();  
                            }else{
                              alert(response)  
                            }
				
            } // /success function

        }); // /ajax function to fetch the printable order
    } // /if orderId
}


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
	function showDiv(select){
		if(select.value==4){
			$("#resultados3").load("../ajax/carga_prima.php");
		} else{
			$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
	function comprobar(select){
		var rnc = $("#rnc").val();
                id_comp== $("#id_comp").val();
                //alert(id_comp)
		if(select.value==1 && rnc==''){
			$.Notification.notify('warning','bottom center','NOTIFICACIÓN', 'AL CLIENTE SELECCIONADO NO SE LE PUEDE IMPRIR LA FACTURA, NO TIENE RNC/DEDULA REGISTRADO')
			$("#resultados4").load("../ajax/tipo_doc.php");
		} else{
			//$("#resultados3").load("../ajax/carga_resibido.php");
		}
	}
	function getval(sel)
  {
    $.Notification.notify('success', 'bottom center', 'NOTIFICACIÓN', 'CAMBIO DE COMPROBANTE')
    $("#outer_comprobante").load("../ajax/carga_correlativos.php?id_comp="+sel.value);

  }
	$(document).ready( function () {
        $(".UpperCase").on("keypress", function () {
         $input=$(this);
         setTimeout(function () {
          $input.val($input.val().toUpperCase());
         },50);
        })
       })
       
       
</script>

<?php require 'includes/footer_end.php'
?>

