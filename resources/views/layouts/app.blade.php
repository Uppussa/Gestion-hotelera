<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('layouts.partials._head')
</head>
<body class="login-bg d-flex align-items-center py-4 bg-body-tertiary">    
    @yield('content')
</body>
</html>
