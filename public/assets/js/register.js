$(document).ready(function () {
    //Acambiar de estado
    $('#cboState').on('change', function(){
        console.log('State is Change');
        $("#cboLocation").html('<option value="">Ciudad</option>');
        if($('#cboState').val()!=''){

            var formData= {
                state_id:$('#cboState').val()
            };

            $.ajax({
                url: "/register-load-locations",
                data: formData,
                type: "POST",
                beforeSend:function(){
                    //cart.loading.fadeIn();
                },
                success: function (response) {
                    var _locations = '<option value="">Ciudad</option>';
                    if(response.result == 'ok'){
                        for(var i=0; i<response.locations.length; i++){
                            var _location = response.locations[i];
                            _locations+='<option value="'+_location.id+'">'+_location.title+'</option>';
                        }
                        $("#cboLocation").html(_locations);
                    }
                },


            });
        }
    });

    //registrar gym
    $("#frmInitRegistro").on("click", "#btnCrear", function(event){
        var form = $("#frmInitRegistro");

        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
        });

        if( form.valid() ){
            event.preventDefault();//Eliminar el evento del submit del botón

            swal({
                title: "Registrando",
                text: "Espere mientras se registra su información",
                type: "info",
                showCancelButton: false,
                cancelButtonText: "",
                showConfirmButton: false,
                confirmButtonText: "",
                closeOnConfirm: false
            },
                function(){
            });


            var formData= {
                tradename:$('#tradename').val(),
                name:$('#name').val(),
                last_name:$('#last_name').val(),
                email:$('#email').val(),
                state:$('#cboState').val(),
                location:$('#cboLocation').val(),
                password:$('#password').val(),
                terminos_condiciones:$('#terminos_condiciones').val()
            };

            $.ajax({
                url: "/registro-init",
                data: formData,
                type: "POST",
                beforeSend:function(){
                    //cart.loading.fadeIn();
                },
                success: function (response) {
                    if(response.result=="ok"){
                        window.location.href="/registro-generales";
                    }else{
                        swal("Atención", response.msj, "warning");
                    }

                },


            });
        }
    });

});
