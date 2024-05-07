<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
$data = $_POST['id'];

$conexion_market = mysqli_connect("localhost", "imporsuit_marketplace", "imporsuit_marketplace", "imporsuit_marketplace");
$sql = "UPDATE plataformas SET tieneDrag = 1 WHERE id_plataforma = $data";

$query = mysqli_query($conexion_market, $sql);

if ($query) {
    $imporsuit_db = mysqli_connect("194.163.183.231", 'administrador', '69635201d674bcb6f0897604c7c97cf8', 'suit-imporcomex');
    $url_site = $_SERVER['HTTP_HOST'];
    echo $url_site;
    $sql_usuario = "SELECT * FROM users WHERE url like '%" . $url_site . "%'";
    $query_usuario = mysqli_query($imporsuit_db, $sql_usuario);
    $rw_usuario = mysqli_fetch_array($query_usuario);
    echo mysqli_error($imporsuit_db);
    $users = $rw_usuario['id'];
    $pagina_data = $url_site . "_cabecera";
    $descripcion = "Cabecera de la página " . $url_site;

    $drag_db = mysqli_connect("194.163.183.231", 'administrador', '69635201d674bcb6f0897604c7c97cf8', 'drag');
    $drag_drop_sql_cabecera = "INSERT INTO pagebuilder__pages (name, title, description, slug, settings, status, user_id) VALUES ('$pagina_data', '$pagina_data', '$descripcion', '$pagina_data', '', 'published', $users)";
    $query_drag = mysqli_query($drag_db, $drag_drop_sql);

    $pagina_data = $url_site . "_footer";
    $drag_drop_sql_footer = "INSERT INTO pagebuilder__pages (name, title, description, slug, settings, status, user_id) VALUES ('$pagina_data', '$pagina_data', '$descripcion', '$pagina_data', '', 'published', $users)";
    $query_drag = mysqli_query($drag_db, $drag_drop_sql);

    $pagina_data = $url_site . "_categorias";
    $drag_drop_sql_categorias = "INSERT INTO pagebuilder__pages (name, title, description, slug, settings, status, user_id) VALUES ('$pagina_data', '$pagina_data', '$descripcion', '$pagina_data', '', 'published', $users)";
    $query_drag = mysqli_query($drag_db, $drag_drop_sql);

    $pagina_data = $url_site . "_main";
    $drag_drop_sql_main = "INSERT INTO pagebuilder__pages (name, title, description, slug, settings, status, user_id) VALUES ('$pagina_data', '$pagina_data', '$descripcion', '$pagina_data', '', 'published', $users)";
    $query_drag = mysqli_query($drag_db, $drag_drop_sql);
} else {
    echo "No se ha podido actualizar el registro";
}
