<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_GET['id'])) {
    $errors[] = "referencia vacío";
} else if (!empty($_GET['id'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
     require_once "../funciones.php";
    $id      = $_GET['id'];
    $stock     = $_GET['stock'];
    $nombre     = get_row('productos', 'nombre_producto', 'id_producto', $id);
    $precio_mayor     = get_row('productos', 'valor2_producto', 'id_producto', $id);
    if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https'
) {
    $protocol = 'https://';
} else {
    $protocol = 'http://';
}
$server_url = $protocol . $_SERVER['HTTP_HOST'];
$tabla = 'productos';
// Configuración de la base de datos de destino
if ($_SERVER['HTTP_HOST']=='localhost'){
    $destino = new mysqli('localhost', 'root', '', 'master');
}else{
 $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');   
}
if ($destino->connect_error) {
    die('Error en la conexión a la base de datos de destino: ' . $destino->connect_error);
}
$sql = "SELECT * FROM $tabla where id_producto=$id";
$query_check_user_name = mysqli_query($conexion, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        while ($fila = $query_check_user_name->fetch_assoc()) { 
            //echo "UPDATE productos SET nombre_producto='" . $nombre . "', stock_producto='" . $stock . "', costo_producto='$precio_mayor' WHERE id_producto_origen='" . $id . "' and inv_producto=0 and tienda='$server_url'";
                    $update  = mysqli_query($destino, "UPDATE productos SET nombre_producto='" . $nombre . "', stock_producto='" . $stock . "', costo_producto='$precio_mayor' WHERE id_producto_origen='" . $id . "' and inv_producto=0 and tienda='$server_url'"); //Actualizo la nueva cantidad en el inventario
header("Location: ../html/productos.php", TRUE, 301);
exit;
        }
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
        <?php
}
?>