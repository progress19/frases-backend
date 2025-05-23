@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-comment" aria-hidden="true"></i> Frases<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">

                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="col-md-3">
                <div class="form-group">
                    {!! Form::label('tipos', 'Tipos') !!}
                    {!! Form::select('tipos', $tipos, null, [
                        'id' => 'tipos',
                        'placeholder' => 'Todos',
                        'class' => 'form-control select2',
                        'data-toggle' => 'tooltip',
                        'title' => 'Seleccione Tipo'
                    ]) !!}
                </div>
            </div>

            <a href="{{ url('/admin/add-frase') }}">
                <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nueva frase</button>
            </a>

            <div class="x_content">

                <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>id</th>
                            <th>Frase</th>
                            <th>Count</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>

            </div>
        </div>
    </div>

    <!-- /page content -->

@endsection

@section('page-js-script')
    @if (session('flash_message'))
        <script>toast('{!! session('flash_message') !!}');</script>
    @endif
    
    <script>
        
        $(function() {
            var table = $('#table').DataTable({
                processing: true,
                serverSide: true,
                pageLength: 100,
                ajax: '{!! route('dataFrases') !!}',
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'frase', name: 'frase' },   
                    { data: 'count', name: 'count' },   
                    { data: 'acciones', title: '', orderable: false, searchable: false, className: 'dt-body-center' },
                ],
                language: { "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json" },
                order: [[0, 'asc']],
                /*
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
                */
            });


            $('#tipos').change(function() {
                table.ajax.url('{!! route('dataFrasesTipo') !!}?tipo=' + $(this).val()).load();
            });

        });


        /*
        $('#desde, #hasta, #usuario, #estado, #idAsignado').change(function() {
            table.ajax.reload();
        });
*/
        $(document).ready(function() {
            $('#table tbody').on('click', '.delReg', function() {
                if (confirm('Está seguro de eliminar el registro ?')) {
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

        $('.select2').select2();

    </script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"
        integrity="sha256-lSjKY0/srUM9BE3dPm+c4fBo1dky2v27Gdjm2uoZaL0=" crossorigin="anonymous"></script>
@stop
