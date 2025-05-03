@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-credit-card"></i> Pagos <small>/ Pagos del Cliente: {{ $cliente->nombre }}</small></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                @if (Session::has('success_message'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <strong>{{ Session::get('success_message') }}</strong>
                    </div>
                @endif
                @if (Session::has('error_message'))
                    <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span
                                aria-hidden="true">×</span>
                        </button>
                        <strong>{{ Session::get('error_message') }}</strong>
                    </div>
                @endif

                <div class="alert alert-info">
                    <strong>Cliente:</strong> {{ $cliente->nombre }} <br>
                    <strong>Email:</strong> {{ $cliente->email }} <br>
                    <strong>CUIT:</strong> {{ $cliente->cuit }} <br>
                    <strong>Domicilio:</strong> {{ $cliente->domicilio }}
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Orden</th>
                                    <th>Monto</th>
                                    <th>Método de Pago</th>
                                    <th>Referencia</th>
                                    <th>Fecha</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @php 
                                    $totalPagado = 0;
                                @endphp
                                @foreach($pagos as $pago)
                                    @php 
                                        $totalPagado += $pago->monto;
                                    @endphp
                                    <tr>
                                        <td>{{ $pago->id }}</td>
                                        <td><a href="{{ url('/admin/pagos-by-orden/' . $pago->orden_id) }}">Orden #{{ $pago->orden_id }}</a></td>
                                        <td>${{ number_format($pago->monto, 2) }}</td>
                                        <td>{{ $pago->metodo_pago }}</td>
                                        <td>{{ $pago->referencia }}</td>
                                        <td>{{ $pago->created_at }}</td>
                                        <td>
                                            <a href="{{ url('/admin/edit-pago/' . $pago->id) }}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Editar</a> 
                                            <a id="deleteButton" rel="{{ $pago->id }}" rel1="delete-pago" href="javascript:" class="btn btn-xs btn-danger deleteButton"><i class="fa fa-trash"></i> Eliminar</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th colspan="2" style="text-align:right">Total Pagado:</th>
                                    <th>${{ number_format($totalPagado, 2) }}</th>
                                    <th colspan="4"></th>
                                </tr>
                            </tfoot>
                        </table>

                        <div class="form-group">
                            <a href="{{ url('/admin/view-clientes') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Volver a Clientes</a>
                            <a href="{{ url('/admin/add-pago') }}" class="btn btn-primary pull-right"><i class="fa fa-plus"></i> Nuevo Pago</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@section('page-js-script')
    <script type="text/javascript">
        $(document).ready(function() {
            // Delete function
            $(document).on('click', '.deleteButton', function() {
                var id = $(this).attr('rel');
                var deleteFunction = $(this).attr('rel1');
                swal({
                        title: "¿Estás seguro?",
                        text: "¡No podrás recuperar este registro!",
                        type: "warning",
                        showCancelButton: true,
                        cancelButtonText: "Cancelar",
                        cancelButtonClass: 'btn-secondary',
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "¡Sí, eliminar!",
                        closeOnConfirm: false,
                        showLoaderOnConfirm: true
                    },
                    function(isConfirm) {
                        if (isConfirm) {
                            window.location.href = baseUrl + "/admin/" + deleteFunction + "/" + id;
                        }
                    });
            });
        });
    </script>
@stop