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
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["texto_icon"], ENT_QUOTES)));
    $subtexto_icon = $_POST["subtexto_icon"];
    $enlace_icon = $_POST["enlace_icon"];
    $icon_select = $_POST["icon_select"];
    $id = $_POST['mod_id'];
    @$posicion = $_POST['mod_posicion'];

    //$sql = "UPDATE caracteristicas_tienda SET texto='" . $nombre . "' where id=$id";
    $sql = "UPDATE caracteristicas_tienda SET 
            texto='$nombre', 
            subtexto_icon='$subtexto_icon', 
            enlace_icon='$enlace_icon', 
            icon_text='$icon_select'
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