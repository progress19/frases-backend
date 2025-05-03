@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-credit-card"></i> Pagos <small>/ Lista de pagos</small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{ url('/admin/add-pago') }}" class="btn btn-primary"><i class="fa fa-plus"></i> Nuevo pago</a>
                </ul>
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
                <div class="row">
                    <div class="col-md-12">
                        <table id="listado" class="table table-striped table-bordered dt-responsive nowrap"
                            cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Cliente</th>
                                    <th>Orden</th>
                                    <th>Monto</th>
                                    <th>Método de Pago</th>
                                    <th>Referencia</th>
                                    <th>Fecha</th>
                                    <th></th>
                                </tr>
                            </thead>
                        </table>
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
            
            $('#listado').DataTable({
                "dom": 'Bfrtip',
                "buttons": [
                    'pageLength',
                    {
                        extend: 'collection',
                        text: 'Exportar',
                        buttons: [
                            'copy',
                            'excel',
                            'csv',
                            'pdf',
                            'print',
                        ]
                    }
                ],
                "processing": true,
                "serverSide": true,
                "ajax": "{{ route('dataPagos') }}",
                "columns": [
                    {"data": "id"},
                    {"data": "cliente"},
                    {"data": "orden"},
                    {"data": "monto"},
                    {"data": "metodo_pago"},
                    {"data": "referencia"},
                    {"data": "created_at"},
                    {"data": "action", "orderable": false, "searchable": false}
                ]
            });

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