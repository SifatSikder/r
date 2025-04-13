<!-- Page Title -->
<title> {{env('APP_NAME')}} - @yield('title') </title>

<meta name="keywords" content="{{$meta_info['keywords']}}"/>
<meta name="description" content="{{$meta_info['description']}}"/>
<meta name="subject" content="{{env('APP_NAME')}} - @yield('title')">
<meta name="summary" content="{{$meta_info['description']}}">
<meta name="url" content="{{url()->current()}}">
<meta name="identifier-URL" content="{{url()->current()}}">
<meta name="category" content="{{$meta_info['keywords']}}">
<meta name="og:title" content="{{env('APP_NAME')}} - @yield('title')"/>
<meta name="og:type" content="{{$meta_info['keywords']}}"/>
<meta name="og:url" content="{{url()->current()}}"/>
<meta name="og:image" content="{{$meta_info['image_full']}}"/>
<meta name="og:site_name" content="{{env('APP_NAME')}}"/>
<meta name="og:description" content="{{$meta_info['description']}}"/>
<meta name="og:postal-code" content="{{$meta_info['postal']}}"/>
<meta name="og:country-name" content="{{$meta_info['country']}}"/>
