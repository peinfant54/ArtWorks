<div class="modal fade" id="new" tabindex="-1" role="dialog" aria-labelledby="edit" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                <h4 class="modal-title custom_align" id="Heading">@lang('obra.NewMsg')</h4>
            </div>
            <div class="modal-body">

                <form class="form-horizontal formularios" id="register" role="form" method="POST" action="{{ url('art/obra/create2') }}"  enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <ul class="alert-box warning radius">


                    </ul>
                    <input type="hidden" name="modalnew" value="0" />

                    <div class="form-group{{ $errors->has('n_inv') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field1')</label>
                        <div class="col-md-6">
                            <input id="n_inv" type="text" class="form-control" name="n_inv" value="{{ old('n_inv') }}" required autofocus>

                            @if ($errors->has('n_inv'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('n_inv') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="artista" class="col-md-4 control-label">@lang('obra.Field2') {{ $artistaid }}</label>

                        <div class="col-md-6">

                            {{Form::select('id_artista', $artist, $artistaid,['class' => 'form-control'])}}
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('titulo') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field3')</label>
                        <div class="col-md-6">
                            <input id="titulo" type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" required >

                            @if ($errors->has('titulo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('titulo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('tecnica') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field4')</label>
                        <div class="col-md-6">
                            <input id="tecnica" type="text" class="form-control" name="tecnica" value="{{ old('tecnica') }}" >

                            @if ($errors->has('tecnica'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('tecnica') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('dimension') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field5')</label>
                        <div class="col-md-6">
                            <input id="dimension" type="text" class="form-control" name="dimension" value="{{ old('dimension') }}" >

                            @if ($errors->has('dimension'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('dimension') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('ano') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field6')</label>
                        <div class="col-md-6">
                            <input id="ano" type="text" class="form-control" name="ano" value="{{ old('ano') }}"  >

                            @if ($errors->has('ano'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('ano') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('edicion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field7')</label>
                        <div class="col-md-6">
                            <input id="edicion" type="text" class="form-control" name="edicion" value="{{ old('edicion') }}"  >

                            @if ($errors->has('edicion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('edicion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('procedencia') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field8')</label>
                        <div class="col-md-6">
                            <input id="edicion" type="text" class="form-control" name="procedencia" value="{{ old('procedencia') }}"  >

                            @if ($errors->has('procedencia'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('procedencia') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('catalogo') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field9')</label>
                        <div class="col-md-6">
                            <input id="edicion" type="text" class="form-control" name="catalogo" value="{{ old('catalogo') }}"  >

                            @if ($errors->has('catalogo'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('catalogo') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('certificacion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field10')</label>
                        <div class="col-md-6">
                            <input id="edicion" type="text" class="form-control" name="certificacion" value="{{ old('certificacion') }}"  >

                            @if ($errors->has('certificacion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('certificacion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('valoracion') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field11')</label>
                        <div class="col-md-6">
                            <input id="edicion" type="text" class="form-control" name="valoracion" value="{{ old('valoracion') }}"  >

                            @if ($errors->has('valoracion'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('valoracion') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Falta el select de ubicacion-->
                    <div class="form-group">
                        <label for="email" class="col-md-4 control-label">@lang('obra.Field12')</label>

                        <div class="col-md-6">
                            {{Form::select('id_ubica', $location, old('id_ubica'),['class' => 'form-control'])}}
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('foto1') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field13')</label>
                        <div class="col-md-6">
                            <input id="file1" type="file" class="form-control" name="foto1" accept="image/*" value="{{ old('foto1') }}"  >

                            @if ($errors->has('foto1'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('foto1') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group{{ $errors->has('pdf.0') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field14')</label>
                        <div class="col-md-6">
                            <input id="pdf" type="file" class="form-control" name="pdf[]" value="{{ old('pdf.0') }}" accept="application/pdf" multiple>
                            @if ($errors->has('pdf.0'))
                                <span class="help-block">
                                        <strong><?php /*dd($errors); */?>
                                            {{ $errors->first('pdf.0') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="form-group{{ $errors->has('obs') ? ' has-error' : '' }}">
                        <label for="name" class="col-md-4 control-label">@lang('obra.Field15')</label>
                        <div class="col-md-6">
                            <textarea name="obs" class="form-control" style="resize:none;">{{ old('obs') }}</textarea>
                            @if ($errors->has('obs'))
                                <span class="help-block">
                                        <strong>{{ $errors->first('obs') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg" style="width: 100%;" name="save"><span class="glyphicon glyphicon-ok-sign"></span> @lang('obra.Save')</button>
                </form>
            </div>
            <!--div class="modal-footer ">

            </div -->

        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>