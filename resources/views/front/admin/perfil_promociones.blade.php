@extends('front.layout.layout_registro')
@section('css')
<link href="/css/registro.steps.css" type="text/css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/jquery.timepicker.css" />

<link href="/admin_assets/plugins/dropzone/dropzone.css" rel="stylesheet" />
<link href="/admin_assets/css/base/theme/custom.css" rel="stylesheet" id="theme" />

<link href="/css/perfil.css" rel="stylesheet" id="theme" />

<link href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet" id="theme" />




@endsection
@section('content')

<!-- about -->
<div class="jarallax agileits-registro agile-section-about-detail" id="aboutUs">
    <div class="container">

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-3">
                <div class="logo-perfil" align="center">
                    <img src="/images/logo_admin_perfil.png" alt="" style="width:100%; text-aling:center;">
                </div>
                <hr class="hr-nav-perfil">
                <ul class="nav-perfil">
                    <li><a href="/administracion">Gimnasios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/usuarios">Usuarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/ventas">Ventas <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/notificaciones">Notificaciones <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li class="active"><a href="/administracion/promociones">Promociones <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                </ul>
                <button type="button" name="button" id="btnCerrarSesion" class="cerrar-session">Cerrar Sesión</button>

            </div>
            <div class="col-lg-9">
                <h1 style="margin-bottom:25px;">Promociones<img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <form class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="editInfo" id="editInfo" value="0">
                    <input type="hidden" name="promo_id" id="promo_id" value="">
                    <fieldset class="col-lg-4">
                        <label for="">Nombre de la Pomoción</label>
                        <input type="text" name="nombre_promocion" id="nombre_promocion"  placeholder="Nombre de la Pomoción" class="form-registro-element" required="required">

                        <label for="">Vigencia de la Pomoción</label>
                        <input type="date" name="vigencia" id="vigencia" class="form-registro-element" required="required" >

                        <label for="">Pomoción en Porcentaje o Especie</label>
                        <select name="tipo" id="tipo" class="form-registro-element" required="required" >
                            <option value="1">Especie</option>
                            <option value="2">Porcentaje</option>
                        </select>

                        <label for="">Monto Promoción</label>
                        <input type="text" name="monto" id="monto"  placeholder="Monto" class="form-registro-element" required="required">

                        <label for="">Límite de la Promoción</label>
                        <select name="limite" id="limite" class="form-registro-element" required="required" >
                            <option value="0">Sin Límite</option>
                            <option value="1">Con Límite</option>
                        </select>

                        <label for="">Cantidad Límite</label>
                        <input type="text" name="cantidad" id="cantidad"  placeholder="Cantidad Límite" class="form-registro-element" required="required">

                        <label for="">Por Usuario</label>
                        <select name="por_usuario" id="por_usuario" class="form-registro-element" required="required" >
                            <option value="0">General</option>
                            <option value="1">Por Usuario</option>
                        </select>

                        <div class="clearfix"></div>


                        <button type="guardar" name="button" id="btnGuardar">Guardar</button>

                        <button type="guardar" name="button" id="btnCancelar" style="background: #c81327; color:#fff; margin-right:10px;">Cancelar</button>

                    </fieldset>

                    <fieldset class="col-lg-8">

                        <table id="table_usuarios" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="200">Promoción</th>
                                    <th width="80">Vigencia</th>
                                    <th width="80">Monto</th>
                                    <th width="60">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($promociones as $promocion)
                                <tr>
                                    <td class="f-w-600 f-s-14">
                                        {{$promocion->nombre_promocion}}
                                    </td>
                                    <td>
                                        {{$promocion->vigencia}}
                                    </td>
                                    <td>
                                        {{$promocion->monto}}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-icon btn-sm btnDelete btn-delete" data-id="{{  $promocion->id }}" style="width: 33px;background: #c81327; color:#fff;"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-success btn-icon btn-sm btn-editar" data-id="{{  $promocion->id }}" style="width: 33px;background: #fdb429; margin-right:10px;"><i class="fa fa-edit"></i></button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

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
<script type="text/javascript" src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script src="/admin_assets/plugins/dropzone/dropzone.js"></script>
<script src="/admin_assets/plugins/dropzone/uploader.js"></script>
<script src="/assets/js/perfil_gym.js"></script>

<script>
$(document).ready(function () {

    formReset();

    $('#table_usuarios').DataTable({
            "bLengthChange": false,
            "iDisplayLength": 10,
            "aaSorting": [
                [0,'ASC']
            ],
        });



    $("#btnCancelar").on('click', function (){
        swal({
            title: 'Cancelar Edición',
            text: "¿Deseas cancelar la edición?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {

                    formReset();
                }
            });
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

            var formData= {
                editInfo:$('#editInfo').val(),
                promo_id:$('#promo_id').val(),
                nombre_promocion:$('#nombre_promocion').val(),
                vigencia:$('#vigencia').val(),
                tipo:$('#tipo').val(),
                monto:$('#monto').val(),
                limite:$('#limite').val(),
                cantidad:$('#cantidad').val(),
                por_usuario:$('#por_usuario').val()
            };

            $.ajax({
                url: "/administracion/promociones/create",
                data: formData,
                type: "POST",
                beforeSend:function(){
                    //cart.loading.fadeIn();
                },
                success: function (response) {
                    if(response.result=="ok"){
                        formReset();
                        location.reload();
                    }else{
                        swal("Atención", response.msj, "warning");
                    }
                },
            });

        }
    });

    //
    $(".btn-editar").on('click', function (){
        var liItem = $(this);

        var idItem = liItem.data('id');
        promocionEditar(idItem);
    });
    $(".btn-delete").on('click', function (){
        var liItem = $(this);

        var idItem = liItem.data('id');
        promocionEliminar(idItem);
    });


//
    function promocionEditar(promo_id){
        console.log('Editar: '+promo_id);

        swal({
            title: "Cargando Información",
            text: "Espera mientras se carga la información de la promoción",
            type: "info",
            showCancelButton: false,
            cancelButtonText: "",
            showConfirmButton: false,
            confirmButtonText: "",
        },
            function(){
        });

        var formData= {
            promo_id:promo_id
        };

        $.ajax({
            url: "/administracion/promociones/select",
            data: formData,
            type: "POST",
            beforeSend:function(){
                //cart.loading.fadeIn();
            },
            success: function (response) {
                if(response.result=="ok"){

                    swal.close();

                    $('#editInfo').val(1);
                    $('#promo_id').val(response.promo.id);
                    $('#nombre_promocion').val(response.promo.nombre_promocion);
                    $('#vigencia').val(response.promo.vigencia);
                    $('#tipo').val(response.promo.tipo);
                    $('#monto').val(response.promo.monto);
                    $('#limite').val(response.promo.limite);
                    $('#cantidad').val(response.promo.cantidad);
                    $('#por_usuario').val(response.promo.por_usuario);

                }else{
                    swal("Atención", response.msj, "warning");
                }
            },


        });
    }

    function promocionEliminar(promo_id){
        swal({
            title: 'Eliminar Promoción',
            text: "¿Deseas eliminar la promoción?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var formData= {
                        promo_id:promo_id
                    };

                    $.ajax({
                        url: "/administracion/promociones/delete",
                        data: formData,
                        type: "POST",
                        beforeSend:function(){
                            //cart.loading.fadeIn();
                        },
                        success: function (response) {
                            if(response.result=="ok"){
                                formReset();
                                location.reload();
                            }else{
                                swal("Atención", response.msj, "warning");
                            }
                        },


                    });
                }
            });
    }

    function formReset(){
        $('#editInfo').val(0);
        $('#promo_id').val('');
        $('#nombre_promocion').val('');
        $('#vigencia').val('');
        $('#monto').val('');
        $('#cantidad').val('');
    }

});

</script>
@endsection
