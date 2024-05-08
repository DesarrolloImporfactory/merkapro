<?php
    //include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    $conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
    if (isset($_FILES["imagefile_marketplace"])) {

        $target_dir    = "../../img/";
        $image_name    = time() . "_" . basename($_FILES["imagefile_marketplace"]["name"]);
        $target_file   = $target_dir . $image_name;
        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);
        $imageFileZise = $_FILES["imagefile_marketplace"]["size"];
        $id = $_POST['mod_id'];

        /* Inicio Validacion*/
        // Allow certain file formats
        if (($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") and $imageFileZise > 0) {
            $errors[] = "<p>Lo sentimos, sólo se permiten archivos JPG , JPEG, PNG y GIF.</p>";
        } else if ($imageFileZise > 10048576) {
            //1048576 byte=1MB
            $errors[] = "<p>Lo sentimos, pero el archivo es demasiado grande. Selecciona logo de menos de 1MB</p>";
        } else {

            /* Fin Validacion*/
            if ($imageFileZise > 0) {
                move_uploaded_file($_FILES["imagefile_marketplace"]["tmp_name"], $target_file);
                $logo_update = "fondo_banner='../../img/$image_name' ";
            } else {
                $logo_update = "";
            }
            $sql              = "UPDATE banner_marketplace SET $logo_update WHERE id='$id';";
            $query_new_insert = mysqli_query($conexion_marketplace, $sql);

            if ($query_new_insert) {
    ?>
                <img class="img-responsive" width="100%" src="../../img/<?php echo $image_name; ?>" alt="Logo">
    <?php
            } else {
                $errors[] = "Lo sentimos, actualización falló. Intente nuevamente. " . mysqli_error($conexion_marketplace);
            }
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