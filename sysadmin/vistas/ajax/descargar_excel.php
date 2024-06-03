<?php
require_once "../db.php";
require_once "../php_conexion.php";
require_once "../funciones.php";
// Inicia Control de Permisos
include "../permisos.php";

$conexion_marketplace = new mysqli('localhost', 'imporsuit_marketplace', 'imporsuit_marketplace', 'imporsuit_marketplace');

if (isset($_GET['tienda'])) {
    // Escapar la entrada para evitar inyecciones SQL
    $tienda = $conexion_marketplace->real_escape_string($_GET['tienda']);

    // Consulta a la base de datos
    $sql = "SELECT * FROM cabecera_cuenta_pagar WHERE tienda = '$tienda' AND visto = 1";
    $query = mysqli_query($conexion_marketplace, $sql);

    if (mysqli_num_rows($query) > 0) {
        // Configurar cabeceras para la descarga del archivo CSV
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="datos.csv"');
        
        $output = fopen('php://output', 'w');

        // Obtener los encabezados de la tabla
        $headers = mysqli_fetch_fields($query);
        $headerRow = [];
        foreach ($headers as $header) {
            $headerRow[] = $header->name;
        }
        fputcsv($output, $headerRow);

        // Agregar los datos al archivo CSV
        while ($row = mysqli_fetch_assoc($query)) {
            fputcsv($output, $row);
        }

        fclose($output);
        exit();  // Asegúrate de cerrar el script después de la salida del archivo
    } else {
        echo "No se encontraron resultados";
    }

    $conexion_marketplace->close();
}
?>