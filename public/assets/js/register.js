$(document).ready(function () {
    //Agregar otro dia
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

});
