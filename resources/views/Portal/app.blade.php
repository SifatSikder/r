<!doctype html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.png')}}">

    <!-- Page Title -->
    <title> {{env('APP_NAME')}} - User Portal </title>
    @include('Front.layouts.components.head')

</head>
<body>

<div class="w-100">
    <div id="app">
        <app></app>
    </div>
</div>

<script>
    window.core = {
        UserInfo: {!! auth()->user() !!}
    };
</script>
@vite('resources/js/portal/portal.js')

</body>
</html>
