<?php
$para = 'desarrollo@imporsuit.com';
$asunto = 'Prueba de correo electrónico';
$mensaje = 'Hola, esto es una prueba de correo electrónico enviado desde PHP.';

// Cabeceras del correo electrónico
$headers = 'From: desarrollo@imporsuit.com' . "\r\n" .
    'Reply-To: desarrollo@imporsuit.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

// Intenta enviar el correo electrónico
if (mail($para, $asunto, $mensaje, $headers)) {
    echo 'El correo electrónico se ha enviado correctamente.';
} else {
    echo 'Hubo un error al enviar el correo electrónico.';
}
?>
En este ejemplo:

$para es la dirección de correo electrónico del destinatario.
$asunto es el asunto del correo electrónico.
$mensaje es el contenido del correo electrónico.
$headers son las cabeceras del correo electrónico, que incluyen el remitente y otra información adicional.
Recuerda reemplazar las direcciones de correo electrónico y otros valores con los tuyos propios. Ten en cuenta que la función mail() puede no funcionar adecuadamente en todos los servidores y puede requerir una configuración adicional. También es importante tener en cuenta que el correo enviado a menudo puede ser marcado como spam si no se configura adecuadamente, especialmente en



?>