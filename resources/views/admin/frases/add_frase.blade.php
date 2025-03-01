@php
    use App\Fun;
@endphp

@extends('layouts.adminLayout.admin_design')
@section('content')

    <link href="{{ asset('vendors/multi-select/css/multi-select.css') }}" rel="stylesheet">

    <!-- page content -->
    <div class="col-md-12">
        <div class="x_panel animate__animated animate__fadeIn">
            <div class="x_title">
                <h2><i class="fa fa-comments"></i> Frases<small> / Nueva</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'add_frase',
                    'name' => 'add_frase',
                    'url' => '/admin/add-frase',
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="row">

                    <div class="col-md-12">
                        <div class="form-group">
                            {!! Form::label('frase', 'Frase') !!}
                            {!! Form::textarea('frase', null, ['id' => 'frase', 'class' => 'form-control']) !!}
                        </div>
                    </div>

                    <div class="clearfix"></div>

                    <div class="col-md-12" style="padding-bottom: 30px;">
                        {!! Form::label('tipos', 'Tipos') !!}

                        <select multiple="multiple" id="tipos-select" name="tipos[]">
                            @if ($tipos)
                                @foreach ($tipos as $tipo)
                                    @php
                                        echo '<option value=' . $tipo->id . '> ' . $tipo->nombre . ' </option>';
                                    @endphp
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-12">
                        <div class="ln_solid"></div>
                        <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"
                                aria-hidden="true"></i> Guardar</button>
                    </div>

                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@section('page-js-script')

    <script src="{{ asset('vendors/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('js/back_js/jquery.quicksearch.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById("frase").focus();
        });
    </script>

    <script>
        $('#tipos-select').multiSelect({

            selectableHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Buscar'>",
            selectionHeader: "<input type='text' class='search-input' autocomplete='off' placeholder='Buscar'>",

            afterInit: function(ms) {
                var that = this,
                    $selectableSearch = that.$selectableUl.prev(),
                    $selectionSearch = that.$selectionUl.prev(),
                    selectableSearchString = '#' + that.$container.attr('id') +
                    ' .ms-elem-selectable:not(.ms-selected)',
                    selectionSearchString = '#' + that.$container.attr('id') +
                    ' .ms-elem-selection.ms-selected';

                that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
                    .on('keydown', function(e) {
                        if (e.which === 40) {
                            that.$selectableUl.focus();
                            return false;
                        }
                    });

                that.qs2 = $selectionSearch.quicksearch(selectionSearchString)
                    .on('keydown', function(e) {
                        if (e.which == 40) {
                            that.$selectionUl.focus();
                            return false;
                        }
                    });
            },
            afterSelect: function() {
                this.qs1.cache();
                this.qs2.cache();
            },
            afterDeselect: function() {
                this.qs1.cache();
                this.qs2.cache();
            }

        });
    </script>

@stop
