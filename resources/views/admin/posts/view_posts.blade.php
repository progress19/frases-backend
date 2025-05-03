@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-10">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-file-text" aria-hidden="true"></i> Posts de Blog<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{ url('/admin/add-post') }}">
                        <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nuevo post</button>
                    </a>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label>Filtrar por Tema:</label>
                            <select id="tema_filter" class="form-control">
                                <option value="">Todos los temas</option>
                                @foreach($temas as $key => $value)
                                    <option value="{{ $key }}">{{ $value }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Fecha Publicación</th>
                            <th>Tiempo de Lectura</th>
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
            let table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 30,
                ajax: '{!! route('dataPosts') !!}',
                columns: [
                    {data: 'id', name: 'id'},
                    {data: 'titulo', name: 'titulo'},
                    {data: 'fecha_publicacion', name: 'fecha_publicacion'},
                    {data: 'tiempo_lectura', name: 'tiempo_lectura'},
                    {data: 'estado', name: 'estado'},
                    {data: 'acciones', title: '', orderable: false, searchable: false},
                ],
                language: {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                order: [[0, 'desc']],
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
            
            // Filtrar por tema cuando cambia el select
            $('#tema_filter').on('change', function() {
                let temaId = $(this).val();
                if (temaId) {
                    table.destroy();
                    table = $('#table').DataTable({
                        processing: true,
                        serverSide: true,
                        pageLength: 30,
                        ajax: {
                            url: '{!! route('dataPostsTema') !!}',
                            data: {
                                tema: temaId
                            }
                        },
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'titulo', name: 'titulo'},
                            {data: 'fecha_publicacion', name: 'fecha_publicacion'},
                            {data: 'tiempo_lectura', name: 'tiempo_lectura'},
                            {data: 'estado', name: 'estado'},
                            {data: 'acciones', title: '', orderable: false, searchable: false},
                        ],
                        language: {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                        order: [[0, 'desc']],
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
                } else {
                    table.destroy();
                    table = $('#table').DataTable({
                        processing: true,
                        serverSide: true,
                        pageLength: 30,
                        ajax: '{!! route('dataPosts') !!}',
                        columns: [
                            {data: 'id', name: 'id'},
                            {data: 'titulo', name: 'titulo'},
                            {data: 'fecha_publicacion', name: 'fecha_publicacion'},
                            {data: 'tiempo_lectura', name: 'tiempo_lectura'},
                            {data: 'estado', name: 'estado'},
                            {data: 'acciones', title: '', orderable: false, searchable: false},
                        ],
                        language: {"url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"},
                        order: [[0, 'desc']],
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
                }
            });
        });
 
        $(document).ready(function() {
            $('#table tbody').on('click', '.delReg', function() {
                if (confirm('¿Está seguro de eliminar el post?')) {
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
@stop