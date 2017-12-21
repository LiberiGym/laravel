@extends('layout.layout')
@section('css')
<link href="css/registro.steps.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />

<link href="/admin_assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
<link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />


@endsection
@section('content')

<!-- about -->
<div class="jarallax agileits-registro agile-section-about-detail" id="aboutUs">
    <div class="container">
        <div class="row" style="margin-bottom:40px;">
            <div class="col-lg-12">
                <div class="stepwizard">
                    <div class="stepwizard-row">
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-selected btn-circle">1</button>
                            <p class="title-selected">Registro</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">2</button>
                            <p class="title">Datos Fiscales</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">3</button>
                            <p class="title">Datos Bancarios</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">4</button>
                            <p class="title">Finalización de Registro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-3">
                <img src="images/registro_01_image.png" alt="">

            </div>
            <div class="col-lg-9">
                <h1>Formulario de Regístro (Anexo 2) <img src="images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <p>Ingresa tus datos en el siguiente formulário para continuar con el regístro.</p>
                <form action="/registro-datos-fiscales" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos de Encargado o Dueño</legend>
                        <input type="text" name="manager"  placeholder="Nombre de Encargado o Gerente" class="form-registro-element" required="required">
                        <input type="text" name="manager_cel"  placeholder="Teléfono Celular de Encargado o Gerente" class="form-registro-element" required="required" number="true">
                        <input type="text" name="gym_monthly_fee"  placeholder="Costo de Mensualidad" class="form-registro-element" required="required" number="true">
                        <input type="text" name="gym_phone"  placeholder="Teléfono de Recepción" class="form-registro-element" required="required" number="true">
                        <input type="email" name="gym_email"  placeholder="Correo de Gimnasio" class="form-registro-element" required="required">
                        <input type="text" name="gym_web"  placeholder="Página Web" class="form-registro-element" required="required">
                        <input type="text" name="gym_url_video"  placeholder="URL de video" class="form-registro-element" required="required">
                        <p style="margin-bottom: 0;">Ingresa una breve descripción de tu negocio</p>
                        <textarea id="txtDescripcion" name="gym_description" placeholder="Descripción Máximo 500 caractéres"  class="form-registro-element" style="height: 111px;" required="required"></textarea>
                        <p><span id="lblCharCounter" style="font-size: 16px; color: #1d4289;">500</span> caractéres restantes</p>

                        <legend class="form-legend-registro">Selecciona los días que opera:</legend>
                        <input id="lunes" name="daysOpen[]" type="checkbox" value="lunes" class="diasSemana" > <label for="lunes" class="form-label-time">Lunes</label>
                        <input id="lunesDe" name="lunesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="lunesA" name="lunesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="martes" name="daysOpen[]" type="checkbox" value="martes" class="diasSemana"> <label for="martes" class="form-label-time">Martes</label>
                        <input id="martesDe" name="martesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="martesA" name="martesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="miercoles" name="daysOpen[]" type="checkbox" value="miercoles" class="diasSemana"> <label for="miercoles" class="form-label-time">Miércoles</label>
                        <input id="miercolesDe" name="miercolesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="miercolesA" name="miercolesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="jueves" name="daysOpen[]" type="checkbox" value="jueves" class="diasSemana"> <label for="jueves" class="form-label-time">Jueves</label>
                        <input id="juevesDe" name="juevesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="juevesA" name="juevesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="viernes" name="daysOpen[]" type="checkbox" value="viernes" class="diasSemana"> <label for="viernes" class="form-label-time">Viernes</label>
                        <input id="viernesDe" name="viernesDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="viernesA" name="viernesA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="sabado" name="daysOpen[]" type="checkbox" value="sabado" class="diasSemana"> <label for="sabado" class="form-label-time">Sábado</label>
                        <input id="sabadoDe" name="sabadoDe" type="text" class="form-registro-time" placeholder="De:" required="required"/>
                        <input id="sabadoA" name="sabadoA" type="text" class="form-registro-time" placeholder="A:" required="required"/>
                        <div class="clearfix"></div>

                        <input id="domingo" name="daysOpen[]" type="checkbox" value="domingo" class="diasSemana"> <label for="domingo" class="form-label-time">Domingo</label>
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
                            <input id="chk_{{$category->id}}" name="servicios[]" type="checkbox" value="{{$category->id}}" checked="false" class="servicioGym"> <label for="chk_{{$category->id}}" class="form-label-servicios">{{$category->title}}</label>
                            </div>
                            @endforeach
                        </div>


                        <div class="clearfix"></div>

                        <legend class="form-legend-registro">Subir imágenes de la Empresa</legend>
                        <p style="font-style: italic;margin-bottom: 0;">Máximo 10</p>
                        <button type="button" id="divUploadImage"  name="button" class="form-button">Seleccionar imágen</button>
                        <div class="clearfix"></div>
                        <div class="" id="divImages" style="margin-top:15px;">
                            <?php $totalImage = count($imagesGym); ?>
                            @foreach($imagesGym as $image)
                            <div style="margin-top:5px; background:url(files/gyms/{{$image->image}}); height: 31px;">
                                <input type="checkbox" name="txtNameFileImage" value="{{$image->image}}" checked disabled><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">{{$image->image}}</span></label>
                            </div>
                            @endforeach
                        </div>




                        <div class="clearfix"></div>

                        <button type="button" name="button" id="btnGuardar">Siguiente</button>
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
            var addImage ='<div style="margin-top:5px; background:url(files/gyms/'+data.file+'); height: 31px;">\
                <input type="checkbox" name="txtNameFileImage" value="'+data.file+'" checked><label class="form-label-servicios" style="background: rgba(29,66,137,0.5);width: 100%; color:#fff;"><i class="fa fa-file-image-o" aria-hidden="true"></i> <span style="font-size:11px;">'+data.file+'</span></label>\
            </div>';
            $('#divImages').append(addImage);
            countImage++;
            if(countImage==10){
                $('#divUploadImage').fadeOut();
            }
        }
        if(data.result =='error_type'){
            swal('Cuidado','Solo puede subir imagenes en formato de tiff y jpg','warning');
        }
    });

    //contador de descripcion
    var _currenText = $("#txtDescripcion").val();
    $("#txtDescripcion").keypress(function() {
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
    });

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
                form.submit();
                console.log('form.submit()');
            }else{
                swal('Cuidado','Debe seleccionar los días en los que opera y almenos un tipo de servicio','warning');
            }
        }
    });



});

</script>
@endsection
