<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" href="{{ asset('public/assets/custom/images/favicon.png')}}" type="image/png">
<meta name="csrf-token" content="{{ csrf_token()}}">
<title>{{!empty($title)?$title.' | '.env('APP_NAME'): env('APP_NAME')}}</title>

<!-- bootstrap -->
<link rel="stylesheet" href="{{asset('public/assets/vendor/bootstrap/css/bootstrap.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/vendor/bootstrap/css/animate.css')}}">
<link rel="stylesheet" href="{{asset('public/assets/vendor/bootstrap/css/animation.css')}}">

<!-- /jquery -->
<script src="{{asset('public/assets/vendor/jquery/jquery-3.7.1.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>


<!-- bootstrap-icons -->
<link rel="stylesheet" href="{{asset('public/assets/vendor/bootstrap-icons/bootstrap-icons.min.css')}}">

<!-- font-awesome -->
<link rel="stylesheet" href="{{asset('public/assets/vendor/font-awesome/css/all.css')}}">

<!-- font-awesome -->
<script src="{{asset('public/assets/vendor/bootstrap-notify/bootstrap-notify.min.js')}}"></script>
<script src="{{asset('public/assets/vendor/bootstrap-notify/message-notify.js')}}"></script>


<script src="{{asset('public/assets/custom/js/scripts.js')}}"></script>

<link href="{{asset('public/assets/custom/css/styles.css')}}" rel="stylesheet" type="text/css"/>
<link href="{{asset('public/assets/custom/css/custom.css')}}" rel="stylesheet" type="text/css"/>

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
    var hostUrl = "assets/";
</script>
