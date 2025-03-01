@php
    use App\Fun;
    use Carbon\Carbon;
@endphp

<link href="{{ asset('vendors/multi-select/css/multi-select.css') }}" rel="stylesheet">

@extends('layouts.adminLayout.admin_design')
@section('content')

    <div class="col-md-12 col-sm-4">
        <div class="x_panel">

            <div class="x_title">
                <h2><i class="fa fa-building"></i> Frase / <small>Editar</small></h2>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_frase',
                    'name' => 'edit_frase',
                    'url' => '/admin/edit-frase/' . $frase->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('frase', 'Frase') !!}
                        {!! Form::textarea('frase', $frase->frase, ['id' => 'frase', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12" style="padding-bottom: 30px;">
                    {!! Form::label('tipos', 'Tipos') !!}

                    <select multiple="multiple" id="tipos-select" name="tipos[]">
                        @if ($tipos)
                            @foreach ($tipos as $tipo)
                                @php
                                    $hasTipos = $frase
                                        ->tipos()
                                        ->where('tipo_id', $tipo->id)
                                        ->exists();
                                    if ($hasTipos) {
                                        echo '<option value=' .
                                            $tipo->id .
                                            ' selected> ' .
                                            $tipo->nombre .
                                            ' </option>';
                                    } else {
                                        echo '<option value=' .
                                            $tipo->id .
                                            ' > ' .
                                            $tipo->nombre .
                                            ' </option>';
                                    }
                                @endphp
                            @endforeach
                        @endif
                    </select>
                </div>

                <div class="col-md-12">
                    <div class="ln_solid"></div>
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i>
                        Guardar</button>
                </div>

                {!! Form::close() !!}

            </div> <!-- x_content -->

        </div>

    </div>

@endsection

@section('page-js-script')

<script src="{{ asset('vendors/multi-select/js/jquery.multi-select.js') }}"></script>
<script src="{{ asset('js/back_js/jquery.quicksearch.js') }}"></script>

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
