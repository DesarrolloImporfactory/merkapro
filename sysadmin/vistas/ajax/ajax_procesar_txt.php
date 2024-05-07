<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['contenido'])) {
    $errors[] = "referencia vacío";
} else if (!empty($_POST['contenido'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    
    $contenido      = $_POST['contenido'];
    $id      = $_POST['id_producto'];
   
    // check if user or email address already exists
    $sql   = "SELECT * FROM landing WHERE id_producto ='" . $id . "';";
     
    $query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true ) {
        //update
         // Generar un nombre de archivo único
        $fila = mysqli_fetch_assoc($query_check_user_name);
    
    // Accede al valor del campo "landing"
    $valorLanding = $fila['contenido'];
   if (strpos($contenido, 'html') !== false){
     unlink($valorLanding);
     $nombre_archivo = $valorLanding;
   }else{
    $nombre_archivo = 'landing_producto/landing_' . time() . '.html';   
   }
    
    
    
    
    // Guardar el contenido en un archivo
    file_put_contents($nombre_archivo, $contenido);
    
    // Almacena la ruta del archivo en una base de datos o donde lo necesites
    $ruta_archivo = $nombre_archivo; // Puedes guardar esto en una base de datos
    
    // Devuelve la ruta del archivo para su posterior uso
    //echo $ruta_archivo;
    
         $sql = "update `landing` set contenido= '$ruta_archivo' where id_producto='$id'";
      // echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
        header("Location: ../html/landin.php?id=$id", TRUE, 301);

exit();

        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
        
    } else {
        // write new user's data into database
$nombre_archivo = 'landing_producto/landing_' . time() . '.html';
    
    // Guardar el contenido en un archivo
    file_put_contents($nombre_archivo, $contenido);
     $ruta_archivo = $nombre_archivo; // Puedes guardar esto en una base de datos
       $sql = "INSERT INTO `landing` ( `id_producto`, `contenido`) VALUES ($id, '$ruta_archivo')";
      // echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
              header("Location: ../html/landin.php?id=$id", TRUE, 301);

        } else {
            $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
        }
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