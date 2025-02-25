$(document).ready(function () {
    /* delete register */

    $(".delReg").click(function () {
        if (confirm("Está seguro de eliminar el registro ?")) {
            return true;
        }
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
                toast("Contraseña modificada!");
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

