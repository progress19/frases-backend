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
                <h2><i class="fa fa-file-text"></i> Blog<small> / Nuevo Post</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">

                {{ Form::open([
                    'id' => 'add_post',
                    'name' => 'add_post',
                    'url' => '/admin/add-post',
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('titulo', 'Título') !!}
                        {!! Form::text('titulo', null, ['id' => 'titulo', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-8">
                    <div class="form-group">
                        {!! Form::label('subtitulo', 'Subtítulo (opcional)') !!}
                        {!! Form::text('subtitulo', null, ['id' => 'subtitulo', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('fecha_publicacion', 'Fecha de Publicación') !!}
                        {!! Form::date('fecha_publicacion', \Carbon\Carbon::now(), ['id' => 'fecha_publicacion', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('tiempo_lectura', 'Tiempo de Lectura (minutos)') !!}
                        {!! Form::number('tiempo_lectura', 5, ['id' => 'tiempo_lectura', 'class' => 'form-control', 'min' => '1']) !!}
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('contenido', 'Contenido') !!}
                        {!! Form::textarea('contenido', null, ['id' => 'contenido', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-12" style="padding-bottom: 30px;">
                    {!! Form::label('temas', 'Temas') !!}

                    <select multiple="multiple" id="temas-select" name="temas[]">
                        @foreach($temas as $tema)
                            <option value="{{ $tema->id }}">{{ $tema->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-12">
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-save"></i> Guardar</button>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
    <!-- /page content -->

@endsection

@section('page-js-script')
    <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>
    <script src="{{ asset('vendors/multi-select/js/jquery.multi-select.js') }}"></script>
    <script src="{{ asset('js/back_js/jquery.quicksearch.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            // Inicializar editor de texto enriquecido
            tinymce.init({
                selector: '#contenido',
                height: 400,
                skin: 'oxide-dark',
                content_css: 'dark',
                plugins: [
                    'advlist autolink lists link image charmap print preview anchor',
                    'searchreplace visualblocks code fullscreen',
                    'insertdatetime media table paste code help wordcount'
                ],
                toolbar: 'undo redo | formatselect | ' +
                'bold italic backcolor | alignleft aligncenter ' +
                'alignright alignjustify | bullist numlist outdent indent | ' +
                'removeformat | help',
                menubar: 'file edit view insert format tools table help'
            });
            
            document.getElementById("titulo").focus();
        });
    </script>

    <script>
        $('#temas-select').multiSelect({

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