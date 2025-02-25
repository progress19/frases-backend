@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-comments"></i> Frases<small> / Nueva</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'add_frase',
                    'name' => 'add_frase',
                    'url' => '/admin/add-frase',
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('frase', 'Frase') !!}
                            {!! Form::textarea('frase', null, ['id' => 'frase', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                    </div>

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@section('page-js-script')
<script>document.addEventListener("DOMContentLoaded", function() { document.getElementById("frase").focus(); });</script>
@stop
