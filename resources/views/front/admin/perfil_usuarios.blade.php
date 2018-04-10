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
                    <li class="active"><a href="/administracion/usuarios">Usuarios <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/ventas">Ventas <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/notificaciones">Notificaciones <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                    <li><a href="/administracion/promociones">Promociones <span><i class="fa fa-angle-right" aria-hidden="true"></i></span></a></li>
                </ul>
                <button type="button" name="button" id="btnCerrarSesion" class="cerrar-session">Cerrar Sesión</button>

            </div>
            <div class="col-lg-9">
                <h1>Registro de usuario <img src="/images/barra_amarilla_banner_top.png" height="6" style="width:79px;"/></h1>
                <p>Alta de usuarios para control interno de aplicación.</p>
                <form class="form-registro" role="form" class="cmxform" method="post" id="frmDatos">
                    <input type="hidden" name="editInfo" id="editInfo" value="0">
                    <input type="hidden" name="user_id" id="user_id" value="">
                    <input type="hidden" name="image" id="image" value="">
                    <fieldset class="col-lg-6">
                        <input type="text" name="user_name" id="user_name"  placeholder="Nombre Completo" class="form-registro-element" required="required" value="">
                        <input type="email" name="user_nick" id="user_nick"  placeholder="Usuario" class="form-registro-element" required="required" value="">
                        <input type="text" name="user_password" id="user_password"  placeholder="Contraseña" class="form-registro-element" required="required">
                        <input type="text" name="user_passwordrepeate" id="user_passwordrepeate"  placeholder="Repertir contrasseña" class="form-registro-element" required="required">
                        <div class="clearfix"></div>

                        <div class="col-lg-5">
                            <div class="photo-usuario" align="center" id="divImgUser">

                            </div>
                            <button type="button" id="btnDeleteImage"  name="button" class="delete-image" style="width: 100%;" disabled="true">Eliminar imágen</button>
                        </div>
                        <div class="col-lg-7">
                            <button type="button" id="divUploadImage"  name="button" class="form-button" style="width: 100%;">Seleccionar imágen</button>
                        </div>

                        <div class="clearfix"></div>

                        <button type="guardar" name="button" id="btnGuardar">Guardar</button>

                        <button type="guardar" name="button" id="btnCancelar" style="background: #c81327; color:#fff; margin-right:10px;">Cancelar</button>

                    </fieldset>

                    <fieldset class="col-lg-6">

                        <table id="table_usuarios" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th width="200">Usuario</th>
                                    <th width="80">Status</th>
                                    <th width="60">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>

                                    <td class="f-w-600 f-s-14">
                                        {{  $user->name }}
                                    </td>
                                    <td>
                                        {{ $user->status }}
                                    </td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-icon btn-sm btnDelete btn-delete" data-id="{{  $user->id }}" style="width: 33px;background: #c81327; color:#fff;"><i class="fa fa-times"></i></button>
                                        <button type="button" class="btn btn-success btn-icon btn-sm btn-editar" data-id="{{  $user->id }}" style="width: 33px;background: #fdb429; margin-right:10px;"><i class="fa fa-edit"></i></button>
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

    //subir imagen usuario
    uploader.add('divUploadImage', {
        url: '/perfil/usuario/upload/image',
        formData: {
            type: 'images'
        }
        },
        function(data){
            if(data.result == 'ok'){
                var addImage ='<div style="margin-top:5px; background:url(/files/users/'+data.file+'); width: 129px; height:100px; background-size:cover;"><div>';
                $('#divImgUser').html(addImage);
                $('#image').val(data.file);

                $("#btnDeleteImage").prop('disabled',false);

            }
            if(data.result =='error_type'){
                swal('Cuidado','Solo puede subir imagenes en formato de tiff y jpg','warning');
            }
    });

    $("#btnDeleteImage").on('click', function (){
        swal({
            title: 'Eliminar Imagen',
            text: "¿Deseas eliminar la imagen?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {

                    var addImage ='<div style="margin-top:5px; background:url(/images/perfil_user_photo_default.png); width: 129px; height:100px; background-size:cover;"><div>';
                    $('#divImgUser').html(addImage);

                    $('#image').val('');

                    $("#btnDeleteImage").prop('disabled',true);
                }
            });
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

            if($("#user_password").val()!=$("#user_passwordrepeate").val()){
                swal("Atención", "Las constraseñas no coinciden, vuelva a escribirlas", "warning");
            }else{
                var formData= {
                    editInfo:$('#editInfo').val(),
                    user_id:$('#user_id').val(),
                    user_name:$('#user_name').val(),
                    user_nick:$('#user_nick').val(),
                    image:$('#image').val(),
                    password:$('#user_password').val()
                };

                $.ajax({
                    url: "/administracion/usuario/create",
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

        }
    });

    //
    $(".btn-editar").on('click', function (){
        var liItem = $(this);

        var idItem = liItem.data('id');
        usuarioEditar(idItem);
    });
    $(".btn-delete").on('click', function (){
        var liItem = $(this);

        var idItem = liItem.data('id');
        usuarioEliminar(idItem);
    });

    function usuarioEditar(user_id){
        console.log('Editar: '+user_id);

        swal({
            title: "Cargando Información",
            text: "Espera mientras se carga la información del usuario",
            type: "info",
            showCancelButton: false,
            cancelButtonText: "",
            showConfirmButton: false,
            confirmButtonText: "",
        },
            function(){
        });

        var formData= {
            user_id:user_id
        };

        $.ajax({
            url: "/administracion/usuario/select",
            data: formData,
            type: "POST",
            beforeSend:function(){
                //cart.loading.fadeIn();
            },
            success: function (response) {
                if(response.result=="ok"){

                    swal.close();

                    $("#editInfo").val(1);
                    $("#user_id").val(response.usuario.id);
                    $("#user_name").val(response.usuario.name);
                    $("#user_nick").val(response.usuario.email);

                    $('#user_password').prop('required',false);
                    $("#user_passwordrepeate").prop('required',false);
                    $("#user_nick").prop('disabled',true);

                    if(response.usuario.image!=''){
                        $("#image").val(response.usuario.image);
                        var addImage ='<div style="margin-top:5px; background:url('+response.usuario.image+'); width: 129px; height:100px; background-size:cover;"><div>';
                        $('#divImgUser').html(addImage);
                        $("#btnDeleteImage").prop('disabled',false);
                    }


                }else{
                    swal("Atención", response.msj, "warning");
                }
            },


        });
    }

    function usuarioEliminar(user_id){
        swal({
            title: 'Eliminar Usuario',
            text: "¿Deseas eliminar el usuario?",
            type: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    var formData= {
                        user_id:user_id
                    };

                    $.ajax({
                        url: "/administracion/usuario/delete",
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
        $('#user_id').val('');
        $('#user_name').val('');
        $('#user_nick').val('');
        $('#image').val('');
        $('#user_password').val('');
        $("#user_passwordrepeate").val('');

        $('#user_password').prop('required',true);
        $("#user_passwordrepeate").prop('required',true);
        $("#user_nick").prop('disabled',false);

        var addImage ='<div style="margin-top:5px; background:url(/images/perfil_user_photo_default.png); width: 129px; height:100px; background-size:cover;"><div>';
        $('#divImgUser').html(addImage);
    }

});

</script>
@endsection
