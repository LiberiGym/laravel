<?php
    $plugins = ['datetimepicker', 'tagit', 'ckeditor', 'uploader'];
    $css = [];
    $js = ['categories/edit'];
?>

@extends('admin.layout.default')
@section('content')

<div class="row">
    <div class="col-md-12 p-0">
        <div class="actionButtons pull-left">
            <a href="{{ $base }}" class="btn btn-sm btn-default pull-left">
                <i class="fa fa-chevron-left"></i> Regresar
            </a>
            <a href="#" data-target="btnSubmit" class="btn btn-sm btn-primary pull-left m-l-10 trigger">
                <i class="fa fa-check m-r-5"></i> Guardar
            </a>
        </div>
        <ol class="breadcrumb pull-right hidden-phone">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{ $base }}">Categorias</a></li>
            <li class="active">{{ $category->title }}</li>
        </ol>
    </div>
</div>

<form novalidate="" class="form-horizontal form-bordered" data-parsley-validate="true"
    name="editForm" id="editForm" method="post" action="edit/{{ $category->id }}/{{ $category->title }}">

    <div class="row panels">
        <div class="col-md-7 m-t-10">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Editar</h4>
                </div>
                <div class="panel-body">
                    <button type="submit" id="btnSubmit" class="btn btn-primary hidden">Save</button>
                    <input type="hidden" name="id" value="{{ $category->id }}" />
                    <input type="hidden" name="status" id="status" value="{{ $category->status }}" />
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3">Estatus:</label>
                        <div class="col-md-6 col-sm-6">
                            <div class="btn-group btn-group-justified statusButtons" data-target="status">
                                <a class="btn btn-success" rel="Activo"><i class="fa fa-check m-r-10"></i> Activo</a>
                                <a class="btn btn-default" rel="Inactivo"><i class="fa fa-check m-r-10"></i> Inactivo</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Programar:</label>
                        <div class="col-md-6 col-sm-6">
                            <input type="checkbox" name="programmed" id="programmed" <?= ($category->programmed) ? "checked" : "" ?> />
                            <label for="programmed">Publicación programada</label>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Publicación:</label>
                        <div class="col-md-6">
                            <div class="input-group date">
                                <input type="text" name="publish_date" id="publish_date" class="form-control" value="{{ $category->publish_date }}" />
                                <label class="input-group-addon" for="publish_date">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </label>
                            </div>
                            <div class="input-goup m-t-10">
                                <span class="label {{ $category->publish_status }}">{{ $category->publish_status }}</span>
                                @if($category->publish_status == 'Pendiente')
                                    <div class="alert alert-warning fade in m-t-10 p-10">
        								Llene el resumen y artículo para publicar.
        								<span class="close" data-dismiss="alert">&times;</span>
        							</div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3">Título:</label>
                        <div class="col-md-9">
                            <input class="form-control" name="title" placeholder="Title" value="{{ $category->title }}"
                                   data-type="alphanum" data-parsley-required="true" type="text" maxlength="50" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Portada:</label>
                        <div class="col-md-9">
                            <div class="photo article" id="image" style="background-image: url({{ $category->image }});"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Etiquetas:</label>
                        <div class="col-md-9">
                            <input type="hidden" id="tags" name="tags" placeholder="" value="<?= $category->tags ?>" />
                            <small>Escriba una etiqueta y presione <strong>Enter</strong></small>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3">Resumen:</label>
                        <div class="col-md-9">
                            <textarea name="overview" class="form-control">{{ $category->overview }}</textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-5 m-t-10">
            <div class="panel panel-inverse">
                <div class="panel-heading">
                    <div class="panel-heading-btn">
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                        <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                    </div>
                    <h4 class="panel-title">Artículo</h4>
                </div>
                <div class="panel-body panel-form">
                    <textarea class="ckeditor" name="article" id="article">{{ $category->article }}</textarea>
                </div>
            </div>
        </div>
    </div>

</form>

@endsection
