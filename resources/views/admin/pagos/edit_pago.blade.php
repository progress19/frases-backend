@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-credit-card"></i> Pagos<small> / Editar Pago #{{ $pago->id }}</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_pago',
                    'name' => 'edit_pago',
                    'url' => '/admin/edit-pago/'.$pago->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-6">
                    <div class="form-group">
                        {!! Form::label('cliente_id', 'Cliente') !!}
                        {!! Form::select('cliente_id', $clientes->pluck('nombre', 'id'), $pago->cliente_id, [
                            'id' => 'cliente_id', 
                            'class' => 'form-control',
                            'placeholder' => 'Seleccione un cliente'
                        ]) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('monto', 'Monto') !!}
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            {!! Form::number('monto', $pago->monto, [
                                'id' => 'monto', 
                                'class' => 'form-control', 
                                'step' => '0.01', 
                                'min' => '0'
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
                        ], $pago->metodo_pago, ['id' => 'metodo_pago', 'class' => 'form-control', 'placeholder' => 'Seleccione un método de pago']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('referencia', 'Referencia') !!}
                        {!! Form::text('referencia', $pago->referencia, ['id' => 'referencia', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('comentarios', 'Comentarios') !!}
                        {!! Form::textarea('comentarios', $pago->comentarios, ['id' => 'comentarios', 'class' => 'form-control', 'rows' => 3]) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Actualizar</button>
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
            // Form validation
            $("#edit_pago").validate({
                rules: {
                    cliente_id: "required",
                    monto: {
                        required: true,
                        number: true,
                        min: 0.01
                    },
                    metodo_pago: "required"
                },
                messages: {
                    cliente_id: "Por favor seleccione un cliente",
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