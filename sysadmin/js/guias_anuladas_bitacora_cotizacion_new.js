var filtroG = "todas";
$(document).ready(function () {
  load(1);

  $("#tienda_q").select2({
    placeholder: "Selecciona una opción",
    allowClear: true,
    // Puedes añadir más opciones de configuración aquí
  });

  // filtro por fechas
  // Inicializa el datepicker de fecha de inicio
  $("#datepickerInicio input")
    .datepicker({
      format: "yyyy-mm-dd",
      language: "es",
      autoclose: true,
      todayHighlight: true,
    })
    .on("changeDate", function (selected) {
      var minDate = new Date(selected.date.valueOf());
      $("#datepickerFin input").datepicker("setStartDate", minDate);
    });

  // Inicializa el datepicker de fecha de fin
  $("#datepickerFin input").datepicker({
    format: "yyyy-mm-dd",
    language: "es",
    autoclose: true,
    todayHighlight: true,
  });

  // Manejador para abrir el calendario al hacer clic en el ícono
  $(".input-group-text").click(function () {
    $(this).parent().prev("input").datepicker("show");
  });

  // Añadir event listener para cambios en el checkbox
  // Inicializar marca de manipulación
  $("#envioGratis_checkout").data("waschecked", false);

  // Establecer la marca cuando el checkbox cambia
  $("#envioGratis_checkout").change(function () {
    $(this).data("waschecked", true); // Marcar como manipulado
    load(1); // Llama a la función load inmediatamente si deseas aplicar el filtro instantáneamente
  });
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
      let msg = JSON.parse(datos);
      if (msg[0] === "Linea ha sido actualizada con Exito.") {
        $.Notification.autoHideNotify(
          "success",
          "top right",
          "Linea ha sido actualizada con Exito.",
          "Linea ha sido actualizada con Exito."
        );
        load(1);
      } else {
        $.Notification.autoHideNotify(
          "error",
          "top right",
          "Error al actualizar la linea.",
          "Comuniquese con Soporte."
        );
      }
    },
  });
  event.preventDefault();
});
function load(page) {
  var q = $("#q").val() || ""; // Usar '' como valor predeterminado si no hay entrada
  var tienda = $("#tienda_q").val();
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  var transportadora = $("#transporte").val();
  var fechaInicio = $("#datepickerInicio input").val() || "";
  var fechaFin = $("#datepickerFin input").val() || "";

  // Obtener el estado del checkbox
  // Verificar si el checkbox ha sido manipulado
  var filtroImpresas;
  if ($("#envioGratis_checkout").data("waschecked") == true) {
    filtroImpresas = $("#envioGratis_checkout").is(":checked") ? 1 : 0;
  }

  var url = "../ajax/buscar_guias_anuladas_cotizacion_new.php?action=ajax&page=" + page;
  url += "&q=" + encodeURIComponent(q);
  if (tienda != 0) url += "&tienda=" + encodeURIComponent(tienda);
  if (estado != 0) url += "&estado=" + encodeURIComponent(estado);
  if (numero != 0) url += "&numero=" + encodeURIComponent(numero);
  if (transportadora != 0)
    url += "&transportadora=" + encodeURIComponent(transportadora);
  if (fechaInicio) url += "&fechaInicio=" + encodeURIComponent(fechaInicio);
  if (fechaFin) url += "&fechaFin=" + encodeURIComponent(fechaFin);
  if (filtroImpresas !== undefined) url += "&filtroImpresas=" + filtroImpresas;

  $("#loader").fadeIn("slow");
  $.ajax({
    url: url,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
      $('[data-toggle="tooltip"]').tooltip({ html: true });
    },
    error: function (xhr, status, error) {
      console.error("Error en AJAX: " + error);
      $("#loader").html("");
    },
  });
}

function buscar(tienda) {
  // alert(tienda)
  var q = $("#q").val();
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  var transportadora = $("#transporte").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (estado == 0) {
    estado = "";
  }
  if (numero == 0) {
    numero = "";
  }
  if (transportadora == 0) {
    transportadora = "";
  }

  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_guias_anuladas_cotizacion_new.php?action=ajax&page=" +
      page +
      "&tienda=" +
      tienda +
      "&q=" +
      q +
      "&estado=" +
      estado +
      "&numero=" +
      numero +
      "&filtro=" +
      filtroG +
      "&transportadora=" +
      transportadora,
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
  var transportadora = $("#transporte").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (estado == 0) {
    estado = "";
  }
  if (numero == 0) {
    numero = "";
  }
  if (transportadora == 0) {
    transportadora = "";
  }
  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_guias_anuladas_cotizacion_new.php?action=ajax&page=" +
      page +
      "&estado=" +
      estado +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&numero=" +
      numero +
      "&filtro=" +
      filtroG +
      "&transportadora=" +
      transportadora,
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
function obtener_datos_local(id) {
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
  var transportadora = $("#transporte").val();
  if (tienda == 0) {
    tienda = "";
  }
  if (numero == 0) {
    numero = "";
  }
  if (estado == 0) {
    estado = "";
  }
  if (transportadora == 0) {
    transportadora = "";
  }

  page = 1;
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/buscar_guias_anuladas_cotizacion_new.php?action=ajax&page=" +
      page +
      "&numero=" +
      numero +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&estado=" +
      estado +
      "&filtro=" +
      filtroG +
      "&transportadora=" +
      transportadora,

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
    },
  });
}
async function abrirModalTienda(tienda) {
  // Aquí puedes hacer una solicitud AJAX para obtener más información de la tienda si es necesario
  await fetch("../ajax/info_tienda.php", {
    method: "POST",
    body: JSON.stringify({ tienda: tienda }),
  })
    .then((response) => response.text())
    .then((data) => {
      $("#boody").html(data);
    });
  $("#tiendaModal").modal("show");
}

const cerrarModal = () => {
  $("#tiendaModal").modal("hide");
};

const filtrarRegistros = (filtro) => {
  filtroG = filtro;
  var q = $("#q").val();
  var url = "../ajax/buscar_guias_anuladas_cotizacion_new.php?action=ajax&page=1&q=" + q;
  var tienda = $("#tienda_q").val();
  var estado = $("#estado_q").val();
  var numero = $("#numero_q").val();
  var transportadora = $("#transporte").val();
  url = url + "&filtro=" + filtro;
  if (tienda != 0) {
    url = url + "&tienda=" + tienda;
  }
  if (estado != 0) {
    url = url + "&estado=" + estado;
  }
  if (numero != 0) {
    url = url + "&numero=" + numero;
  }
  if (transportadora != 0) {
    url = url + "&transportadora=" + transportadora;
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
};
$(document).on("click", ".anadir", function () {
  var guia_fast = $(this).data("guias");
  $("#guia_fast").val(guia_fast);
});

$(document).on("click", ".cerrarModal", function () {
  $("#guia_fast").val("");
  $("#motorizado").modal("hide");
});

function asignar_motorizado(event) {
  event.preventDefault();
  var guia_fast = $("#guia_fast").val();
  var motorizado = $("#motorizado_s").val();
  var parametros = {
    guia_fast: guia_fast,
    motorizado: motorizado,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/asignar_motorizado.php",
    data: JSON.stringify(parametros),
    contentType: "application/json",
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#motorizado").modal("hide");
      load(1);
    },
  });
}

$(document).on("click", ".ver", function () {
  var nombre = $(this).data("nombrem");
  var telefono = $(this).data("telefono");
  var placa = $(this).data("placa");
  var empresa = $(this).data("empresa");

  $("#nombre").val(nombre);
  $("#telefono").val(telefono);
  $("#placa").val(placa);
  $("#empresa").val(empresa);
});

function buscar_transporte(transporte) {
  // alert(tienda)
  var q = $("#q").val();
  var tienda = $("#tienda_q").val();
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
      "../ajax/buscar_guias_anuladas_cotizacion_new.php?action=ajax&page=" +
      page +
      "&transportadora=" +
      transporte +
      "&q=" +
      q +
      "&tienda=" +
      tienda +
      "&estado=" +
      estado +
      "&numero=" +
      numero +
      "&filtro=" +
      filtroG,
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
