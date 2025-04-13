@extends('Front.layouts.front')
@section('title', 'Terms & Conditions')
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/3.jpg')}}')">
        <div class="container">
            <div class="home-banner-content banner-50 d-flex align-items-center">
                <div class="w-100">
                    <h1 class="text-white"><strong>Terms & Conditions</strong></h1>
                </div>
            </div>
        </div>
    </div>

    <div class="top-content-plate bg-light">
        <div class="container">
            <div class="top-content-plate-content shadow">
                <div class="w-100 bg-white rounded p-5">

                    {!! nl2br($terms_conditions) !!}

                </div>
            </div>
        </div>
    </div>

@endsection
