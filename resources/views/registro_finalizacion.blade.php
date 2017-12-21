@extends('layout.layout')
@section('css')
<link href="css/registro.steps.css" type="text/css" rel="stylesheet">
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
                            <button type="button" class="btn btn-disabled btn-circle"  disabled="disabled">1</button>
                            <p class="title">Registro</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle"  disabled="disabled">2</button>
                            <p class="title">Datos Fiscales</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-disabled btn-circle" disabled="disabled">3</button>
                            <p class="title">Datos Bancarios</p>
                            <hr/>
                        </div>
                        <div class="stepwizard-step">
                            <button type="button" class="btn btn-selected btn-circle">4</button>
                            <p class="title-selected">Finalización de Registro</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="w3agile-about w3agile-about-detail">

            <div class="col-lg-12 text-center">
                <h1 class="form-registro-final" style="margin-bottom:20px;">Registro Exitoso</h1>
                <p>¡Ya eres parte de la mejor red<br>de gimnasios, <span class="brand-text">LIBERI</span>!</p>
                <img src="images/registro_button_finalizar.png" alt="" style="width:173px; margin-bottom:40px;">
                <p>Un representante de LIBERI te visitará en un lapso<br>de 15 días hábiles para firmar tu contrato.</p>
                <a href="/perfil-gym"><button type="button" name="button" class="form-button-finalizar">Ir a mi Perfil</button></a>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<!-- //about -->
@endsection
@section('js')

@endsection
