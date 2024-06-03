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

    $numero_factura = $_POST['comprobante'];

    $sql_pago = "INSERT INTO `pagos`(`fecha`, `numero_documento`, `valor`, `forma_pago`, `tienda`, `imagen`) VALUES ('$fecha', '$numero_factura', $total_abonado, '$forma_pago', '$tienda', '$url_ubicacion');";
    $resultado_pago = mysqli_query($conexion, $sql_pago);

    date_default_timezone_set('America/Guayaquil');
    $fecha = date('Y-m-d H:i:s');

    $sql_billetera = "SELECT * FROM billeteras WHERE tienda = '$tienda'";
    $resultado_billetera = mysqli_query($conexion, $sql_billetera);
    $rw_billetera = mysqli_fetch_array($resultado_billetera);
    $id_billetera = $rw_billetera['id_billetera'];

    $sql_historial = "INSERT INTO `historial_billetera`(`fecha`, `motivo`, `monto`,`tipo`, `id_billetera`) VALUES ('$fecha', 'Retiro de dinero de la tienda', '$total_abonado','Salida', '$id_billetera');";
    $resultado_historial = mysqli_query($conexion, $sql_historial);

    echo mysqli_error($conexion);

    $sql_billetera = "UPDATE billeteras SET saldo = ROUND(saldo - '$total_abonado', 2) WHERE tienda = '$tienda'";
    $resultado_billetera = mysqli_query($conexion, $sql_billetera);
}


require_once '../../PHPMailer/PHPMailer.php';
require_once '../../PHPMailer/SMTP.php';
require_once '../../PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

$correo = "SELECT * FROM datos_banco_usuarios WHERE tienda = '$tienda'";
$resultado_correo = mysqli_query($conexion, $correo);
$datos_correo = mysqli_fetch_assoc($resultado_correo);

$correo = $datos_correo['correo'];
$nombre = $datos_correo['nombre'];
$banco = $datos_correo['banco'];
$tipo_cuenta = $datos_correo['tipo_cuenta'];
$numero_cuenta = $datos_correo['numero_cuenta'];
$cedula = $datos_correo['cedula'];
$telefono = $datos_correo['telefono'];

include '../../PHPMailer/Mail_pago.php';

$mail = new PHPMailer(true);
try {
    //Server settings

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->SMTPDebug = $smtp_debug;
    $mail->Host = $smtp_host;
    $mail->SMTPAuth = true;
    $mail->Username = $smtp_user;
    $mail->Password = $smtp_pass;
    $mail->Port = 465;
    $mail->SMTPSecure = $smtp_secure;

    $mail->isHTML(true);
    $mail->CharSet = 'UTF-8';
    $mail->setFrom($smtp_from, $smtp_from_name);
    $mail->addAddress($correo);
    $mail->Subject = 'Solicitud de pago ' . $tienda;
    $mail->Body = $message_body3;


    if ($mail->send()) {
    } else {
        echo $mail->ErrorInfo;
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

if (isset($errors)) {
?>
    <div class="alert alert-danger" role="alert">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
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
        <button type="button" class="close" data-dismiss="alert">&times;</button>
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