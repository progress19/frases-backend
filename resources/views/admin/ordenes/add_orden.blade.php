@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-file-text-o"></i> Órdenes<small> / Nueva Orden</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'add_orden',
                    'name' => 'add_orden',
                    'url' => '/admin/add-orden',
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('cliente_id', 'Cliente') !!}
                        {!! Form::select('cliente_id', $clientes, null, [
                            'id' => 'cliente_id',
                            'class' => 'form-control select2',
                            'placeholder' => 'Seleccione cliente...',
                            'data-toggle' => 'tooltip',
                            'title' => 'Seleccione Cliente'
                        ]) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('fecha', 'Fecha') !!}
                        <div class="input-group date">
                            {!! Form::text('fecha', date('d/m/Y'), [
                                'id' => 'fecha', 
                                'class' => 'form-control datepickers', 
                                'placeholder' => 'dd/mm/aaaa',
                                'readonly' => 'readonly'
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('asunto', 'Asunto') !!}
                        {!! Form::text('asunto', null, ['id' => 'asunto', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('descripcion', 'Descripción') !!}
                        {!! Form::textarea('descripcion', null, ['id' => 'descripcion', 'class' => 'form-control', 'rows' => 4]) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('importe', 'Importe ($)') !!}
                        {!! Form::number('importe', 0, ['id' => 'importe', 'class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('estado_pago', 'Estado de pago') !!}
                        {!! Form::select('estado_pago', ['Pendiente' => 'Pendiente', 'Pagado' => 'Pagado'], 'Pendiente', ['id' => 'estado_pago', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('estado_orden', 'Estado de la orden') !!}
                        {!! Form::select('estado_orden', [
                            'Pendiente' => 'Pendiente', 
                            'En progreso' => 'En progreso', 
                            'Completada' => 'Completada', 
                            'Cancelada' => 'Cancelada'
                        ], 'Pendiente', ['id' => 'estado_orden', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('tipo_trabajo', 'Tipo de trabajo') !!}
                        {!! Form::select('tipo_trabajo', [
                            'Desarrollo' => 'Desarrollo', 
                            'Soporte técnico' => 'Soporte técnico',
                            'Hosting' => 'Hosting'
                        ], null, ['id' => 'tipo_trabajo', 'class' => 'form-control']) !!}
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
    <!-- Incluir TinyMCE desde CDN -->
    <script src="https://cdn.tiny.cloud/1/u2ahwwjoqyrt21r4yawptscosrvgucfxlzxld2616d8r0ud2/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    
    <script>
        $(document).ready(function() {
            $('.select2').select2();
            document.getElementById("cliente_id").focus();
            
            // Inicializar TinyMCE en modo oscuro
            tinymce.init({
                selector: '#descripcion',
                plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
                toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
                skin: 'oxide-dark',
                content_css: 'dark',
                height: 300
            });

            // Inicializar bootstrap-datepicker
            $('.datepickers').datepicker({
                format: 'dd/mm/yyyy',
                autoclose: true,
                todayHighlight: true,
                language: 'es' 
            });
        });
    </script>
@stop