@php
    use Khill\Lavacharts\Lavacharts;
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


            <div class="x_content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="dashboard-stats">
                            <h4>Cantidad de frases: {{ $frases }}</h4>
                            <h4>Cantidad de frases mostradas: {{ $frases_mostradas }}</h4>
                        </div>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="col-md-12">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th>Tipo</th>
                                        <th>Total de frases</th>
                                        <th>Frases mostradas</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tipos as $tipo)
                                        <tr>
                                            <td>{{ $tipo->nombre }}</td>
                                            <td>{{ $tipo->total_frases }}</td>
                                            <td>{{ $tipo->frases_mostradas }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
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
@stop
