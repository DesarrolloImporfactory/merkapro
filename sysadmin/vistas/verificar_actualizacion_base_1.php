<?php
//$repositoryPath = 'C:\xampp\htdocs\imporsuitv01'; // Reemplaza con la ruta de tu repositorio
require_once "db.php";
require_once "php_conexion.php";
   // require_once "sysadmin/vistas/funciones.php";
    
    // Consulta para verificar la existencia del campo
    
//29-10-2023 aumentar campo id_producto en testimonios
$query = "SELECT id_producto FROM testimonios LIMIT 1";
@$result = mysqli_fetch_array($query);
if (!$result) {
    
    
    $query = mysqli_query($conexion, "ALTER TABLE `testimonios` ADD `id_producto` INT NOT NULL AFTER `date_added`;");
   
} 

//29-10-2023 aumentar campo id_articulo en testimonios

$query = "SELECT habilitar_proveedor FROM perfil LIMIT 1";
@$result = mysqli_fetch_array($query);
if (!$result) {
    //echo 'pasa';
    
    $query = mysqli_query($conexion, "ALTER TABLE `perfil` ADD `habilitar_proveedor` INT NOT NULL AFTER `flotante`;");
   
} 


$query = "SELECT habilitar_proveedor FROM perfil LIMIT 1";
@$result = mysqli_fetch_array($query);
if (!$result) {
    echo 'pasa';
    echo "ALTER TABLE `productos` ADD `tienda` VARCHAR(500) NOT NULL AFTER `valor4_producto`;";
    $query = mysqli_query($conexion, "ALTER TABLE `productos` ADD `tienda` VARCHAR(500) NOT NULL AFTER `valor4_producto`;");
   
} 

$query = "SELECT habilitar_proveedor FROM perfil LIMIT 1";
@$result = mysqli_fetch_array($query);
if (!$result) {
    //echo 'pasa';
    
    $query = mysqli_query($conexion, "ALTER TABLE `productos` ADD `drogshipin` INT NOT NULL DEFAULT '0' AFTER `tienda`;");
   
} 

?>


