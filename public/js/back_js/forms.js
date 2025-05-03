$(document).ready(function () {
    /* delete register */

    $(".delReg").click(function (e) {
        e.preventDefault();
        var deleteUrl = $(this).attr('href');
        
        Swal.fire({
            title: '¿Está seguro?',
            text: "Esta acción no se puede deshacer",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#0089c0', // --c-9: azul claro intranet
            cancelButtonColor: '#111827', // --c-1: fondo principal oscuro
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: '#1f2937', // --c-2: fondo secundario
            color: '#e5e7eb', // --c-6: texto claro
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
        return false;
    });

    $("#reset_pwd").click(function (e) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });

        $.ajax({
            type: "get",
            url: "../reset-pwd",
            data: {
                id: $("#userID").val(), // This could be a hidden field whit the value of user id
                new_password: $("#newPassword").val(),
            },
            success: function (data) {
                //$('#').html(data);
                //alert(data);
                $("#modal_reset").modal("hide");
                toastr.success("Contraseña modificada!");
            },
        });
    });

    $("#new_pwd").click(function () {
        var current_pwd = $("#current_pwd").val();
        $.ajax({
            url: "../admin/check-pwd",
            type: "get",
            data: { current_pwd: current_pwd },
            success: function (resp) {
                if (resp == "false") {
                    $("#chkPwd").html(
                        '<font color="red">La áctual contraseña es incorrecta.</font>'
                    );
                } else if (resp == "true") {
                    $("#chkPwd").html(
                        '<font color="green">La áctual contraseña es correcta.</font>'
                    );
                }
            },
            error: function () {
                alert("Error");
            },
        });
    });
});

$("#frmPwdAdmin").validate({
    event: "blur",
    rules: {
        current_pwd: "required",
        new_pwd: "required",
        confirm_pwd: {
            equalTo: "#new_pwd",
        },
    },
    messages: {
        current_pwd: "Por favor ingrese contraseña actual",
        new_pwd: "Ingrese nueva contraseña",
        confirm_pwd: "Las contraseñas no coinciden.",
    },
    debug: true,
    errorElement: "label",

    submitHandler: function (form) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });

        $.ajax({
            url: "../admin/update-pwd",
            method: "post",
            data: $("#frmPwdAdmin").serialize(),
            success: function (data) {
                if ((data = "1")) {
                    var text = "Contraseña actualizada correctamente!";
                }
                if ((data = "0")) {
                    var text = "La contraseña actual es incorrecta.";
                }

                window.location.href = "../admin/dashboard";
            },
        });
    },
});

/* Usuarios add_usuario */

$("#add_usuario").validate({
    event: "blur",
    rules: {
        name: "required",
        email: "required",
        password: "required",
    },
    messages: {
        name: "Por favor ingrese nombre.",
        email: "Por favor ingrese un valor.",
        password: "Por favor ingrese un valor.",
    },
    debug: true,
    errorElement: "label",

    submitHandler: function (form) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });
        $("#add_usuario")[0].submit();
    },
});

/* Usuarios edit_usuario */

$("#edit_usuario").validate({
    event: "blur",
    rules: {
        name: "required",
        email: "required",
        password: "required",
    },
    messages: {
        name: "Por favor ingrese nombre.",
        email: "Por favor ingrese un valor.",
        password: "Por favor ingrese un valor.",
    },
    debug: true,
    errorElement: "label",

    submitHandler: function (form) {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });
        $("#edit_usuario")[0].submit();
    },
});

/* Traduccion add_tradduccion */

$("#add_traduccion").validate({
    event: "blur",
    rules: {
        es: "required",
    },
    messages: {
        es: "Por favor ingrese el texto.",
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send")
            .prop("disabled", true)
            .html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i> ');
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });
        $("#add_traduccion")[0].submit();
    },
});

/* Traduccion edit_tradduccion */

$("#edit_traduccion").validate({
    event: "blur",
    rules: {
        es: "required",
    },
    messages: {
        es: "Por favor ingrese el texto.",
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send")
            .prop("disabled", true)
            .html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });
        $("#edit_traduccion")[0].submit();
    },
});

/* Traduccion edit_tradduccion */

$("#edit_config").validate({
    event: "blur",
    rules: {
        destinatarios: "required",
    },
    messages: {
        destinatarios: "Por favor ingrese un email.",
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send")
            .prop("disabled", true)
            .html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),
            },
        });
        $("#edit_config")[0].submit();
    },
});

/* frases */

$("#add_frase").validate({
    event: "blur",
    rules: { 
        frase: {
            required: true,
          },
     },
    messages: { 
        frase: {
            required: "Este campo es obligatorio.",
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#add_frase")[0].submit();
    },
});

$("#edit_frase").validate({
    event: "blur",
    rules: { 
        frase: {
            required: true,
          },
     },
     messages: { 
        frase: {
            required: "Este campo es obligatorio.",
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#edit_frase")[0].submit();
    },
});

/* tipos */

$("#add_tipo").validate({
    event: "blur",
    rules: { 
        nombre: {
            required: true,
          },
     },
    messages: { 
        nombre: {
            required: "Este campo es obligatorio.",
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#add_tipo")[0].submit();
    },
});

$("#edit_tipo").validate({
    event: "blur",
    rules: { 
        nombre: {
            required: true,
          },
     },
     messages: { 
        nombre: {
            required: "Este campo es obligatorio.",
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#edit_tipo")[0].submit();
    },
});

/* Posts */

$("#add_post").validate({
    event: "blur",
    rules: { 
        titulo: {
            required: true,
            minlength: 5
        },
        fecha_publicacion: {
            required: true
        },
        tiempo_lectura: {
            required: true,
            number: true,
            min: 1
        },
        contenido: {
            required: true,
            minlength: 50
        }
    },
    messages: { 
        titulo: {
            required: "El título es obligatorio",
            minlength: "El título debe tener al menos 5 caracteres"
        },
        fecha_publicacion: {
            required: "La fecha de publicación es obligatoria"
        },
        tiempo_lectura: {
            required: "El tiempo de lectura es obligatorio",
            number: "Introduce un número válido",
            min: "El tiempo de lectura debe ser al menos 1 minuto"
        },
        contenido: {
            required: "El contenido es obligatorio",
            minlength: "El contenido debe tener al menos 50 caracteres"
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#add_post")[0].submit();
    },
});

$("#edit_post").validate({
    event: "blur",
    rules: { 
        titulo: {
            required: true,
            minlength: 5
        },
        fecha_publicacion: {
            required: true
        },
        tiempo_lectura: {
            required: true,
            number: true,
            min: 1
        },
        contenido: {
            required: true,
            minlength: 50
        }
    },
    messages: { 
        titulo: {
            required: "El título es obligatorio",
            minlength: "El título debe tener al menos 5 caracteres"
        },
        fecha_publicacion: {
            required: "La fecha de publicación es obligatoria"
        },
        tiempo_lectura: {
            required: "El tiempo de lectura es obligatorio",
            number: "Introduce un número válido",
            min: "El tiempo de lectura debe ser al menos 1 minuto"
        },
        contenido: {
            required: "El contenido es obligatorio",
            minlength: "El contenido debe tener al menos 50 caracteres"
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#edit_post")[0].submit();
    },
});

/* Clientes */

$("#add_cliente").validate({
    event: "blur",
    rules: { 
        nombre: {
            required: true,
            minlength: 3
        },
        email: {
            email: true
        },
        cuit: {
            digits: true
        }
    },
    messages: { 
        nombre: {
            required: "El nombre es obligatorio",
            minlength: "El nombre debe tener al menos 3 caracteres"
        },
        email: {
            email: "Por favor ingrese un email válido"
        },
        cuit: {
            digits: "El CUIT debe contener solo números"
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#add_cliente")[0].submit();
    },
});

$("#edit_cliente").validate({
    event: "blur",
    rules: { 
        nombre: {
            required: true,
            minlength: 3
        },
        email: {
            email: true
        },
        cuit: {
            digits: true
        }
    },
    messages: { 
        nombre: {
            required: "El nombre es obligatorio",
            minlength: "El nombre debe tener al menos 3 caracteres"
        },
        email: {
            email: "Por favor ingrese un email válido"
        },
        cuit: {
            digits: "El CUIT debe contener solo números"
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#edit_cliente")[0].submit();
    },
});

/* Órdenes */

$("#add_orden").validate({
    event: "blur",
    rules: { 
        cliente_id: {
            required: true
        },
        asunto: {
            required: true,
            minlength: 3
        },
        importe: {
            required: true,
            number: true,
            min: 0
        }
    },
    messages: { 
        cliente_id: {
            required: "Debe seleccionar un cliente"
        },
        asunto: {
            required: "El asunto es obligatorio",
            minlength: "El asunto debe tener al menos 3 caracteres"
        },
        importe: {
            required: "El importe es obligatorio",
            number: "Ingrese un valor numérico válido",
            min: "El importe debe ser mayor o igual a 0"
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#add_orden")[0].submit();
    },
});

$("#edit_orden").validate({
    event: "blur",
    rules: { 
        cliente_id: {
            required: true
        },
        asunto: {
            required: true,
            minlength: 3
        },
        importe: {
            required: true,
            number: true,
            min: 0
        }
    },
    messages: { 
        cliente_id: {
            required: "Debe seleccionar un cliente"
        },
        asunto: {
            required: "El asunto es obligatorio",
            minlength: "El asunto debe tener al menos 3 caracteres"
        },
        importe: {
            required: "El importe es obligatorio",
            number: "Ingrese un valor numérico válido",
            min: "El importe debe ser mayor o igual a 0"
        }
    },
    debug: true,
    errorElement: "label",
    submitHandler: function (form) {
        $("#send").prop("disabled", true).html('<i class="fa fa-circle-o-notch fa-spin fa-1x fa-fw"></i>');
        $.ajaxSetup({ headers: {"X-CSRF-TOKEN": $('meta[name="csrf_token"]').attr("content"),},});
        $("#edit_orden")[0].submit();
    },
});
