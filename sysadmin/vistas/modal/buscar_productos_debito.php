<?php
if (isset($conexion)) {
    $sql        = mysqli_query($conexion, "select LAST_INSERT_ID(id_factura) as last from notadebito20 order by id_factura desc limit 0,1 ");
    $rw         = mysqli_fetch_array($sql);
    if(isset($rw) == null){
        $id_debito = 0 + 1;
    }else{
        $id_debito = $rw['last'] + 1;
    }
    ?>
	<div id="detalledebito" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-search'></i> Agregar Detalle D&eacute;bito</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal">
					
					</form>
                    <div class="outer_lib" >
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-sm">
                                <tr  class="info">
                                
                                    <th class='text-center'>Razon Modificaci&oacute;n</th>
                                    <th class='text-center'>Valor Modificaci&oacute;n</th>
                                    <th class='text-center' style="width: 36px;"></th>
                                </tr>
                                <tr>
                                    <td>
                                        <input type="text" class="form-control" style="text-align:center" id="desproducto_deb"  value="" >
                                    </td>
                                    <td class='col-xs-2' width="15%">
                                        <div class="pull-right">
                                            <input type="text" class="form-control" style="text-align:right" id="precio_venta_deb"  value="" >
                                        </div>
                                    </td>
                                    <td class='text-center'>
                                        <a class='btn btn-success' href="#" title="Agregar a Detalle Debito" onclick="agregar_detalle_debito('<?php echo 'deb' ?>','<?php echo $id_debito ?>')"><i class="fa fa-plus"></i>
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan=6>
                                        <span class="pull-right"></span>
                                    </td>
                                </tr>
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
	<?php
}
?>