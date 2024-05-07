$(document).ready(function () {
  load(1);
});
$("#editar_linea").submit(function (event) {
  // alert();
  $("#actualizar_datos").attr("disabled", true);
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/editar_pedido.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajax2").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax2").html(datos);
      $("#actualizar_datos").attr("disabled", false);
      //load(1);
      $("#editarLinea").modal("hide");

      window.setTimeout(function () {
        $(".alert")
          .fadeTo(200, 0)
          .slideUp(200, function () {
            $(this).remove();
          });
      }, 2000);
    },
  });
  event.preventDefault();
});
function load(page) {
  var q = $("#q").val();
  var tienda = $("#tienda_q").val();
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  var url = "";

  if (tienda != 0) {
    url =
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&numero=" +
      numero;
  } else if (estado != 0) {
    url =
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&estado=" +
      estado +
      "&numero=" +
      numero;
  } else if (tienda != 0 && estado != 0) {
    url =
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&estado=" +
      estado +
      "&numero=" +
      numero;
  } else {
    url =
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&q=" +
      q +
      "&numero=" +
      numero;
  }
  $("#loader").fadeIn("slow");
  $.ajax({
    url: url,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
    },
  });
}

function buscar(tienda) {
  // alert(tienda)
  var q = $("#q").val();
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (estado == 0) {
    estado = "";
  }
  if (numero == 0) {
    numero = "";
  }
  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&tienda=" +
      tienda +
      "&q=" +
      q +
      "&estado=" +
      estado +
      "&numero=" +
      numero,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
    },
  });
}

function buscar_estado(estado) {
  // alert(tienda)
  var q = $("#q").val();
  var tienda = $("#tienda_q").val();
  var numero = $("#numero_q").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (estado == 0) {
    estado = "";
  }
  if (numero == 0) {
    numero = "";
  }
  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&estado=" +
      estado +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&numero=" +
      numero,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
    },
  });
}

$("#dataDelete").on("show.bs.modal", function (event) {
  var button = $(event.relatedTarget); // Botón que activó el modal
  var id = button.data("id"); // Extraer la información de atributos de datos
  var modal = $(this);
  modal.find("#id_factura").val(id);
});
$("#eliminarDatos").submit(function (event) {
  var parametros = $(this).serialize();
  $.ajax({
    type: "POST",
    url: "../ajax/eliminar_factura.php",
    data: parametros,
    beforeSend: function (objeto) {
      $(".datos_ajax_delete").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $(".datos_ajax_delete").html(datos);
      $("#dataDelete").modal("hide");
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

function imprimir_factura(id_factura) {
  VentanaCentrada(
    "../pdf/documentos/ver_cotizacion.php?id_factura=" + id_factura,
    "Factura",
    "",
    "724",
    "568",
    "true"
  );
}
// print order function
function printOrder(id_factura) {
  if (id_factura) {
    $.ajax({
      url: "../pdf/documentos/imprimir_factura.php",
      type: "post",
      data: {
        id_factura: id_factura,
      },
      dataType: "text",
      success: function (response) {
        var mywindow = window.open(
          "",
          "Stock Management System",
          "height=400,width=600"
        );
        mywindow.document.write("<html><head><title>Facturación</title>");
        mywindow.document.write("</head><body>");
        mywindow.document.write(response);
        mywindow.document.write("</body></html>");
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();
      }, // /success function
    }); // /ajax function to fetch the printable order
  } // /if orderId
} // /print order function
// print order function
function print_ticket(id_factura) {
  if (id_factura) {
    $.ajax({
      url: "../pdf/documentos/imprimir_venta_edit.php",
      type: "post",
      data: {
        id_factura: id_factura,
      },
      dataType: "text",
      success: function (response) {
        var mywindow = window.open(
          "",
          "Stock Management System",
          "height=400,width=600"
        );
        mywindow.document.write("<html><head><title>Facturación</title>");
        mywindow.document.write("</head><body>");
        mywindow.document.write(response);
        mywindow.document.write("</body></html>");
        mywindow.document.close(); // necessary for IE >= 10
        mywindow.focus(); // necessary for IE >= 10
        mywindow.print();
        mywindow.close();
      }, // /success function
    }); // /ajax function to fetch the printable order
  } // /if orderId
} // /print order function

function obtener_datos(id) {
  var estado = $("#estado_sistema" + id).val();
  // alert(estado);

  $("#mod_estado").val(estado);
  $("#mod_id").val(id);

  $("#editar_linea").submit(); // Esto activará el envío del formulario con el ID "editar_linea"
}

function guia_importar(numero_factura) {}

function buscar_numero(numero) {
  // alert(tienda)
  var q = $("#q").val();
  var tienda = $("#tienda_q").val();
  var estado = $("#estado_q").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (numero == 0) {
    numero = "";
  }
  if (estado == 0) {
    estado = "";
  }

  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_cotizacion1.php?action=ajax&page=" +
      page +
      "&numero=" +
      numero +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&estado=" +
      estado,

    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({
        html: true,
      });
    },
  });
}

function ver_detalle_cot(numero_factura) {
  // alert(numero_factura)
  var parametros = {
    action: "ajax",
    numero_factura: numero_factura,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/ver_detalle_cot.php",

    data: parametros,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $("#loader").html("");
      $("#modal_cot").html(data);
      $("#Modal").modal("show");
      $;
    },
  });
}
