@extends('layouts.adminLayout.admin_design')
@section('content')
    <div class="col-md-10">
        <div class="x_panel">
            <div class="x_title">
                <h2><i class="fa fa-gear"></i> Configuración<small>/ Editar</small></h2>
                <ul class="nav navbar-right panel_toolbox"></ul>
                <div class="clearfix"></div>
            </div>

            <div class="x_content">

                {{ Form::open([
                    'id' => 'edit_config',
                    'name' => 'edit_config',
                    'url' => '/admin/edit-config/' . $config->id,
                    'role' => 'form',
                    'method' => 'post',
                    'files' => true,
                ]) }}

                <div class="col-md-7">
                    <div class="form-group">
                        {!! Form::label(
                            'destinatarios',
                            'Destinatarios formularios (separados por coma, ej : info@apartssantelmo.com, consultas@apartssantelmo.com)',
                        ) !!}
                        {!! Form::text('destinatarios', $config->destinatarios, ['id' => 'destinatarios', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-1">
                    <div class="form-group">
                        {!! Form::label('Dolar', '') !!}
                        {!! Form::text('usd', $config->usd, ['id' => 'usd', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Teléfonos', '') !!}
                        {!! Form::text('telefono', $config->telefono, ['id' => 'telefono', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Whatsapp', '') !!}
                        {!! Form::text('whatsapp', $config->whatsapp, ['id' => 'whatsapp', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-3">
                    <div class="form-group">
                        {!! Form::label('Dirección', 'Dirección') !!}
                        {!! Form::text('direccion', $config->direccion, ['id' => 'direccion', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('instagram', 'Instagram') !!}
                        {!! Form::text('instagram', $config->instagram, ['id' => 'instagram', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('facebook', 'Facebook') !!}
                        {!! Form::text('facebook', $config->facebook, ['id' => 'facebook', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('tiktok', 'Tiktok') !!}
                        {!! Form::text('tiktok', $config->tiktok, ['id' => 'Tiktok', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('youtube', 'Youtube') !!}
                        {!! Form::text('youtube', $config->youtube, ['id' => 'youtube', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        {!! Form::label('vimeo', 'Vimeo') !!}
                        {!! Form::text('vimeo', $config->vimeo, ['id' => 'vimeo', 'class' => 'form-control']) !!}
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('logo', 'Logo') !!}
                        {!! Form::file('logo', null, ['id' => 'logo', 'class' => 'form-control']) !!}
                    </div>
                </div>
                {{ Form::hidden('current_logo', $config->logo) }}

                <!-- SOBRE NOSOTROS -->

                <div class="clearfix"></div>

                <div class="ln_solid"></div>
                <div class="col-12">
                    <h2 style="padding-bottom: 20px">Sobre Nosotros</h2>
                </div>

                <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="español-tab" data-toggle="tab" href="#español" role="tab"
                            aria-controls="español" aria-selected="true"> Español</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ingles-tab" data-toggle="tab" href="#ingles" role="tab"
                            aria-controls="ingles" aria-selected="false"> Inglés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="portu-tab" data-toggle="tab" href="#portu" role="tab"
                            aria-controls="portu" aria-selected="false"> Portugués</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="español" role="tabpanel" aria-labelledby="español-tab">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('nosotros_es', 'Descripción') !!}
                                {!! Form::textarea('nosotros_es', $config->nosotros_es, ['id' => 'nosotros_es', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                    </div>

                    <!-- ################################################################### ingles  ##########################################
                            ###########################################################################################################################-->

                    <div class="tab-pane fade" id="ingles" role="tabpanel" aria-labelledby="ingles-tab">

                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('nosotros_en', 'Descripción') !!}
                                {!! Form::textarea('nosotros_en', $config->nosotros_en, ['id' => 'nosotros_en', 'class' => 'form-control']) !!}
                            </div>
                        </div>

                    </div>

                    <!-- ################################################################## portu  ##########################################
                        ###########################################################################################################################-->

                    <div class="tab-pane fade" id="portu" role="tabpanel" aria-labelledby="portu-tab">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('nosotros_pr', 'Descripción') !!}
                                {!! Form::textarea('nosotros_pr', $config->nosotros_pr, ['id' => 'nosotros_pr', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        {!! Form::label('nosotros_imagen', 'Imagen') !!}
                        {!! Form::file('nosotros_imagen', null, ['id' => 'nosotros_imagen', 'class' => 'form-control']) !!}
                    </div>
                </div>
                {{ Form::hidden('current_nosotros_imagen', $config->nosotros_imagen) }}

                <div class="clearfix"></div>

                <!-- FIN NOSOTROS -->

                <!-- TERMINOS Y CONDICIONES -->
                <div class="ln_solid"></div>
                <div class="col-12">
                    <h2 style="padding-bottom: 20px">Términos y condiciones</h2>
                </div>

                <ul class="nav nav-tabs bar_tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="español-tab-ter" data-toggle="tab" href="#español-ter" role="tab"
                            aria-controls="español" aria-selected="true"> Español</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="ingles-tab-ter" data-toggle="tab" href="#ingles-ter" role="tab"
                            aria-controls="ingles" aria-selected="false"> Inglés</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="portu-tab-ter" data-toggle="tab" href="#portu-ter" role="tab"
                            aria-controls="portu" aria-selected="false"> Portugués</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade show active" id="español-ter" role="tabpanel" aria-labelledby="español-tab">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('terminos_es', 'Descripción') !!}
                                {!! Form::textarea('terminos_es', $config->terminos_es, ['id' => 'terminos_es', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <!-- ################################################################### ingles ##########################################
                    ###########################################################################################################################-->

                    <div class="tab-pane fade" id="ingles-ter" role="tabpanel" aria-labelledby="ingles-tab-ter">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('terminos_en', 'Descripción') !!}
                                {!! Form::textarea('terminos_en', $config->terminos_en, ['id' => 'terminos_en', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                    <!-- ################################################################## portu ##########################################
                    ###########################################################################################################################-->

                    <div class="tab-pane fade" id="portu-ter" role="tabpanel" aria-labelledby="portu-tab-ter">
                        <div class="col-md-12">
                            <div class="form-group">
                                {!! Form::label('terminos_pr', 'Descripción') !!}
                                {!! Form::textarea('terminos_pr', $config->terminos_pr, ['id' => 'terminos_pr', 'class' => 'form-control']) !!}
                            </div>
                        </div>
                    </div>

                </div>
                
                <!-- FIN TERMINOS Y CONDICIONES -->

                <div class="col-md-12">
                    <div class="ln_solid"></div>
                    <button id="send" type="submit" class="btn btn-primary pull-right"><i class="fa fa-floppy-o"
                            aria-hidden="true"></i> Guardar</button>
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
@endsection

@section('page-js-script')
    <script>
        /*
        ClassicEditor
            .create(document.querySelector('#nosotros_es'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#nosotros_en'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#nosotros_pr'))
            .catch(error => {
                console.error(error);
            });
        */
        ClassicEditor
            .create(document.querySelector('#terminos_es'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#terminos_en'))
            .catch(error => {
                console.error(error);
            });
        ClassicEditor
            .create(document.querySelector('#terminos_pr'))
            .catch(error => {
                console.error(error);
            });

    </script>
@stop
