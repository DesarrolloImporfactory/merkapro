    <?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
if (isset($_FILES["imagefile"])) {

    $target_dir    = "../../img/";
    $target_dir_factura    = "../../vistas/assets/js/lib_firma_sri/src/services/uploads/";
    $image_name_factura='Logo.jpg';
    $target_file_factura=$target_dir_factura.$image_name_factura;
    echo $target_file_factura;
    $image_name    = time() . "_" . basename($_FILES["imagefile"]["name"]);
    $target_file   = $target_dir . $image_name;
    $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
    $imageFileZise = $_FILES["imagefile"]["size"];

    /* Inicio Validacion*/
    // Allow certain file formats
    if (($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") and $imageFileZise > 0) {
        $errors[] = "<p>Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG y GIF.</p>";
    } else if ($imageFileZise > 1048576) {
//1048576 byte=1MB
        $errors[] = "<p>Lo sentimos, pero el archivo es demasiado grande. Selecciona logo de menos de 1MB</p>";
    } else {

        /* Fin Validacion*/
        if ($imageFileZise > 0) {
           // move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file);
            
            move_uploaded_file($_FILES["imagefile"]["tmp_name"], $target_file_factura);
            $logo_update = "logo_url='../../img/$image_name' ";

        } else { $logo_update = "";}
        

        
    }
}

?>
    <?php
if (isset($errors)) {
    ?>
        <div class="alert alert-danger">
            <button type="button" class="close" data-dismiss="alert">&times;</button>
            <strong>Error! </strong>
        <?php
foreach ($errors as $error) {
        echo $error;
    }
    ?>
        </div>
    <?php
}
?>
