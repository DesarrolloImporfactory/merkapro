function obtenerComprobanteFirmado_sri(ruta_certificado, pwd_p12, ruta_respuesta, ruta_factura,id,comprobante,dir = null, ambiente,logo) {
    //alert("enviando al SRI" + id +', compro' + comprobante,dir)
    $('.cargandospinnercontainer').show();
    $('.cargandospinnercontainercredito').show();
    if(dir){
        rutaleerfactura        = "../assets/js/lib_firma_sri/src/leerFactura.php";
        rutafirma              = "../assets/js/lib_firma_sri/src/firma.php";
        rutavalidarComprobante = "../assets/js/lib_firma_sri/src/services/validarComprobante.php";
        rutaautorizacionCompro = "../assets/js/lib_firma_sri/src/services/autorizacionComprobante.php";
    }else{
        rutaleerfactura        = "../../assets/js/lib_firma_sri/src/leerFactura.php";
        rutafirma              = "../../assets/js/lib_firma_sri/src/firma.php";
        rutavalidarComprobante = "../../assets/js/lib_firma_sri/src/services/validarComprobante.php";
        rutaautorizacionCompro = "../../assets/js/lib_firma_sri/src/services/autorizacionComprobante.php";
    }
    var response = [];
    $.ajax({
        
        url: rutaleerfactura,
        type: 'POST',
        data: {
                  'ruta_factura': ruta_factura
               },
        context: document.body
    }).done(function (respuesta) {

        window.contenido_comprobante = respuesta;
		
		
		console.log(window.contenido_comprobante);
		
        var oReq = new XMLHttpRequest();
        oReq.open("GET", ruta_certificado, true);
        oReq.responseType = "arraybuffer";
        oReq.onload = function (oEvent) {
            var blob = new Blob([oReq.response], {
				type: "application/x-pkcs12"
				});
            window.contenido_p12 = [oReq.response];
			
            console.log(window.contenido_p12);
			
            var comprobanteFirmado_xml = firmarComprobante(window.contenido_p12[0],
                    pwd_p12,
                    window.contenido_comprobante);

            $.ajax({
                url: rutafirma,
                type: 'POST',
                data: {
                    'mensaje': comprobanteFirmado_xml
                },
                context: document.body
            }).done(function (respuesta) {

                service = 'Validar Comprobante';
                xmlDoc = $.parseXML(window.contenido_comprobante),
                        $xml = $(xmlDoc),
                        $claveAcceso = $xml.find("claveAcceso");
                $.ajax({
                    type: 'POST',
                    url: rutavalidarComprobante,
                    data: {
                        'service': service, 'claveAcceso': $claveAcceso.text(), 'id': id , 'comprobante': comprobante, 'ambiente': ambiente
                    },
                    context: document.body
                }).done(function (respuestaValidarComprobante) {

                    
                    respuesta = decodeURIComponent(respuestaValidarComprobante);
                    respuesta = respuesta.toString();
                    var validar_comprobante = respuestaValidarComprobante;
                
                    if (/RECIBIDA/i.test(respuesta) || /CLAVE ACCESO REGISTRADA/i.test(respuesta)) {
                        service = 'Autorizacion Comprobante';
                        xmlDoc = $.parseXML(window.contenido_comprobante),
                                $xml = $(xmlDoc),
                                $claveAcceso = $xml.find("claveAcceso");
                        $.ajax({
                            type: 'POST',
                            url: rutaautorizacionCompro,
                            data: {
                                'service': service, 'claveAcceso': $claveAcceso.text(), 'id': id , 'comprobante': comprobante, 'ambiente': ambiente, 'logo' :logo
                            },
                            context: document.body
                        }).done(function (respuestaAutorizacionComprobante) {
			                                         
                            var autorizacion_comprobante = respuestaAutorizacionComprobante;
                            response[0] = validar_comprobante;
                            response[1] = autorizacion_comprobante;
                           
                                //Respuesta enviada
                                if(dir){
                                    if(comprobante == 'FACTURA'){
                                        swal({
                                            title: 'Envio Automatico al SRI FACTURA',
                                            text: 'Estado: Comprobante enviado',
                                            type: 'success',
                                            confirmButtonText: 'ok'
                                        })
                                    }else if(comprobante == 'LIQUIDACION COMPRA'){
                                        swal({
                                            title: 'Envio Automatico al SRI LIQUIDACION COMPRA',
                                            text: 'Estado: Comprobante enviado',
                                            type: 'success',
                                            confirmButtonText: 'ok'
                                        })
                                    }else if(comprobante == 'NOTA CREDITO'){
                                        swal({
                                            title: 'Envio Automatico al SRI NOTA CREDITO',
                                            text: 'Estado: Comprobante enviado',
                                            type: 'success',
                                            confirmButtonText: 'ok'
                                        })
                                    }else if(comprobante == 'NOTA DEBITO'){
                                        swal({
                                            title: 'Envio Automatico al SRI NOTA DEBITO',
                                            text: 'Estado: Comprobante enviado',
                                            type: 'success',
                                            confirmButtonText: 'ok'
                                        })
                                    }else if(comprobante == 'GUIA'){
                                        swal({
                                            title: 'Envio Automatico al SRI GUIA',
                                            text: 'Estado: Comprobante enviado',
                                            type: 'success',
                                            confirmButtonText: 'ok'
                                        })
                                    }else if(comprobante == 'RETENCION'){
                                        swal({
                                            title: 'Envio Automatico al SRI RETENCION',
                                            text: 'Estado: Comprobante enviado',
                                            type: 'success',
                                            confirmButtonText: 'ok'
                                        })
                                    }
                                }else{
                                    window.close();
                                }
                        });
                    } else {
                        response[0] = validar_comprobante;
                        $.ajax({
                            type: 'POST',
                            url: ruta_respuesta,
                            data: {'respuestaFirmarFactura': response},
                            context: document.body
                        }).done(function (respuesta) {
                            //Respuesta enviada
                            if(dir){
                                if(comprobante == 'FACTURA'){
                                    swal({
                                        title: 'Envio Automatico al SRI FACTURA',
                                        text: 'Estado: Hubo un error en la autorizacion del comprobante',
                                        type: 'error',
                                        confirmButtonText: 'ok'
                                    })
                                }else if(comprobante == 'LIQUIDACION COMPRA'){
                                    swal({
                                        title: 'Envio Automatico al SRI LIQUIDACION COMPRA',
                                        text: 'Estado: Hubo un error en la autorizacion del comprobante',
                                        type: 'error',
                                        confirmButtonText: 'ok'
                                    })
                                }else if(comprobante == 'NOTA CREDITO'){
                                    swal({
                                        title: 'Envio Automatico al SRI NOTA CREDITO',
                                        text: 'Estado: Hubo un error en la autorizacion del comprobante',
                                        type: 'error',
                                        confirmButtonText: 'ok'
                                    })
                                }else if(comprobante == 'NOTA DEBITO'){
                                    swal({
                                        title: 'Envio Automatico al SRI NOTA DEBITO',
                                        text: 'Estado: Hubo un error en la autorizacion del comprobante',
                                        type: 'error',
                                        confirmButtonText: 'ok'
                                    })
                                }else if(comprobante == 'GUIA'){
                                    swal({
                                        title: 'Envio Automatico al SRI GUIA',
                                        text: 'Estado: Hubo un error en la autorizacion del comprobante',
                                        type: 'error',
                                        confirmButtonText: 'ok'
                                    })
                                }else if(comprobante == 'RETENCION'){
                                    swal({
                                        title: 'Envio Automatico al SRI RETENCION',
                                        text: 'Estado: Hubo un error en la autorizacion del comprobante',
                                        type: 'error',
                                        confirmButtonText: 'ok'
                                    })
                                }
                            }
                            
                        });
                    }

                    /*if(dir){
                        if(comprobante == 'FACTURA'){
                            swal({
                                title: 'Envio Automatico al SRI FACTURA',
                                text: 'Estado: Comprobante enviado y exitoso',
                                type: 'success',
                                confirmButtonText: 'ok'
                            })
                            $('.cargandospinnercontainer').hide();
                        }else if(comprobante == 'LIQUIDACION COMPRA'){
                            swal({
                                title: 'Envio Automatico al SRI LIQUIDACION COMPRA',
                                text: 'Estado: Comprobante enviado y exitoso',
                                type: 'success',
                                confirmButtonText: 'ok'
                            })
                            $('.cargandospinnercontainercredito').hide();
                        }else if(comprobante == 'NOTA CREDITO'){
                            swal({
                                title: 'Envio Automatico al SRI NOTA CREDITO',
                                text: 'Estado: Comprobante enviado y exitoso',
                                type: 'success',
                                confirmButtonText: 'ok'
                            })
                            $('.cargandospinnercontainercredito').hide();
                        }else if(comprobante == 'NOTA DEBITO'){
                            swal({
                                title: 'Envio Automatico al SRI NOTA DEBITO',
                                text: 'Estado: Comprobante enviado y exitoso',
                                type: 'success',
                                confirmButtonText: 'ok'
                            })
                            $('.cargandospinnercontainercredito').hide();
                        }else if(comprobante == 'GUIA'){
                            swal({
                                title: 'Envio Automatico al SRI GUIA',
                                text: 'Estado: Comprobante enviado y exitoso',
                                type: 'success',
                                confirmButtonText: 'ok'
                            })
                            $('.cargandospinnercontainercredito').hide();
                        }else if(comprobante == 'RETENCION'){
                            swal({
                                title: 'Envio Automatico al SRI RETENCION',
                                text: 'Estado: Comprobante enviado y exitoso',
                                type: 'success',
                                confirmButtonText: 'ok'
                            })
                            $('.cargandospinnercontainercredito').hide();
                        }
                    }else{
                        setTimeout(function () {
                            window.close();
                        }, 2000);
                    }*/

                    //window.close();
                    /*if(comprobante == 'FACTURA'){
                        //alert('entra1');
                        window.location.href = "http://localhost/punto_venta/vistas/ajax/bitacora_ventas.php";
                    }else if(comprobante ==  'NOTA CREDITO'){
                        //alert('entra2');
                        window.location.href = "http://localhost/punto_venta/vistas/ajax/enviarcorreocredito.php&email=juanpulga99o@gmail.com";
                    }else if(comprobante ==  'RETENCION'){
                        //alert('entra3');
                        window.location.href = "http://localhost/punto_venta/vistas/ajax/bitacora_retencion.php";
                    }else if(comprobante ==  'NOTA DEBITO'){
                        //alert('entra4');
                        window.location.href = "http://localhost/punto_venta/vistas/ajax/bitacora_debito.php";
                    }else if(comprobante ==  'LIQUIDACION'){
                        //alert('llega');
                        window.location.href = "http://localhost/debra/main.php?module=liquidacion&db=kennedy";
                    }else if(comprobante ==  'GUIA'){
                        //alert('llega');
                        window.location.href = "http://localhost/punto_venta/vistas/html/bitacora_guia.php";
                    }*/
                    //window.location.href = "http://localhost/debra/main.php?module=ticket&db=kennedy&factura="+id;
                });
            });
        }
        oReq.send();
    }
    );
}

function fechas_certificado(ruta_certificado, mi_pwd_p12, ruta_respuesta) {

    var response = [];

    var oReq = new XMLHttpRequest();
    oReq.open("GET", ruta_certificado, true);
    oReq.responseType = "arraybuffer";
    oReq.onload = function (oEvent) {
        var blob = new Blob([oReq.response], {type: "application/x-pkcs12"});
        window.contenido_p12 = [oReq.response];
        var arrayUint8 = new Uint8Array(window.contenido_p12[0]);
        var p12B64 = forge.util.binary.base64.encode(arrayUint8);
        var p12Der = forge.util.decode64(p12B64);
        var p12Asn1 = forge.asn1.fromDer(p12Der);
        var p12 = forge.pkcs12.pkcs12FromAsn1(p12Asn1, mi_pwd_p12);
        var certBags = p12.getBags({bagType: forge.pki.oids.certBag})
        var cert = certBags[forge.oids.certBag][0].cert;
        //Validar Fecha de vencimiento del p12
        var fechaInicio = cert.validity['notBefore'];
        var fechaFin = cert.validity['notAfter'];
        var response = [];
        response[0] = fechaInicio;
        response[1] = fechaFin;

        $.ajax({
            type: 'POST',
            url: "src/validarFechaCertificado.php",
            data: {
                'fechaInicio': fechaInicio,
                'fechaFin': fechaFin
            },
            context: document.body
        }).done(function (respuesta) {
            response[2] = respuesta;
            $.ajax({
                type: 'POST',
                url: ruta_respuesta,
                data: {'respuestaValidarVigencia': response},
                context: document.body
            }).done(function (respuesta) {
                return true;
            });
        });
    }
    oReq.send();
}



function validar_pwrd(ruta_certificado, mi_pwd_p12, ruta_respuesta) {

    var oReq = new XMLHttpRequest();
    oReq.open("GET", ruta_certificado, true);
    oReq.responseType = "arraybuffer";
    oReq.onload = function (oEvent) {
        var blob = new Blob([oReq.response], {type: "application/x-pkcs12"});
        window.contenido_p12 = [oReq.response];

        var arrayUint8 = new Uint8Array(window.contenido_p12[0]);

        var p12B64 = forge.util.binary.base64.encode(arrayUint8);

        var p12Der = forge.util.decode64(p12B64);

        var p12Asn1 = forge.asn1.fromDer(p12Der);

        try {

            forge.pkcs12.pkcs12FromAsn1(p12Asn1, mi_pwd_p12);
            $.ajax({
                type: 'POST',
                url: ruta_respuesta,
                data: {'respuestaValidarContraseña': 'Contraseña Correcta'},
                context: document.body
            }).done(function (respuesta) {
                return "contraseña valida"
            });

        } catch (err) {
            $.ajax({
                type: 'POST',
                url: ruta_respuesta,
                data: {'respuestaValidarContraseña': 'Contraseña Invalida'},
                context: document.body
            }).done(function (respuesta) {
                return "contraseña invalida"
            });
        }
    }
    oReq.send();
}





var contenido_p12 = null;

function firmarComprobante(mi_contenido_p12, mi_pwd_p12, comprobante) {


    var arrayUint8 = new Uint8Array(mi_contenido_p12);
    console.log(arrayUint8)
    var p12B64 = forge.util.binary.base64.encode(arrayUint8);
    var p12Der = forge.util.decode64(p12B64);
    var p12Asn1 = forge.asn1.fromDer(p12Der);

    var p12 = forge.pkcs12.pkcs12FromAsn1(p12Asn1, mi_pwd_p12);

    var certBags = p12.getBags({bagType: forge.pki.oids.certBag})
    var signaturesQuantity = certBags[forge.oids.certBag];
    var count = 0;
    var positionSignature = 0;
    console.log('prueba')
    console.log(certBags)

    var anf_validacion = false
    var uanataca_validacion = false


    if (certBags[forge.oids.certBag][0].cert.issuer.attributes[2].value) {
        var uanataca = certBags[forge.oids.certBag][0].cert.issuer.attributes[2].value
        console.log(uanataca)
        console.log("identificando UANATACA")
        console.log(certBags[forge.oids.certBag][0].cert.extensions[5].value)
        if (/UANATACA/.test(uanataca)) {
            uanataca = 'UANATACA'
            uanataca_validacion = true
        }
    }


    if (certBags[forge.oids.certBag][0].cert.extensions[5].value) {
        var anf = certBags[forge.oids.certBag][0].cert.extensions[5].value;

        console.log("identificando ANF")
        console.log(certBags[forge.oids.certBag][0].cert.extensions[5].value)
        if (/anf/.test(anf)) {
            anf = 'ANF'
            anf_validacion = true
        }

    } 


    if (anf_validacion == true) {
        entidad = 'ANF'
        var certBags = p12.getBags({ bagType: forge.pki.oids.certBag })

        if (/ANF_Global_Root/.test(anf) || /ANF_Ecuador_CA1/.test(anf)) {
            var cert = certBags[forge.oids.certBag][0].cert;
            var issuerName = 'O=ANFAC Autoridad de Certificacion Ecuador CA,OU=ANF Autoridad Raiz Ecuador,C=EC,CN=ANF Ecuador CA1,2.5.4.5=#130d31373932363031323135303031';
        } else {
            var cert = certBags[forge.oids.certBag][0].cert;
            var issuerName = 'CN=ANF High Assurance Ecuador Intermediate CA,OU=ANF Autoridad intermedia  EC,O=ANFAC AUTORIDAD DE CERTIFICACION ECUADOR C.A.,C=EC,2.5.4.5=#130d31373932363031323135303031';
        }
        anf_validacion = true;
    }
    else if (uanataca_validacion == true) {
        entidad = 'UANATACA'
        var certBags = p12.getBags({ bagType: forge.pki.oids.certBag })
        var cert = certBags[forge.oids.certBag][0].cert;
        var issuerName = '2.5.4.97=#0c0f56415445532d413636373231343939,CN=UANATACA CA2 2016,OU=TSP-UANATACA,O=UANATACA S.A.,L=Barcelona (see current address at www.uanataca.com/address),C=ES';
    }
    else {
        var entidad = signaturesQuantity[0].attributes.friendlyName[0];
        if (/BANCO CENTRAL/i.test(entidad)) {
            entidad = 'BANCO_CENTRAL';
            var certBags = p12.getBags({ bagType: forge.pki.oids.certBag })

            var cert = certBags[forge.oids.certBag][1].cert;
            // issuerName
            var issuerName = 'CN=AC BANCO CENTRAL DEL ECUADOR,L=QUITO,OU=ENTIDAD DE CERTIFICACION DE INFORMACION-ECIBCE,O=BANCO CENTRAL DEL ECUADOR,C=EC';
        } else if (/SECURITY DATA/i.test(entidad)) {
            entidad = 'SECURITY_DATA';
            var contador = 0;
            var max = 0;
            var attributes_array = [];
            certBags[forge.oids.certBag].forEach(function (entry) {
                var bag = entry.cert;
                var attributes = bag.extensions;

                attributes_array[contador] = attributes;
                attributes_array.sort().reverse();
                max = attributes_array[0].length;

                contador++;
                /*if (attributes.length >= 23) {
                 cert = bag;
                 }*/
            });

            certBags[forge.oids.certBag].forEach(function (entry) {
                var bag = entry.cert;
                var attributes = bag.extensions;
                if (attributes.length >= max) {
                    cert = bag;
                }
            });



            // issuerName
            var issuerName = 'CN=AUTORIDAD DE CERTIFICACION SUB SECURITY DATA,OU=ENTIDAD DE CERTIFICACION DE INFORMACION,O=SECURITY DATA S.A.,C=EC';
        }
        else {
            var cert = certBags[forge.oids.certBag][0].cert;
            console.log("security data definiendo 1 o 2")
            var tipoSecurityData = certBags[forge.oids.certBag][0].cert.extensions[3].value;
			var tipoSecurityData2 = certBags[forge.oids.certBag][0].cert.extensions[5].value;
            console.log(tipoSecurityData)
            if (/SUBCA-2/i.test(tipoSecurityData)) {
                console.log("firma sub securirty data 2")
                var issuerName = 'CN=AUTORIDAD DE CERTIFICACION SUBCA-2 SECURITY DATA,OU=ENTIDAD DE CERTIFICACION DE INFORMACION,O=SECURITY DATA S.A. 2,C=EC';
                entidad = 'SECURITY_DATA';
            } else if (/SUBCA-3/i.test(tipoSecurityData)) {
                console.log("firma sub securirty data 3")
                var issuerName = 'CN=AUTORIDAD DE CERTIFICACION SUBCA-3 SECURITY DATA,OU=ENTIDAD DE CERTIFICACION DE INFORMACION,O=SECURITY DATA S.A. 3,C=EC';
                entidad = 'SECURITY_DATA';
            }else if(/SUBCA-1/i.test(tipoSecurityData) || /SUBCA-1/i.test(tipoSecurityData2)){
				console.log("firma sub securirty data 1")
                var issuerName = 'CN=AUTORIDAD DE CERTIFICACION SUBCA-1 SECURITY DATA,OU=ENTIDAD DE CERTIFICACION DE INFORMACION,O=SECURITY DATA S.A. 1,C=EC';
                entidad = 'SECURITY_DATA';
            } else {
				console.log("firma  NUEVAAAA Lazzate")
                var issuerName = 'CN=Lazzate Emisor CA,OU=Ente de Certificacion,O=Lazzate Cia. Ltda.,2.5.4.97=#13053539333832,1.2.840.113549.1.9.1=#1615636572746966696361646f7340656e6578742e6563,L=Quito,ST=Quito - Pichincha,C=EC';
                entidad = 'Lazzate'
            }

            
            console.log(entidad)
        }

    }
    console.log(entidad)
    //Validar Fecha de vencimiento del p12
   // var fechaInicio = cert.validity['notBefore'];
   // var fechaFin = cert.validity['notAfter'];


   
    var pkcs8bags = p12.getBags({bagType: forge.pki.oids.pkcs8ShroudedKeyBag});

    if (entidad == 'BANCO_CENTRAL') {
        var pkcs8 = pkcs8bags[forge.oids.pkcs8ShroudedKeyBag][1];
    } else {
        var pkcs8 = pkcs8bags[forge.oids.pkcs8ShroudedKeyBag][0];
    }
    
    var key = pkcs8.key;
    console.log(key)
    if (key == null) {
        key = pkcs8.asn1;
    }

    certificateX509_pem = forge.pki.certificateToPem(cert);

    certificateX509 = certificateX509_pem;
    certificateX509 = certificateX509.substr(certificateX509.indexOf('\n'));
    certificateX509 = certificateX509.substr(0, certificateX509.indexOf('\n-----END CERTIFICATE-----'));

    certificateX509 = certificateX509.replace(/\r?\n|\r/g, '').replace(/([^\0]{76})/g, '$1\n');

    //Pasar certificado a formato DER y sacar su hash:
    certificateX509_asn1 = forge.pki.certificateToAsn1(cert);
    certificateX509_der = forge.asn1.toDer(certificateX509_asn1).getBytes();
    certificateX509_der_hash = sha1_base64(certificateX509_der);



    //Serial Number
    var X509SerialNumber;
    console.log("ENTIDADDDD")
    console.log(entidad)

    //Serial Number
    if (entidad == 'ANF' || entidad == 'UANATACA' || entidad == 'Lazzate') {
        $.ajax({
            url: "../../assets/js/lib_firma_sri/src/hexToInt.php",
            type: 'POST',
            async: false,
            data: {
                'hex': cert.serialNumber
            },
            context: document.body
        }).done(function (respuestaHex) {
            X509SerialNumber = respuestaHex;
        });
    } else {

        X509SerialNumber = parseInt(cert.serialNumber, 16);
    }

    exponent = hexToBase64(key.e.data[0].toString(16));
    modulus = bigint2base64(key.n);
	comprobante = comprobante.replace(/\t|\r/g, "")

 //var sha1_comprobante = sha1_base64(comprobante.replace('<?xml version="1.0" encoding="UTF-8"?>', ''));


var sha1_comprobante = sha1_base64(utf8.encode(comprobante.replace('<?xml version="1.0" encoding="UTF-8"?>', '')));



    var xmlns = 'xmlns:ds="http://www.w3.org/2000/09/xmldsig#" xmlns:etsi="http://uri.etsi.org/01903/v1.3.2#"';


    //numeros involucrados en los hash:

    //var Certificate_number = 1217155;//p_obtener_aleatorio(); //1562780 en el ejemplo del SRI
    var Certificate_number = p_obtener_aleatorio(); //1562780 en el ejemplo del SRI

    //var Signature_number = 1021879;//p_obtener_aleatorio(); //620397 en el ejemplo del SRI
    var Signature_number = p_obtener_aleatorio(); //620397 en el ejemplo del SRI

    //var SignedProperties_number = 1006287;//p_obtener_aleatorio(); //24123 en el ejemplo del SRI
    var SignedProperties_number = p_obtener_aleatorio(); //24123 en el ejemplo del SRI

    //numeros fuera de los hash:

    //var SignedInfo_number = 696603;//p_obtener_aleatorio(); //814463 en el ejemplo del SRI
    var SignedInfo_number = p_obtener_aleatorio(); //814463 en el ejemplo del SRI

    //var SignedPropertiesID_number = 77625;//p_obtener_aleatorio(); //157683 en el ejemplo del SRI
    var SignedPropertiesID_number = p_obtener_aleatorio(); //157683 en el ejemplo del SRI

    //var Reference_ID_number = 235824;//p_obtener_aleatorio(); //363558 en el ejemplo del SRI
    var Reference_ID_number = p_obtener_aleatorio(); //363558 en el ejemplo del SRI

    //var SignatureValue_number = 844709;//p_obtener_aleatorio(); //398963 en el ejemplo del SRI
    var SignatureValue_number = p_obtener_aleatorio(); //398963 en el ejemplo del SRI

    //var Object_number = 621794;//p_obtener_aleatorio(); //231987 en el ejemplo del SRI
    var Object_number = p_obtener_aleatorio(); //231987 en el ejemplo del SRI







    var SignedProperties = '';

    SignedProperties += '<etsi:SignedProperties Id="Signature' + Signature_number + '-SignedProperties' + SignedProperties_number + '">';  //SignedProperties
    SignedProperties += '<etsi:SignedSignatureProperties>';
    SignedProperties += '<etsi:SigningTime>';

    //SignedProperties += '2016-12-24T13:46:43-05:00';//moment().format('YYYY-MM-DD\THH:mm:ssZ');
    SignedProperties += moment().format('YYYY-MM-DD\THH:mm:ssZ');

    SignedProperties += '</etsi:SigningTime>';
    SignedProperties += '<etsi:SigningCertificate>';
    SignedProperties += '<etsi:Cert>';
    SignedProperties += '<etsi:CertDigest>';
    SignedProperties += '<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
    SignedProperties += '</ds:DigestMethod>';
    SignedProperties += '<ds:DigestValue>';

    SignedProperties += certificateX509_der_hash;

    SignedProperties += '</ds:DigestValue>';
    SignedProperties += '</etsi:CertDigest>';
    SignedProperties += '<etsi:IssuerSerial>';
    SignedProperties += '<ds:X509IssuerName>';
    SignedProperties += issuerName;
    SignedProperties += '</ds:X509IssuerName>';
    SignedProperties += '<ds:X509SerialNumber>';

    SignedProperties += X509SerialNumber;

    SignedProperties += '</ds:X509SerialNumber>';
    SignedProperties += '</etsi:IssuerSerial>';
    SignedProperties += '</etsi:Cert>';
    SignedProperties += '</etsi:SigningCertificate>';
    SignedProperties += '</etsi:SignedSignatureProperties>';
    SignedProperties += '<etsi:SignedDataObjectProperties>';
    SignedProperties += '<etsi:DataObjectFormat ObjectReference="#Reference-ID-' + Reference_ID_number + '">';
    SignedProperties += '<etsi:Description>';

    SignedProperties += 'contenido comprobante';

    SignedProperties += '</etsi:Description>';
    SignedProperties += '<etsi:MimeType>';
    SignedProperties += 'text/xml';
    SignedProperties += '</etsi:MimeType>';
    SignedProperties += '</etsi:DataObjectFormat>';
    SignedProperties += '</etsi:SignedDataObjectProperties>';
    SignedProperties += '</etsi:SignedProperties>'; //fin SignedProperties

    SignedProperties_para_hash = SignedProperties.replace('<etsi:SignedProperties', '<etsi:SignedProperties ' + xmlns);

    var sha1_SignedProperties = sha1_base64(SignedProperties_para_hash);


    var KeyInfo = '';

    KeyInfo += '<ds:KeyInfo Id="Certificate' + Certificate_number + '">';
    KeyInfo += '\n<ds:X509Data>';
    KeyInfo += '\n<ds:X509Certificate>\n';

    //CERTIFICADO X509 CODIFICADO EN Base64 
    KeyInfo += certificateX509;

    KeyInfo += '\n</ds:X509Certificate>';
    KeyInfo += '\n</ds:X509Data>';
    KeyInfo += '\n<ds:KeyValue>';
    KeyInfo += '\n<ds:RSAKeyValue>';
    KeyInfo += '\n<ds:Modulus>\n';

    //MODULO DEL CERTIFICADO X509
    KeyInfo += modulus;

    KeyInfo += '\n</ds:Modulus>';
    KeyInfo += '\n<ds:Exponent>';

    //KeyInfo += 'AQAB';
    KeyInfo += exponent;

    KeyInfo += '</ds:Exponent>';
    KeyInfo += '\n</ds:RSAKeyValue>';
    KeyInfo += '\n</ds:KeyValue>';
    KeyInfo += '\n</ds:KeyInfo>';

    KeyInfo_para_hash = KeyInfo.replace('<ds:KeyInfo', '<ds:KeyInfo ' + xmlns);

    var sha1_certificado = sha1_base64(KeyInfo_para_hash);


    var SignedInfo = '';

    SignedInfo += '<ds:SignedInfo Id="Signature-SignedInfo' + SignedInfo_number + '">';
    SignedInfo += '\n<ds:CanonicalizationMethod Algorithm="http://www.w3.org/TR/2001/REC-xml-c14n-20010315">';
    SignedInfo += '</ds:CanonicalizationMethod>';
    SignedInfo += '\n<ds:SignatureMethod Algorithm="http://www.w3.org/2000/09/xmldsig#rsa-sha1">';
    SignedInfo += '</ds:SignatureMethod>';
    SignedInfo += '\n<ds:Reference Id="SignedPropertiesID' + SignedPropertiesID_number + '" Type="http://uri.etsi.org/01903#SignedProperties" URI="#Signature' + Signature_number + '-SignedProperties' + SignedProperties_number + '">';
    SignedInfo += '\n<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
    SignedInfo += '</ds:DigestMethod>';
    SignedInfo += '\n<ds:DigestValue>';

    //HASH O DIGEST DEL ELEMENTO <etsi:SignedProperties>';
    SignedInfo += sha1_SignedProperties;

    SignedInfo += '</ds:DigestValue>';
    SignedInfo += '\n</ds:Reference>';
    SignedInfo += '\n<ds:Reference URI="#Certificate' + Certificate_number + '">';
    SignedInfo += '\n<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
    SignedInfo += '</ds:DigestMethod>';
    SignedInfo += '\n<ds:DigestValue>';

    //HASH O DIGEST DEL CERTIFICADO X509
    SignedInfo += sha1_certificado;

    SignedInfo += '</ds:DigestValue>';
    SignedInfo += '\n</ds:Reference>';
    SignedInfo += '\n<ds:Reference Id="Reference-ID-' + Reference_ID_number + '" URI="#comprobante">';
    SignedInfo += '\n<ds:Transforms>';
    SignedInfo += '\n<ds:Transform Algorithm="http://www.w3.org/2000/09/xmldsig#enveloped-signature">';
    SignedInfo += '</ds:Transform>';
    SignedInfo += '\n</ds:Transforms>';
    SignedInfo += '\n<ds:DigestMethod Algorithm="http://www.w3.org/2000/09/xmldsig#sha1">';
    SignedInfo += '</ds:DigestMethod>';
    SignedInfo += '\n<ds:DigestValue>';

    //HASH O DIGEST DE TODO EL ARCHIVO XML IDENTIFICADO POR EL id="comprobante" 
    SignedInfo += sha1_comprobante;

    SignedInfo += '</ds:DigestValue>';
    SignedInfo += '\n</ds:Reference>';
    SignedInfo += '\n</ds:SignedInfo>';

    SignedInfo_para_firma = SignedInfo.replace('<ds:SignedInfo', '<ds:SignedInfo ' + xmlns);

    var md = forge.md.sha1.create();
    md.update(SignedInfo_para_firma, 'utf8');

    var signature = btoa(key.sign(md)).match(/.{1,76}/g).join("\n");


    var xades_bes = '';

    //INICIO DE LA FIRMA DIGITAL 
    xades_bes += '<ds:Signature ' + xmlns + ' Id="Signature' + Signature_number + '">';
    xades_bes += '\n' + SignedInfo;

    xades_bes += '\n<ds:SignatureValue Id="SignatureValue' + SignatureValue_number + '">\n';

    //VALOR DE LA FIRMA (ENCRIPTADO CON LA LLAVE PRIVADA DEL CERTIFICADO DIGITAL) 
    xades_bes += signature;

    xades_bes += '\n</ds:SignatureValue>';

    xades_bes += '\n' + KeyInfo;

    xades_bes += '\n<ds:Object Id="Signature' + Signature_number + '-Object' + Object_number + '">';
    xades_bes += '<etsi:QualifyingProperties Target="#Signature' + Signature_number + '">';

    //ELEMENTO <etsi:SignedProperties>';
    xades_bes += SignedProperties;

    xades_bes += '</etsi:QualifyingProperties>';
    xades_bes += '</ds:Object>';
    xades_bes += '</ds:Signature>';

    //FIN DE LA FIRMA DIGITAL 

    return  comprobante.replace(/(<[^<]+)$/, xades_bes + '$1');
}

function sha1_base64(txt) {
	

    var md = forge.md.sha1.create();
    md.update(txt);
	
	
    //console.log('Buffer in: ', Buffer);
    //return new Buffer(md.digest().toHex(), 'hex').toString('base64');
    return new window.buffer.Buffer(md.digest().toHex(), 'hex').toString('base64');
}

function hexToBase64(str) {
    var hex = ('00' + str).slice(0 - str.length - str.length % 2);
    return btoa(String.fromCharCode.apply(null,
            hex.replace(/\r|\n/g, "").replace(/([\da-fA-F]{2}) ?/g, "0x$1 ").replace(/ +$/, "").split(" "))
            );
}

function bigint2base64(bigint) {
    var base64 = '';
    base64 = btoa(bigint.toString(16).match(/\w{2}/g).map(function (a) {
        return String.fromCharCode(parseInt(a, 16));
    }).join(""));
    base64 = base64.match(/.{1,76}/g).join("\n");
    return base64;
}

function p_obtener_aleatorio() {
    return Math.floor(Math.random() * 999000) + 990;
}
