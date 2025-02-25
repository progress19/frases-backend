@php
use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

<!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
          <div class="x_title">
            <h2><i class="fa fa-language"></i> Traducción<small> / Editar</small></h2>
            <ul class="nav navbar-right panel_toolbox"></ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            {{ Form::open([
              'id' => 'edit_traduccion',
              'name' => 'edit_traduccion',
              'url' => '/admin/edit-traduccion/'.$traduccion->id,
              'role' => 'form',
              'method' => 'post',
              'files' => true]) }}

              <div class="row">

                <div class="col-md-4">
                  <div class="form-group">
                    {!! Form::label('es', 'Español') !!}
                    {!! Form::textarea('es', $traduccion->es, ['id' => 'es', 'class' => 'form-control']) !!}
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    {!! Form::label('en', 'Inglés') !!}
                    {!! Form::textarea('en', $traduccion->en, ['id' => 'en', 'class' => 'form-control']) !!}
                  </div>
                </div>

                <div class="col-md-4">
                  <div class="form-group">
                    {!! Form::label('pr', 'Portugués') !!}
                    {!! Form::textarea('pr', $traduccion->pr, ['id' => 'pr', 'class' => 'form-control']) !!}
                  </div>
                </div>

                <div class="col-md-12"><div class="ln_solid"></div>
                <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                <button id="autocompletar" type="button" class="btn btn-secondary pull-left"><i class="fa fa-magic" aria-hidden="true"></i> Autocompletar</button>
              </div>

            </div>
            {{ Form::hidden('baseUrl', url('/'), ['id' => 'baseUrl']) }}
            {!! Form::close() !!}

          </div>
        </div>
      </div>

<!-- /page content -->

</div>

@endsection

@section('page-js-script')
<script src="{{ asset('js/back_js/autocomplete.js') }}"></script>
<script>document.addEventListener("DOMContentLoaded", function() { document.getElementById("es").focus(); });</script>
@stop

