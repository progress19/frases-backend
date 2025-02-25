@php
    use App\Fun;
    use Carbon\Carbon;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <div class="col-md-12 col-sm-4">
        <div class="x_panel">

            <div class="x_title">
                <h2><i class="fa fa-building"></i> Frase / <small>Editar</small></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_frase',
                    'name' => 'edit_frase',
                    'url' => '/admin/edit-frase/' . $frase->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('frase', 'Frase') !!}
                        {!! Form::textarea('frase', $frase->frase, ['id' => 'frase', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <div class="ln_solid"></div>
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i>
                        Guardar</button>
                </div>

                {!! Form::close() !!}

            </div> <!-- x_content -->

        </div>

    </div>

@endsection

@section('page-js-script')

@stop
