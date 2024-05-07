<?php
if (isset($conexion)) {
?>
    <form class="form-horizontal" method="post" name="remove_abono" id="remove_abono" enctype="multipart/form-data">
        <!-- Modal -->
        <div id="remove-stock" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">×</button>
                        <h4 class="modal-title"> <i class="fa fa-edit"></i> Reducir Deuda</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="abono" class="control-label">Abono:</label>
                                    <input type="text" class="form-control" id="abono" name="abono" autocomplete="off" pattern="^[0-9]{1,5}(\.[0-9]{0,2})?$" title="Ingresa sólo números con 0 ó 2 decimales" maxlength="8" required autofocus>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="forma_pago">Elige el metodo de pago.</label>
                                    <select class="form-control" id="forma_pago" name="forma_pago" required>
                                        <option value="">Selecciona una opción</option>
                                        <option value="Efectivo">Efectivo</option>
                                        <option value="Tarjeta">Tarjeta</option>
                                        <option value="Transferencia">Transferencia</option>
                                        <option value="Cheque">Cheque</option>
                                        <option value="Otro">Otro</option>
                                    </select>


                                    <label for="img">Imagen de la factura:</label>
                                    <input type="file" class="form-control" id="img" name="img" accept="image/*" required>

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos2">Guardar</button>
                    </div>
                </div>

            </div>
        </div>
    </form>
<?php
}
?>