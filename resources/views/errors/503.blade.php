@extends('Front.layouts.error')
@section('title', 'Not Found')
@section('content')

    <div class="home-banner full-banner-shadow" style="background-image: url('{{asset('img/banners/2.jpg')}}')">
        <div class="container">
            <div class="home-banner-content">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-content">
                            <div class="w-100 text-center">
                                <div class="w-100 d-inline-block mt-5 pt-5">
                                    <div class="w-100 d-inline-block mt-5 pt-5">
                                        <h1 class="title mt-5"><strong>503</strong></h1>
                                        <h1 class="title"><strong>We are <br> Under Construction</strong></h1>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
