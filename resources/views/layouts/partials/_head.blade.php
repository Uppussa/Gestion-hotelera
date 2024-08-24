<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ asset('public/app/images/favicon.png')}}" type="image/png">
<meta name="csrf-token" content="{{csrf_token()}}">
<title>{{!empty($title)?$title.' | '.env('APP_NAME'): env('APP_NAME')}}</title>

<!-- bootstrap -->
<link rel="stylesheet" href="{{asset('public/vendor/bootstrap/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('public/vendor/bootstrap/css/animate.css')}}">
<link rel="stylesheet" href="{{asset('public/vendor/bootstrap/css/animation.css')}}">

<!-- /jquery -->
<script src="{{asset('public/vendor/jquery/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('public/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<!-- bootstrap-icons -->
<link rel="stylesheet" href="{{asset('public/vendor/bootstrap-icons/bootstrap-icons.min.css')}}">

<!-- font-awesome -->
<link rel="stylesheet" href="{{asset('public/vendor/font-awesome/css/all.css')}}">

<!-- font-awesome -->
<script src="{{asset('public/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('public/vendor/bootstrap-notify/message-notify.js')}}"></script>


<script src="{{asset('public/app/js/scripts.js')}}"></script>

<link href="{{asset('public/app/css/styles.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/app/css/custom.css')}}" rel="stylesheet" type="text/css"/>

<script src="{{asset('public/vendor/ckeditor5/build/ckeditor.js')}}" type="text/javascript"></script>

<script src={{asset('public/vendor/highcharts/highcharts.js')}}></script>
<script src={{asset('public/vendor/highcharts/modules/exporting.js')}}></script>

<script src="{{asset('public/app/ajx/ajxsearch.js')}}"></script>

@if (auth()->check())
    <meta name="api-token" content="{{auth()->user()->api_token}}">
@endif

<style>
    .fstElement {
        font-size: 0.6em;
    }
    .fstToggleBtn {
        min-width: 2em;
    }
    .submitBtn {
        display: none;
    }
    .fstMultipleMode {
        display: block;
    }
    .fstMultipleMode .fstControls {
        width: 100%;
    }
    .multipleSelect{
        overflow-x: auto !important;
        max-height: 20px !important;
        z-index: 3898;
    }
    .google-maps iframe {
        width: 100% !important;
    }
</style>

<script>
    var base_url = "{{route('/')}}";
    var autorizadoToken = "{{ csrf_token() }}";
    var subsec 	= "start";
    var sec 	= "ini";
    var hostUrl = "";
</script>
