var formslayout = {
    contacto: function(){
        var datos = $('#form-contacto').serialize();
        swal('Espere', 'su información se está enviando','info');

        $.ajax({
            url:'send-contacto',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: datos,
            type:"POST",
            success: function(response){
                if(response.result === "ok"){
                    $('#form-contacto')[0].reset();
                    swal('', 'Se ha enviado su información. Nos pondremos en contacto a la brevedad.', 'success');

                }
                else{
                    swal('Error','Revise su información','warning');
                }

            }

        })
    },
    loginUser : function (){
        var datos = $('#form-login').serialize();
        swal('Espere', 'su información se está enviando','info');

        $.ajax({
            url:'/login',
            headers:{'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: datos,
            type:"POST",
            success: function(response){
                if(response.result === "ok"){
                    $('#form-login')[0].reset();

                    window.location.href="/perfil";

                }
                else{
                    swal('Error',response.message,'warning');
                }

            }

        })
    },

};
