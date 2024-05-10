$(document).ready(function() {
  $('#nombre_producto').on('keyup', function() {
      cargarDatos($(this).val());
  });

  function cargarDatos(query = '') {
      $.ajax({
          url: '../ajax/buscar_productos_inventario.php',
          type: 'GET',
          data: { nombre_producto: query }, // Enviar la query como parámetro
          success: function(response) {
              $('#loader1').html(response);
          },
          error: function() {
              $('#loader1').html('Error al cargar los datos');
          }
      });
  }

  // Llamar a cargarDatos sin parámetros para cargar todos los productos inicialmente
  cargarDatos();
});
$('#btnBuscar').on('click', function() {
  var query = $('#nombre_producto').val();
  cargarDatos(query);
});