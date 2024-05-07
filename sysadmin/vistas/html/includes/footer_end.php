<?php
@$datos = mysqli_query($conexion, "SELECT * FROM dropi");
@$datos = mysqli_fetch_assoc($datos);
if (!empty($datos)) {
?>
    <script>
        var url_origen = location.origin + "/sysadmin/vistas/ajax/texto_plano.php";
        var url_origen_login = location.origin + "/sysadmin/api/integracion/Dropi/login";

        $.ajax({
            url: url_origen,
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                // Se ejecuta cuando se obtienen las credenciales correctamente
                // Crear un nuevo objeto FormData y agregar los datos obtenidos
                var formData = new FormData();
                formData.append('correo', data['usuario']);
                formData.append('contrasena', data['contrasena']);

                // Segunda solicitud AJAX para enviar las credenciales al servidor de login
                $.ajax({
                    url: url_origen_login,
                    method: 'POST',
                    data: formData,
                    processData: false, // Evitar que jQuery procese los datos
                    contentType: false, // Evitar que jQuery establezca el Content-Type
                    success: function(responseData) {
                        // Se ejecuta cuando se obtiene una respuesta del servidor de login
                        var respuesta = JSON.parse(responseData);
                        localStorage.setItem('dropi_token', respuesta.data);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        // Se ejecuta si hay un error en la solicitud
                        console.error('Error en la solicitud:', errorThrown);
                    }
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // Se ejecuta si hay un error en la primera solicitud AJAX
                console.error('Error al obtener las credenciales:', errorThrown);
            }
        });
    </script>
<?php
}
?>
</body>

</html>