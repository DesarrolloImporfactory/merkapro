<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_GET['id'])) {
    $errors[] = "referencia vacío";
} else if (!empty($_GET['id'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    
    //$contenido      = $_POST['contenido'];
    $id      = $_GET['id'];
   
    // check if user or email address already exists
 // Nombre de la tabla que deseas copiar
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

// Realiza una consulta para seleccionar todos los registros de la tabla de origen
$sql = "SELECT * FROM $tabla where id_producto=$id";
$query_check_user_name = mysqli_query($destino, $sql);
    $query_check_user      = mysqli_num_rows($query_check_user_name);
    if ($query_check_user == true) {
        //update
        while ($fila = $query_check_user_name->fetch_assoc()) {
            //echo 'si entra';
            
      $codigo_producto = $fila['codigo_producto'];
      $nombre_producto = $fila['nombre_producto'];
      //echo $nombre_producto;
      $descripcion_producto = $fila['descripcion_producto'];
      $id_linea_producto = $fila['id_linea_producto'];
      $id_med_producto = $fila['id_med_producto'];
      $id_proveedor = 6;
      $inv_producto = $fila['inv_producto'];
      $iva_producto = $fila['iva_producto'];
      $estado_producto = $fila['estado_producto'];
      $costo_producto = $fila['costo_producto'];
      $utilidad_producto = $fila['utilidad_producto'];
        
       $moneda_producto = $fila['moneda_producto'];
       $valor1_producto = $fila['valor1_producto'];
       $valor2_producto = $fila['valor2_producto'];
       $valor3_producto = $fila['valor3_producto'];
        
       $stock_producto = $fila['stock_producto'];
       $stock_min_producto = $fila['stock_min_producto'];
       $date_added = $fila['date_added'];
       $image_path = $fila['image_path'];
       $tienda = $fila['tienda'];
        
       $id_imp_producto = $fila['id_imp_producto'];
       $pagina_web = $fila['pagina_web'];
       $formato = $fila['formato'];
       $url_a1 = $fila['url_a1'];
       
       $url_a2 = $fila['url_a2'];
       $url_a3 = $fila['url_a3'];
       $url_a4 = $fila['url_a4'];
       $url_a5 = $fila['url_a5'];
       
       $valor4_producto = $fila['valor4_producto'];
       
       $id_producto_origen= $fila['id_producto_origen'];
       $id_producto_marketplace= $fila['id_producto'];
      if(isset($valor4_producto)){
          
      }else{
       $valor4_producto=0;   
      }
       //echo 'valor4'.$valor4_producto.'-';
       
       $tienda = $fila['tienda'];
       $drogshipin = $fila['drogshipin'];
        
               if (isset($_SERVER['HTTPS']) &&
    ($_SERVER['HTTPS'] == 'on' || $_SERVER['HTTPS'] == 1) ||
    isset($_SERVER['HTTP_X_FORWARDED_PROTO']) &&
    $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https') {
  $protocol = 'https://';
}
else {
  $protocol = 'http://';
}
$image_path = str_replace('../..', 'sysadmin', $image_path);

        $server_url = $protocol . $_SERVER['HTTP_HOST'];
        
        if ($_SERVER['HTTP_HOST']=='localhost'){
    $carpeta = '/imporsuitv01';
}else{
 $carpeta = ''; 
}

        


$image_path=$image_path;
      //echo $image_path;
        
        $insert_query = "INSERT INTO `productos` (`id_producto`, `codigo_producto`, `nombre_producto`, "
                . "`descripcion_producto`, `id_linea_producto`, `id_med_producto`, "
                . "`id_proveedor`, `inv_producto`, `iva_producto`,"
                . " `estado_producto`, `costo_producto`, `utilidad_producto`, "
                . " `valor1_producto`, `valor2_producto`, "
                . "`valor3_producto`, `stock_producto`, `stock_min_producto`, "
                . "`date_added`, `image_path`, `id_imp_producto`, "
                . "`pagina_web`, `formato`, `url_a1`, "
                . "`url_a2`, `url_a3`, `url_a4`, "
                . "`url_a5`, `valor4_producto`, `tienda`, "
                . "`drogshipin`, `id_producto_origen`, `id_marketplace`) VALUES (NULL, '$codigo_producto', '$nombre_producto', "
                . "'$descripcion_producto', '$id_linea_producto', 0, "
                . "'$id_proveedor', '$inv_producto', '$iva_producto', "
                . "'$estado_producto', '$costo_producto', '$utilidad_producto', "
                . " '$valor1_producto', '$valor2_producto', "
                . "'$valor3_producto', '$stock_producto', '1', "
                . "'$date_added', '$image_path', '$id_imp_producto', "
                . "'$pagina_web', '$formato', '$url_a1', "
                . "'$url_a2', '$url_a3', '$url_a4', "
                . "'$url_a5', $valor4_producto, '$tienda', '1',$id_producto_origen, $id_producto_marketplace );";
        
        //echo $insert_query;
        
         if (!$conexion->query($insert_query)) {
            echo "Error al insertar datos: " . $destino->error;
            
          
        }else{
            $ultimo_id = $conexion->insert_id;
          //  echo "SELECT * FROM landing where id_producto=$id";
            $sql_landing = "SELECT * FROM landing where id_producto=$id";
$query_landing = mysqli_query($destino, $sql_landing);
    $query_landing_existe      = mysqli_num_rows($query_landing);
  //  echo $query_landing_existe;
    if ($query_landing_existe == true) {
        //update
  
       
        while ($fila_landing = $query_landing->fetch_assoc()) {
        $contenido = $fila_landing['contenido'];
        $contenido=$contenido;
          $insert_query_landing = "INSERT INTO `landing`(`id_producto`,`contenido`) values ($ultimo_id, '$contenido')";
         // echo $insert_query_landing; 
          if (!$conexion->query($insert_query_landing)) {
            echo "Error al insertar landing: " . $conexion->error;
            
          
        }else{
            
            // Consulta SQL para actualizar el campo "tienda"
$sql = "UPDATE productos SET tienda = 'enviado' WHERE id_producto = $id";

if ($conexion->query($sql) === TRUE) {
   header("Location: ../html/productos.php", TRUE, 301);
} else {
    echo "Error en la actualización: " . $conexion->error;
}

        }  
        }
    }  
      
 $sql = "UPDATE productos SET tienda = 'enviado' WHERE id_producto = $id";

if ($conexion->query($sql) === TRUE) {
   header("Location: ../html/productos.php", TRUE, 301);
} else {
    echo "Error en la actualización: " . $conexion->error;
}

header("Location: ../html/productos.php", TRUE, 301);

        }
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