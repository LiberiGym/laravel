<?php
    $plugins = ['datatable'];
    $css = [];
    $js = ['categories/list'];
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
            <li><a href="{{ $base }}">Categorias</a></li>
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
                <table id="table_categories" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th width="30">ID</th>
                            <th width="200">Título</th>
                            <th width="80">Status</th>
                            <th width="60">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($categories as $category)
                        <tr>
                            <td>
                                {{ $category->id }}
                            </td>
                            <td class="f-w-600 f-s-14">
                                <a href="edit/{{ $category->id }}/{{ $category->title }}">
                                    {{  $category->title }}
                                </a>
                            </td>
                            <td>
                                <span class="label {{ $category->status }}">{{ $category->status }}</span>
                            </td>
                            <td>
                                <a href="edit/{{ $category->id }}/{{ $category->title }}" class="btn btn-success btn-icon btn-circle btn-sm">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="delete/{{ $category->id }}" class="btn btn-danger btn-icon btn-circle btn-sm btnDelete">
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
