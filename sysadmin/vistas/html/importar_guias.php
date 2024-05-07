<script>
    async function cargar(factura) {
        await fetch('https://marketplace.imporsuit.com/sysadmin/api/integracion/Laar/guias', {
            method: 'POST',
            body: JSON.stringify({
                factura: factura
            })
        });
    }
</script>
<?php
// Al inicio del script
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
/* Connect To Database*/
require_once "../db.php"; //Contiene las variables de configuracion para conectar a la base de datos
require_once "../php_conexion.php"; //Contiene funcion que conecta a la base de datos
//Inicia Control de Permisos
include "../permisos.php";


$sql = "SELECT numero_factura FROM `cabecera_cuenta_pagar`;";
$consultar = mysqli_query($conexion, $sql);

// Imprimir todas las filas
while ($rw = mysqli_fetch_assoc($consultar)) {
    print_r($rw);
}

?>