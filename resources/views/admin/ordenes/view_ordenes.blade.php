@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-file-text-o" aria-hidden="true"></i> Órdenes<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{ url('/admin/add-orden') }}">
                        <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nueva orden</button>
                    </a>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Fecha</th>
                            <th>Cliente</th>
                            <th>Asunto</th>
                            <th>Importe</th>
                            <th>Estado pago</th>
                            <th>Estado orden</th>
                            <th>Tipo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="row_position">
                        <!-- Aquí van las filas de la tabla -->
                    </tbody>
                </table>

            </div>
        </div>
    </div>

    <!-- /page content -->

@endsection

@section('page-js-script')
    @if (session('flash_message'))
        <script>
            toast('{!! session('flash_message') !!}');
        </script>
    @endif

    <script>
        $(function() {
            let table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 30,
                ajax: '{!! route('dataOrdenes') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'fecha', name: 'fecha'},
                    {data: 'cliente_id', name: 'cliente_id'},
                    {data: 'asunto', name: 'asunto'},
                    {data: 'importe', name: 'importe'},
                    {data: 'estado_pago', name: 'estado_pago'},
                    {data: 'estado_orden', name: 'estado_orden'},
                    {data: 'tipo_trabajo', name: 'tipo_trabajo'},
                    {data: 'acciones', name: 'acciones', orderable: false, searchable: false},
                ],
                language: {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                order: [[0, 'desc']]
            });
        });
 
        $(document).ready(function() {
            $('#table tbody').on('click', '.delReg', function() {
                if (confirm('¿Está seguro de eliminar la orden?')) {
                    return true;
                }
                return false;
            });
        });
    </script>
@stop