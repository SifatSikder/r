<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="{{asset('favicon.png')}}">

    <!-- Bootstrap 5 Stylesheet -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
    <!-- Bootstrap 5 Stylesheet -->

    <!-- MOT4AI Stylesheet -->
    @vite('resources/scss/admin/style.scss')
    <!-- MOT4AI Stylesheet -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" integrity="sha512-SfTiTlX6kk+qitfevl/7LibUOeJWlt9rbyDn92a1DqWOw9vWG2MFoays0sgObmWazO5BQPiFucnnEAjpAB+/Sw==" crossorigin="anonymous" referrerpolicy="no-referrer"/>
    <title>Administration - {{env('APP_NAME')}}</title>

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-P1B7CE4183"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', 'G-P1B7CE4183');
    </script>

</head>
<body class="bg-light">

<div id="app">
    <app></app>
</div>

</body>
<script>
    window.core = {
        UserInfo: null,
        APP_URL: '{{env('APP_URL')}}',
        qGroups: {!! json_encode(\App\Models\Questionnaires::$Groups) !!},
        qTypes: {!! json_encode(\App\Models\Questionnaires::$Types) !!},
    };
    @if(auth()->guard('admin')->check())
        window.core.UserInfo = {!! auth()->guard('admin')->user() !!}
    @endif
</script>

@vite('resources/js/admin/app.js')
</html>
