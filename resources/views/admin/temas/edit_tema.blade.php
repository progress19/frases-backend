@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-6">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-tags"></i> Temas<small> / Editar</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_tema',
                    'name' => 'edit_tema',
                    'url' => '/admin/edit-tema/' . $tema->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}


                <div class="col-md-7">
                    <div class="form-group">
                        {!! Form::label('nombre', 'Nombre') !!}
                        {!! Form::text('nombre', $tema->nombre, ['id' => 'nombre', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('descripcion', 'Descripción (opcional)') !!}
                        {!! Form::textarea('descripcion', $tema->descripcion, ['id' => 'descripcion', 'class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button>
                </div>

            </div>

            {!! Form::close() !!}

        </div>
    </div>

@endsection

@section('page-js-script')
    <script>
        $(document).ready(function() {
            $('#edit_tema').validate({
                rules: {
                    nombre: {
                        required: true,
                        minlength: 2
                    }
                },
                messages: {
                    nombre: {
                        required: "El nombre es obligatorio",
                        minlength: "El nombre debe tener al menos 2 caracteres"
                    }
                },
                highlight: function(element) {
                    $(element).closest('.form-group').addClass('has-error');
                },
                unhighlight: function(element) {
                    $(element).closest('.form-group').removeClass('has-error');
                },
                errorElement: 'span',
                errorClass: 'help-block',
                errorPlacement: function(error, element) {
                    if (element.parent('.input-group').length) {
                        error.insertAfter(element.parent());
                    } else {
                        error.insertAfter(element);
                    }
                }
            });
            
            document.getElementById("nombre").focus();
        });
    </script>
@stop