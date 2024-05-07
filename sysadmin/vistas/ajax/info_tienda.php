<?php

$get_datos = json_decode(file_get_contents('php://input'), true);
$tienda = $get_datos['tienda'];
$conexion_marketplace = mysqli_connect('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');
$sql = "SELECT * FROM plataformas WHERE nombre_tienda = '$tienda' or url_imporsuit like '%$tienda.%'";
$query = mysqli_query($conexion_marketplace, $sql);
$datos = mysqli_fetch_array($query);

$nombre = $datos['contacto'];
$telefono = $datos['whatsapp'];
$correo = $datos['email'];
$enlace = $datos['url_imporsuit'];

echo '
<div class="card">
    <div class="card-header">
        <h5 class="card-title
        ">Información de la tienda</h5>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control" id="nombre" value="' . $nombre . '" readonly>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group
                ">
                    <label for="telefono">Teléfono</label>
                    <input type="text" class="form-control" id="telefono" value="' . $telefono . '" readonly>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="correo">Correo</label>
            <input type="text" class="form-control" id="correo" value="' . $correo . '" readonly>
        </div>
        <div class="form-group">
            <label for="enlace">Enlace</label>
            <input type="text" class="form-control" id="enlace" value="' . $enlace . '" readonly>
        </div>
    </div>
</div>
    
';
