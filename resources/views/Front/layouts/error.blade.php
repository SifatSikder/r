
<!doctype html>
<html lang="en">
<head>
    <!-- Meta Information -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.png')}}">

    @include('Front.layouts.components.head')
    @yield('stylesheets')

</head>
<body>

<!--Header-Area-->
<div class="header">
    <div class="container">
        <nav class="navbar navbar-expand-lg py-sm-3">
            <div class="container-fluid">
                <a class="navbar-brand m-auto" href="{{route('front.home')}}">
                    Rai<span class="text-danger">DOT</span>
                </a>
            </div>
        </nav>
    </div>
</div>
<!--Header-Area/-->

<div class="w-100">
    @yield('content')
</div>

@include('Front.layouts.components.footer')

@include('Front.layouts.components.scripts')
@yield('scripts')

</body>
</html>
