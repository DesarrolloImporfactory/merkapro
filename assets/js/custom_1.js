function cargar() {
  var sesion = $("#session").val();

  //  alert(sesion)
  $.ajax({
    type: "POST",
    url: "ajax/agregar_tmp_modalventas.php",
    data: "sesion=" + sesion,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
      // total = $("#total_c").val();
      //$("#q").val();
      // alert(total)
    },
    success: function (datos) {
      // alert(datos)
      $("#resultados").html(datos);
    },
  });
}
function terminar_compra() {
  sesion = $("#session").val();
  nombre = $("#nombre").val();
  telefono = $("#telefono").val();
  ciudad = $("#ciudad").val();
  direccion = $("#direccion").val();
  cliente = 1;
  //fbq("track", "Purchase");

  $.ajax({
    type: "POST",
    url: "ajax/guardar_cotizacion.php",
    data:
      "session=" +
      sesion +
      "&cliente=" +
      cliente +
      "&nombre=" +
      nombre +
      "&telefono=" +
      telefono +
      "&ciudad=" +
      ciudad +
      "&direccion=" +
      direccion,
    beforeSend: function (objeto) {
      window.location.href = "gracias.php";
    },
    success: function (datos) {
      // $("#resultados").html(datos);
    },
  });
}

function agregar_tmp(id, precio_venta) {
  //fbq("track", "AddToCart");
  //fbq("track", "InitiateCheckout");
  cantidad = 1;
  //Fin validacion
  // alert(id);
  sesion = $("#session").val();
  $.ajax({
    type: "POST",
    url: "ajax/agregar_tmp_modalventas_1.php",
    data:
      "id=" +
      id +
      "&precio_venta=" +
      precio_venta +
      "&cantidad=" +
      cantidad +
      "&operacion=" +
      2 +
      "&sesion=" +
      sesion,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
      // total = $("#total_c").val();
      //$("#q").val();
      // alert(total)
    },
    success: function (datos) {
      // alert(datos)
      $("#resultados").html(datos);
    },
  });
}

function eliminar(id) {
  sesion = $("#session").val();
  //alert(sesion)
  $.ajax({
    type: "GET",
    url: "ajax/eliminar_tmp.php",
    data: "id=" + id + "&sesion=" + sesion,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados").html(datos);
    },
  });
}
