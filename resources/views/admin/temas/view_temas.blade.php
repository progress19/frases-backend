@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-10">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-tags" aria-hidden="true"></i> Temas<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{ url('/admin/add-tema') }}">
                        <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo tema</button>
                    </a>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Nombre</th>
                            <th>Estado</th>
                            <th></th>
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
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 30,
                ajax: '{!! route('dataTemas') !!}',
                columns: [
                    {data: 'id', name: 'id', visible: true },
                    {data: 'nombre'},
                    {data: 'estado'},
                    {data: 'acciones', title: '', orderable: false, searchable: false},
                ],
                language: {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                order: [[1, 'asc']],
                drawCallback: function() {
                    var elems = Array.prototype.slice.call(document.querySelectorAll('.estado-chk'));
                    elems.forEach(function(html) {
                        var switchery = new Switchery(html, {
                            size: 'small',
                            color: 'var(--c-4)',
                            secondaryColor: 'var(--c-5)',
                            jackColor: 'var(--c-1)',
                            jackSecondaryColor: 'var(--c-1)'
                        });
                    });
                }
            });
        });
 
        $(document).ready(function() {
            $('#table tbody').on('click', '.delReg', function() {
                if (confirm('¿Está seguro de eliminar el tema?')) {
                    return true;
                }
                return false;
            });
        });

        function elif(id, model) {
            $.ajax({
                url: '../cambiarEstado/' + id + '/' + model,
                type: 'get',
                success: function(data) {
                    toast('Estado modificado correctamente.');
                }
            });
        }

    </script>

<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js" integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>

@stop