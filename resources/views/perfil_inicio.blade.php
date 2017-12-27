@extends('layout.layout')
@section('css')
<link href="css/registro.steps.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />

<link href="/admin_assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
<link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />

<link href="css/perfil.css" rel="stylesheet" id="theme" />


@endsection
@section('content')

<!-- about -->
<div class="jarallax agileits-registro agile-section-about-detail" id="aboutUs">
    <div class="container">

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-3">
                <div class="logo-perfil" align="center">
                    @if($gym->gym_logo!='default.png' || $gym->gym_logo!='')
                    <img src="files/gyms/{{$gym->gym_logo}}" alt="" style="height: 100px; width:auto; text-aling:center;">
                    @endif
                </div>
                <hr class="hr-nav-perfil">
                <ul class="nav-perfil">
                    <li class="active"><a href="/perfil-inicio">Inicio <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-usuarios">Usuarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-datos-cuenta">Datos de Cuenta <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-clientes">Clientes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="perfil-reportes">Reportes <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                </ul>
                <button type="button" name="button" id="btnCerrarSesion" class="cerrar-session">Cerrar Sesión</button>

            </div>
            <div class="col-lg-9">
                <h1 style="margin-bottom: 45px;">Mi Perfil <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form action="/perfil-inicio" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="editInfo" value="1">
                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos de Encargado o Dueño</legend>
                        <input type="text" name="manager"  placeholder="Nombre de Encargado o Gerente" class="form-registro-element" required="required" value="{{$gym->manager}}">
                        <input type="text" name="manager_cel"  placeholder="Teléfono Celular de Encargado o Gerente" class="form-registro-element" required="required" number="true" value="{{$gym->manager_cel}}">
                        <input type="text" name="gym_monthly_fee"  placeholder="Costo de Mensualidad" class="form-registro-element" required="required" number="true" value="{{$gym->gym_monthly_fee}}">
                        <input type="text" name="gym_phone"  placeholder="Teléfono de Recepción" class="form-registro-element" required="required" number="true" value="{{$gym->gym_phone}}">
                        <input type="email" name="gym_email"  placeholder="Correo de Gimnasio" class="form-registro-element" required="required" value="{{$gym->gym_email}}">
                        <input type="text" name="gym_web"  placeholder="Página Web" class="form-registro-element" required="required" value="{{$gym->gym_web}}">
                        <input type="text" name="gym_url_video"  placeholder="URL de video" class="form-registro-element" required="required" value="{{$gym->gym_url_video}}">
                        <p style="margin-bottom: 0;">Ingresa una breve descripción de tu negocio</p>
                        <textarea id="txtDescripcion" name="gym_description" placeholder="Descripción Máximo 500 caractéres"  class="form-registro-element" style="height: 111px;" required="required">{{$gym->gym_description}}</textarea>
                        <p><span id="lblCharCounter" style="font-size: 16px; color: #1d4289;">500</span> caractéres restantes</p>

                        <legend class="form-legend-registro">Selecciona los días que opera:</legend>

                        <input id="lunes" name="daysOpen[]" type="checkbox" value="lunes" class="diasSemana" {{($schedulesSelected[0]['checked']=='checked')?' checked ':''}} > <label for="lunes" class="form-label-time">Lunes</label>
                        <input id="lunesDe" name="lunesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="lunesA" name="lunesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="martes" name="daysOpen[]" type="checkbox" value="martes" class="diasSemana" {{($schedulesSelected[1]['checked']=='checked')?'checked':''}}> <label for="martes" class="form-label-time">Martes</label>
                        <input id="martesDe" name="martesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="martesA" name="martesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="miercoles" name="daysOpen[]" type="checkbox" value="miercoles" class="diasSemana" {{($schedulesSelected[2]['checked']=='checked')?'checked':''}}> <label for="miercoles" class="form-label-time">Miércoles</label>
                        <input id="miercolesDe" name="miercolesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="miercolesA" name="miercolesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="jueves" name="daysOpen[]" type="checkbox" value="jueves" class="diasSemana" {{($schedulesSelected[3]['checked']=='checked')?'checked':''}}> <label for="jueves" class="form-label-time">Jueves</label>
                        <input id="juevesDe" name="juevesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="juevesA" name="juevesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="viernes" name="daysOpen[]" type="checkbox" value="viernes" class="diasSemana" {{($schedulesSelected[4]['checked']=='checked')?'checked':''}}> <label for="viernes" class="form-label-time">Viernes</label>
                        <input id="viernesDe" name="viernesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="viernesA" name="viernesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="sabado" name="daysOpen[]" type="checkbox" value="sabado" class="diasSemana" {{($schedulesSelected[5]['checked']=='checked')?'checked':''}}> <label for="sabado" class="form-label-time">Sábado</label>
                        <input id="sabadoDe" name="sabadoDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="sabadoA" name="sabadoA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="domingo" name="daysOpen[]" type="checkbox" value="domingo" class="diasSemana" {{($schedulesSelected[6]['checked']=='checked')?'checked':''}}> <label for="domingo" class="form-label-time">Domingo</label>
                        <input id="domingoDe" name="domingoDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="domingoA" name="domingoA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>




                    </fieldset>

                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos de la Empresa</legend>
                        <input type="text" name="gym_street"  placeholder="Calle" class="form-registro-element" value="{{$gym->gym_street}}" required="required">
                        <input type="text" name="gym_number"  placeholder="Número" class="form-registro-element" value="{{$gym->gym_number}}" required="required">
                        <input type="text" name="gym_neighborhood" value="{{$gym->gym_neighborhood}}"  placeholder="Colonia" class="form-registro-element" required="required">
                        <input type="text" name="gym_zipcode" value="{{$gym->gym_zipcode}}" placeholder="C.P." class="form-registro-element" required="required">
                        <input type="text" name="gym_city" placeholder="Ciudad" class="form-registro-element" readonly="readonly" value="{{$gym->gym_city}}">
                        <input type="text" name="gym_state"  placeholder="Estado" class="form-registro-element" readonly="readonly"  value="{{$gym->gym_state}}">


                        <legend class="form-legend-registro">Selecciona los servicios que ofrece:</legend>
                        <div class="col-lg-12">
                            @foreach($categories as $category)
                            <div class="col-lg-6">
                            <input id="chk_{{$category->id}}" name="servicios[]" type="checkbox" value="{{$category->id}}"  {{(in_array($category->id, $servicesSelected))? 'checked' : '' }} class="servicioGym"> <label for="chk_{{$category->id}}" class="form-label-servicios">{{$category->title}}</label>
                            </div>
                            @endforeach
                        </div>


                        <div class="clearfix"></div>







                    </fieldset>

                    <fieldset class="col-lg-12" style="margin-top:15px;">
                        <legend class="form-legend-registro">Subir imágenes de la Empresa</legend>
                        <p style="font-style: italic;margin-bottom: 0;">Máximo 10</p>
                        <button type="button" id="divUploadImage"  name="button" class="form-button">Seleccionar imágen</button>
                        <div class="clearfix"></div>
                        <div class="" id="divImages" style="margin-top:15px;">
                            <?php $totalImage = count($imagesGym); ?>
                            @foreach($imagesGym as $image)
                            <div class="col-lg-3 images-selected" data-id="{{$image->id}}" style="margin:2px; background:url(files/gyms/{{$image->image}}); background-size:cover; height: 100px;" >
                                <label class="form-label-servicios" style="background: rgba(29,66,137,0.8);width: 100%; color:#fff; padding:3px;"><i class="fa fa-times" aria-hidden="true"></i> <span style="font-size:11px;">Eliminar</span></label>
                            </div>
                            @endforeach
                        </div>
                        <div class="clearfix"></div>

                        <button type="guardar" name="button" id="btnGuardar">Guardar</button>
                    </fieldset>
                </form>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //about -->
@endsection
@section('js')
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script src="/admin_assets/plugins/dropzone/dropzone.js"></script>
<script src="/admin_assets/plugins/dropzone/uploader.js"></script>

<script>
$(function() {
    $('#lunesDe, #lunesA, #martesDe, #martesA, #miercolesDe, #miercolesA, #juevesDe, #juevesA, #viernesDe, #viernesA, #sabadoDe, #sabadoA, #domingoDe, #domingoA').timepicker({ 'timeFormat': 'H:i:s' }).prop('disabled', true).css('background','#ccc');

    $('.diasSemana').on('change',function () {//input[name=daysOpen]
        var _nameChk = $(this).val();
        console.log(_nameChk);
        if (this.checked) {
            $('#'+_nameChk+'De').prop('disabled', false).css('background','#fff');
            $('#'+_nameChk+'A').prop('disabled', false).css('background','#fff');
        }else{
            $('#'+_nameChk+'De').prop('disabled', true).css('background','#ccc');
            $('#'+_nameChk+'A').prop('disabled', true).css('background','#ccc');
        }
    });

});
$(document).ready(function () {
    var arrImages = [];

    $('.diasSemana').each(
        function() {
            var _nameChk = $(this).val();
            if($(this).is(':checked')){
                $('#'+_nameChk+'De').prop('disabled', false).css('background','#fff');
                $('#'+_nameChk+'A').prop('disabled', false).css('background','#fff');
            }
        }
    );

    /*asignamos valor al timepicker*/
    $('#lunesDe').timepicker('setTime', "<?php echo $schedulesSelected[0]['inicia']; ?>" );
    $('#lunesA').timepicker('setTime', "<?php echo $schedulesSelected[0]['termina']; ?>" );
    $('#martesDe').timepicker('setTime', "<?php echo $schedulesSelected[1]['inicia']; ?>" );
    $('#martesA').timepicker('setTime', "<?php echo $schedulesSelected[1]['termina']; ?>" );
    $('#miercolesDe').timepicker('setTime', "<?php echo $schedulesSelected[2]['inicia']; ?>" );
    $('#miercolesA').timepicker('setTime', "<?php echo $schedulesSelected[2]['termina']; ?>" );
    $('#juevesDe').timepicker('setTime', "<?php echo $schedulesSelected[3]['inicia']; ?>" );
    $('#juevesA').timepicker('setTime', "<?php echo $schedulesSelected[3]['termina']; ?>" );
    $('#viernesDe').timepicker('setTime', "<?php echo $schedulesSelected[4]['inicia']; ?>" );
    $('#viernesA').timepicker('setTime', "<?php echo $schedulesSelected[4]['termina']; ?>" );
    $('#sabadoDe').timepicker('setTime', "<?php echo $schedulesSelected[5]['inicia']; ?>" );
    $('#sabadoA').timepicker('setTime', "<?php echo $schedulesSelected[5]['termina']; ?>" );
    $('#domingoDe').timepicker('setTime', "<?php echo $schedulesSelected[6]['inicia']; ?>" );
    $('#domingoA').timepicker('setTime', "<?php echo $schedulesSelected[6]['termina']; ?>" );

    console.log( Date("<?php echo $schedulesSelected[6]['termina']; ?>")   );


    //subir image
    var countImage=( isNaN(parseInt('<?php echo $totalImage; ?>') ) ) ? 0 : parseInt('<?php echo $totalImage; ?>');
    console.log('Count Image: '+countImage);
    if(countImage==10){
        $('#divUploadImage').fadeOut();
    }

    uploader.add('divUploadImage', {
        url: '/register-upload-image',
        formData: {
            type: 'images'
        }
    }, function(data){
        if(data.result == 'ok'){

            location.reload();
            /*var addImage ='<div style="margin-top:5px; background:url(files/gyms/'+data.file+'); height: 31px;">\
                <input type="checkbox" name="txtNameFileImage" value="'+data.file+'" checked><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">'+data.file+'</span></label>\
            </div>';
            $('#divImages').append(addImage);
            countImage++;
            if(countImage==10){
                $('#divUploadImage').fadeOut();
            }*/
        }
        if(data.result =='error_type'){
            swal('Cuidado','Solo puede subir imagenes en formato de tiff y jpg','warning');
        }
    });





    var _images = {
        //delete images
        ImageDelete : function(_idImage){

            swal({
                type: 'success',
                title: 'Espere mientras se elimina la imagen',
                showConfirmButton: false
            })

            var formData= {
                image_id:_idImage
            };

            $.ajax({
                url: "/perfil-delete-image",
                data: formData,
                type: "POST",
                beforeSend:function(){
                },
                success: function (response) {
                    if(response.result == 'ok'){
                        location.reload();
                    }else{
                        swal('Cuidado','No se pudo eliminar la imagen, vuelva a intentarlo','warning');
                    }
                },
            });
        },
    };

    $('.images-selected').each(
        function() {
            var listItem = $(this);
            $(listItem).on('click', function (event){
                event.preventDefault();
                var idItem = listItem.data('id');

                swal({
                    title: 'Eliminar Imagen',
                    text: "¿Deseas eliminar la imagen?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Si',
                    cancelButtonText: 'No'
                    }).then((result) => {
                        console.log(result);
                        if (result.value) {
                            _images.ImageDelete(idItem);
                        }
                    });

            });
        }
    );



    //contador de descripcion
    var _currenText = $("#txtDescripcion").val();

    $("#txtDescripcion").keypress(function() {
        getLengthChar();
    });

    function getLengthChar(){
        var _maxChar = 500;
        var _lngChar = parseInt($("#txtDescripcion").val().length);
        var _leftChar = _maxChar-_lngChar;
        if(_leftChar>0){
            $("#lblCharCounter").html(_leftChar);
            _currenText = $("#txtDescripcion").val();
        }else{
            $("#lblCharCounter").html(0);
            $("#txtDescripcion").val(_currenText);
        }
    }
    getLengthChar();

    //form registro
    $("#frmDatos").on("click", "#btnGuardar", function(event){
        var form = $("#frmDatos");

        form.validate({
            errorPlacement: function errorPlacement(error, element) {
                element.after(error);
            },
        });

        if( form.valid() ){
            event.preventDefault();//Eliminar el evento del submit del botón

            var _diasSelected = false;
            var _serviceSelected = false;

            $('.diasSemana').each(
                function() {
                    if($(this).is(':checked')){
                        _diasSelected = true;
                        console.log('Dias seleccionados: '+_diasSelected);
                    }
                }
            );

            $('.servicioGym').each(
                function() {
                    if($(this).is(':checked')){
                        _serviceSelected = true;
                        console.log('Servicios seleccionados: '+_serviceSelected);
                    }
                }
            );

            if(_diasSelected && _serviceSelected){
                swal({
                    type: 'success',
                    title: 'Guardando sus cambios',
                    showConfirmButton: false
                })
                form.submit();
                console.log('form.submit()');
            }else{
                swal('Cuidado','Debe seleccionar los días en los que opera y almenos un tipo de servicio','warning');
            }
        }
    });

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

</script>
@endsection
