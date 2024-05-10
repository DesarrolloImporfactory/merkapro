<?php
include 'is_logged.php';  // Archivo verifica que el usuario que intenta acceder a la URL está logueado
require_once "../db.php";  // Contiene las variables de configuración para conectar a la base de datos
require_once "../php_conexion.php";  // Contiene la función que conecta a la base de datos

$response = ['status' => 'error', 'message' => 'No se recibieron datos'];

if (!empty($_POST)) {
    $id_pixel = null;
    $nombre = null;
    $pixel = null;
    $modalId = null;
    
    // Determina qué formulario fue enviado y configura las variables
    if (isset($_POST['pixel_googleTag'])) {
        $pixel = mysqli_real_escape_string($conexion, $_POST['pixel_googleTag']);
        $nombre = 'Google Tag';
        $id_pixel = 2;
        $modalId = 'google_tag';
    } elseif (isset($_POST['pixel_googleAnalytics'])) {
        $pixel = mysqli_real_escape_string($conexion, $_POST['pixel_googleAnalytics']);
        $nombre = 'Google Analytics';
        $id_pixel = 3;
        $modalId = 'google_analytics';
    } elseif (isset($_POST['pixel_tiktok'])) {
        $pixel = mysqli_real_escape_string($conexion, $_POST['pixel_tiktok']);
        $nombre = 'Tiktok';
        $id_pixel = 4;
        $modalId = 'tiktok';
    }elseif (isset($_POST['pixel_X'])) {
        $pixel = mysqli_real_escape_string($conexion, $_POST['pixel_X']);
        $nombre = 'X';
        $id_pixel = 5;
        $modalId = 'X';
    }elseif (isset($_POST['pixel_clarity'])) {
        $pixel = mysqli_real_escape_string($conexion, $_POST['pixel_clarity']);
        $nombre = 'Clarity';
        $id_pixel = 6;
        $modalId = 'clarity';
    }
    // ...agrega tantos elseif como formularios tengas.
    
    // Comprueba si existe un registro con ese id_pixel
    $checkQuery = "SELECT * FROM pixel WHERE id_pixel = ?";
    $checkStmt = mysqli_prepare($conexion, $checkQuery);
    mysqli_stmt_bind_param($checkStmt, 'i', $id_pixel);
    mysqli_stmt_execute($checkStmt);
    $resultCheck = mysqli_stmt_get_result($checkStmt);

    if ($resultCheck && mysqli_num_rows($resultCheck) > 0) {
        // Existe un registro, por lo tanto, actualizamos
        $updateQuery = "UPDATE pixel SET nombre = ?, pixel = ? WHERE id_pixel = ?";
        $updateStmt = mysqli_prepare($conexion, $updateQuery);
        mysqli_stmt_bind_param($updateStmt, 'ssi', $nombre, $pixel, $id_pixel);
        $resultUpdate = mysqli_stmt_execute($updateStmt);
        mysqli_stmt_close($updateStmt);

        if ($resultUpdate) {
            $response = ['status' => 'success', 'title' => 'Actualizado', 'message' => 'Se ha actualizado correctamente', 'modalId' => $modalId];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al actualizar'];
        }
    } else {
        // No existe, insertamos un nuevo registro
        $insertQuery = "INSERT INTO pixel (id_pixel, nombre, pixel) VALUES (?, ?, ?)";
        $insertStmt = mysqli_prepare($conexion, $insertQuery);
        mysqli_stmt_bind_param($insertStmt, 'iss', $id_pixel, $nombre, $pixel);
        $resultInsert = mysqli_stmt_execute($insertStmt);
        mysqli_stmt_close($insertStmt);

        if ($resultInsert) {
            $response = ['status' => 'success', 'title' => 'Guardado', 'message' => 'Se ha guardado correctamente', 'modalId' => $modalId];
        } else {
            $response = ['status' => 'error', 'message' => 'Error al guardar'];
        }
    }

    mysqli_close($conexion);
}

echo json_encode($response);
?>