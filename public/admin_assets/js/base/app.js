
$(document).ready(function () {
    App.init();
    CustomControls.ini();
    CustomErrors.init();
});

var CustomControls = {
    iniButtons: function () {
        $.each($(".statusButtons"), function () {
            var group = $(this);
            var target = $("#" + group.data("target"));
            group.find("a[rel=" + target.val() + "]").addClass("active");
        });

        $(".statusButtons .btn").on({
            click: function (e) {
                e.preventDefault();
                var btn = $(this);
                var group = btn.parent();
                var target = $("#" + group.data("target"));

                group.children().removeClass("active");
                btn.addClass("active");

                target.val(btn.attr("rel"));
            }
        });

        $(".btnDelete").on({
            click: function (e) {
                e.preventDefault();
                var link = $(this).attr("href");
                msg.confirm("Advertencia", "¿Confirma eliminar este elemento y su contenido?", "Sí, Eliminar", function () {
                    window.location = link;
                });
            }
        });

        $('.trigger').on({
            click: function(e){
                e.preventDefault();
                $('#' + $(this).data('target')).trigger('click');
            }
        })

    },
    ini: function () {
        CustomControls.iniButtons();

        $(document).on({
            scroll: function (e) {
                var top = $(window).scrollTop();
                if (top > 55) {
                    $("body").addClass("static");
                } else {
                    $("body").removeClass("static");
                }
            }
        });
    }
};

var CustomErrors = {
    init: function(){
        if($('#modal-alert-error').length == 1){
            $('#modal-alert-error').modal();
        }
    }
};

window.msg = {
    ok: function (message) {
        swal("Ok", message, "success");
    },
    error: function (message) {
        swal("Error", message, "error");
    },
    info: function (title, message) {
        swal(title, message, "info");
    },
    confirm: function (title, message, confirmText, callback) {
        swal({
            title: title,
            text: message,
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#DD6B55",
            confirmButtonText: confirmText,
            cancelButtonText: "Cancelar",
            closeOnConfirm: true
        },
            function () {
                callback();
            });
    },
    close: function () {
        swal.close();
    }
};
