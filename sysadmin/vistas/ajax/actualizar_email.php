<?php

include("../db.php");
include("../php_conexion.php");
$get_datos = json_decode(file_get_contents('php://input'), true);

if (!empty($get_datos)) {
    $email = $get_datos['email'];
    $cedula = $get_datos['cedula'];
    $direccion = $get_datos['direccion'];
    // Corrección en la consulta SQL, cerrando la comilla simple
    $sql = "UPDATE users SET email_users = '$email', cedula_facturacion = '$cedula', direccion_facturacion = '$direccion', correo_facturacion = '$email' WHERE id_users = '1'";
    $resultado = mysqli_query($conexion, $sql);
    if ($resultado) {
        $amrketplace_db = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
        $sql = "UPDATE plataformas set direccion_facturacion = '$direccion', cedula_facturacion = '$cedula', correo_facturacion = '$email' WHERE email = '$email'";
        $resultado = mysqli_query($amrketplace_db, $sql);

        echo json_encode(array(
            "email" => $email,
            "status" => "actualizado"
        ));
    } else {
        echo json_encode(array(
            "email" => $email,
            "status" => "noactualizado"
        ));
    }
} else {
    $sql = "SELECT email_users FROM users WHERE id_users = '1'";
    $resultado = mysqli_query($conexion, $sql);
    $rw = mysqli_fetch_array($resultado);
    $email = $rw['email_users'];
    if ($email === "root@admin.com") {
        // Corrección en cómo se devuelve el JSON
        echo json_encode(array(
            "email" => $email,
            "status" => "cambio"
        ));
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Corrección en cómo se devuelve el JSON
        echo json_encode(array(
            "email" => $email,
            "status" => "cambio"
        ));
    } else {
        // Corrección en cómo se devuelve el JSON
        echo json_encode(array(
            "email" => $email,
            "status" => "nocambio"
        ));
    }
}
