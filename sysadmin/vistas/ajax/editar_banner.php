<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $titulo_slider2 = $_POST["titulo_slider2"];
    $texto_btn_slider2 = $_POST["texto_btn_slider2"];
    $enlace_btn_slider2 = $_POST["enlace_btn_slider2"];
    $texto_slider2 = $_POST['texto_slider2'];
    $alineacion = $_POST['alineacion'];
    $id = $_POST['mod_id'];
    @$posicion = $_POST['mod_posicion'];

    //$sql = "UPDATE caracteristicas_tienda SET texto='" . $nombre . "' where id=$id";
    $sql = "UPDATE banner_adicional SET 
            texto_banner='$texto_slider2', 
            titulo='$titulo_slider2', 
            texto_boton='$texto_btn_slider2', 
            enlace_boton='$enlace_btn_slider2',
            alineacion='$alineacion'
        WHERE id=$id";
    // echo $sql;                        
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Linea ha sido actualizada con Exito.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

?>
    <div class="alert alert-danger" role="alert">
        <strong>Error!</strong>
        <?php
        foreach ($errors as $error) {
            echo $error;
        }
        ?>
    </div>
<?php
}
if (isset($messages)) {

?>
    <div class="alert alert-success" role="alert">
        <strong>¡Bien hecho!</strong>
        <?php
        foreach ($messages as $message) {
            echo $message;
        }
        ?>
    </div>
<?php
}

?>