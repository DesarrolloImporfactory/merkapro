<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
/* Connect To Database*/
require_once "../db.php";
require_once "../php_conexion.php";
// escaping, additionally removing everything that could be (html/javascript-) code

//$contenido      = $_POST['contenido'];

// check if user or email address already exists
// Nombre de la tabla que deseas copiar
$tabla = 'productos';

// Configuración de la base de datos de destino
if ($_SERVER['HTTP_HOST']=='localhost'){
    $destino = new mysqli('localhost', 'root', '', 'prueba_imporsuit');
}else{
 $destino = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');   
}

if ($destino->connect_error) {
    die('Error en la conexión a la base de datos de destino: ' . $destino->connect_error);
}

// Recibir la variable 'info' enviada desde JavaScript
$info = $_POST['info'];
$info = json_decode($info, true);

// Preparar la consulta SQL para insertar los datos en la tabla productos
$stmt = $conexion->prepare("INSERT INTO $tabla (codigo_producto, nombre_producto, descripcion_producto, id_linea_producto, id_proveedor, 
inv_producto, iva_producto, estado_producto, costo_producto, utilidad_producto, valor1_producto, valor2_producto, valor3_producto, 
stock_producto, stock_min_producto, date_added, image_path, id_imp_producto, pagina_web, formato, tienda, drogshipin) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?
, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

// Asociar parámetros con valores y ejecutar la consulta
$stmt->bind_param("sssiiiiididddiissiiisi", $codigo_producto, $nombre_producto, $descripcion_producto, $id_linea_producto, $id_proveedor, $inv_producto, $iva_producto, 
$estado_producto, $costo_producto, $utilidad_producto, $valor1_producto, $valor2_producto, $valor3_producto, $stock_producto, $stock_min_producto, $date_added, 
$image_path, $id_imp_producto, $pagina_web, $formato, $tienda, $drogshipin);

$codigo_producto = $info['id'];
$nombre_producto = $info['name'];
if($info['description'] === null){
    $descripcion_producto = '';
}else{
    $descripcion_producto = $info['description'];
}

$descripcion_producto = quitarEmojis($descripcion_producto);

$id_linea_producto = 70; //no estoy seguro como funciona el id_linea_producto
$id_proveedor = 6; // temporal hasta que tengamos el proveedor de dropi bien normalizado en la base de datos
$inv_producto = 0;
$iva_producto = 0;
$estado_producto = 1;
$costo_producto = $info['sale_price'];
$utilidad_producto = 0;
$valor1_producto = $info['suggested_price'];
$valor2_producto = $info['sale_price'];
$valor3_producto = $info['suggested_price'];
$stock_producto = $info['stock'];
$stock_min_producto = 0;
date_default_timezone_set('America/Guayaquil');
$fechaHoraEcuador = date('Y-m-d H:i:s');
$date_added = $fechaHoraEcuador;
// Hacer algo con la variable 'info' recibida
$imagen = count($info['gallery']);
if($imagen !== 0){
    $imagen -=1;
    if($info['gallery'][$imagen]['urlS3'] === null){
        $image_path = 'https://api.dropi.ec/'.$info['gallery'][$imagen]['url'].'';
    }else{
        $image_path = 'https://d39ru7awumhhs2.cloudfront.net/'.$info['gallery'][$imagen]['urlS3'].'';
    }
}else{
    $image_path = 'https://cdn.icon-icons.com/icons2/2633/PNG/512/office_gallery_image_picture_icon_159182.png';
}
$id_imp_producto = 0;
$pagina_web = 1;
$formato = 1;
$tienda = 'https://app.dropi.ec/'; //temporal pueso que variaria dependiendo de la eleccion del pais
$drogshipin = 2;

$stmt->execute();

// Verificar si la consulta se ejecutó correctamente
if ($stmt->affected_rows > 0) {
  echo "Datos insertados correctamente en la tabla productos.";
} else {
  echo "Error al insertar datos en la tabla productos: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();

//print_r($info['gallery']);
//echo $info['gallery'];

function quitarEmojis($texto) {
    $regexEmojis = '/([\x{1F600}-\x{1F64F}]|[\x{1F300}-\x{1F5FF}]|[\x{1F680}-\x{1F6FF}]|[\x{1F700}-\x{1F77F}]|[\x{1F780}-\x{1F7FF}]|[\x{1F800}-\x{1F8FF}]|[\x{1F900}-\x{1F9FF}]|[\x{1FA00}-\x{1FA6F}]|[\x{1FA70}-\x{1FAFF}]|[\x{2600}-\x{26FF}]|[\x{2700}-\x{27BF}]|[\x{2B50}])/ux';
    return preg_replace($regexEmojis, '', $texto);
}