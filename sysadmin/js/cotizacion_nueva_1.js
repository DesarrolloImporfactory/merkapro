$(document).ready(function () {
  $("#resultados").load("../ajax/agregar_tmp_cot_n.php?parametro=" + parametro);
  $("#f_resultado").load("../ajax/incrementa_fact_cot_n.php");
  $("#datos_factura").load();
  $("#barcode").focus();
  //alert($("#id_producto_importar").val())
  if ($("#id_producto_importar").val() != 0) {
    //alert($("#id_producto_importar").val())
    id_prodcuto = $("#id_producto_importar").val();
    precio_importar = $("#precio_importar").val();
    //alert(precio_importar)
    agregar_prod(id_prodcuto);
  }
  load(1);
});

function load(page) {
  parametro = $("#parametro").val();
  //  alert(parametro)
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/productos_modal_ventas_n.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&parametro=" +
      parametro,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      //  alert(data);
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}

function agregar(id) {
  //alert();
  var precio_venta = document.getElementById("precio_venta_" + id).value;
  var cantidad = document.getElementById("cantidad_" + id).value;
  //quita el disabled

  document.getElementById("provinica").disabled = false;
  //Inicia validacion
  if (isNaN(cantidad)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO"
    );
    document.getElementById("cantidad_" + id).focus();
    return false;
  }
  if (isNaN(precio_venta)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "EL PRECIO NO ES UN NUMERO, INTENTAR DE NUEVO"
    );
    document.getElementById("precio_venta_" + id).focus();
    return false;
  }
  //Fin validacion
  $.ajax({
    type: "POST",
    url: "../ajax/agregar_tmp_modalcot_n.php",
    data:
      "id=" +
      id +
      "&precio_venta=" +
      precio_venta +
      "&cantidad=" +
      cantidad +
      "&operacion=" +
      2,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      //alert(datos);
      $("#resultados").html(datos);
      if (
        $("#ciudad_entrega").val() == 0 ||
        $("#ciudad_entrega").val() == null ||
        $("#ciudad_entrega").val() == ""
      ) {
      } else {
        calcular_guia($("#cod").val());
        var id_provincia = $("#ciudad_entrega").val();
        var id_producto = $("#cod").val();
        calcular_servi(id_provincia, id_producto);
      }
      //alert($("#valor_total_").val());
    },
  });
}
function sanitizeInput(selector, regex) {
  $(selector).on("input", function () {
    var input = $(this).val();
    var sanitizedInput = input.replace(regex, "");
    $(this).val(sanitizedInput);
  });
}

// Campos que permiten letras, números, espacios, comas y puntos
const commonRegex = /[^0-9a-zA-Z\s,\.]/g;

sanitizeInput("#nombred", commonRegex);
sanitizeInput("#calle_principal", commonRegex);
sanitizeInput("#calle_secundaria", commonRegex);
sanitizeInput("#referencia", commonRegex);
sanitizeInput("#observacion", commonRegex);

// Campos que solo permiten números
const numberRegex = /[^0-9]/g;

sanitizeInput("#telefonod", numberRegex);
sanitizeInput("#celulard", numberRegex);
sanitizeInput("#numerocasa", commonRegex);

function agregar_prod(id) {
  //alert(id);
  var precio_venta = $("#precio_importar").val();
  var cantidad = 1;
  //quita el disabled

  document.getElementById("provinica").disabled = false;
  //Inicia validacion
  if (isNaN(cantidad)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO"
    );
    document.getElementById("cantidad_" + id).focus();
    return false;
  }
  if (isNaN(precio_venta)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "EL PRECIO NO ES UN NUMERO, INTENTAR DE NUEVO"
    );
    document.getElementById("precio_venta_" + id).focus();
    return false;
  }
  //Fin validacion
  $.ajax({
    type: "POST",
    url: "../ajax/agregar_tmp_modalcot_n.php",
    data:
      "id=" +
      id +
      "&precio_venta=" +
      precio_venta +
      "&cantidad=" +
      cantidad +
      "&operacion=" +
      2,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      //alert(datos);
      $("#resultados").html(datos);
      //alert($("#valor_total_").val());
    },
  });
}
//CONTROLA EL FORMULARIO DEL CODIGO DE BARRA
$("#barcode_form").submit(function (event) {
  var id = $("#barcode").val();
  var cantidad = $("#barcode_qty").val();
  var id_sucursal = 0;
  //Inicia validacion
  if (isNaN(cantidad)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO"
    );
    $("#barcode_qty").focus();
    return false;
  }
  //Fin validacion
  parametros = {
    operacion: 1,
    id: id,
    id_sucursal: id_sucursal,
    cantidad: cantidad,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/agregar_tmp_cot.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados").html(datos);
      $("#id").val("");
      $("#id").focus();
      $("#barcode").val("");
      $("#f_resultado").load("../ajax/incrementa_fact_cot.php"); //Actualizamos el numero de Factura
    },
  });
  event.preventDefault();
});

function eliminar(id) {
  $.ajax({
    type: "GET",
    url: "../ajax/agregar_tmp_cot.php",
    data: "id=" + id,
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

$("#guardar_cliente").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/nuevo_cliente.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#guardar_datos").attr("disabled", false);
      //resetea el formulario
      $("#guardar_cliente")[0].reset();
      //desaparecer la alerta
      $(".alert-success")
        .delay(400)
        .show(10, function () {
          $(this)
            .delay(2000)
            .hide(10, function () {
              $(this).remove();
            });
        }); // /.alert
      load(1);
    },
  });
  event.preventDefault();
});
$("#guardar_producto").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/nuevo_producto.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax_productos").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax_productos").html(datos);
      $("#guardar_datos").attr("disabled", false);
      //resetea el formulario
      $("#guardar_producto")[0].reset();
      //desaparecer la alerta
      $(".alert-success")
        .delay(400)
        .show(10, function () {
          $(this)
            .delay(2000)
            .hide(10, function () {
              $(this).remove();
            });
        }); // /.alert
      load(1);
    },
  });
  event.preventDefault();
});

function imprimir_factura(user_id) {
  VentanaCentrada(
    "../pdf/documentos/corte_caja.php?user_id=" + user_id,
    "Corte",
    "",
    "724",
    "568",
    "true"
  );
}

document
  .getElementById("ciudad_entrega")
  .addEventListener("click", function () {
    console.log("xD");
  });
