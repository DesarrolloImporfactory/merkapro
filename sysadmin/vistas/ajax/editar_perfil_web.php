<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['nombre_empresa'])) {
    $errors[] = "Nombre de empresa esta vacío";
} else if (empty($_POST['telefono'])) {
    $errors[] = "Teléfono esta vacío";
} else if (
    !empty($_POST['nombre_empresa']) &&
    !empty($_POST['telefono'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    $nombre_empresa = mysqli_real_escape_string($conexion, (strip_tags($_POST["nombre_empresa"], ENT_QUOTES)));
    $giro           = mysqli_real_escape_string($conexion, (strip_tags($_POST["giro"], ENT_QUOTES)));
    $fiscal         = mysqli_real_escape_string($conexion, (strip_tags($_POST["fiscal"], ENT_QUOTES)));
    $telefono       = mysqli_real_escape_string($conexion, (strip_tags($_POST["telefono"], ENT_QUOTES)));
    $email          = mysqli_real_escape_string($conexion, (strip_tags($_POST["email"], ENT_QUOTES)));
    $direccion      = mysqli_real_escape_string($conexion, (strip_tags($_POST["direccion"], ENT_QUOTES)));
    //$ciudad         = mysqli_real_escape_string($conexion, (strip_tags($_POST["ciudad"], ENT_QUOTES)));
    //$estado         = mysqli_real_escape_string($conexion, (strip_tags($_POST["estado"], ENT_QUOTES)));
    //$codigo_postal  = mysqli_real_escape_string($conexion, (strip_tags($_POST["codigo_postal"], ENT_QUOTES)));
    $mapa  = $_POST["mapa"];
    $color = $_POST["color"];
    $color_botones = $_POST["color_botones"];
    $color_footer = $_POST["color_footer"];
    $facebook = $_POST["facebook"];
    $instagram = $_POST["instagram"];
    $tiktok = $_POST["tiktok"];
    $whatsapp = $_POST["whatsapp"];
    
    $texto_cabecera = $_POST["texto_cabecera"];
    $texto_boton = $_POST["texto_boton"];
    $texto_footer = $_POST["texto_footer"];
    $texto_precio = $_POST["texto_precio"];
    $texto_contactos = $_POST["texto_contactos"];
    
    $texto_btn_slider = $_POST["texto_btn_slider"];
    $enlace_btn_slider = $_POST["enlace_btn_slider"];
    $titulo_slider = $_POST["titulo_slider"];
    $alineacion_slider = $_POST["alineacion_slider"];
    $texto_slider = $_POST["texto_slider"];
    $banner_opacidad = $_POST["banner_opacidad"];
    $banner_color_filtro  = $_POST["banner_color_filtro"];
    
    
    

    $sql = "UPDATE perfil SET nombre_empresa='" . $nombre_empresa . "',
                                            giro_empresa='" . $giro . "',
                                            fiscal_empresa='" . $fiscal . "',
                                            telefono='" . $telefono . "',
                                            email='" . $email . "',
                                            direccion='" . $direccion . "',
                                            color='" . $color . "',
                                            facebook='" . $facebook . "',
                                            mapa='" . $mapa . "',
                                            texto_contactos='" . $texto_contactos . "',
                                            texto_cabecera='" . $texto_cabecera . "',
                                            texto_boton='" . $texto_boton . "',
                                            texto_footer='" . $texto_footer . "',
                                            texto_precio='" . $texto_precio . "',
                                            instagram='" . $instagram . "',
                                            banner_opacidad='" . $banner_opacidad . "',
                                            banner_color_filtro='" . $banner_color_filtro . "',
                                            tiktok='" . $tiktok . "',
                                            whatsapp='" . $whatsapp . "',
                                            color_botones='" . $color_botones . "',
                                                color_footer='" . $color_footer . "',
                                                    texto_btn_slider='" . $texto_btn_slider . "',
                                                    enlace_btn_slider='" . $enlace_btn_slider . "',
                                                    titulo_slider='" . $titulo_slider . "',
                                                    alineacion_slider='" . $alineacion_slider . "',
                                                    texto_slider='" . $texto_slider . "'                                            
                                            WHERE id_perfil='1'";
    //echo $sql;
    $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Datos han sido actualizados satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
} else {
    $errors[] = "Error desconocido.";
}

if (isset($errors)) {

    ?>
            <div class="alert alert-danger" role="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
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
                        <button type="button" class="close" data-dismiss="alert">&times;</button>
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