@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-6">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa-solid fa-cogs"></i> tipos<small> / Editar</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_tipo',
                    'name' => 'edit_tipo',
                    'url' => '/admin/edit-tipo/' . $tipo->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}


                <div class="col-md-7">
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre') !!}
                        {!! Form::text('nombre', null, ['id' => 'nombre', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"
                            aria-hidden="true"></i> Guardar</button>
                </div>

            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('page-js-script')

@stop
