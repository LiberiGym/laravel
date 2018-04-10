@extends('front.layout.layout_registro')
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
                <form action="/registro-create-datosgrales" class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="diasoperasemana" id="diasoperasemana">

                    <fieldset class="col-lg-6">
                        <legend class="form-legend-registro">Datos de Encargado o Dueño</legend>
                        <input type="text" name="manager"  placeholder="Nombre de Encargado o Gerente" class="form-registro-element" required="required">
                        <input type="text" name="manager_cel"  placeholder="Teléfono Celular de Encargado o Gerente" class="form-registro-element" required="required" number="true">
                        <input type="text" name="gym_monthly_fee" id="gym_monthly_fee"  placeholder="Costo de Mensualidad" class="form-registro-element" required="required" number="true">
                        <input type="text" name="gym_phone"  placeholder="Teléfono de Recepción" class="form-registro-element" required="required" number="true">
                        <input type="email" name="gym_email"  placeholder="Correo de Gimnasio" class="form-registro-element" required="required">
                        <input type="text" name="gym_web"  placeholder="Página Web" class="form-registro-element">
                        <input type="text" name="gym_url_video"  placeholder="URL de video" class="form-registro-element">
                        <p style="margin-bottom: 0;">Ingresa una breve descripción de tu negocio</p>
                        <textarea id="txtDescripcion" name="gym_description" placeholder="Descripción Máximo 500 caractéres"  class="form-registro-element" style="height: 111px;" required="required"></textarea>
                        <p><span id="lblCharCounter" style="font-size: 16px; color: #1d4289;">500</span> caractéres restantes</p>

                        <p style="margin-bottom: 0;">Ingresa la leyenda de horario para mostrar</p>
                        <input type="text" name="gym_schedule"  placeholder="Ejemplo: Lunes a Viernes de 6:00 am a 10:00 pm" class="form-registro-element" required="required">

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
                        <input type="text" name="gym_city" id="gym_city" placeholder="Ciudad" class="form-registro-element" readonly="readonly" value="{{$gym->gym_city}}">
                        <input type="text" name="gym_state" id="gym_state"  placeholder="Estado" class="form-registro-element" readonly="readonly"  value="{{$gym->gym_state}}">

                        <div id="map" style="height: 266px;"></div>

                        <input type="hidden" name="lat" id="txtLat" />
                        <input type="hidden" name="lng" id="txtLng" />

                        <div class="clearfix"></div>

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


                        <!--<button type="button" name="button" id="btnCalculadora" data-toggle="modal" data-target="#mdlCalculadora">Calculadora</button>-->

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
<!-- Modal -->
<div class="modal fade" id="mdlCalculadora" tabindex="-1" role="dialog" aria-labelledby="mdlCalculadora" aria-hidden="true">
    <div class="modal-dialog" role="document"  style="background:#DFE0E4;">
        <div class="modal-content" style="background:#DFE0E4;">
            <!--<div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">¡CALCULA TU COSTO POR VISITA!</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>-->
            <div class="modal-body" style="background:#DFE0E4;">
                <h1 style="font-family: 'AvenirLTStd-Black'; font-size: 32px; color: #1d4289; text-align:center; margin-bottom:25px;">¡CALCULA TU COSTO POR VISITA!</h1>
                <form class="form-registro" role="form" style="padding-bottom: 0em;">
                <div class="row">

                    <div class="col-lg-8">
                        <div class="col-lg-12" style="margin-bottom:80px;">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">Introduce costo de tu mensualidad más completa</label>
                            <p style="font-style: italic; margin-bottom: 0;color: #DD2124;">(Sin promociones ni descuentos)</p>
                            <input type="text" id="txtCostoMensualidad"  placeholder="0.00" class="form-registro-element">


                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">¿Cuántos días a la semana da servicio?</label>

                            <select id="cboDias" class="form-registro-element">
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7" selected>7</option>
                            </select>

                        </div>

                        <div class="col-lg-12">
                            <p style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0; text-align:center;">Estás a punto de formar parte de la red de Centros de Acondicionaminto Físico más grande del país.</p>
                            <p style="font-style: italic; margin-bottom: 0;color: #DD2124;font-family: 'AvenirLTStd-Black'; text-align:center;">¡Completa tu registro y aumenta tus ganancias!</p>
                        </div>

                    </div>
                    <div class="col-lg-4">
                        <div class="col-lg-12">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">Costo de visita</label>
                            <input type="text" id="txtCosto"  placeholder="0.00" class="form-registro-element" disabled="disabled">
                        </div>
                        <div class="col-lg-12">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">Visita + I.V.A.</label>
                            <input type="text" id="txtCostoIva"  placeholder="0.00" class="form-registro-element" disabled="disabled">
                        </div>
                        <div class="col-lg-12">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">Comisión por transacción</label>
                            <input type="text" id="txtCostoTransaccion"  placeholder="0.00" class="form-registro-element" disabled="disabled">
                        </div>
                        <div class="col-lg-12">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">Ganancia REAL por visita</label>
                            <input type="text" id="txtGanancia"  placeholder="0.00" class="form-registro-element" disabled="disabled">
                        </div>
                        <div class="col-lg-6">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">90%</label>
                            <input type="text" id="txtGananciaGym"  placeholder="0.00" class="form-registro-element" disabled="disabled">
                        </div>
                        <div class="col-lg-6">
                            <label style="color: #1d4289;font-size: 14px;font-family: 'AvenirLTStd-Black';margin-bottom: 0;">10%</label>
                            <input type="text" id="txtGananciaLiberi"  placeholder="0.00" class="form-registro-element" disabled="disabled">
                        </div>
                    </div>



                </div>
                <div class="row">
                    <div class="col-lg-12" style="background: #fff;">
                        <input id="calculadoraCond" class="require" name="calculadora" type="checkbox" required="required"> <label for="calculadoraCond" class="form-label-servicios">Acepto el cálculo de costo por visita</label>
                    </div>
                </div>
                </form>
            </div>
            <div class="modal-footer" style="background:#DFE0E4;">

                <button type="button" class="btn btn-secondary" style="background:#FFD916;" id="btnAceptarCalculo">Continuar Registro</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
<script type="text/javascript" src="js/jquery.timepicker.js"></script>
<script src="/admin_assets/plugins/dropzone/dropzone.js"></script>
<script src="/admin_assets/plugins/dropzone/uploader.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_maps.key') }}"></script>

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

    //iniciamos la modal de costo de VISITA
    $('#mdlCalculadora').modal({backdrop: 'static', keyboard: false});

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

    //funciones calculadora
    $('#cboDias').on('change',function () {//input[name=daysOpen]
        calcularVisita();
    });
    $( "#txtCostoMensualidad" ).keyup(function() {
        calcularVisita();
    });

    function calcularVisita(){
        var _diasOperaSemana = $("#cboDias").val();
        var _semanasAnho = 52;
        var _diasOperaMes = (_diasOperaSemana*_semanasAnho)/12;
        var _costoMensualidad = $( "#txtCostoMensualidad" ).val();
        var _costoVisita = 0;
        var _costoVisitaIva = 0;
        var _comisionTransaccion = 0;
        var _costoTransaccion = 0;
        var _gananciaBruta = 0;
        var _gananciaGym = 0;
        var _gananciaLiberi = 0;
        /*txtCosto
        txtCostoIva
        txtCostoTransaccion
        txtGanancia
        txtGananciaGym
        txtGananciaLiberi*/
        if(!isNaN(_costoMensualidad)){

            console.log(_diasOperaMes);


            _costoVisita = _costoMensualidad/(_diasOperaMes*.7); //•	COSTO POR VISITA = COSTO MENSUALIDAD/(DIAS QUE LABORA AL MES * .8);
            _costoVisitaIva = (_costoVisita*.16)+_costoVisita;
            _comisionTransaccion = (_costoVisitaIva*.03)+4;
            _costoTransaccion = (_comisionTransaccion*.16)+_comisionTransaccion;
            _gananciaBruta = _costoVisitaIva-_costoTransaccion;
            _gananciaGym = _gananciaBruta*.9;
            _gananciaLiberi = _gananciaBruta*.1;

            $( "#txtCosto" ).val(number_format(_costoVisita,2));
            $( "#txtCostoIva" ).val(number_format(_costoVisitaIva,2));
            $( "#txtCostoTransaccion" ).val(number_format(_costoTransaccion,2));
            $( "#txtGanancia" ).val(number_format(_gananciaBruta,2));
            $( "#txtGananciaGym" ).val(number_format(_gananciaGym,2));
            $( "#txtGananciaLiberi" ).val(number_format(_gananciaLiberi,2));
        }else{
            $( "#txtCostoMensualidad" ).val('');
            $( "#txtCosto" ).val('');
            $( "#txtCostoIva" ).val('');
            $( "#txtCostoTransaccion" ).val('');
            $( "#txtGanancia" ).val('');
            $( "#txtGananciaGym" ).val('');
            $( "#txtGananciaLiberi" ).val('');
        }
    }

    $("#btnAceptarCalculo").on('click', function (){
        if($("#calculadoraCond").is(':checked')){

            var _diasOperaSemana = $("#cboDias").val();
            var _costoMensualidad = $( "#txtCostoMensualidad" ).val();

            if(isNaN(_costoMensualidad) || _costoMensualidad == "" || _costoMensualidad<=0){
                swal('Cuidado','Por favor ingrese una cantidad en el Costo de Mensualidad','warning');
            }else{
                $("#diasoperasemana").val(_diasOperaSemana);
                $("#gym_monthly_fee").val(_costoMensualidad);
                $('#mdlCalculadora').modal('hide');
            }
        }else{
            swal('Cuidado','Debe aceptar el cálculo de costo por visita','warning');
        }
    });

    //FUNCION PARA FORMATEAR A MONEDA
    function number_format(value, decimals, separators) {
        decimals = decimals >= 0 ? parseInt(decimals, 0) : 2;
        separators = separators || [',', "'", '.'];
        var number = (parseFloat(value) || 0).toFixed(decimals);
        if (number.length <= (4 + decimals))
            return number.replace('.', separators[separators.length - 1]);
        var parts = number.split(/[-.]/);
        value = parts[parts.length > 1 ? parts.length - 2 : 0];
        var result = value.substr(value.length - 3, 3) + (parts.length > 1 ?
            separators[separators.length - 1] + parts[parts.length - 1] : '');
        var start = value.length - 6;
        var idx = 0;
        while (start > -3) {
            result = (start > 0 ? value.substr(start, 3) : value.substr(0, 3 + start))
                + separators[idx] + result;
            idx = (++idx) % 2;
            start -= 3;
        }
        return (parts.length == 3 ? '-' : '') + result;
    }

    cityEdit.init();

});

var cityEdit = {
    id: 0,
    form: null,
    lat: 0,
    lng: 0,
    init: function(){

        gmap();

    },
    updateLocation: function(lat, lng){
        this.lat = lat;
        this.lng = lng;
        $('#txtLat').val(this.lat);
        $('#txtLng').val(this.lng);



    }
};


var gmap = function() {
    "use strict";
    var mapDefault;
    var marker;

    function initialize() {

        var geocoder = new google.maps.Geocoder();
        var address = $('#gym_city').val()+", "+$('#gym_state').val();
        var latAddres = cityEdit.lat;
        var lngAddres = cityEdit.lng;
        var positionGym = 0;



        var mapOptions = {
            zoom: 13,
            center: new google.maps.LatLng(latAddres, lngAddres),
            mapTypeId: google.maps.MapTypeId.ROADMAP,
            //disableDefaultUI: true,
        };

        mapDefault = new google.maps.Map(document.getElementById('map'), mapOptions);

        geocoder.geocode({'address': address}, function(results, status) {
            if (status === 'OK') {
                latAddres=results[0].geometry.location.lat;
                lngAddres=results[0].geometry.location.lng;
                console.log(results[0].geometry.location.lat);
                cityEdit.updateLocation(latAddres, lngAddres);
                positionGym = results[0].geometry.location
            mapDefault.setCenter(positionGym);

            var icon = new google.maps.MarkerImage("/images/marker.png", null, null, null, new google.maps.Size(24, 50));


            marker = new google.maps.Marker({
                //position: {lat: parseFloat(cityEdit.lat), lng: parseFloat(cityEdit.lng)},
                position: positionGym,
                title: 'Ubicación', icon: icon, draggable: true
            });

            google.maps.event.addListener(marker, 'dragend', function (event) {
                var markerLat = this.position.lat();
                var markerLng = this.position.lng();
                cityEdit.updateLocation(markerLat, markerLng);
            });
            marker.setMap(mapDefault);

          } else {
            console.log('Geocode was not successful for the following reason: ' + status);
          }
        });


        /*var icon = new google.maps.MarkerImage("/images/marker.png", null, null, null, new google.maps.Size(50, 50));


        marker = new google.maps.Marker({
            position: {lat: parseFloat(cityEdit.lat), lng: parseFloat(cityEdit.lng)},
            title: 'Ubicación', icon: icon, draggable: true
        });*/
        /*google.maps.event.addListener(marker, 'dragend', function (event) {
            var markerLat = this.position.lat();
            var markerLng = this.position.lng();
            cityEdit.updateLocation(markerLat, markerLng);
        });*/

        //marker.setMap(mapDefault);
    }
    google.maps.event.addDomListener(window, 'load', initialize);

    $(window).resize(function() {
        google.maps.event.trigger(mapDefault, "resize");
        mapDefault.setCenter(marker.getPosition());
    });



};

</script>

@endsection
