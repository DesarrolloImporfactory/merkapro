<?php
// Recibir los datos enviados desde el cliente
$datos = json_decode(file_get_contents('php://input'), true);

// Convertir el array combinado a formato JSON
$nuevo_contenido_json = json_encode($datos);

// Escribir el nuevo contenido JSON en el archivo
file_put_contents('../json/datos_dropi_new.json', $nuevo_contenido_json);


// Obtener el contenido actual del archivo JSON
$contenido_json = file_get_contents('../json/datos_dropi_new.json');

print_r($contenido_json)
?>
