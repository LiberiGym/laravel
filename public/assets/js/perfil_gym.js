$(document).ready(function () {
    $("#btnCerrarSesion").on('click', function(){
        swal({
            title: 'Cerrar Sesión',
            text: "¿Deseas cerrar tu sesión?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    window.location.href="/logout";
                }
            });
    });

});
