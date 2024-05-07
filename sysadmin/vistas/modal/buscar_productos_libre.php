<?php
if (isset($conexion)) {
    ?>
	<div id="libre" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title"><i class='fa fa-search'></i> Agregar producto</h4>
				</div>
				<div class="modal-body">

					<form class="form-horizontal">
					
					</form>
                                    <div class="outer_lib" >
                                        <div class="table-responsive">
              <table class="table table-bordered table-striped table-sm">
                <tr  class="info">
                  
                    <th class='text-center'>NOMBRE PRODUCTO</th>
          
                    <th class='text-center'>CANT</th>
                    <th class='text-center'>PRECIO</th>
                    <th class='text-center' style="width: 36px;"></th>
                </tr>

                    <tr>
                     
                           
                        <td>
                            <input type="text" class="form-control" style="text-align:center" id="desproducto_lib"  value="" >
                        </td>
                      
                        <td class='col-xs-1' width="15%">
                        <div class="pull-right">
                        <input type="text" class="form-control" style="text-align:center" id="cantidad_lib"  value="1" >
                        </div>
                        </td>
                        <td class='col-xs-2' width="15%"><div class="pull-right">
                        <input type="text" class="form-control" style="text-align:right" id="precio_venta_lib"  value="" >
                        </div></td>
                        <td class='text-center'>
                        <a class='btn btn-success' href="#" title="Agregar a Factura" onclick="agregar_libre('<?php echo 'lib' ?>')"><i class="fa fa-plus"></i>
                        </a>
                        </td>
                    </tr>
 
                <tr>
                    <td colspan=6><span class="pull-right">
                  </span></td>
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