@extends('Front.layouts.risk')
@section('title', 'Multi-scale Operation-assurance evaluation Tool for AI Systems')
@section('content')

    <div class="home-banner" style="background-image: url('{{asset('img/banners/1.jpg')}}');min-height: 100vh;">
        <div class="container-lg">
            <div class="w-100 py-5">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="w-100 py-5 my-5">
                            <div class="w-100 py-5 position-relative">
                                <div id="app">
                                    <app></app>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
    @vite('resources/js/awareness_evaluation/app.js')
@endsection
