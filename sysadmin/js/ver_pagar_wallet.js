async function validar_laar(guia, cot) {
  console.log(cot);

  try {
    let response = await fetch(
      "https://api.laarcourier.com:9727/guias/" + guia,
      {
        method: "GET",
      }
    );

    if (!response.ok) {
      throw new Error("Network response was not ok");
    }

    let result = await response.json();
    let resultado = {};

    if (result.novedades.length > 0) {
      for (let element of result.novedades) {
        if (
          element.codigoTipoNovedad == 42 ||
          element.codigoTipoNovedad == 96
        ) {
          resultado.estado_codigo = 9;
          break;
        } else {
          resultado.estado_codigo = result.estadoActualCodigo;
        }
      }
    } else {
      resultado.estado_codigo = result.estadoActualCodigo;
    }

    resultado.pesoKilos = Math.round(result.pesoKilos);
    resultado.noGuia = result.noGuia;

    $.ajax({
      url: "../ajax/guardar_guia_wallet.php",
      type: "POST",
      data: {
        guia: resultado.noGuia,
        estado: resultado.estado_codigo,
        peso: resultado.pesoKilos,
      },
      beforeSend: function (objeto) {
        $("#estados_laar_" + resultado.noGuia).html(
          '<img src="../../img/ajax-loader.gif"> Cargando...'
        );
        $("#estados_laar__" + resultado.noGuia).html(
          '<img src="../../img/ajax-loader.gif"> Cargando...'
        );
      },
      success: function (data) {
        const estado_laar = document.querySelector(
          "#estados_laar_" + resultado.noGuia
        );
        const peso_laar = document.querySelector(
          "#estados_laar__" + resultado.noGuia
        );

        const estadoMap = {
          1: "Anulado",
          2: "Por recolectar",
          3: "Recolectado",
          4: "En bodega",
          5: "En Transito",
          6: "Zona de Entrega",
          7: "Entregado",
          8: "Anulado",
          9: "Devolucion",
          10: "Facturado",
          11: "En Transito",
          12: "En Transito",
          13: "En Transito",
          14: "Con Novedad",
        };

        const badgeClassMap = {
          1: "badge-danger",
          2: "badge-purple",
          3: "badge-purple",
          4: "badge-purple",
          5: "badge-warning",
          6: "badge-purple",
          7: "badge-purple",
          8: "badge-danger",
          9: "badge-danger",
          10: "badge-purple",
          11: "badge-warning",
          12: "badge-warning",
          13: "badge-warning",
          14: "badge-danger",
        };

        const estado = estadoMap[resultado.estado_codigo];
        const badgeClass = badgeClassMap[resultado.estado_codigo];

        estado_laar.innerHTML = `<span class='badge ${badgeClass}'><span>${estado}</span></span><br>`;
        peso_laar.innerHTML = resultado.pesoKilos + "kg";
      },
      error: function (xhr, status, error) {
        console.error("Error al guardar la guía: ", status, error);
      },
    });
  } catch (error) {
    console.error("Error fetching data: ", error);
  }
}

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
  let comprobante = $("#comprobante").val();
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
      $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
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

$("#saldar_abono").submit(function (event) {
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
    url: "../ajax/agregar_saldo_wallet.php",
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
      $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
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
      $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
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
          $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
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
      $(".outer_div").load("../ajax/ver_pagos.php?action=ajax");
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
          $("#facturas").load("../ajax/cargar_facturas.php?filtro=mayor_menor");
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
