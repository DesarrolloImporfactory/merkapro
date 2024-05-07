<?php
//include "is_logged.php"; //Archivo comprueba si el usuario esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
if (isset($_REQUEST['id_producto'])) {
    $id_producto = intval($_REQUEST['id_producto']);
    $sql_img     = mysqli_query($conexion, "select * from landing_producto where id_producto_l='$id_producto'");
    $rw          = mysqli_fetch_array($sql_img);
    $url         = $rw['url_imagen'];
    ?>
	<div class="row">
		<div class="col-md-12">
			<div class="form-group">
				<label for="image" class="col-sm-2 control-label">Imagen </label>
				<div class="col-sm-10">
					<input type="file" class='form-control' name="imagefile1" id="imagefile1" onchange="upload_image1(<?php echo $id_producto; ?>);">
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-3"></div>
			<div class="col-sm-6 col-lg-8 col-md-4 webdesign illustrator">
				<div class="gal-detail thumb">
					<div id="load_img1">
					<?php
if ($url == null) {
        echo '<img src="../../img/productos/default.jpg" class="thumb-img">';
    } else {
        echo '<img src="' . $url . '" class="thumb-img">';
    }

    ?>
						<!--<img class="thumb-img rounded-circle" src="<?php echo $url; ?>">-->
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php }?>