@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-file-text-o"></i> Órdenes<small> / Editar Orden</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_orden',
                    'name' => 'edit_orden',
                    'url' => '/admin/edit-orden/' . $orden->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('cliente_id', 'Cliente') !!}
                        {!! Form::select('cliente_id', $clientes, $orden->cliente_id, ['id' => 'cliente_id', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('asunto', 'Asunto') !!}
                        {!! Form::text('asunto', $orden->asunto, ['id' => 'asunto', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('descripcion', 'Descripción') !!}
                        {!! Form::textarea('descripcion', $orden->descripcion, ['id' => 'descripcion', 'class' => 'form-control', 'rows' => 4]) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('importe', 'Importe ($)') !!}
                        {!! Form::number('importe', $orden->importe, ['id' => 'importe', 'class' => 'form-control', 'step' => '0.01', 'min' => '0']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('estado_pago', 'Estado de pago') !!}
                        {!! Form::select('estado_pago', ['Pendiente' => 'Pendiente', 'Pagado' => 'Pagado'], $orden->estado_pago, ['id' => 'estado_pago', 'class' => 'form-control']) !!}
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
                        ], $orden->estado_orden, ['id' => 'estado_orden', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-2">
                    <div class="form-group">
                        {!! Form::label('tipo_trabajo', 'Tipo de trabajo') !!}
                        {!! Form::select('tipo_trabajo', [
                            'Desarrollo' => 'Desarrollo', 
                            'Soporte técnico' => 'Soporte técnico',
                            'Hosting' => 'Hosting'
                        ], $orden->tipo_trabajo, ['id' => 'tipo_trabajo', 'class' => 'form-control']) !!}
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
        $(document).ready(function() {
            document.getElementById("cliente_id").focus();
        });
    </script>
@stop