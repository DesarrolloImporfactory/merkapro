<?php
  require_once "../db.php";
    require_once "../php_conexion.php";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Verifica si se recibió un archivo y si no hubo errores durante la carga.
    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
        $nombreArchivo = $_FILES["imagen"]["name"];
        $tipoArchivo = $_FILES["imagen"]["type"];
        $tamanioArchivo = $_FILES["imagen"]["size"];
        $rutaTemporal = $_FILES["imagen"]["tmp_name"];
        
        // Define la carpeta donde se guardará la imagen (debes crear esta carpeta en tu servidor).
        $carpetaDestino = "banner/";

        // Mueve el archivo de la ubicación temporal a la carpeta de destino.
        if (move_uploaded_file($rutaTemporal, $carpetaDestino . $nombreArchivo)) {
            echo "La imagen se ha cargado y guardado correctamente.";
            $sql = "UPDATE perfil SET banner='" . $carpetaDestino.$nombreArchivo."' where id_perfil=1" ;
            echo $sql;
             $query_update = mysqli_query($conexion, $sql);
    if ($query_update) {
        $messages[] = "Datos han sido actualizados satisfactoriamente.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
    //redirigir
        } else {
            echo "Hubo un error al guardar la imagen.";
        }
    } else {
        echo "No se ha seleccionado ninguna imagen o hubo un error en la carga.";
    }
}
?>

