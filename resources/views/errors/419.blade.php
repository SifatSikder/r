@extends('Front.layouts.front')
@section('title', 'Forbidden Request!')
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/errors.jpg')}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100">
                                <h1 class="title"><strong>419</strong></h1>
                                <p class="slogan">Page Expired!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
