@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-language" aria-hidden="true"></i> Traducciones<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <a href="{{ url('/admin/add-traduccion') }}">
                        <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-plus" aria-hidden="true"></i> Nueva traducción</button>
                    </a>
                </ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                <table id="table" class="hover table table-striped table-bordered dt-responsive nowrap" cellspacing="0"
                    width="100%">
                    <thead>
                        <tr>
                            <th>Español</th>
                            <th>Inglés</th>
                            <th>Portugués</th>
                            <th></th>
                        </tr>
                    </thead>
                </table>

            </div>
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
                //serverSide: true,
                pageLength: 30,
                ajax: '{!! route('dataTraducciones') !!}',

                columns: [
                    {data: 'es'},
                    {data: 'en_raw'},
                    {data: 'pr_raw'},
                    {
                        data: 'acciones',
                        title: '',
                        orderable: false,
                        searchable: false,
                        className: 'dt-body-center'
                    },
                ],
                language: {
                    "url": "https://cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                },
            });
        });

        $(document).ready(function() {
            $('#table tbody').on( 'click', '.delReg', function () {
            if (confirm('Está seguro de eliminar el registro ?')) {
                return true;
            }
            return false;
            });
        });

    </script>

@stop
