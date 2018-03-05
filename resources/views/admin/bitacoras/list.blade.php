<?php
    $plugins = ['datatable'];
    $css = [];
    $js = ['bitacoras/list'];
?>

@extends('admin.layout.default')
@section('content')

<div class="row">
    <div class="col-md-12 p-0">
        <div class="actionButtons pull-left">
            <a href="#modalCreate" class="btn btn-sm btn-primary pull-left" data-toggle="modal">
                <i class="fa fa-plus m-r-5"></i> Nuevo
            </a>
        </div>
        <ol class="breadcrumb pull-right hidden-phone">
            <li><a href="/"><i class="fa fa-home"></i> Home</a></li>
            <li><a href="{{ $base }}">Notificaciones Bitacora</a></li>
            <li class="active">Todos los registros</li>
        </ol>
    </div>
</div>

<div class="row">
    <div class="col-md-12 p-0 m-t-10">
        <div class="panel panel-inverse">
            <div class="panel-heading">
                <div class="panel-heading-btn">
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                    <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                </div>
                <h4 class="panel-title">Registros</h4>
            </div>
            <div class="panel-body">
                <table id="table_bitacoras" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30">ID</th>
                            <th width="30">Portada</th>
                            <th width="200">Título</th>
                            <th width="80">Etiquetas</th>
                            <th width="80">Fecha publicación</th>
                            <th width="40">Vistas</th>
                            <th width="60">Creado</th>
                            <th width="80">Status</th>
                            <th width="60">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bitacoras as $bitacora)
                        <tr>
                            <td>
                                {{ $bitacora->id }}
                            </td>
                            <td>
                                <a href="edit/{{ $bitacora->id }}/{{ $bitacora->title }}">
                                    <div class="previewImage" style="background-image: url({{ $bitacora->image }})"></div>
                                </a>
                            </td>
                            <td class="f-w-600 f-s-14">
                                <a href="edit/{{ $bitacora->id }}/{{ $bitacora->title }}">
                                    {{  $bitacora->title }}
                                </a>
                            </td>
                            <td class="text-success f-w-600">
                                {{  $bitacora->tags }}
                            </td>
                            <td class="text-info f-w-600">
                                {{  $bitacora->publish_date }}
                            </td>
                            <td class="text-info f-w-600">
                                {{  $bitacora->views }}
                            </td>
                            <td>
                                por admin
                            <td>
                                <span class="label {{ $bitacora->publish_status }}">{{ $bitacora->publish_status }}</span>
                            </td>
                            <td>
                                <a href="edit/{{ $bitacora->id }}/{{ $bitacora->title }}" class="btn btn-success btn-icon btn-circle btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="delete/{{ $bitacora->id }}" class="btn btn-danger btn-icon btn-circle btn-sm btnDelete">
                                    <i class="fa fa-times"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div style="display: none;" class="modal fade in" id="modalCreate">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title"><i class="fa fa-asterisk"></i> Nuevo</h4>
            </div>
            <div class="modal-body">
                <form novalidate="" class="form-horizontal form-bordered" data-parsley-validate="true" name="new-form" method="post" action="create">
                    <div class="form-group">
                        <label class="control-label col-md-4 col-sm-4">Título:</label>
                        <div class="col-md-6">
                            <input class="form-control" name="title" placeholder="Title"
                                   data-type="alphanum" data-parsley-required="true" type="text" maxlength="50" />
                            <ul class="parsley-errors-list"></ul>
                        </div>
                    </div>
                    <div class="modal-footer m-t-10">
                        <a href="javascript:;" class="btn btn-white" data-dismiss="modal">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
