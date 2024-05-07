<?php
require '../../vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/

if (empty($_POST['email'])) {
    $errors[] = "Corre vacio";
} else if (!empty($_POST['email'])) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    
    $email      = mysqli_real_escape_string($conexion, (strip_tags($_POST["email"], ENT_QUOTES)));
    $claveaccesomodal      = mysqli_real_escape_string($conexion, (strip_tags($_POST["claveaccesomodal"], ENT_QUOTES)));
    $iddelcliente      = $_POST["iddelcliente"];
    $perfilcliente        = mysqli_query($conexion, "SELECT * FROM clientes where id_cliente='".$iddelcliente."'");
    $rwcliente         = mysqli_fetch_array($perfilcliente);
    //perfil
    $perfilperfil        = mysqli_query($conexion, "SELECT * FROM perfil where id_perfil=1");
    $rwperfil         = mysqli_fetch_array($perfilperfil);
    //var_dump($rwcliente['nombre_cliente']);die;
    $archivoxml = '../assets/comprobantes/autorizados/'.$claveaccesomodal.'.xml';
    $archivopdf = '../assets/comprobantes/autorizados/NC_'.$claveaccesomodal.'.pdf';
    
    try {
        
        $mail = new PHPMailer;
        $mail->isSMTP();
        
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;

        $mail->Username = 'pulgajuan1999@gmail.com';
        $mail->Password = 'eckvrkwovnyqrtwf';

        $mail->setFrom('pulgajuan1999@gmail.com', 'Comprobantes Electronicos');
        //$mail->addAddress('juanpulga99o@gmail.com', 'Bunea');
        $mail->addAddress($email, 'Copia');
        $mail->Subject = $rwperfil['nombre_empresa'];
        $mail->AddAttachment($archivoxml);
        $mail->AddAttachment($archivopdf);
        
        $mail->Body = 'Estimado(a),
        '.$rwcliente['nombre_cliente'].'
        Esta es una notificacion automatica de un documento tributario electronico emitido por'. $rwperfil['nombre_empresa'] .'
        Nro de Comprobante: '.$rwperfil['codigo_establecimiento'].'-'.$rwperfil['codigo_punto_emision'].'-'.$rwperfil['secuencialcredito'].'
        Los detalles generales del comprobante pueden ser consultados en el archivo pdf adjunto en este correo.
        Atentamente,'. $rwperfil['nombre_empresa'];
        $mail->send();
        $messages[] = "El correo se ah enviado correctamente.";
    } catch (\Throwable $th) {
        $errors[] = "Lo siento el correo o contraseña del smtp estan incorrectos";
    }
    //$mail->addAttachment('attachment.txt');
    /*if (!$mail->send()) {
        echo 'Mailer Error: ' . $mail->ErrorInfo;
    } else {
        echo 'El mensaje de correo electrónico fue enviado.';
    }*/
    
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