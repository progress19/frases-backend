@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-6">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-list"></i> Tipos<small> / Nuevo</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'add_tipo',
                    'name' => 'add_tipo',
                    'url' => '/admin/add-tipo',
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
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@section('page-js-script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("titulo_es").focus();
        });
    </script>
@stop
