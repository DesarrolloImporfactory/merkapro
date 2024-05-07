<?php
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
$modId = $_POST['id'];
$query_empresa = mysqli_query($conexion, "select * from banner_adicional where id=$modId");
$row           = mysqli_fetch_array($query_empresa);
$id_banner = $row['fondo_banner'];

$select1= "";
if(isset($_POST['alineacion']) && $_POST['alineacion'] == '1'){
    $select1="selected";
} else{
    $select1= "";
}

$select2= "";
if(isset($_POST['alineacion']) && $_POST['alineacion'] == '2'){
    $select2="selected";
} else{
    $select2= "";
}

$select3= "";
if(isset($_POST['alineacion']) && $_POST['alineacion'] == '3'){
    $select3="selected";
} else{
    $select3= "";
}

echo '
                        <div id="resultados_ajax2"></div>

                        <div class="form-group d-flex flex-column">
                            <input type="hidden" id="mod_id" name="mod_id" value="'.$_POST['id'].'">
                            <div class="d-flex flex-row">
                                <!-- contenido modal -->
                                <div class="col-sm-6">
                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Titulo</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="'.$_POST['titulo'].'" name="titulo_slider2" id="titulo_slider2" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Boton</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="'.$_POST['texto_boton'].'" name="texto_btn_slider2" id="texto_btn_slider2" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Enlace Boton</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="'.$_POST['enlace_boton'].'" name="enlace_btn_slider2" id="enlace_btn_slider2" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <span class="help-block">Texto del slider </span>
                                    <input type="text" class="form-control" value="'.$_POST['texto_banner'].'" name="texto_slider2" id="texto_slider2" autocomplete="off">
                                    <br>

                                    <div class="form-group row">
                                        <label for="inputPassword3" class="col-sm-2 col-form-label">Alineacion</label>
                                        <div class="col-sm-10">
                                            <select class="form-control" name="alineacion" id="alineacion">
                                                <option value="1" '.$select1.'>Izquierda </option>
                                                <option value="2" '.$select2.'>Centro </option>
                                                <option value="3" '.$select3.'>Derecha </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <div>
                                    <div id="load_img4">
                                        <strong>BANNER HOME</strong>
                                        <img src="'.$id_banner.'" class="img-responsive" alt="profile-image" width="200px" height="200px">
                                    </div>

                                    <div class="form-group">
                                        <input class="form-control" data-buttonText="Logo" type="file" name="imagefile4" id="imagefile4" onchange="upload_image_banner2();">
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
                ';
?>