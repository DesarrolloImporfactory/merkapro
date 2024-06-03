<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'is_logged.php';


$tienda = $_SESSION['tienda'];
require_once "../db.php";
$cantidad = 0;
if (empty($_POST['abono'])) {
    $errors[] = "Cantidad vacía";
} elseif (!empty($_POST['abono'])) {
    require_once "../php_conexion.php";
    require_once "../funciones.php";

    $abono = floatval($_POST['abono']);
    $cantidad = $abono;
    $total_abonado = $abono;
    $forma_pago = $_POST["forma_pago"];

    $imagen = $_FILES['img']['name'];
    $ruta = $_FILES['img']['tmp_name'];

    $nombre_alterado = date("Y-m-d-H-i-s") . "-" . $imagen;
    $url_ubicacion = "https://marketplace.imporsuit.com/sysadmin/img/facturas/" . $nombre_alterado;

    $destino = "../../img/facturas/" . $nombre_alterado;
    copy($ruta, $destino);

    $user_id  = $_SESSION['id_users'];
    $fecha    = date("Y-m-d H:i:s");

    $numero_documento = "SALDAR-";
    $random = rand(1000, 9999);
    $numero_documento .= $random;

    $total_abonado *= -1;

    $sql_pago = "INSERT INTO `pagos`(`fecha`, `numero_documento`, `valor`, `forma_pago`, `tienda`, `imagen`) VALUES ('$fecha', '$numero_documento', $total_abonado, '$forma_pago', '$tienda', '$url_ubicacion');";
    $query_pago = mysqli_query($conexion, $sql_pago);
} else {
    $errors[] = "Error desconocido.";
}
