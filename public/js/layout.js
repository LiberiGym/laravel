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

                    if(response.type==2){
                        window.location.href="/perfil";

                    }else if(response.type==5){
                        window.location.href="/perfil";

                    }else if(response.type==3){
                        window.location.href="/administracion";
                    }
                }
                else{
                    if(response.type==1){
                        window.location.href="/logout";

                    }else{
                        swal('Error',response.message,'warning');
                    }
                }

            }

        })
    },

};
