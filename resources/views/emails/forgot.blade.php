<!doctype html>
<html lang="en">
<head>

</head>
<body>

Hello {{$userInfo->name}}, <br>
Your password reset link is <br>
<a href="{{route('front.reset', [$userInfo->reset_code])}}">{{route('front.reset', [$userInfo->reset_code])}}</a>

<br><br>

Regards <br>
{{env('APP_NAME')}}

</body>
</html>
