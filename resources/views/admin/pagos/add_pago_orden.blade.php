@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-credit-card"></i> Pagos<small> / Nuevo Pago para Orden #{{ $orden->id }}</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                <div class="alert alert-info">
                    <strong>Cliente:</strong> {{ $cliente->nombre }} <br>
                    <strong>Orden:</strong> {{ $orden->asunto }} <br>
                    <strong>Importe Total:</strong> ${{ number_format($orden->importe, 2) }} <br>
                    <strong>Estado de Pago:</strong> {{ $orden->estado_pago }}
                </div>

                {{ Form::open([
                    'id' => 'add_pago_orden',
                    'name' => 'add_pago_orden',
                    'url' => '/admin/add-pago',
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                {!! Form::hidden('orden_id', $orden->id) !!}
                {!! Form::hidden('cliente_id', $cliente->id) !!}

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('monto', 'Monto') !!}
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!! Form::number('monto', null, [
                                'id' => 'monto', 
                                'class' => 'form-control', 
                                'step' => '0.01', 
                                'min' => '0',
                                'max' => $orden->importe
                            ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('metodo_pago', 'Método de Pago') !!}
                        {!! Form::select('metodo_pago', [
                            'Efectivo' => 'Efectivo', 
                            'Transferencia' => 'Transferencia', 
                            'Tarjeta de Crédito' => 'Tarjeta de Crédito', 
                            'Tarjeta de Débito' => 'Tarjeta de Débito',
                            'Cheque' => 'Cheque',
                            'Otro' => 'Otro'
                        ], null, ['id' => 'metodo_pago', 'class' => 'form-control', 'placeholder' => 'Seleccione un método de pago']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('referencia', 'Referencia') !!}
                        {!! Form::text('referencia', null, ['id' => 'referencia', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('comentarios', 'Comentarios') !!}
                        {!! Form::textarea('comentarios', null, ['id' => 'comentarios', 'class' => 'form-control', 'rows' => 3]) !!}
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
            // Focus on first field
            document.getElementById("monto").focus();

            // Form validation
            $("#add_pago_orden").validate({
                rules: {
                    monto: {
                        required: true,
                        number: true,
                        min: 0.01
                    },
                    metodo_pago: "required"
                },
                messages: {
                    monto: {
                        required: "Por favor ingrese el monto",
                        number: "Por favor ingrese un número válido",
                        min: "El monto debe ser mayor a cero"
                    },
                    metodo_pago: "Por favor seleccione un método de pago"
                },
                errorElement: "em",
                errorPlacement: function(error, element) {
                    // Add the `invalid-feedback` class to the error element
                    error.addClass("invalid-feedback");
                    if (element.prop("type") === "checkbox") {
                        error.insertAfter(element.next("label"));
                    } else {
                        error.insertAfter(element);
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-invalid").removeClass("is-valid");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).addClass("is-valid").removeClass("is-invalid");
                },
                submitHandler: function(form) {
                    form.submit();
                }
            });
        });
    </script>
@stop