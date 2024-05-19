@extends('layouts.appMain')
@section('breadcrumb')
	@include('layouts.partials._breadcrumbs')
@endsection

@section('content')
@include('users.mdls')
<div id="kt_content_container" class="container-fluid p-2 mt-0 pt-0">
    <div class="card mb-3">
        <div class="card-header border-0 p-4 d-none">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0">
                    <i class="far fa-clipboard-list"></i> Agregar usuario
                </h3>
            </div>
        </div>
        <div class="card-body pt-4 pb-0 p-4">
            <form  class="form-add-reg mt-3" method="post">
                @if (auth()->user()->nivel->lvl > 2)
                    <div class="row justify-content-end">
                        <div class="col-lg-3 col-md-3 col-sm-6 mb-4">
                            <select class="form-select slt-mun" name="client_id" required="" data-control="select2" data-placeholder="Seleccionar cliente">
                                <option></option>
                                @foreach (clients() as $client)
                                    <option value="{{$client->id_com}}">{{$client->nom_com}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endif
                <div class="row">
                    <div class="col-lg-4 col-md-4 col-sm-6 mb-3">
                        {!! inputText('nom_user', 'Nombre/Área: *', old('nom_user', ''), 'bi bi-person', ['placeholder'=>' ', 'required'=>'required', 'autocomplete'=>'off']) !!}
                    </div>
                    <div class="col-lg-4 col-md-4 mb-3">
                        {!! inputText('email', 'Email: *', old('email', ''), 'bi bi-at', ['placeholder'=>' ', 'required'=>'required',  'class' => 'lowercase', 'autocomplete'=>'off']) !!}
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 mb-3">
                        {!! inputText('tel_user', 'Teléfono:', old('tel_user', ''), 'bi bi-phone', ['placeholder'=>' ', 'autocomplete'=>'off', 'data-mask'=>'(###)-###-####', 'maxlength'=>'14']) !!}
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 mb-3">
                        {!! inputSelect('lvl_id', 'Nivel: *', null, $levels->pluck('nom_lvl', 'id_lvl')->toArray(), ['required'=>'required']) !!}
                    </div>
                    <div class="col-lg-12 mb-3">
                        {!! inputText('dir_emp', 'Calle/Número. Col. Mun. Edo:', old('dir_emp', ''), 'bi bi-location', ['placeholder'=>' ', 'autocomplete'=>'off', 'maxlength'=>'255']) !!}
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <p class="">Información laboral</p>
                    </div>
                    <div id="div-cnt-oficinas-mun" class="col-lg-3 col-md-3 col-sm-6 col-6 mt-3">
                        @if(auth()->user()->lvl_id>2)
                            <select class="form-select select-2" name="cta_id" required="" data-control="select2" data-placeholder="Seleccionar oficina">
                                <option></option>
                            </select>
                        @else
                            <select class="form-select select-2" name="cta_id" required="" data-control="select2" data-placeholder="Seleccionar oficina">
                                <option></option>
                                @foreach ($offices as $office)
                                    <option value="{{$office->id_ofi}}">{{$office->nom_ofi}}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="col-lg-3 col-md-3 col-sm-6 col-6 mt-3">
                        {!! inputText('puesto_emp', 'Puesto:', old('puesto_emp', ''), 'bi bi-person-badge', ['placeholder'=>' ', 'autocomplete'=>'off', 'maxlength'=>'255']) !!}
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 mt-3">
                        {!! inputSelect('tipo_emp', 'Tipo usuario: *', null, $tipoemps->pluck('nom_cat', 'id_cat')->toArray(), ['required'=>'required']) !!}
                    </div>

                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 mt-3">
                        {!! inputDate('fi_emp', 'Inicio:', old('fi_emp', (date('Y').'-01-01')), ['placeholder'=>' ']) !!}
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6 col-6 mt-3 mb-3">
                        {!! inputDate('ff_emp', 'Fin:', old('ff_emp', (date('Y').'-12-31')), ['placeholder'=>' ']) !!}
                    </div>

                    <div class="col-md-12 mt-3">
                        {!! inputTextArea('cv_emp', 'Puesto:', old('cv_emp', ''), 'bi bi-person-badge', ['placeholder'=>' ', 'class'=>'txt-cv', 'autocomplete'=>'off', 'maxlength'=>'255']) !!}
                    </div>
                </div>
                <div class="row justify-content-end">
                    <div class="col-lg-2 col-md-3 col-sm-4 col-6 mt-2 mb-2">
                        <button type="submit" class="btn btn-success btn-block" id="btn-add-emp">
                            <i class="bi bi-check-circle"></i> Continuar
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
@section('script')
	<script src="{{asset('public/assets/ajx/ajxusers.js')}}"></script>
	<script>
		$(document).ready(function() {
            let editor;
            ClassicEditor.create(document.querySelector('.txt-cv'), {
                ckfinder: {
                    uploadUrl: base_url+'/upload',
                },
                height: '300px',
                toolbar: {
                    items: [
                        'heading',
                        '|',
                        'bold',
                        'italic',
                        'link',
                        'bulletedList',
                        'numberedList',
                        '|',
                        'outdent',
                        'indent',
                        '|',
                        'imageUpload',
                        'blockQuote',
                        'insertTable',
                        'undo',
                        'redo',
                        'alignment',
                        'fontSize'
                    ]
                },
                language: 'es',
                image: {
                    styles: [
                        'alignLeft', 'alignCenter', 'alignRight'
                    ],
                    // Configure the available image resize options.
                    resizeOptions: [
                        {
                            name: 'resizeImage:original',
                            label: 'Original',
                            value: null
                        },
                        {
                            name: 'resizeImage:50',
                            label: '50%',
                            value: '50'
                        },
                        {
                            name: 'resizeImage:75',
                            label: '75%',
                            value: '75'
                        }
                    ],
                    // You need to configure the image toolbar, too, so it shows the new style
                    // buttons as well as the resize buttons.
                    toolbar: [
                        'imageStyle:alignLeft', 'imageStyle:alignCenter', 'imageStyle:alignRight',
                        '|',
                        'resizeImage',
                        '|',
                        'imageTextAlternative'
                    ],
                },
                table: {
                    contentToolbar: [
                        'tableColumn',
                        'tableRow',
                        'mergeTableCells'
                    ]
                },
            })
            .then( newEditor => {
                window.editor = newEditor;
                editor = newEditor;
            })
            .catch( error => {
                console.error( 'Oops, something went wrong!' );
                console.error( 'Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:' );
                console.warn( 'Build id: q6l505nuvif2-xw3ce1wx5aqw' );
                console.error( error );
            });
		});
	</script>
@endsection
