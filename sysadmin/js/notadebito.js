$(document).ready(function() {
    //al cargar la pagina carga los ajax
    $("#resultados").load("../ajax/agregarnotadebito_tmp.php");
    //$("#f_resultado").load("../ajax/incrementa_notacredito.php");
    $("#resultados2").load("../ajax/carga_caja.php");
    $("#resultados3").load("../ajax/carga_resibido.php");
    $("#resultados4").load("../ajax/tipo_doc.php");
    $("#resultados5").load("../ajax/carga_num_trans.php");
    $("#datos_credito").load();
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
            $(".outer_div").html(data).fadeIn('slow');
            $('#loader').html('');
        }
    })
}

function agregar(id) {
   alert('se ejecuta primero')
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
        url: "../ajax/agregar_tmp_modalNotacredito.php",
        data: "id=" + id + "&precio_venta=" + precio_venta + "&cantidad=" + cantidad + "&operacion=" + 2,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}

function agregar_libre(id) {
    alert('se ejecuta 2')
    var precio_venta = document.getElementById('precio_venta_' + id).value;
    var cantidad = document.getElementById('cantidad_' + id).value;
    var descripcion = document.getElementById('desproducto_' + id).value;
    alert(descripcion);
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
        url: "../ajax/agregar_tmp_modalNotacredito.php",
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
    alert('se ejecuta 3')
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
        url: "../ajax/agregarnotacredito_tmp.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
            $("#id").val("");
            $("#id").focus();
            $("#barcode").val("");
            $("#f_resultado").load("../ajax/incrementa_notacredito.php"); //Actualizamos el numero de Factura
        }
    });
    event.preventDefault();
})

function eliminar(id) {
    alert('se ejecuta 4')
    $.ajax({
        type: "GET",
        url: "../ajax/agregarnotacredito_tmp.php",
        data: "id=" + id,
        beforeSend: function(objeto) {
            $("#resultados").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados").html(datos);
        }
    });
}
//cargar datos
$("#datos_credito").submit(function(event) {
    alert('se ejecuta 5')
    //$('#guardar_factura').attr("disabled", true);
    var id_cliente = $("#id_cliente").val();
    var resibido = $("#resibido").val();
    $("#fechaEmision2").val($("#fechaEmision").val()); 
    $("#tipoDocumentocredito2").val($("#tipoDocumentocredito").val());
    $("#fechaDocModificado2").val($("#fechaDocModificado").val());
    $("#numeroDocMod2").val($("#numeroDocMod").val());
    $("#motivo2").val($("#motivo").val());
    
    if (isNaN(resibido)) {
        $.Notification.notify('error','bottom center','NOTIFICACIÓN', 'EL DATO NO ES VALIDO, INTENTAR DE NUEVO')
        $("#resibido").focus();
        return false;
    }
    if (id_cliente == "") {
        $.Notification.notify('warning','bottom center','NOTIFICACIÓN', 'DEBE SELECCIONAR UN CLIENTE VALIDO')
        $("#nombre_cliente").focus();
        $('#guardar_factura').attr("disabled", false);
        return false;
    }
    var parametros = $(this).serialize();

    $.ajax({
        type: "POST",
        url: "../ajax/guardar_notacredito.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajaxf").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            
            $("#resultados_ajaxf").html(datos);
            $('#guardar_factura').attr("disabled", false);
            //resetea el formulario
            //$('#modal_vuelto').modal('show');
            $("#datos_credito")[0].reset(); //Recet al formilario de el cliente
            $("#barcode_form")[0].reset(); // Recet al formulario de la fatura
            $("#resultados").load("../ajax/agregarnotacredito_tmp.php"); // carga los datos nuevamente
            $("#f_resultado").load("../ajax/incrementa_notacredito.php"); // carga la caja de incrementar la factura
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
    alert('se ejecuta 6')
    $('#guardar_datos').attr("disabled", true);
    var parametros = $(this).serialize();
    $.ajax({
        type: "POST",
        url: "../ajax/nuevo_cliente.php",
        data: parametros,
        beforeSend: function(objeto) {
            $("#resultados_ajax").html('<img src="../../img/ajax-loader.gif"> Cargando...');
        },
        success: function(datos) {
            $("#resultados_ajax").html(datos);
            $('#guardar_datos').attr("disabled", false);
            //resetea el formulario
            $("#guardar_cliente")[0].reset();
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
$("#guardar_producto").submit(function(event) {
    alert('se ejecuta 7')
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
        alert('se ejecuta 8')
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