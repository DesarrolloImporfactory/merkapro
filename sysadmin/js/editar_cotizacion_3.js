$(document).ready(function () {
  load(1);
  $("#id_pedido_cot").val(window.location.href.split("=")[1]);
  $("#resultados").load("../ajax/editar_tmp_cot.php");
  $("#resultados3").load("../ajax/carga_resibido.php");
  $("#resultados4").load("../ajax/tipo_doc.php");
  $("#resultados5").load("../ajax/carga_num_trans.php");
  // alert($('#costo_total').val());
});

function load(page) {
  var q = $("#q").val();
  $("#loader").fadeIn("slow");
  $.ajax({
    url:
      "../ajax/productos_modal_ventas.php?action=ajax&page=" + page + "&q=" + q,
    beforeSend: function (objeto) {
      $("#loader").html('<img src="../../img/ajax-loader.gif"> Cargando...');
    },
    success: function (data) {
      $(".outer_div").html(data).fadeIn("slow");
      $("#loader").html("");
    },
  });
}

function agregar(id) {
  var precio_venta = document.getElementById("precio_venta_" + id).value;
  var cantidad = document.getElementById("cantidad_" + id).value;
  //Inicia validacion
  if (isNaN(cantidad)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "LA CANTIDAD NO ES UN NUMERO. INTENTELO DE NUEVO"
    );
    document.getElementById("cantidad_" + id).focus();
    return false;
  }
  if (isNaN(precio_venta)) {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "ESTO NO ES UN NUMERO. INTENTELO DE NUEVO"
    );
    document.getElementById("precio_venta_" + id).focus();
    return false;
  }
  //Fin validacion
  $.ajax({
    type: "POST",
    url: "../ajax/editar_tmp_modalcot.php",
    data:
      "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $.Notification.notify(
        "success",
        "bottom center",
        "NOTIFICACIÓN",
        "PRODUCTO AGREGADO A LA FACTURA CORRECTAMENTE"
      );
      $("#resultados").html(datos);

      calcular_guia($("#cod").val());
      var id_provincia = $("#ciudad_entrega").val();
      var id_producto = $("#cod").val();

      calcular_servi(id_provincia, id_producto);
    },
  });
}

function eliminar(id) {
  $.ajax({
    type: "GET",
    url: "../ajax/editar_tmp_cot.php",
    data: "id=" + id,
    beforeSend: function (objeto) {
      $("#resultados").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $.Notification.notify(
        "warning",
        "bottom center",
        "NOTIFICACIÓN",
        "PRODCUTO ELIMINADO DE LA DATA"
      );
      $("#resultados").html(datos);
      calcular_guia($("#cod").val());
    },
  });
}
//GUARDAMOS LA ACTUALIZACION DEL CLIENTE
$("#btn_actualizar").off("click");
$("#btn_actualizar").on("click", function (e) {
  $("#btn_actualizar").attr("disabled", true);
  var id_cliente = $("#id_cliente").val();
  var condiciones = $("#condiciones").val();
  var validez = $("#validez").val();
  var id_vendedor = $("#id_vendedor").val();
  if (id_cliente == "") {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "SELECCIONAR UN CLIENTE VALIDO"
    );
    $("#nombre_cliente").focus();
    return false;
  }
  parametros = {
    id_cliente: id_cliente,
    condiciones: condiciones,
    validez: validez,
    id_vendedor: id_vendedor,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/editar_fact_cot.php",
    data: parametros,
    beforeSend: function (objeto) {
      $(".editar_factura").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $(".editar_factura").html(datos);
      $("#btn_actualizar").attr("disabled", false);
      $("#resultados").load("../ajax/editar_tmp_cot.php"); // carga los datos nuevamente
      $("#barcode").focus();
      load(1);
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
    },
  });
  event.preventDefault();
});
//CONTROLA EL FORMULARIO DEL CODIGO DE BARRA
$("#barcode_form").submit(function (event) {
  var id = $("#barcode").val();
  var cantidad = $("#barcode_qty").val();
  var id_factura = $("#factura").val();
  var id_sucursal = 0;
  //Inicia validacion
  if (isNaN(cantidad)) {
    swal(
      "Oops...",
      "La Cantidad no es un numero. Inténtalo de nuevo!",
      "error"
    );
    $("#barcode_qty").focus();
    $("#btn_guardar").attr("disabled", false);
    return false;
  }
  //Fin validacion
  parametros = {
    id: id,
    id_sucursal: id_sucursal,
    cantidad: cantidad,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/editar_tmp_cot.php",
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
    },
  });
  event.preventDefault();
});
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
      load(1);
      //resetea el formulario
      $("#guardar_cliente")[0].reset();
      $("#nombre").focus();
      //desaparecer la alerta
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
      load(1);
    },
  });
  event.preventDefault();
});
//COVERTIMOS LA COTIZACION A VENTA
$("#btn_guardar").off("click");
$("#btn_guardar").on("click", function (e) {
  alert();
  $("#btn_guardar").attr("disabled", true);
  var id_cliente = $("#id_cliente1").val();
  var cotizacion = $("#cotizacion").val();
  var factura = $("#factura").val();
  var id_comp = $("#id_comp").val();
  var tip_doc = $("#tip_doc").val();
  var trans = $("#trans").val();

  var formaPago = $("#formaPago").val();
  var plazodias = $("#plazodias").val();

  var condiciones = $("#condiciones").val();
  var resibido = $("#resibido").val();
  if (id_cliente == "") {
    $.Notification.notify(
      "error",
      "bottom center",
      "NOTIFICACIÓN",
      "SELECCIONAR UN CLIENTE VALIDO"
    );
    $("#nombre_cliente").focus();
    $("#btn_guardar").attr("disabled", false);
    return false;
  }
  parametros = {
    id_cliente: id_cliente,
    cotizacion: cotizacion,
    factura: factura,
    id_comp: id_comp,
    tip_doc: tip_doc,
    trans: trans,
    condiciones: condiciones,
    formaPago: formaPago,
    plazodias: plazodias,
    resibido: resibido,
  };
  $.ajax({
    type: "POST",
    url: "../ajax/guardar_venta_cot.php",
    data: parametros,
    beforeSend: function (objeto) {
      $("#resultados_ajaxf").html(
        '<img src="../../img/ajax-loader.gif"> Cargando...'
      );
    },
    success: function (datos) {
      $("#resultados_ajaxf").html(datos);
      $("#btn_guardar").attr("disabled", false);
      $("#resultados").load("../ajax/editar_tmp_cot.php"); // carga los datos nuevamente
      $("#barcode").focus();
      load(1);
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
    },
  });
  event.preventDefault();
});

function imprimir_factura(id_factura) {
  VentanaCentrada(
    "../pdf/documentos/ver_factura.php?id_factura=" + id_factura,
    "Factura",
    "",
    "724",
    "568",
    "true"
  );
}
function generar_guia() {
  $("#generar_guia_btn").prop("disabled", true);
  $("#id_pedido_cot").val(window.location.href.split("=")[1]);

  let monto_total = $("#monto_total_").text();
  monto_total_ = monto_total.replace(/,/g, "");
  monto_total__ = monto_total_.replace(/\./g, "");
  monto_total = monto_total__.replace("$", "");
  monto_total = parseFloat(monto_total);

  if (monto_total <= 0) {
    $.Notification.notify(
      "error",
      "bottom right",
      "ERROR!",
      "El monto total debe ser mayor a 0"
    );
    return;
  }
  let transportadora = $("#transp").val();
  if (transportadora == "") {
    $.Notification.notify(
      "error",
      "bottom right",
      "ERROR!",
      "Debes seleccionar una transportadora"
    );
  }
  if (transportadora === "1") {
    var formulario = document.getElementById("datos_pedido");
    if (document.querySelector("#valorasegurado").value === "") {
      document.querySelector("#valorasegurado").value = 0;
    }

    var data = new FormData(formulario);
    data.append(
      "direccion",
      document.getElementById("direccion_destino").value
    );
    data.append("valor_total", document.getElementById("valor_total_").value);
    data.append(
      "cantidad_total",
      document.getElementById("cantidad_total").value
    );
    data.append("costo_total", document.getElementById("costo_total").value);
    data.append("ciudad", document.getElementById("ciudad_entrega").value);
    data.append(
      "productos_guia",
      document.getElementById("productos_guia").value
    );
    data.append(
      "nombre_destino",
      document.getElementById("nombredestino").value
    );
    data.set("id_pedido_cot", $("#id_pedido_cot").val());
    data.append("costo_envio", document.getElementById("costo_envio").value);

    $.ajax({
      url: "../ajax/editar_data.php",
      type: "post",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        $.ajax({
          url: "../ajax/calcular_guia.php",
          type: "post",
          data: data,
          contentType: false,
          processData: false,
          success: function (response) {
            // $("#resultados").html(response);
            $("#generar_guia_btn").prop("disabled", false);
          },
        });
        $.ajax({
          url: "../ajax/enviar_laar.php",
          type: "POST",
          data: data,
          contentType: false,
          processData: false,
          success: function (response) {
            Swal.fire({
              icon: "success",
              title: "Guía generada",
              text: "La guía ha sido generada exitosamente",
            }).then(() => {
              location.reload();
            });
          },
        });
      },
    });
  }
  if (transportadora === "2") {
    var formulario = document.getElementById("datos_pedido");
    if (document.querySelector("#valorasegurado").value === "") {
      document.querySelector("#valorasegurado").value = 0;
    }

    var data = new FormData(formulario);
    data.append(
      "direccion",
      document.getElementById("direccion_destino").value
    );
    data.append("valor_total", document.getElementById("valor_total_").value);
    data.append(
      "cantidad_total",
      document.getElementById("cantidad_total").value
    );
    data.append("costo_total", document.getElementById("costo_total").value);
    data.append("ciudad", document.getElementById("ciudad_entrega").value);
    data.append(
      "productos_guia",
      document.getElementById("productos_guia").value
    );
    data.append(
      "nombre_destino",
      document.getElementById("nombredestino").value
    );
    data.set("id_pedido_cot", $("#id_pedido_cot").val());
    data.append("costo_envio", document.getElementById("costo_envio").value);
    $.ajax({
      url: "../ajax/calcular_guia.php",
      type: "post",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        // $("#resultados").html(response);
        $("#generar_guia_btn").prop("disabled", false);
      },
    });
    $.ajax({
      url: "../ajax/enviar_guia_local.php",
      type: "POST",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          icon: "success",
          title: "Guía generada",
          text: "La guía ha sido generada exitosamente",
          showConfirmButton: false,
          timer: 1500,
        }).then(() => {
          location.reload();
        });
      },
    });
  }
  if (transportadora === "3") {
    var formulario = document.getElementById("datos_pedido");
    if (document.querySelector("#valorasegurado").value === "") {
      document.querySelector("#valorasegurado").value = 0;
    }

    var data = new FormData(formulario);
    data.append(
      "direccion",
      document.getElementById("direccion_destino").value
    );
    data.append("valor_total", document.getElementById("valor_total_").value);
    data.append(
      "cantidad_total",
      document.getElementById("cantidad_total").value
    );
    data.append("costo_total", document.getElementById("costo_total").value);
    data.append("ciudad", document.getElementById("ciudad_entrega").value);
    data.append(
      "productos_guia",
      document.getElementById("productos_guia").value
    );
    data.append(
      "nombre_destino",
      document.getElementById("nombredestino").value
    );
    data.set("id_pedido_cot", $("#id_pedido_cot").val());
    data.append("costo_envio", document.getElementById("costo_envio").value);
    $.ajax({
      url: "../ajax/calcular_guia.php",
      type: "post",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        $("#resultados").html(response);
        $("#generar_guia_btn").prop("disabled", false);
      },
    });

    data.set("id_pedido_cot", $("#id_pedido_cot").val());
    let ciudad_texto = $("#ciudad_entrega option:selected").text();
    let destino_texto = $("#destino_c").val();
    data.append("ciudad_texto", ciudad_texto);
    data.append("destino_texto", destino_texto);
    data.append("provincia", $("#provinica option:selected").text());
    $.ajax({
      url: "../ajax/datos_servi.php",
      type: "POST",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        let datos_servi = JSON.parse(response);
        let codigo = datos_servi["codigo"];
        let codigo_origen = datos_servi["codigo_origen"];
        data.append("codigo", codigo);
        data.append("codigo_origen", codigo_origen);
        let esRecaudo = $("#cod").val();
        if (esRecaudo == 1) {
          $.ajax({
            url: "../../../ajax/servientrega/generar_guia_servientrega_r.php",
            type: "POST",
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
              let data_se = JSON.parse(response);
              let id_servi = data_se["id"];
              data.append("id_servi", id_servi);
              Swal.fire({
                icon: "info",
                title: "Por favor espere",
                text: "Estamos generando la guía",
                showConfirmButton: false,
                didOpen: () => {
                  Swal.showLoading();
                },
              });
              $.ajax({
                url: "../ajax/enviar_servi.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                  Swal.fire({
                    icon: "success",
                    title: "Guía generada",
                    text: "La guía ha sido generada exitosamente",
                    showConfirmButton: true,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
                    }
                  });
                },
              });
            },
          });
        } else if (esRecaudo == 2) {
          $.ajax({
            url: "../../../ajax/servientrega/generar_guia_servientrega.php",
            type: "POST",
            data: data,
            contentType: false,
            processData: false,
            success: function (response) {
              let data_se = JSON.parse(response);
              let id_servi = data_se["id"];
              data.append("id_servi", id_servi);
              Swal.fire({
                icon: "info",
                title: "Por favor espere",
                text: "Estamos generando la guía",
                showConfirmButton: false,
                didOpen: () => {
                  Swal.showLoading();
                },
              });
              $.ajax({
                url: "../ajax/enviar_servi.php",
                type: "POST",
                data: data,
                contentType: false,
                processData: false,
                success: function (response) {
                  Swal.fire({
                    icon: "success",
                    title: "Guía generada",
                    text: "La guía ha sido generada exitosamente",
                    showConfirmButton: true,
                  }).then((result) => {
                    if (result.isConfirmed) {
                      location.reload();
                    }
                  });
                },
              });
            },
          });
        }
      },
    });
  }
  if (transportadora === "4") {
    var formulario = document.getElementById("datos_pedido");
    if (document.querySelector("#valorasegurado").value === "") {
      document.querySelector("#valorasegurado").value = 0;
    }

    var data = new FormData(formulario);
    data.append(
      "direccion",
      document.getElementById("direccion_destino").value
    );
    data.append("valor_total", document.getElementById("valor_total_").value);
    data.append(
      "cantidad_total",
      document.getElementById("cantidad_total").value
    );
    data.append("costo_total", document.getElementById("costo_total").value);
    data.append("ciudad", document.getElementById("ciudad_entrega").value);
    data.append(
      "productos_guia",
      document.getElementById("productos_guia").value
    );
    data.append(
      "nombre_destino",
      document.getElementById("nombredestino").value
    );
    data.set("id_pedido_cot", $("#id_pedido_cot").val());
    data.append("costo_envio", document.getElementById("costo_envio").value);
    $.ajax({
      url: "../ajax/calcular_guia.php",
      type: "post",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        $("#resultados").html(response);
        $("#generar_guia_btn").prop("disabled", false);
      },
    });

    data.set("id_pedido_cot", $("#id_pedido_cot").val());
    let ciudad_texto = $("#ciudad_entrega option:selected").text();
    let destino_texto = $("#destino_c").val();
    data.append("ciudad_texto", ciudad_texto);
    data.append("destino_texto", destino_texto);
    $.ajax({
      url: "../ajax/generar_gintracom.php",
      type: "POST",
      data: data,
      contentType: false,
      processData: false,
      success: function (response) {
        Swal.fire({
          icon: "info",
          title: "Por favor espere",
          text: "Estamos generando la guía",
          showConfirmButton: false,
          didOpen: () => {
            Swal.showLoading();
          },
        });
        response = JSON.parse(response);

        $id_gintracom = response["guia"];
        data.append("id_gintracom", $id_gintracom);
        $.ajax({
          url: "../ajax/enviar_gintracom.php",
          type: "POST",
          data: data,
          contentType: false,
          processData: false,
          success: function (response) {
            Swal.fire({
              icon: "success",
              title: "Guía generada",
              text: "La guía ha sido generada exitosamente",
              showConfirmButton: true,
            }).then((result) => {
              if (result.isConfirmed) {
                location.reload();
              }
            });
          },
        });
      },
    });
  }
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

sanitizeInput("#nombredestino", commonRegex);
sanitizeInput("#direccion_destino", commonRegex);
sanitizeInput("#referencia", commonRegex);
sanitizeInput("#observacion", commonRegex);

// Campos que solo permiten números
const numberRegex = /[^0-9]/g;

sanitizeInput("#telefono", numberRegex);
sanitizeInput("#identificacion", numberRegex);
sanitizeInput("#numerocasa", commonRegex);
