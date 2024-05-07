<?php
include 'is_logged.php'; //Archivo verifica que el usario que intenta acceder a la URL esta logueado
/*Inicia validacion del lado del servidor*/
if (empty($_POST['mod_id'])) {
    $errors[] = "ID vacío";
} else if (
    !empty($_POST['mod_id'])
) {
    /* Connect To Database*/
    require_once "../db.php";
    require_once "../php_conexion.php";
    require_once "../funciones.php";
    // escaping, additionally removing everything that could be (html/javascript-) code
    //$nombre      = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_nombre"], ENT_QUOTES)));
    //$descripcion = mysqli_real_escape_string($conexion, (strip_tags($_POST["mod_descripcion"], ENT_QUOTES)));
    $estado      = intval($_POST['mod_estado']);
    $id      = intval($_POST['mod_id']);

    $sql = "UPDATE wallet_cot SET  estado_factura=" . $estado . "
                                WHERE id_factura='" . $id . "'";
    $query_update = mysqli_query($conexion, $sql);

    if ($estado == 8) {
        $guia = get_row('guia_laar', 'guia_laar', 'id_pedido', $id);
        $authData = array(
            "username" => "prueba.importshop.api",
            "password" => "!mp0rt@sh@23"
        );

        $authDataJSON = json_encode($authData);

        // URL y datos para la autenticación
        $authURL = 'https://api.laarcourier.com:9727/authenticate';
        $authHeaders = array(
            'accept: application/json',
            'Content-Type: application/json',
        );

        // Inicializar cURL para la autenticación
        $chAuth = curl_init($authURL);
        curl_setopt($chAuth, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($chAuth, CURLOPT_POSTFIELDS, $authDataJSON);
        curl_setopt($chAuth, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($chAuth, CURLOPT_HTTPHEADER, $authHeaders);

        // Ejecutar la solicitud de autenticación y obtener la respuesta
        $authResponse = curl_exec($chAuth);

        // Verificar si la autenticación fue exitosa
        $httpCode = curl_getinfo($chAuth, CURLINFO_HTTP_CODE);
        if ($httpCode !== 200) {
            echo 'Error en la autenticación. Código de estado: ' . $httpCode;
            // Manejar el error apropiadamente
        } else {
            // Decodificar la respuesta JSON de autenticación
            $authResult = json_decode($authResponse, true);

            // Obtener el token de autenticación
            $token = $authResult['token'];

            // URL para la solicitud DELETE
            $deleteURL = 'https://api.laarcourier.com:9727/guias/anular/' . $guia;

            // Inicializar cURL para la solicitud DELETE con la cabecera de autenticación
            $chDelete = curl_init($deleteURL);
            $deleteHeaders = array(
                'Authorization: Bearer ' . $token,
            );

            curl_setopt($chDelete, CURLOPT_CUSTOMREQUEST, 'DELETE');
            curl_setopt($chDelete, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($chDelete, CURLOPT_HTTPHEADER, $deleteHeaders);

            // Ejecutar la solicitud DELETE y obtener la respuesta
            $deleteResponse = curl_exec($chDelete);

            // Verificar si la solicitud DELETE fue exitosa
            $deleteHttpCode = curl_getinfo($chDelete, CURLINFO_HTTP_CODE);
            if ($deleteHttpCode === 200) {

                echo 'ok';
            } else {
                echo 'Error al enviar la solicitud DELETE. Código de estado: ' . $deleteHttpCode;
                // Manejar el error apropiadamente
            }

            // Cerrar las conexiones cURL
            curl_close($chDelete);
        }

        // Cerrar la conexión cURL de autenticación
        curl_close($chAuth);
    }


    //echo $sql; 

    if ($query_update) {
        $messages[] = "Linea ha sido actualizada con Exito.";
    } else {
        $errors[] = "Lo siento algo ha salido mal intenta nuevamente." . mysqli_error($conexion);
    }
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