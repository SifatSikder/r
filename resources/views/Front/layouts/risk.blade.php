<!doctype html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.png')}}">

    @include('Front.layouts.components.meta')
    @include('Front.layouts.components.head')
    @yield('stylesheets')

    <!-- Google Recaptcha -->
    <script src="https://www.google.com/recaptcha/api.js?render={{env('RECAPTCHA_SITE_KEY')}}"></script>
    <!-- Google Recaptcha -->

</head>
<body>

@include('Front.layouts.components.header')

<div class="w-100">
    @yield('content')
</div>

@yield('scripts')

</body>
</html>
