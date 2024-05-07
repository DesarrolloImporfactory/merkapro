$(document).ready(function () {
  $("#widgets").load("../ajax/cargar_widget_wallet.php");
  $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
  load(1);
});
function load(page) {
  var range = $("#range").val();
  var parametros = {
    action: "ajax",
    page: page,
    range: range,
  };
  $("#loader").fadeIn("slow");
  $.ajax({
    url: "../ajax/ver_pagos.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#loader").html("<img src='../../img/ajax-loader.gif'>");
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}
$("#add_abono").submit(function (event) {
  $("#guardar_datos").attr("disabled", true);
  var abono = $("#abono").val();
  //Inicia validacion
  if (isNaN(abono)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "El ABONO NO ES UN DATO VALIDO, INTENTAR DE NUEVO"
    );
    $("#abono").focus();
    $("#guardar_datos").attr("disabled", false);
    return false;
  }
  //Fin validacion
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: "../ajax/agregar_abono_wallet.php",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#guardar_datos").attr("disabled", false);
      load(1);
      //resetea el formulario
      $("#add_abono")[0].reset();
      //cierra la Modal
      $("#outer_div").load("../ajax/ver_pagos.php");
      $("#widgets").load("../ajax/cargar_widget_wallet.php");
      $("#facturas").load("../ajax/cargar_facturas.php");
      $("#add-stock").modal("hide");
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(500, 0)
          .slideUp(500, function () {
            $(this).remove();
          });
      }, 5000);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(
        "Error en la solicitud AJAX: " + textStatus + " - " + errorThrown
      );
      // Puedes mostrar un mensaje de error al usuario aquí
    },
  });
  event.preventDefault();
});

$("#remove_abono").submit(function (event) {
  $("#guardar_datos2").attr("disabled", true);
  var abono = $("#abono").val();
  //Inicia validacion
  if (isNaN(abono)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "El ABONO NO ES UN DATO VALIDO, INTENTAR DE NUEVO"
    );
    $("#abono").focus();
    $("#guardar_datos").attr("disabled", false);
    return false;
  }
  //Fin validacion
  var formData = new FormData(this);
  $.ajax({
    type: "POST",
    url: "../ajax/eliminar_abono_wallet.php",
    data: formData,
    processData: false,
    contentType: false,
    beforeSend: function (objeto) {
      $("#resultados_ajax").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajax").html(datos);
      $("#guardar_datos2").attr("disabled", false);
      load(1);
      //resetea el formulario
      $("#remove_abono")[0].reset();
      //cierra la Modal
      $("#outer_div").load("../ajax/ver_pagos.php");
      $("#widgets").load("../ajax/cargar_widget_wallet.php");
      $("#facturas").load("../ajax/cargar_facturas.php");
      $("#remove-stock").modal("hide");
      //desaparecer la alerta
      window.setTimeout(function () {
        $(".alert")
          .fadeTo(500, 0)
          .slideUp(500, function () {
            $(this).remove();
          });
      }, 5000);
    },
    error: function (jqXHR, textStatus, errorThrown) {
      console.log(
        "Error en la solicitud AJAX: " + textStatus + " - " + errorThrown
      );
      // Puedes mostrar un mensaje de error al usuario aquí
    },
  });
  event.preventDefault();
});

function ver_detalles(id_cabecera) {
  var parametros = {
    id_cabecera: id_cabecera,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/ver_detalles.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#loader").html("<img src='../../img/ajax-loader.gif'>");
    },
    success: function (datos) {
      $("#loader").html("");
      $("#detalles").html(datos);
      $("#Modal").modal("show");
    },
  });
}

function devolucion(guia_laar) {
  Swal.fire({
    title: "¿Estás seguro de devolver?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, devolver",
    cancelButtonText: "No, cancelar",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
  }).then((result) => {
    if (result.value) {
      var parametros = {
        guia_laar: guia_laar,
      };
      $.ajax({
        type: "POST",
        url: "../ajax/devolucion.php",
        data: parametros,
        beforeSend: function (objeto) {
          $("#loader").html("<img src='../../img/ajax-loader.gif'>");
        },
        success: function (datos) {
          $("#loader").html("");
          $("#outer_div").load("../ajax/ver_pagos.php");
          $("#widgets").load("../ajax/cargar_widget_wallet.php");
          $("#facturas").load("../ajax/cargar_facturas.php");
        },
      });
      Swal.fire("¡Eliminado!", "Su archivo ha sido devuelto.", "success");
    }
  });
}

function visto(id_cabecera) {
  var parametros = {
    id_cabecera: id_cabecera,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/visto.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#loader").html("<img src='../../img/ajax-loader.gif'>");
    },
    success: function (datos) {
      $("#loader").html("");
      $("#outer_div").load("../ajax/ver_pagos.php");
      $("#widgets").load("../ajax/cargar_widget_wallet.php");
      $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
    },
  });
}

function eliminar(id_cabecera) {
  Swal.fire({
    title: "¿Estás seguro?",
    text: "¡No podrás revertir esto!",
    icon: "warning",
    showCancelButton: true,
    confirmButtonText: "Sí, eliminarlo",
    cancelButtonText: "No, cancelar",
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
  }).then((result) => {
    if (result.value) {
      var parametros = {
        id_cabecera: id_cabecera,
      };
      $.ajax({
        type: "POST",
        url: "../ajax/eliminar_pago.php",
        data: parametros,
        beforeSend: function (objeto) {
          $("#loader").html("<img src='../../img/ajax-loader.gif'>");
        },
        success: function (datos) {
          $("#loader").html("");
          $("#outer_div").load("../ajax/ver_pagos.php");
          $("#widgets").load("../ajax/cargar_widget_wallet.php");
          $("#facturas").load("../ajax/cargar_facturas.php");
        },
      });
      Swal.fire("¡Eliminado!", "Su archivo ha sido eliminado.", "success");
    }
  });
}

function filtrarRegistros(filtro) {
  var url = "../ajax/cargar_facturas.php";
  url = url + "?filtro=" + filtro;

  $("#facturas").load(url);
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
