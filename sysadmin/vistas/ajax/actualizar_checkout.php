<?php
$data = file_get_contents("php://input");
if (!empty($data)) {
    // Reemplaza '../json/checkout.json' con la ruta correcta al archivo JSON en tu servidor
    if (file_put_contents('../json/checkout.json', $data)) {
        echo "Estado guardado correctamente";
    } else {
        header("HTTP/1.1 500 Internal Server Error");
        echo "Error al guardar el estado";
    }
} else {
    header("HTTP/1.1 400 Bad Request");
    echo "No hay datos recibidos";
}
?>