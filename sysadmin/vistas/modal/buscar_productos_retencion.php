<?php
if (isset($conexion)) {
    $sql        = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from retencion20 order by id_factura desc limit 0,1 ");
    $rw         = mysqli_fetch_array($sql);
    if(isset($rw) == null){
        $id_retencion = 0 + 1;
    }else{
        $id_retencion = $rw['last'] + 1;
    }
    ?>
	<div id="productosretencion" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-search'></i> Agregar agregar retencion</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal">
					
					</form>
                    <div class="outer_lib" >
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped " width="100%">
                                <tr  class="info">
                                    <th class='text-center' style="width: 100px;">Tipo</th>
									<th class='text-center' style="width: 100px;">Cod. Reten</th>
									<th class='text-center' style="width: 100px;">%</th>
									<th class='text-center' style="width: 100px;">Base Imp.</th>
									<th class='text-center' style="width: 100px;">Total</th>
									<th class='text-center' style="width: 100px;">Documento No.</th>
									<th class='text-center' style="width: 100px;">Tipo Doc</th>
									<th class='text-center' style="width: 100px;">Fecha Doc</th>
                                    <th class='text-center' style="width: 36px;"></th>
                                </tr>
                                <tr >
                                    <td >
                                        <select class="form-control" name = 'tipoImpuesto' id='tipoImpuesto'>
                                            <option value = '1'> Renta</option>
                                            <option value = '2'> IVA</option>
                                            <option value = '6'> ISD</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input size = '8' type = 'text' readonly name = 'codRetencion' class = 'valor form-control' id = 'codRetencion' required='required'/>
                                        <button type='button' data-toggle='modal' data-target='#codigo-retencion'>
                                            <i class='fa fa-search'></i>
                                        </button>
                                    </td>
                                    <td>
                                        <input size = '4' type = 'text' readonly name = 'porcentaje' class = 'valor form-control' id = 'porcentaje' onchange = 'calcularaValorTotal()' required='required'/>
                                    </td>
                                    <td>
                                        <input size = '6' type = 'text' name = 'baseImponible' class = 'valor form-control' id = 'baseImponible' onchange = 'calcularaValorTotal()' required='required'/>
                                    </td>
                                    <td>
                                        <input size = '6' type = 'text' readonly name = 'total' class = 'valor form-control' id = 'total'  required='required'/>
                                    </td>
                                    <td>
                                        <input  type = 'text' name = 'documento' class = 'valor form-control name' id = 'documento' required='required' />
                                        <!--<span class="mensajedocsustento" style="color:red">El numero de sustento debe tener solo numeros y con un maximo de 15 numeros</span>-->
                                    </td>
                                    <td>
                                        <select name = 'tipoDoc' id = 'tipoDoc'  class='form-control'>
                                            <option value = '01'> Factura</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input size = '8' type = 'date' name = 'fecha' class = 'valor form-control' id = 'fecha' required='required'/>
                                    </td>
                                    <td class='text-center'>
                                        <a class='btn btn-success' href="#" title="Agregar a Retencion" onclick="agregar_detalle_retencion('<?php echo $id_retencion ?>')"><i class="fa fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                               <!--  <tr>
                                    <td colspan=6>
                                        <span class="pull-right"></span>
                                    </td>
                                </tr>-->
                            </table>
                        </div>
                    </div><!-- Datos ajax Final -->

				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
				</div>
			</div>
		</div>
	</div><!-- /.modal -->
	
	<!--<script>
	    $('.name').on('input', function () { 
            this.value = this.value.replace(/[^0-9]/g,'');
            valor = this.value.length;
            if(valor == 15 or valor == '15'){
                $('.mensajedocsustento').hide();
            }else{
                $('.mensajedocsustento').show();
            }
        });
	</script>-->
	<?php
}
?>