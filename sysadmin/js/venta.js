$(document).ready(function() {
    $("#resultados").load("../ajax/agregar_tmp.php");
    $("#outer_comprobante").load("../ajax/carga_correlativos.php?id_comp=1");
    //$("#f_resultado").load("../ajax/incrementa_factura.php");
    $("#resultados2").load("../ajax/carga_caja.php");
    $("#resultados3").load("../ajax/carga_resibido.php");
    //$("#resultados4").load("../ajax/tipo_doc.php");
   $.ajax({
    url: "../ajax/carga_num_trans.php",
    method: "GET", // O POST dependiendo de tu necesidad
    dataType: "text", // Puedes ajustar el tipo de datos según lo que espera el servidor
    success: function(resultado) {
       // alert(resultado)
        $("#trans").val(resultado); // Asigna el resultado al valor del input con ID "trans"
    },
    error: function(xhr, status, error) {
        console.error("Error al cargar el número de transacción:", status, error);
    }
});
    $("#datos_factura").load();
    $("#barcode").focus();
    load(1);
});

function load(page) {
    var q = $("#q").val();
    $("#loader").fadeIn('slow');
    $.ajax({
        url: '../ajax/productos_modal_ventas.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(data) {
           // alert (data)
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
      $.ajax({
        url: '../ajax/productos_modal_ventas_pos.php?action=ajax&page=' + page + '&q=' + q,
        beforeSend: function(objeto) {
            $('#loader').html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(data) {
           // alert (data)
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}

function agregar(id) {
   
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    //Inicia validacion
    if (isNaN(cantidad)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO')
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(precio_venta)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'EL PRECIO NO ES UN NUMERO, INTENTAR DE NUEVO')
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    //Fin validacion
    // alert(id);
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_tmp_modalventas.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad + "&operacion=" + 2,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
            var audio = document.getElementById("myAudio");
           // alert()
  audio.play();
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}
function agregar_pos(id) {
   
    var precio_venta = document.getElementById('pos_precio_venta_' + id).value;
    var cantidad = document.getElementById('pos_cantidad_' + id).value;
    //Inicia validacion
    if (isNaN(cantidad)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO')
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(precio_venta)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'EL PRECIO NO ES UN NUMERO, INTENTAR DE NUEVO')
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    //Fin validacion
    // alert(id);
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_tmp_modalventas.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad + "&operacion=" + 2,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
            var audio = document.getElementById("myAudio");
           // alert()
  audio.play();
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}

function agregar_libre(id) {
   
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var descripcion = document.getElementById('desproducto_' + id).value;
    //Inicia validacion
    if (isNaN(cantidad)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO')
        document.getElementById('cantidad_' + id).focus();
        return false;
    }
    if (isNaN(precio_venta)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'EL PRECIO NO ES UN NUMERO, INTENTAR DE NUEVO')
        document.getElementById('precio_venta_' + id).focus();
        return false;
    }
    //Fin validacion
     alert(id);
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_tmp_modalventas.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad + "&descripcion=" + descripcion + "&operacion=" + 2,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}


//CONTROLA EL FORMULARIO DEL CODIGO DE BARRA
$("#barcode_form").submit(function(event) {
    var id = $("#barcode").val();
    var cantidad = $("#barcode_qty").val();
    var id_sucursal = 0;
    //Inicia validacion
    if (isNaN(cantidad)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'LA CANTIDAD NO ES UN NUMERO, INTENTAR DE NUEVO')
        $("#barcode_qty").focus();
        return false;
    }
    //Fin validacion
    parametros = {
        'operacion':1,
        'id': id,
        'id_sucursal': id_sucursal,
        'cantidad': cantidad
    };
    $.ajax({
        type: "POST",
        url: "../ajax/agregar_tmp.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
            $("#id").val("");
            $("#id").focus();
            $("#barcode").val("");
            $("#f_resultado").load("../ajax/incrementa_factura.php"); //Actualizamos el numero de Factura
        }
    });
    event.preventDefault();
})

function eliminar(id) {
    $.ajax({
        type: "GET",
        url: "../ajax/agregar_tmp.php",
        data: "id=" + id,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
              var audio = document.getElementById("myAudioEliminar");
           // alert()
  audio.play();
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}

$("#datos_factura").submit(function(event) {
    $('#guardar_factura').attr("disabled", true);
    var id_cliente = $("#id_cliente").val();
    var resibido = $("#resibido").val();
    if (isNaN(resibido)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'EL DATO NO ES VALIDO, INTENTAR DE NUEVO')
        $("#resibido").focus();
        return false;
    }
    if (id_cliente == '') {
        $.Notification.notify('warning','bottom center','NOTIFICACIÓN', 'DEBE SELECCIONAR UN CLIENTE VALIDO')
        $("#nombre_cliente").focus();
        $('#guardar_factura').attr("disabled", false);
        return false;
    }
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/guardar_venta.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajaxf").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajaxf").html(datos);
            $('#guardar_factura').attr("disabled", false);
            //resetea el formulario
            //$('#modal_vuelto').modal('show');
            $("#datos_factura")[0].reset(); //Recet al formilario de el cliente
            $("#barcode_form")[0].reset(); // Recet al formulario de la fatura
            $("#resultados").load("../ajax/agregar_tmp.php"); // carga los datos nuevamente
            $("#f_resultado").load("../ajax/incrementa_factura.php"); // carga la caja de incrementar la factura
            $("#resultados2").load("../ajax/carga_caja.php"); // carga la caja total del dia
            $("#barcode").focus();
            load(1);
            //desaparecer la alerta
            $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert
        }
    });
    event.preventDefault();
})

$("#guardar_cliente").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_cliente_pos.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            alert(datos);
            
            $('#guardar_datos').attr("disabled", false);
            //resetea el formulario
            
            //desaparecer la alerta
            if (datos.indexOf("alert-danger") !== -1) {
              $("#resultados_ajax").html(datos);   
            }else{
                  $('#id_cliente').val(datos);
				$('#nombre_cliente').val($('#nombre').val());
				$('#rnc').val($('#fiscal').val());
                                $("#guardar_cliente")[0].reset();
                                 $("#resultados_ajax").html(""); 
                                 $('#nuevoCliente').modal('hide');


				$.Notification.notify('custom','bottom right','EXITO!', 'CLIENTE AGREGADO CORRECTAMENTE')
                                $('#nuevoCliente').modal('hide');
            }
                
           
          
                                
            $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
                
            }); // /.alert
            load(1);
        }
    });
    event.preventDefault();
})
$("#guardar_producto").submit(function(event) {
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_producto.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax_productos").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax_productos").html(datos);
            $('#guardar_datos').attr("disabled", false);
            //resetea el formulario
            $("#guardar_producto")[0].reset();
            //desaparecer la alerta
            $(".alert-success").delay(400).show(10, function() {
                $(this).delay(2000).hide(10, function() {
                    $(this).remove();
                });
            }); // /.alert
            load(1);
        }
    });
    event.preventDefault();
})
$('#dataDelete').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Botón que activó el modal
            var id = button.data('id') // Extraer la información de atributos de datos
            var modal = $(this)
            modal.find('#id_factura').val(id)
        })
        $("#eliminarDatos").submit(function(event) {
            var parametros = $(this).serialize();
            $.ajax({
                type: "POST",
                url: "../ajax/anular_factura.php",
                data: parametros,
                beforeSend: function(objeto) {
                    $(".datos_ajax_delete").html('<img src="../../img/ajax-loader.gif"> Cargando...');
                },
                success: function(datos) {
                    $(".datos_ajax_delete").html(datos);
                    $('#dataDelete').modal('hide');
                    load(1);
                    //desaparecer la alerta
                    window.setTimeout(function() {
                        $(".alert").fadeTo(200, 0).slideUp(200, function() {
                            $(this).remove();
                        });
                    }, 2000);
                }
            });
            event.preventDefault();
        });

function imprimir_factura(user_id) {
    VentanaCentrada('../pdf/documentos/corte_caja.php?user_id=' + user_id, 'Corte', '', '724', '568', 'true');
}

