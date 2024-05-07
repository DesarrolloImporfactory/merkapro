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
   
  
        //update
         $sql = "update `politicas_empresa` set politica= '$contenido' where id_politica='$id'";
         
       //  echo $sql;
      // echo 'inserat0'.$sql;
        $query_new_insert = mysqli_query($conexion, $sql);

        if ($query_new_insert) {
             header("Location: ../html/registro_politicas.php?id=$id", TRUE, 301);

exit();

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