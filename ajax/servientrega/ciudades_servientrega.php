<?php

// Reemplaza 'usuario' y 'contraseña' con los valores reales
$usuario = urlencode('impor.comex');
$contrasena = urlencode('123456');
$url = "https://181.39.87.158:8021/api/ciudades/['$usuario','$contrasena']";

// Inicializa cURL
$ch = curl_init($url);

// Configura opciones de cURL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// Ignora la verificación de SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

// Ejecuta la petición
$response = curl_exec($ch);

// Verifica si hubo errores
if (curl_errno($ch)) {
    echo 'Error en la petición: ' . curl_error($ch);
} else {
    // Muestra la respuesta
    echo $response;
}

// Cierra la sesión cURL
curl_close($ch);