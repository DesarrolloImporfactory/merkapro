<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

include 'is_logged.php'; // Verifica que el usuario esté logueado
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['query'])) {
    $searchQuery = $_POST['query'];
    $searchQuery = "%{$searchQuery}%"; // Adecuar para la búsqueda con LIKE

    // Preparar la consulta SQL
    $stmt = $conexion->prepare("SELECT id_producto, nombre_producto FROM productos WHERE nombre_producto LIKE ?");
    $stmt->bind_param("s", $searchQuery);
    $stmt->execute();
    $result = $stmt->get_result();

    $suggestions = [];
    while ($row = $result->fetch_assoc()) {
        array_push($suggestions, ['id_producto' => $row['id_producto'], 'nombre_producto' => $row['nombre_producto']]);
    }
    echo json_encode($suggestions); // Devuelve el ID y el nombre del producto como JSON

    $stmt->close();
}
?>