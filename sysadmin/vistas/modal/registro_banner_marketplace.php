<?php
$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
if (isset($conexion_marketplace)) {
?>
    <div id="nuevoBanner" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title"><i class='fa fa-edit'></i> Nuevo Item </h4>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" method="post" id="guardar_banner" name="guardar_linea2">
                        <div id="resultados_ajax"></div>

                        <div class="form-group d-flex flex-row">

                            <!-- contenido modal -->
                            <div class="col-sm-6">
                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Titulo</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="titulo_slider" id="titulo_slider" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Boton</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="texto_btn_slider" id="texto_btn_slider" autocomplete="off">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Enlace Boton</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" name="enlace_btn_slider" id="enlace_btn_slider" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <span class="help-block">Texto del slider </span>
                                <textarea type="text" class="form-control " name="texto_slider" id="texto_slider" autocomplete="off"></textarea>
                                </br>

                                <div class="form-group row">
                                    <label for="inputPassword3" class="col-sm-2 col-form-label">Alineacion</label>
                                    <div class="col-sm-10">
                                        <select class="form-control" name="alineacion2" id="alineacion2">
                                            <option value="1">Izquierda </option>
                                            <option value="2">Centro </option>
                                            <option value="3">Derecha </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" id="guardar_datos2">Guardar</button>
                </div>
                </form>
            </div>
        </div>
    </div><!-- /.modal -->
<?php
}
?>