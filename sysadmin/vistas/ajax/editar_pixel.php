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
    $nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    $pixel      = $_POST["mod_pixel"];
    //echo 'asadad'.$pixel;
    $codigo = "'".$pixel."'";
  $id=$_POST['mod_id'];

    //$sql = 'UPDATE pixel SET  nombre="' . $nombre. '", pixel='.$codigo.' where id_pixel='.$id;
      // echo $sql;
  
try {
    $pdo = new PDO("mysql:host=$host;dbname=$base_de_datos", $usuario, $contrasena);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // ID del registro que deseas actualizar
    $id_registro = 1; // Cambia esto al ID del registro que deseas actualizar

    // Consulta SQL para actualizar el código en la base de datos
    $query = "UPDATE pixel SET pixel = :codigo WHERE id_pixel = :id";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':codigo', $_POST["mod_pixel"], PDO::PARAM_STR);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "El código se ha actualizado en la base de datos.";
    } else {
        echo "Error al actualizar el código.";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
        
  // $query_update = mysqli_query($conexion, $sql);
   
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