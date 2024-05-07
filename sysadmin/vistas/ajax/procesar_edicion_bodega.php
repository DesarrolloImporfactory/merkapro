<?php
include 'is_logged.php'; // Verifica que el usuario esté logueado
// Inicia validación del lado del servidor
if (empty($_POST['latitud'])) {
    $errors[] = "Latitud vacía";
} else {
    /* Connect To Database*/
    require_once "../db.php"; // Variables de configuración para conectar a la base de datos
    require_once "../php_conexion.php"; // Función que conecta a la base de datos

    // Recibir el ID de la bodega a actualizar
    $id_bodega = intval($_POST['id_bodega']);

    // Escaping, additionally removing everything that could be (html/javascript-) code
    $users = $_POST['empresa'];
    $nombre = mysqli_real_escape_string($conexion, strip_tags($_POST["nombre"], ENT_QUOTES));
    $direccion = mysqli_real_escape_string($conexion, strip_tags($_POST["direccion_completa"], ENT_QUOTES));
    $provincia = mysqli_real_escape_string($conexion, strip_tags($_POST["provinica"], ENT_QUOTES));
    $localidad = mysqli_real_escape_string($conexion, strip_tags($_POST["ciudad_entrega"], ENT_QUOTES));
    $latitud = mysqli_real_escape_string($conexion, strip_tags($_POST["latitud"], ENT_QUOTES));
    $longitud = mysqli_real_escape_string($conexion, strip_tags($_POST["longitud"], ENT_QUOTES));
    $contacto = mysqli_real_escape_string($conexion, strip_tags($_POST["nombre_contacto"], ENT_QUOTES));
    $telefono = mysqli_real_escape_string($conexion, strip_tags($_POST["telefono"], ENT_QUOTES));
    $numero_casa = mysqli_real_escape_string($conexion, strip_tags($_POST["numero_casa"], ENT_QUOTES));
    $referencia = mysqli_real_escape_string($conexion, strip_tags($_POST["referencia"], ENT_QUOTES));

    // Actualizar la información en la tabla bodega
    $sql = "UPDATE `bodega` SET 
                `nombre`='$nombre', 
                `id_empresa`='$users', 
                `longitud`='$longitud', 
                `latitud`='$latitud', 
                `direccion`='$direccion', 
                `num_casa`='$numero_casa', 
                `referencia`='$referencia', 
                `responsable`='$contacto', 
                `contacto`='$telefono', 
                `localidad`='$localidad', 
                `provincia`='$provincia' 
            WHERE `id`='$id_bodega'";

    $query_update = mysqli_query($conexion, $sql);

    if ($query_update) {
        header("Location: ../html/bodegas_empresa.php");
        exit;
    } else {
        $errors[] = "Lo siento, algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
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
?>
